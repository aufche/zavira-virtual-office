@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Transaksi Cash</h1>
          <p>Pada halaman ini, kamu bisa menambah data transaksi cash</p>
        </div>
      </div>

      <div class="tile">
        <?php
        if ($jenis_transaksi == 1){
            $class = "border-info";
            $class2 ="bg-info text-white";
            $header = 'Menambah transaksi dana masuk';
            $btn = "btn-info";
        }else{
            $class = "border-warning";
            $class2 ="bg-warning text-dark";
            $header = 'Menambah transaksi dana keluar';
            $btn = "btn-warning";
        }
        ?>
        <h2 class="font-weight-light h3 text-uppercase"><?php echo $header;?></h2>
      </div>

      <div class="tile">
       <form method="post" action="<?php echo route('pembukuan.insert');?>" autocomplete="off">
       <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
       <input type = "hidden" name = "jenis_transaksi" value = "<?php echo $jenis_transaksi; ?>">

       <div class="card <?php echo $class;?>">
        <div class="card-header <?php echo $class2;?>">Data Transaksi</div>
            <div class="card-body">
            <div class="form-row">

        
            <div class="col-md-4 mb-3">
            <label for="validationDefault04">Tanggal</label>
            <input type="text" name="tanggal" value="<?php echo old('tanggal');?>" id="date" class="form-control" required>
            </div>
            
            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Nominal</label>
            <input type="text" name="nominal" class="form-control" value="<?php echo old('nominal');?>" required>
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Buku</label>
            <select class="form-control" name="buku_id" required>
                        <?php 
                            foreach ($buku as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
            </div>

            </div>

            
            <!-- form-row--->        
            <div class="form-row">
            <div class="col-md-4">
            <?php
              if ($jenis_transaksi == 1){
            ?>
              <label for="alamat">Pelunasan dari siapa?</label>
              <input type="text" class="form-control mb-3" name="show_user" id="show-user" />  
              <label for="alamat">No Order</label>
              <input type="text" class="form-control" name="pesanan_id" value="<?php if (isset($_GET['id'])) echo $_GET['id'];?>" readonly />        
              <?php } ?>
            </div>

            <div class="col-md-8">
              <label for="alamat">Keterangan</label>
              <textarea class="form-control" name="keterangan" rows="5" required><?php echo old('keterangan');?></textarea>                
            </div>
            
            
            </div>

            <button type="submit" class="btn <?php echo $btn;?> btn-lg btn-block mt-3">Simpan</button>

            </div>
        </div>

       </form>
      </div>

     
    </main>
@include('layouts.footer');