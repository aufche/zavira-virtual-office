@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-gem"></i> Edit Logam <?php echo $data->id;?></h1>
          <p>Sebelum mengubah logam, perlu diperhatikan bahwa harga cincin akan mengikuti  harga logam efektif hari ini.</p>
        </div>
      </div>
    <div class="tile">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
           <form method="post" action="<?php echo route('pesanan.force.edit');?>">
           <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
            <div class="form-row">
                <div class="col-md-6 col-sm-12 mb-3">
                    
                      <label for="bpria">Harga per gram logam cincin pria</label>
                      <input type="text" class="form-control form-control-lg" name="sertifikat_hargapria" value="<?php echo $data->sertifikat_hargapria;?>" />
                      <small id="helpId" class="form-text text-muted"><?php echo rupiah($data->sertifikat_hargapria);?> per gram</small>
                    
                    </div>

                   

                <div class="col-md-6 col-sm-12 mb-3">
                  
                      <label for="bpria">Harga per gram logam cincin wanita</label>
                      <input type="text" class="form-control form-control-lg" name="sertifikat_hargawanita" value="<?php echo $data->sertifikat_hargawanita;?>" />
                      <small id="helpId" class="form-text text-muted"><?php echo rupiah($data->sertifikat_hargawanita);?> per gram</small>

                   
                    </div>

                    
            </div>
            <button type="submit" class="btn btn-warning btn-lg btn-block border-dark">Update</button>
           </form>
    </div>
    </main>
  
@include('layouts.footer');