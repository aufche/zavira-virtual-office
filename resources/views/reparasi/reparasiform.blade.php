@include('layouts.header')
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
      <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
        <div class="card border-warning">
        <div class="card-header bg-warning text-dark">Data Konsumen</div>
            <div class="card-body">
            <div class="form-row">
            <div class="col-md-4 mb-3">
            <label for="validationDefault03">Nama Pemesan</label>
            <input type="text" value="<?php echo old('nama',$data->nama);?>" name="nama" class="form-control" >
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">No. HP</label>
            <input type="text" value="<?php echo $data->nohp;?>" name="nohp" class="form-control" >
            </div>
            
            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Email</label>
            <input type="text" name="email" value="<?php echo $data->email;?>" class="form-control" >
            </div>
            </div>
            <!-- form-row--->        
            <div class="form-group">
            <label for="alamat">Alamat Pengiriman</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="3"><?php echo $data->alamat;?></textarea>
            </div>
            </div>

            

        </div>
        <hr />

        <div class="card border-dark mb-3">
       <div class="card-header bg-dark text-white">Status Garansi Free Lapis 1x</div>
            <div class="card-body">
              <?php
                if ($data->garansi_lapis_pria == 1){
                  echo '<div><strong>CINCIN PRIA</strong> sudah diklaim garansi free lapis 1x pada tanggal '.nice_date($data->tgl_klaim_pria).'</div>';
                }
                if ($data->garansi_lapis_wanita == 1){
                  echo '<div><strong>CINCIN WANITA</strong> sudah diklaim garansi free lapis 1x pada tanggal '.nice_date($data->tgl_klaim_wanita).'</div>';
                }
              ?>
            </div>
        </div>


       <div class="card border-dark mb-3">
       <div class="card-header bg-dark text-white">Detail Reparasi</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                    <label for="validationDefault05">Deadline</label>
                    <input type="text" name="tdeadline" value="<?php echo old('tdeadline');?>" id="date3" class="form-control form-control-lg mb-3" >
                    <label for="validationDefault05">Cincin yang direparasi</label>
                    <select class="form-control form-control-lg mb-3" name="ncincin">
                      <option value="p">Pria Saja</option>
                      <option value="w">Wanita Saja</option>
                      <option value="c">Couple</option>
                    </select>
                    <label for="validationDefault05">Termasuk klaim garansi lapis 1x ?</label>
                    <select class="form-control form-control-lg" name="klaim_garansi_lapis">
                      <option value="y">Ya, klaim garansi lapis 1x gratis</option>
                      <option value="t" selected>Tidak</option>
                    </select>
                    </div>
                    <div class="col-md-4 mb-3">
                    <label for="alamat">Kelengkapan Paket</label>
                    <textarea class="form-control form-control-lg" name="kelengkapan_paket" id="alamat" rows="8" required></textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="alamat">Keterangan Reparasi</label>
                    <textarea class="form-control form-control-lg" name="keterangan_reparasi" id="alamat" rows="8" required></textarea>
                    </div>
                </div>
                <!-- form-row--->

            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block">Masukkan Data Reparasi Ini</button>
      </form>
    </div>
      
    </main>
@include('layouts.footer')