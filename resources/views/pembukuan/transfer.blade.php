@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Transaksi Cash</h1>
          <p>Pada halaman ini, kamu bisa menambah data transaksi cash</p>
        </div>
      </div>

      <div class="tile">
        <h2 class="font-weight-light h3 text-uppercase">Transfer Antar Pembukuan</h2>
      </div>

      <div class="tile">
       <form method="post" action="<?php echo route('pembukuan.transfering');?>" autocomplete="off">
       <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    
       <div class="card border-success">
        <div class="card-header bg-success text-white">Data Transaksi</div>
            <div class="card-body">
            <div class="form-row">

        
            <div class="col-md-6 mb-3">
            <label for="validationDefault04">Tanggal</label>
            <input type="text" name="tanggal" value="<?php echo old('tanggal');?>" id="date" class="form-control form-control-lg" required>
            </div>
            
            <div class="col-md-6 mb-3">
            <label for="validationDefault05">Nominal</label>
            <input type="text" name="nominal" class="form-control form-control-lg" value="<?php echo old('nominal');?>" required>
            </div>

            </div>

            <div class="form-row">
            
            <div class="col-md-6 mb-3">
            <label for="validationDefault05">Dari Buku</label>
            <select class="form-control form-control-lg" name="asal_buku_id" required>
                        <?php 
                            foreach ($buku as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>|<?php echo $title;?>"><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
            </div>

            <div class="col-md-6 mb-3">
            <label for="validationDefault05">Menuju ke Buku</label>
            <select class="form-control form-control-lg" name="tujuan_buku_id" required>
                        <?php 
                            foreach ($buku as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>|<?php echo $title;?>"><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
            </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">Simpan</button>

            </div>
        </div>

       </form>
      </div>

     
    </main>
@include('layouts.footer')