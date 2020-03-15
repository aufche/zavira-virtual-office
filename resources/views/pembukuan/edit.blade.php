@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Transaksi Cash</h1>
          <p>Pada halaman ini, kamu bisa menambah data transaksi cash</p>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
       <form method="post" action="<?php echo route('pembukuan.insert',['aksi'=>'edit']);?>">
       <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
       <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
       <input type = "hidden" name = "jenis_transaksi" value = "<?php echo $data->jenis_transaksi; ?>">

       <div class="card border-dark">
        <div class="card-header bg-dark text-white">Data Pembukuan</div>
            <div class="card-body">
            <div class="form-row">

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">Tanggal</label>
            <input type="text" name="tanggal" value="<?php echo old('tanggal',$data->tanggal);?>" id="date" class="form-control" required>
            </div>
            
            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Nominal</label>
            <input type="text" name="nominal" class="form-control" value="<?php if ($data->jenis_transaksi == 1) echo $data->masuk; else echo $data->keluar;?>" required>
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Buku</label>
            <select class="form-control" name="buku_id" required>
                        <?php 
                            foreach ($buku as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if ($id == $data->buku_id) echo 'selected="selected"';?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
            </div>

            </div>

            
            <!-- form-row--->        
            <div class="form-group">
            <label for="alamat">Keterangan</label>
            <textarea class="form-control" name="keterangan" rows="3" required><?php echo $data->keterangan;?></textarea>
            </div>

            <button type="submit" class="btn btn-dark btn-lg btn-block">Simpan</button>

            </div>
        </div>

       </form>
      </div>

     
    </main>
@include('layouts.footer');