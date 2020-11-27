@include('layouts.header');
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
          <h1><i class="fa fa-dashboard"></i> Laba</h1>
        </div>
      </div>


      <div class="tile">
        <?php
            if (!empty($saldo)){
                $total_saldo = 0;
                echo '<table class="table table-bordered mb-4"><tr>';
                foreach ($saldo as $buku=>$nominal){
                    //echo $buku.' = '.rupiah($nominal).'<br />';
                    $total_saldo = $total_saldo + $nominal;
                    ?>
                        <td><div class="text-uppercase"><?php echo $buku;?></div><?php echo rupiah($nominal);?></td>
                    <?php
                }
                echo '</tr><tr><td colspan="3">'.rupiah($total_saldo).'</td></tr>';
                echo '</table>';
                //echo rupiah($total_saldo);
                
            }
            
        ?>
    </div>
    <div class="tile">
    <form action="<?php echo route('laba.semua');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
        <div class="col-md-3">
               
               <label for="">No Order</label>
               <input type="text" class="form-control form-control-lg" name="no_order" />
               <small id="helpId" class="form-text text-muted">No Order</small>
                
          </div>

            <div class="col-md-3">
            <label for="validationDefault05">Asal Orderan</label>
            <select class="form-control form-control-lg" name="asal_id">
                <option value="0" selected="selected">Pilih asal orderan</option>
                <?php 
                    foreach ($showroom as $title=>$id){
                        ?>
                        <option value="<?php echo $id;?>"><?php echo $title;?></option>
                        <?php
                    }
                ?>
                </select>
            </div>

            <div class="col-md-3">
               
                 <label for="">Dari Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_awal" id="date" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-3">
                 <label for="">Sampai Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_akhir" id="date2" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>
            </div>
        </div>
    
    </form>
    </div>


    <?php
        if (!empty($data_tambahan['laba'])){
            ?>
            <div class="tile">
                <?php echo tanggal($data_tambahan['awal']);?> s/d <?php echo tanggal($data_tambahan['akhir']);?><br /><h2 class="display-2 h3">Laba <?php echo rupiah($data_tambahan['laba']);?></h2><br />
                <i>Perhitungan laba diatas akan valid jika semua kolom transaksi lengkap</i><br />
                Ongkos pembuatan cincin premium <?php echo rupiah($data_tambahan['ongkos_premium']);?>, cincin perak <?php echo rupiah($data_tambahan['ongkos_perak']);?><br />
                Data yang kosong (Perak) <?php echo $data_tambahan['data_ongkos_kosong_perak'];?>, (Premium) <?php echo $data_tambahan['data_ongkos_kosong_premium'];?>
            
            </div>
            <?php
        }
    ?>



<div class="tile">
    <?php echo $data->links();
    //dd($data);
    foreach ($data as $item){
        if (!$item->dp) echo 'DP belum disini';
        ?>
        <table class="table table-bordered mb-4">
                <tr class="table-active">
                    <td>No Order</td>
                    <td>Bahan Cincin Pria</td>
                    <td>Berat akhir pria</td>
                    <td>Berat awal pria</td>
                    <td>Bahan Cincin Wanita</td>
                    <td>Berat akhir wanita</td>
                    <td>Berat awal wanita</td>
                    <td>Susut(P)</td>
                    <td>Susut (W)</td>
                    <td>Detail</td>
                </tr>
       
      
        <tr>
            <td><?php echo $item->id;?></td> <!-- no order -->
            <td><?php echo $item->bahanpria()->first()['title'];?></td> <!-- bahan cincin pria -->
            <td><?php echo aa('',$item->sertifikat_beratpria,'gr');?></td> <!-- berat akhir pria -->
            <td><?php echo aa('',$item->produksi_beratpria,'gr');?></td> <!-- berat awal pria -->
            <td><?php echo $item->bahanwanita()->first()['title'];?></td> <!-- bahan wanita -->
            <td><?php echo aa('',$item->sertifikat_beratwanita,'gr');?></td> <!-- berat akhir wanita -->
            <td><?php echo aa('',$item->produksi_beratwanita,'gr');?></td> <!-- berat awal wanita -->
            <td><?php echo aa('',($item->sertifikat_beratpria - $item->produksi_beratpria),'gr');?></td>
            <td><?php echo aa('',($item->sertifikat_beratwanita - $item->produksi_beratwanita),'gr');?></td>
            <td><a href="<?php route('laba.detail',['id'=>$item->id]);?>" target="popup" onclick="window.open('<?php echo route('laba.detail',['id'=>$item->id]);?>','popup','width=600,height=800'); return false;">Detail</a></td>
        </tr>
   
        <tr class="table-active">
           <td>DP</td>
           <td>Pelunasan</td>
           <td>Hrg Jual (P)</td>
           <td>Cost. Prod (P)</td> 
           <td>Ongkir</td>
           <td>Hrg Jual (W)</td>
           <td>Cost. Prod(W)</td>
           
           <td>Ttl.Produksi</td>
           <td>Ttl.Pembelian</td>
           <td>Laba Bersih</td>
        </tr>
        <tr>
            <td ><?php echo rupiah($item->dp);?></td>
            <td ><?php echo rupiah($item->pelunasan);?></td>
            <td ><?php echo rupiah($item->sertifikat_beratpria*$item->sertifikat_hargapria);?></td>
            <td ><?php echo rupiah($item->produksi_beratpria*$item->produksi_hargapria);?></td>
            <td ><?php echo rupiah($item->ongkir);?></td>
            <td ><?php echo rupiah($item->sertifikat_beratwanita*$item->sertifikat_hargawanita);?></td>
            <td ><?php echo rupiah($item->produksi_beratwanita*$item->produksi_hargawanita);?></td>
            <td >
                <?php
                    if ($item->sertifikat_done == 2){
                        //-- semuanya emas /pall, bisa sepasang atau 1
                        if ($item->yang_premium == 'PW'){
                            $modal_produksi = ($item->produksi_beratpria*$item->produksi_hargapria)+($item->produksi_beratwanita*$item->produksi_hargawanita)+$item->modal_pengrajin+$item->modal_lapis;
                            echo rupiah ($modal_produksi);
                        }
                        
                        if ($item->yang_premium == 'P'){
                            $modal_produksi = ($item->produksi_beratpria*$item->produksi_hargapria)+$item->modal_pengrajin+$item->modal_lapis;
                            echo rupiah ($modal_produksi);
                        }
                        
                        if ($item->yang_premium == 'W'){
                            $modal_produksi = ($item->produksi_beratwanita*$item->produksi_hargawanita)+$item->modal_pengrajin+$item->modal_lapis;
                            echo rupiah ($modal_produksi);
                        }
                        
                    }elseif ($item->sertifikat_done == 1){
                        //-- perak couple or single
                        $modal_produksi = $modal_produksi = ($item->produksi_beratpria*$item->produksi_hargapria)+($item->produksi_beratwanita*$item->produksi_hargawanita)+$item->modal_pengrajin+$item->modal_lapis;
                        echo rupiah ($modal_produksi);
                    }
                ?>
            </td>
            <td ><?php echo rupiah(((int)$item->dp + (int)$item->pelunasan + (int)$item->ongkir));?></td>
            <td ><?php
                if ($item->sertifikat_done == 2){
                    //-- semuanya emas /pall, bisa sepasang atau 1
                    if ($item->yang_premium == 'PW'){
                        $jual = ($item->sertifikat_beratpria*$item->sertifikat_hargapria)+($item->sertifikat_beratwanita*$item->sertifikat_hargawanita)+$item->ongkos_bikin;
                        echo rupiah ($jual - $modal_produksi);
                    }
                    
                    if ($item->yang_premium == 'P'){
                        $jual = ($item->sertifikat_beratpria*$item->sertifikat_hargapria)+$item->ongkos_bikin;
                        echo rupiah ($jual - $modal_produksi);
                    }
                    
                    if ($item->yang_premium == 'W'){
                        $jual = ($item->sertifikat_beratwanita*$item->sertifikat_hargawanita)+$item->ongkos_bikin;
                        echo rupiah ($jual - $modal_produksi);
                    }
                    
                }elseif ($item->sertifikat_done == 1){
                    //-- perak couple
                    $jual = $item->hargabarang;
                    echo rupiah ((int)$jual - (int)$modal_produksi);
                }
            ?></td>
        </tr>

        <tr>
            <td colspan="2">Ongkos Pengrajin</td>
            <td colspan="2"><?php echo rupiah($item->modal_pengrajin);?></td>
            <td colspan="2">Lapis</td>
            <td colspan="2"><?php echo rupiah($item->modal_lapis);?></td>
            
            
            <?php
                if (!empty($item->dp) && !empty($item->pelunasan) && !empty($item->modal_pengrajin) && !empty($item->modal_lapis) ){
                    echo '<td colspan="2" class="table-success">Status : Done</td>';
                }else{
                    echo '<td colspan="2" class="table-danger">Status : Belum Lengkap</td>';
                }
            ?>
           </tr>

        </table>  
        <?php
    }
    ?>
    <?php echo $data->appends(Request::except('page'))->links();?>
    </div>


   
    </main>
  
@include('layouts.footer');