@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Pesanan</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>
      
      <div class="tile">
     
        <?php
          if ($redirect == 'cetak.amplop'){
            echo '<div class="alert alert-primary" role="alert">
            Silahkan isikan jumlah pelunasan terlebih dahulu. Jika sudah lunas, silahkan isi dengan angka nol
            </div>';
          }
        ?>
      <form action="<?php echo route('prosespelunasan');?>" method="post" enctype="multipart/form-data">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input type = "hidden" name = "id" value = "<?php echo $data->id ?>">
      <input type = "hidden" name = "re" value = "<?php echo $redirect ?>">
        <div class="card border-warning">
        <div class="card-header bg-warning text-dark">Update Resi dan Pelunasan</div>
            <div class="card-body">
            <div class="form-row">
            <div class="col-md-4 mb-3">
            <label for="validationDefault03">No Resi</label>
            <input type="text" value="<?php echo old('nama',$data->resi);?>" name="resi" class="form-control form-control-lg" >
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">Pelunasan</label>
            <input type="number" value="<?php echo $data->pelunasan;?>" name="pelunasan" class="form-control form-control-lg" >
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">Ongkir</label>
            <input type="number" value="<?php echo $data->ongkir;?>" name="ongkir"  class="form-control form-control-lg" >
            </div>

            <!--<div class="col-md-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" />
                    <label class="form-check-label">
                        Cincin ini sudah dikirim dan sudah tidak ada di showroom
                    </label>
                </div>
                
            </div>-->
            
            </div>
            <!-- form-row--->        
            <button type="submit" class="btn btn-warning btn-lg btn-block">Simpan</button>            
            </div>

            

        </div>
        
      </form>


      </div>

      
    </main>
@include('layouts.footer')