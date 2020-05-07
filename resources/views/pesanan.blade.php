@include('layouts.header');
<style type="text/css">
   @media (max-width: 767px) {
    .table-responsive .dropdown-menu {
        position: static !important;
    }
}
@media (min-width: 768px) {
    .table-responsive {
        overflow: visible;
    }
}
</style>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1 class="h3"><i class="fas fa-tachometer-alt"></i> All Orders</h1>
          <p>This page contains all orders</p>
          <p id="man"></p>
        </div>
      </div>

    

      <div class="tile">

    <form action="<?php echo route('pesanan.result.simple.filter');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            
            <div class="col-md-4">
               
                 <label for="">Dari Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_awal" id="date" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-4">
                 <label for="">Sampai Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_akhir" id="date2" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            <div class="col-md-4">
            <label for="validationDefault05">Status Produksi</label>
            <select class="form-control form-control-lg" name="finising_type">
                <option value="" selected="selected">Masih dikerjakan</option>
                <option value="1">Proses Finising</option>
                <option value="2">Selesai finising dan sudah di kantor</option>
                <option value="3">Sudah dikirim</option>
                </select>
            </div>

            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-warning btn-lg btn-block shadow border border-dark"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>
    
    </form>
                    
    </div>

    <?php
      if (!empty($data_count)){
        ?>
        <div class="tile">
          Total Orderan <?php echo $data_count;?>
        </div>
        <?php
      }
    ?>

      <div class="tile">
       @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <?php echo $data->appends(Request::except('page'))->links();?>
        
           <?php
       
      
            foreach ($data as $item){
                if ($item->urgent == 1){
                  $trclass = 'table-warning';
                }
                else{
                  $trclass ='';
                }
                ?>

                <div class="table-responsive  mb-5 clearfix">
                    <table class="table table-hover table-bordered shadow rounded">
                    <thead>
                    <tr>
                        <th>No Order</th>
                        <!--<th>Option</th>-->
                        <th>Nama Pemesan</th>
                        <th>Kode</th>
                        <th>Bahan Cincin Pria</th>
                        <th>Bahan Cincin Wanita</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>Asal & CS</th>
                        <th>Pengrajin</th>
                        <th>Urgen?</th>
                    </tr>
                    </thead>
                    <tbody>


                <tr class="<?php echo $trclass;?>">
                  <td><?php echo $item->id;?> <br /> <?php if ($item->siap_cetak == 1) echo '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>';?> <?php if ($item->kirim_ke_pengrajin == 1) echo '<i class="fa fa-share" aria-hidden="true"></i>';?></td>
                    
                    <td>
                    <?php //echo $item->finising.'<br /';?>
                    <a data-toggle="collapse" href="#collapseExample<?php echo $item->id;?>"><?php echo $item->nama;?></a>
                    <div class="collapse" id="collapseExample<?php echo $item->id;?>">
                      Alamat pengiriman : <?php echo $item->alamat;?>, <?php echo $item->nohp;?><br />
                      <hr>
                      <?php echo $item->keterangan;?><hr />
                      <?php
                        if (!empty($item->gambar)){
                          ?>
                          <img src="<?php echo $item->gambar;?>" class="img-thumbnail" alt="cincin" /><br />
                          <?php
                        }

                        if (!empty($item->gambargambar)){
                          $gambar = explode(',',$item->gambargambar);
                            foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-thumbnail" width="200px" /><br />
                            <?php
                        }
                        }
                      ?><br />
                      <?php echo aa('Harga ',rupiah($item->hargabarang,'<br />'));?><br />
                      <?php echo aa('DP ',rupiah($item->dp,'<br />'));?><br />
                      <?php echo aa('Ongkir ',rupiah($item->ongkir,'<br />'));?><br />
                      <?php echo aa('Pelunasan ',rupiah($item->pelunasan,'<br />'));?><br />
                      <?php 
                        if (!empty($item->free_woodbox)){
                          echo aa('Grafir ',$item->free_woodbox);
                        }
                      ?>
                    </div>
                    </td>
                    <td><?php echo $item->kodecincin;?></td>
                    <td><?php echo $item->bahanpria()->first()['title'];?><br /><?php echo aa('Ukuran ',$item->ukuranpria);?><br /><?php echo aa('Grafir ',$item->grafirpria);?><br /><?php echo aa('Max ',$item->produksi_beratpria,'gr');?></td>
                    <td><?php echo $item->bahanwanita()->first()['title'];?><br /><?php echo aa('Ukuran ',$item->ukuranwanita);?><br /><?php echo aa('Grafir ',$item->grafirwanita);?><br /><?php echo aa('Max ',$item->produksi_beratwanita,'gr');?></td>
                    <td><?php echo date('d M Y', strtotime($item->tglmasuk));?></td>
                    <td><?php echo date('d M Y', strtotime($item->tglselesai));?><br /><span class="badge badge-pill badge-warning">Deadline pengrajin <?php echo date('d M Y', strtotime($item->deadline));?></span></td>
                    <td><?php echo $item->asal->title;?><br />By <?php echo $item->user->name;?></td>
                    <td><?php echo $item->pengrajin->nama;?></td>
                    <td><?php echo text_urgent($item->urgent);?></td>
                </tr>

                <tr class="table-info">
                    <td colspan="2">Status</td>
                    <td>
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
                    <td colspan="2">Free kotak exclusive <?php echo $item->finising;?></td>
                    <td colspan="2"><?php if (!empty($item->free_woodbox)) {
                      echo '<span class="badge badge-danger">Ya</span>';
                      echo $item->free_woodbox;
                      if ($item->woodbox_ok == 1){
                          echo ' <i class="fas fa-check-circle"></i> Sudah dibuat';
                      }
                    }else{
                      echo 'Tidak';
                    };?></td>
                    <td colspan="2">Promo</td>
                    <td colspan="1"><?php if ($item->promo_id) echo $item->promo->title;?></td>
                </tr>
                <tr class="bg-dark text-white">
                    <td class="border border-bottom border-dark border-top-0 border-right-0 border-left-0" colspan="2">
                        <div class="dropdown dropright">
                        
                        <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-asterisk"></i> Action</a>

                        <div class="dropdown-menu shadow shadow-lg" aria-labelledby="dropdownMenuLink">
                           
                          <a class="dropdown-item" href="<?php echo route('edit',['id'=>$item->id]);?>"><i class="fas fa-edit"></i> Edit</a>
                          
                          <a class="dropdown-item" href="<?php 
                            if (!empty($item->pelunasan)){
                              echo route('cetak.amplop',['id'=>$item->id]);
                            }else{
                              echo route('pelunasan',['id'=>$item->id,'re'=>'cetak.amplop']);
                            }
                          ?>" target="_blank"><i class="fas fa-envelope-open-text"></i> Cetak Amplop</a>
                          <a class="dropdown-item" href="<?php echo route('buktidp',['id'=>$item->id]);?>" target="_blank"><i class="fas fa-file-invoice-dollar"></i> Cetak Bukti Pembayaran DP</a>
                          <!--<a class="dropdown-item" href="#">Cetak Nota Pembelian</a>-->
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item" target="popup" onclick="window.open('<?php echo route('pesanan.pembayaran.pelunasan',['id'=>$item->id]);?>','popup','width=600,height=500,location=no'); return false;" ><i class="fas fa-scroll"></i> Update Pelunasan  Non Tunai</a>
                          <a href="<?php echo route('pembukuan.add',['status'=>1,'id'=>$item->id]);?>" class="dropdown-item"><i class="fas fa-scroll"></i> Update Pelunasan Tunai</a>
                          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_lunas" data-whatever="<?php echo $item->id;?>" data-jenis="resi"><i class="fas fa-scroll"></i> Update Resi</a>
                          <div class="dropdown-divider"></div>
                          <!--<a class="dropdown-item" href="<?php echo route('pelunasan',['id'=>$item->id,'re'=>'semua']);?>"><i class="fas fa-scroll"></i> Update Pelunasan dan Resi</a>-->
                          <a class="dropdown-item" href="<?php echo route('take',['id'=>$item->id,'template'=>'print']);?>" target="popup" onclick="window.open('<?php echo route('take',['id'=>$item->id,'template'=>'print']);?>','popup','width=800,height=600'); return false;"><i class="fas fa-print"></i> Cetak Order Ini</a>
                          <!--<a class="dropdown-item" href="#" target="popup" onclick="konfirmasi('Yakin akan mencetak orderan ini?','<?php echo route('take',['id'=>$item->id,'template'=>'print']);?>')"><i class="fas fa-print"></i> Cetak Order Ini</a>-->

                          <a class="dropdown-item" href="<?php echo route('penting.add',['id'=>$item->id,'tambahan'=>'lapis']);?>"><i class="fas fa-exclamation-triangle"></i> Pengaduan Masalah</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="<?php echo route('sertifikatform',['id'=>$item->id]);?>"><i class="fas fa-award"></i> Buat/Edit Sertifikat</a>
                          <a class="dropdown-item" target="_blank" href="
                            <?php if ($item->ispremium == 1){
                                  echo route('sertifikat.single',['id'=>$item->id]);
                                }elseif ($item->ispremium == 2){
                                  echo route('sertifikat.premium',['id'=>$item->id]);
                                }elseif($item->ispremium == 0){ 
                                  echo route('sertifikat.silver',['id'=>$item->id]); 
                                }
                                ?>"><i class="fas fa-sticky-note"></i> Cetak Sertifikat</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="<?php echo route('riwayat',['id'=>$item->id]);?>"><i class="fas fa-tools"></i> Catatan Reparasi</a>
                          <a class="dropdown-item" href="<?php echo route('reparasiform',['id'=>$item->id]);?>"><i class="fas fa-hammer"></i> Reparasi Baru</a>
                          <a class="dropdown-item" href="<?php echo route('timeline.index',['id'=>$item->id]);?>"><i class="fas fa-business-time"></i> Timeline Orderan</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="<?php echo route('hapus',['id'=>$item->id]);?>"><i class="fas fa-trash-alt"></i> Hapus</a>
                        </div>
                      </div>
                    </td>
                    <td class="border border-bottom border-dark border-top-0 border-right-0 border-left-0"><?php echo aa('Harga<br />',rupiah($item->hargabarang));?></td>
                    <td colspan="2" class="border border-bottom border-dark border-top-0 border-right-0 border-left-0"><?php echo aa('DP<br />',rupiah($item->dp));?></td>
                    <td colspan="2" class="border border-bottom border-dark border-top-0 border-right-0 border-left-0"><?php echo aa('Ongkir<br />',rupiah($item->ongkir));?></td>
                    <td colspan="2" class="border border-bottom border-dark border-top-0 border-right-0 border-left-0"><?php echo aa('Pelunasan<br />',rupiah($item->pelunasan));?></td>
                    <td colspan="2" class="border border-bottom border-dark border-top-0 border-right-0 border-left-0"><?php echo aa('Resi<br />',$item->resi,'<br />'.$item->kurir->title);?></td>
                    
                </tr>
                <!--<tr>
                    <td colspan="3">Finising <?php echo $item->finising;?></td>
                    <td colspan="3">Siap Cetak <?php echo $item->siap_cetak;?></td>
                    <td colspan="5">kirim ke pak bejo <?php echo $item->kirim_ke_pengrajin;?></td>
                </tr>-->
                    </tbody>
            </table>
            </div> <!-- responsive table -->
                <?php
            }
           ?>
        <?php echo $data->appends(Request::except('page'))->links();?><br />

        <div class="container">
          <div class="row">
            <div class="col-md-6">
            <?php
                if (!empty($bahanpria)){
                 echo '<table class="table table-bordered table-hover">';
                 echo '<tr>
                    <td colspan="2">Komposisi Pesanan Logam Pria</td>
                 </tr>';
                  foreach ($bahanpria as $logampria){
                    ?>
                      <tr>
                        <td><?php echo $logampria->bahanpria()->first()['title'];?></td>
                        <td><?php echo $logampria->total;?></td>
                      </tr>
                    <?php
                  }
                  echo '</table>';
                }
              ?>              
            </div>

            <div class="col-md-6">
            <?php
                if (!empty($bahanwanita)){
                 echo '<table class="table table-bordered table-hover">';
                 echo '<tr>
                    <td colspan="2">Komposisi Pesanan Logam Wanita</td>
                 </tr>';
                  foreach ($bahanwanita as $logamwanita){
                    ?>
                      <tr>
                        <td><?php echo $logamwanita->bahanwanita()->first()['title'];?></td>
                        <td><?php echo $logamwanita->total;?></td>
                      </tr>
                    <?php
                  }
                  echo '</table>';
                }
              ?>  
            </div>

            <div class="col-md-12">
                <?php 
                  if (!empty($finising)){
                    echo '<table class="table table-bordered table-hover">';
                    echo '<tr>
                        <td>Status</td>
                        <td>Jumlah</td>
                    </tr>';
                    foreach ($finising as $item){
                      ?>
                      <tr>
                        <td><?php if ($item->finising == null || $item->finising == 0) 
                          echo 'Belum finising'; 
                          elseif ($item->finising == 1) 
                          echo 'Sudah Finising';
                          elseif ($item->finising == 2)
                          echo 'Sudah finising dan di kantor';
                          ?></td>
                        <td><?php echo $item->total;?></td>
                      </tr>
                    <?php
                    }
                    echo '</table>';
                  }
                  ?>
            </div>
          </div>
        </div>
        
      </div>

    </main>


<div class="modal fade" id="modal_lunas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="<?php echo route('pesanan.pelunasan') ?>">
      <div class="modal-body">
            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <input type="hidden" id="modal_jenis" name="jenis" />
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">No. Order</label>
            <input type="text" class="form-control form-control-lg" id="no_order" name="id" readonly>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label" id="target">Nominal</label>
            <input type="text" class="form-control form-control-lg" name="nominal">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-warning border-dark btn-lg">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    /*function konfirmasi(pertanyaan,url){
        var response = confirm(pertanyaan);
        if (response == true){
            window.open(url,'popup','width=800,height=600');
        }else{
            return false;
        }
    }
    */


</script>
@include('layouts.footer');
