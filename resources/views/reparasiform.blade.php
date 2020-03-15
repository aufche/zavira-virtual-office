@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Input Data Reparasi</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

    <div class="tile">
    <form action="<?php echo route('prosesreparasiform');?>" method="post" enctype="multipart/form-data">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input type = "hidden" name = "id" value = "<?php echo $data[0]->id; ?>">
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
       <div class="card-header bg-dark text-white">Detail Reparasi</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault05">Deadline</label>
                    <input type="text" name="tdeadline" value="<?php echo old('tdeadline');?>" id="date3" class="form-control form-control-lg" >
                    </div>
                    <div class="col-md-4 mb-3">
                    <label for="alamat">Kelengkapan Paket</label>
                    <textarea class="form-control form-control-lg" name="kelengkapan_paket" id="alamat" rows="3"></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="alamat">Keterangan Reparasi</label>
                    <textarea class="form-control form-control-lg" name="keterangan_reparasi" id="alamat" rows="3"></textarea>
                    </div>
                </div>
                <!-- form-row--->

            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Masukkan Data Reparasi Ini</button>
      </form>
    </div>
      
    </main>
@include('layouts.footer');