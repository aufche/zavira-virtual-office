@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Pembuatan Sertifikat Logam</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

    <div class="tile">
    <form action="<?php echo route('prosessertifikat');?>" method="post" target="_blank" enctype="multipart/form-data">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input type = "hidden" name = "id" value = "<?php echo $data[0]->id ?>">
        <div class="card border-warning">
        <div class="card-header bg-warning text-dark">Data Konsumen</div>
            <div class="card-body">
            <div class="form-row">
            <div class="col-md-4 mb-3">
            <label for="validationDefault03">Nama Pemesan</label>
            <input type="text" value="<?php echo old('nama',$data[0]->nama);?>" name="nama" class="form-control" >
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">No. HP</label>
            <input type="text" value="<?php echo $data[0]->nohp;?>" name="nohp" class="form-control" >
            </div>
            
            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Email</label>
            <input type="text" name="email" value="<?php echo $data[0]->email;?>" class="form-control" >
            </div>
            </div>
            <!-- form-row--->        
            <div class="form-group">
            <label for="alamat">Alamat Pengiriman</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="3"><?php echo $data[0]->alamat;?></textarea>
            </div>
            </div>

            

        </div>
        <hr />

       <div class="card border-dark mb-3">
       <div class="card-header bg-dark text-white">Detail Cincin Pria</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Berat akhir cincin pria</label>
                    <input type="text" value="<?php echo old('sertifikat_beratpria',$data[0]->sertifikat_beratpria);?>" name="sertifikat_beratpria" class="form-control" >
                    <?php
                    if ($data[0]->bahanpria()->first()['kode']=='s100'){
                      //--- silve 
                      ?>
                      <label for="validationDefault03">Harga untuk cincin pria karena terbuat dari silver</label>
                      <input type="text" value="<?php echo old('harga_cincin_jika_perak_pria',$data[0]->sertifikat_hargapria);?>" name="harga_cincin_jika_perak_pria" class="form-control" >
                      <?php
                    }
                    ?>
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="validationDefault04">Harga per gram</label>
                    <input type="text" name="sertifikat_hargapria" disabled="disabled" value="<?php echo old('sertifikat_hargapria',$data[0]->sertifikat_hargapria);?>" class="form-control" >
                    </div>
                    
                    <div class="col-md-4 mb-3">
                    <div class="form-group">
                      <label for="bpria">Bahan</label>
                      <input type="text" name="bahanpria" disabled="disabled" value="<?php echo $data[0]->bahanpria()->first()['title'];?>" class="form-control" >
                    </div>
                    </div>
                </div>
                <!-- form-row--->
            </div>
        </div>

        <div class="card mb-3 border-info">
        <div class="card-header bg-info text-white">Cincin Wanita</div> 
            <div class="card-body"> 
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Berat akhir cincin wanita</label>
                    <input type="text" name="sertifikat_beratwanita" value="<?php echo old('sertifikat_beratwanita',$data[0]->sertifikat_beratwanita);?>" class="form-control" >

                    <?php
                    if ($data[0]->bahanwanita()->first()['kode']=='s100'){
                      //--- silve 
                      ?>
                      <label for="validationDefault03">Harga untuk cincin wanita karena terbuat dari silver</label>
                      <input type="text" value="<?php echo old('harga_cincin_jika_perak_wanita',$data[0]->sertifikat_hargawanita);?>" name="harga_cincin_jika_perak_wanita" class="form-control" >
                      <?php
                    }
                    ?>
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="validationDefault04">Harga per gram</label>
                    <input type="text" name="sertifikat_hargawanita" disabled="disabled" value="<?php echo old('sertifikat_hargawanita',$data[0]->sertifikat_hargawanita);?>" class="form-control" >
                    </div>
                    
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault05">Bahan</label>
                    <input type="text" name="bahanwanita" disabled="disabled" value="<?php echo $data[0]->bahanwanita()->first()['title'];?>" class="form-control" >
                    </div>
                </div>
                <!-- form-row--->
            </div>
        </div>


        <div class="card mb-3 border-info">
        <div class="card-header bg-info text-white">Tambahan</div> 
            <div class="card-body"> 
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault03">Ongkos Bikin</label>
                    <input type="text" name="ongkos_bikin" value="<?php echo old('ongkos_bikin',$data[0]->ongkos_bikin);?>" class="form-control" >
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="validationDefault04">Item Tambahan (Misal : berlian)</label>
                    <input type="text" name="sertifikat_berlian"  class="form-control" value="<?php echo old('sertifikat_berlian',$data[0]->sertifikat_berlian);?>" >
                    </div>
                    
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault05">Harga</label>
                    <input type="text" name="sertifikat_harga_berlian"  class="form-control" value="<?php echo old('sertifikat_harga_berlian',$data[0]->sertifikat_harga_berlian);?>" >
                    </div>
                </div>
                <!-- form-row--->
            </div>
        </div>


        <div class="form-group">
          <label for="sertifikat_gambarcincin">Gambar Cincin Jadi</label>
          <input type="file" class="form-control-file" name="sertifikat_gambarcincin" id="sertifikat_gambarcincin" placeholder="" aria-describedby="sertifikat_gambarcincin">
          <small id="sertifikat_gambarcincin" class="form-text text-muted">Silahkan upload gambar hasil jadi cincin</small>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="250000" name="kotakcincin" <?php if (!empty($data[0]->sertifikat_kotakcincin)) echo 'checked="checked"';?>>
           <label class="form-check-label" for="defaultCheck1">Kotak cincin kayu</label>
           
        </div>

        
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="120000" name="freeongkir" <?php if (!empty($data[0]->sertifikat_freeongkir)) echo 'checked="checked"';?>>
           <label class="form-check-label" for="defaultCheck1">Free ongkir ke seluruh indonesia</label>
           
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Bikin Sertifikat Sekarang</button>
      </form>
    </div>
      
    </main>
@include('layouts.footer');