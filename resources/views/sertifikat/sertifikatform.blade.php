@include('layouts.header')
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
      <input type = "hidden" name = "id" value = "<?php echo $data->id ?>">
        <div class="card border-warning">
        <div class="card-header bg-warning text-dark">Data Konsumen</div>
            <div class="card-body">
            <div class="form-row">
            <div class="col-md-4 mb-3">
            <label for="validationDefault03">Nama Pemesan</label>
            <input type="text" value="<?php echo old('nama',$data->nama);?>" name="nama" class="form-control form-control-lg" >
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">No. HP</label>
            <input type="text" value="<?php echo $data->nohp;?>" name="nohp" class="form-control form-control-lg" >
            </div>
            
            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Email</label>
            <input type="text" name="email" value="<?php echo $data->email;?>" class="form-control form-control-lg" >
            </div>
            </div>
            <!-- form-row--->        
            <div class="form-group">
            <label for="alamat">Alamat Pengiriman</label>
            <textarea class="form-control form-control-lg" name="alamat" id="alamat" rows="3"><?php echo $data->alamat;?></textarea>
            </div>
            </div>

            

        </div>
        <hr />


        <?php 
        if (empty($data->ukuranpria) && empty($data->bpria)){
            echo '<div class="card mb-3 shadow border-dark" style="display:none">';
            //echo '<div class="card mb-3 shadow border-dark">';
        }else{
            
            echo '<div class="card mb-3 shadow border-dark">';
        }
        ?>
       
       <div class="card-header bg-dark text-white">Detail Cincin Pria</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Berat akhir cincin pria (Berat maksimal <?php echo $data->produksi_beratpria;?> gr)</label>
                    <input type="text" value="<?php echo old('sertifikat_beratpria',$data->sertifikat_beratpria);?>" name="sertifikat_beratpria" class="form-control form-control-lg" >
                    <?php
                    if (title_logam($data->bahanpria()->first(),'kode') == 's100'){
                      //--- silve 
                      ?>
                      <label for="validationDefault03">Harga untuk cincin pria karena terbuat dari silver</label>
                      <input type="text" value="<?php echo old('harga_cincin_jika_perak_pria',$data->sertifikat_hargapria + ($data->sertifikat_hargapria * 0.1));?>" name="harga_cincin_jika_perak_pria" class="form-control form-control-lg" >
                      <?php
                    }
                    ?>
                    </div>
                    <?php
                      if ($data->skema_baru == 1){
                    ?>
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Biaya Produksi Cincin Pria</label>
                    <input type="number" value="<?php echo old('sertifikat_beratpria',$data->biaya_produksi_pria);?>" name="biaya_produksi_pria" class="form-control form-control-lg" >
                    </div>
                    <?php } ?>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Harga per gram</label>
                    <input type="number" name="sertifikat_hargapria" disabled="disabled" value="<?php echo old('sertifikat_hargapria',$data->sertifikat_hargapria);?>" class="form-control form-control-lg" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <label for="bpria">Bahan</label>
                      <input type="text" name="bahanpria" disabled="disabled" value="<?php echo title_logam($data->bahanpria()->first(),'title');?>" class="form-control form-control-lg" >
                    </div>
                    </div>
                </div>
                <!-- form-row--->
            </div>
        </div>

        <?php 
        if (empty($data->ukuranwanita) && empty($data->bwanita)){
            echo '<div class="card mb-3 shadow border-info" style="display:none">';
            //echo '<div class="card mb-3 shadow border-info">';
        }else{
            echo '<div class="card mb-3 shadow border-info">';
        }
        ?>

        
        <div class="card-header bg-info text-white">Cincin Wanita</div> 
            <div class="card-body"> 
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Berat akhir cincin wanita (Berat maksimal <?php echo $data->produksi_beratwanita;?> gr)</label>
                    <input type="text" name="sertifikat_beratwanita" value="<?php echo old('sertifikat_beratwanita',$data->sertifikat_beratwanita);?>" class="form-control form-control-lg" >

                    <?php
                    if (title_logam($data->bahanwanita()->first(),'kode') == 's100'){
                      //--- silve 
                      ?>
                      <label for="validationDefault03">Harga untuk cincin wanita karena terbuat dari silver</label>
                      <input type="text" value="<?php echo old('harga_cincin_jika_perak_wanita',$data->sertifikat_hargawanita + ($data->sertifikat_hargawanita * 0.1));?>" name="harga_cincin_jika_perak_wanita" class="form-control form-control-lg" >
                      <?php
                    }
                    ?>
                    </div>
                    <?php
                      if ($data->skema_baru == 1){
                    ?>
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Biaya Produksi Cincin Wanita</label>
                    <input type="number" value="<?php echo old('sertifikat_beratwanita',$data->biaya_produksi_wanita);?>" name="biaya_produksi_wanita" class="form-control form-control-lg" >
                    </div>
                    <?php } ?>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Harga per gram</label>
                    <input type="text" name="sertifikat_hargawanita" disabled="disabled" value="<?php echo old('sertifikat_hargawanita',$data->sertifikat_hargawanita);?>" class="form-control form-control-lg" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Bahan</label>
                    <input type="text" name="bahanwanita" disabled="disabled" value="<?php echo title_logam($data->bahanwanita()->first(),'title');?>" class="form-control form-control-lg" >
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
                    <input type="text" name="ongkos_bikin" value="<?php echo old('ongkos_bikin',$data->ongkos_bikin);?>" class="form-control form-control-lg" >
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="validationDefault04">Item Tambahan (Misal : berlian)</label>
                    <input type="text" name="sertifikat_berlian"  class="form-control form-control-lg" value="<?php echo old('sertifikat_berlian',$data->sertifikat_berlian);?>" >
                    </div>
                    
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault05">Harga</label>
                    <input type="text" name="sertifikat_harga_berlian"  class="form-control form-control-lg" value="<?php echo old('sertifikat_harga_berlian',$data->sertifikat_harga_berlian);?>" >
                    </div>
                </div>
                <!-- form-row--->
            </div>
        </div>


        <div class="form-group">
          <label for="sertifikat_gambarcincin">Gambar Cincin Jadi</label>
          <input type="file" class="form-control-file form-control-lg-file" name="sertifikat_gambarcincin" id="sertifikat_gambarcincin" placeholder="" aria-describedby="sertifikat_gambarcincin">
          <small id="sertifikat_gambarcincin" class="form-text text-muted">Silahkan upload gambar hasil jadi cincin</small>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="250000" name="kotakcincin" <?php if (!empty($data->sertifikat_kotakcincin)) echo 'checked="checked"';?>>
           <label class="form-check-label" for="defaultCheck1">Kotak cincin kayu</label>
           
        </div>

        
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="120000" name="freeongkir" <?php if (!empty($data->sertifikat_freeongkir)) echo 'checked="checked"';?>>
           <label class="form-check-label" for="defaultCheck1">Free ongkir ke seluruh indonesia</label>
           
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Bikin Sertifikat Sekarang</button>
      </form>
    </div>
      
    </main>
@include('layouts.footer')