@include('layouts.header')
<style type="text/css">
    table.table-bordered{
    border:1px solid #000;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid #000;
}
table.table-bordered > tbody > tr > td{
    border:1px solid #000;
}
    </style>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-dashboard"></i> Gaji Karyawan</h1>
        </div>
      </div>


      
    <div class="tile">
    <form action="<?php echo route('gaji');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            
            <div class="col-md-2">
               
                 <label for="">Dari Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_awal" id="date" value="<?php echo $awal;?>" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-2">
                 <label for="">Sampai Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_akhir" id="date2" value="<?php echo $akhir;?>" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            <div class="col-md-3">
            <label for="validationDefault05">Customer Service</label>
            <select class="form-control form-control-lg" name="cs">
                <?php 
                    foreach ($cs as $name=>$id){
                        ?>
                        <option value="<?php echo $id;?>" <?php if ($cs_id == $id) echo 'selected="selected"';?>><?php echo $name;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-3">
            <label for="validationDefault05">Orderan Selesai</label>
            <select class="form-control form-control-lg" name="status_order">
                    <option value="done" <?php if ($status_order == 'done') echo 'selected';?>>Orderan Selesai</option>
                    <option value="not" <?php if ($status_order == 'not') echo 'selected';?>>Orderan Belum Selesai</option>
                    <option value="all" <?php if ($status_order == 'all') echo 'selected';?>>Semua Orderan</option>
                </select>
            </div>

            <div class="col-md-2">
            <label for="validationDefault05">Termasuk Reseller?</label>
            <select class="form-control form-control-lg" name="include_reseller">
                    <option value="1" <?php if ($include_reseller == '1') echo 'selected';?>>Ya</option>
                    <option value="0" <?php if ($include_reseller == '0') echo 'selected';?>>Tidak</option>
                </select>
            </div>

            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-warning btn-lg btn-block shadow border border-dark"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>
    
    </form>
    </div>

    <?php
        $no = 1;
        if (!empty($data)){
            //dd($data);
            ?>
            <div class="tile">
            <div>
                Data dari tanggal <?php echo date('d M Y', strtotime($awal))?> s/d tanggal <?php echo date('d M Y', strtotime($akhir))?>
            </div>
            <table class="table table-hover">
                <tr>
                    <td>No.</td>
                    <td>Nama Pemesan</td>
                    <td>Bahan Pria</td>
                    <td>Bahan Wanita</td>
                    <td>Belanja</td>
                    <td>Modal Produksi</td>
                    <td>Laba Bersih</td>
                </tr>
            <?php
                $laba_total = 0;
                $komisi = 0;
                $statistik['pengrajin_lapis'] = 0;
                $statistik['lapis'] = 0;
                $statistik['pengrajin'] = 0;
                $done = '';
            foreach ($data as $item){
                if ($item->modal_pengrajin == null && $item->modal_lapis == null){
                    $warning = 'table-danger';
                    $statistik['pengrajin_lapis'] += 1;
                }elseif ($item->modal_pengrajin != null && $item->modal_lapis == null){
                    $warning = 'table-warning';
                    $statistik['lapis'] += 1;
                }elseif ($item->modal_pengrajin == null && $item->modal_lapis != null){
                    $warning = 'table-secondary';
                    $statistik['pengrajin'] += 1;
                }else{
                    $warning = '';
                    $done = '<i class="fas fa-check-circle"></i>';
                }
                ?>
                <tr class="<?php echo $warning;?>">
                    <td><?php echo $no.' '.$done?></td>
                    <td><?php echo $item->nama;?><br />Tanggal pemesanan <?php echo date('d M Y', strtotime($item->tglmasuk))?><br />Dealer <?php echo $item->asal->title;?>
                    <br />
                    <?php
                          if ($item->arsipkan == 1){
                            echo '<span class="text-white bg-danger">Data ini sudah dihapus</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == null && $item->kirim_ke_pengrajin == 0){
                            echo '<span class="text-white bg-primary">Order siap cetak</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == null && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-dark bg-warning">Order sedang dikerjakan oleh '.$item->pengrajin->nama.'</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == 3 && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-white bg-success">Pesanan sudah dikirim dengan no resi '.$item->resi.' dan sudah dilunasi</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == 1 && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-white bg-info">Sedang difinising/lapis</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == 2 && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-white bg-success">Orderan sudah di kantor</span>';
                          }elseif ($item->siap_cetak == 0 && $item->finising == null && $item->kirim_ke_pengrajin == 0){
                            echo '<span class="text-white bg-danger">Order berhasil diinput ke database</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == 4 && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-white bg-danger">Sedang proses reparasi</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == 5 && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-white bg-danger">Barang masih di showroom, tapi SUDAH dilunasi</span>';
                          }elseif ($item->siap_cetak == 1 && $item->finising == 6 && $item->kirim_ke_pengrajin == 1){
                            echo '<span class="text-white bg-danger">Barang sudah dikirim, tapi belum ada data pelunasan</span>';
                          }
                        ?>
                    
                    </td>
                    <td><?php echo title_logam($item->bahanpria()->first(),'title');?></td>
                    <td><?php echo title_logam($item->bahanwanita()->first(),'title');?></td>
                    <td>
                      <?php echo aa('DP ',rupiah($item->dp,'<br />'));?><br />
                      <?php echo aa('Pelunasan ',rupiah((int)$item->pelunasan,'<br />'));?><br />
                        Total Belanja <?php echo rupiah((int)$item->dp+$item->pelunasan);?></td>
                    <td>
                    <?php 
                        $modal = ((int)$item->produksi_beratpria * (int)$item->produksi_hargapria) + ((int)$item->produksi_beratwanita * (int)$item->produksi_hargawanita) + (int)$item->ongkir + (int)$item->modal_pengrajin + (int)$item->modal_lapis;
                        echo aa('Modal Cincin Pria ',rupiah( (int)$item->produksi_beratpria * $item->produksi_hargapria),'<br />').'<br />';
                        echo aa('Modal Cincin Wanita ',rupiah( (int)$item->produksi_beratwanita * $item->produksi_hargawanita),'<br />').'<br />';
                        echo aa('Ongkir ',rupiah((int)$item->ongkir,'<br />')).'<br />';
                        echo aa('Pengrajin ',rupiah((int)$item->modal_pengrajin,'<br />')).'<br />';
                        echo aa('Lapis ',rupiah((int)$item->modal_lapis,'<br />')).'<br />';
                        echo '<strong>'.aa('Total ',rupiah($modal),'<br />').'</strong>';
                       
                    ?></td>
                    <td><?php 
                        if ($item->modal_pengrajin != null && $item->modal_lapis != null && $item->ongkir != null){
                            $laba = ( (int)$item->dp + (int)$item->pelunasan) - (int)($modal);
                        echo rupiah($laba);
                        $laba_total = $laba_total+$laba;
                        }
                        
                        if ($item->ispremium == 2 && $item->asal_id == 1) {
                            $komisi = $komisi+30000;
                        }elseif ($item->ispremium == 1 && $item->asal_id == 1){
                            $komisi = $komisi+15000;
                        }elseif ($item->ispremium == 0 && $item->asal_id == 1 && $item->couple == 1){
                            //-- perak sepasang
                            $komisi = $komisi+10000;
                        }elseif ($item->ispremium == 0 && $item->asal_id == 1 && $item->couple == 0){
                            //-- perak single
                            $komisi = $komisi+5000;
                        }
                        
                    ?></td>
                </tr>
                <?php
                $modal = 0;
                $laba = 0;
                $no++;
                $done = '';
            }
            echo '</table></div>';
            ?>

            <div class="tile">
                <?php 
                    echo aa('Data pengrajin dan biaya lapis yang belum terisi ',$statistik['pengrajin_lapis']).'<br />';
                    echo aa('Data pengrajin saja yang belum terisi ',$statistik['pengrajin']).'<br />';
                    echo aa('Data biaya lapis saja yang belum terisi ',$statistik['lapis']).'<br />';
                    echo aa('Total data belum lengkap ',$statistik['lapis']+$statistik['pengrajin_lapis']+$statistik['pengrajin']).'<br />';
                ?>
            </div>
            <div class="tile">
                Laba Bersih
                
                <div class="display-3"><?php echo rupiah($laba_total);?></div>
                <table class="table">
                    <tr>
                        <td>Nama Karyawan</td>
                        <td><?php echo $elemen_gaji->name;?></td>
                    </tr>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td><?php echo rupiah($elemen_gaji->gaji_pokok);?></td>
                    </tr>
                    <tr>
                        <td>Tunjangan</td>
                        <td><?php echo rupiah($elemen_gaji->tunjangan);?></td>
                    </tr>
                    <tr>
                        <td>Uang Makan</td>
                        <td><?php echo rupiah($elemen_gaji->uang_makan);?></td>
                    </tr>
                    <tr>
                        <td>Bonus Keuntungan</td>
                        <td><?php echo rupiah(0.1*(int)$laba_total);?></td>
                    </tr>
                    <tr>
                        <td>Komisi Toko</td>
                        <td><?php echo rupiah($komisi);?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?php echo rupiah($elemen_gaji->gaji_pokok+$elemen_gaji->tunjangan+$elemen_gaji->uang_makan+(int)(0.05*$laba_total)+$komisi);?></td>
                    </tr>
                </table>
            </div>
            <?php
        }
        ?>



   
    </main>
  
@include('layouts.footer')