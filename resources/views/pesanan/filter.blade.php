@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Orders</h1>
          <p>This page contains all orders</p>
        </div>
      </div>
    <div class="tile">

    <form action="<?php echo route('pesanan.result.filter');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            <div class="col-md-3">
            <label for="validationDefault05">Asal Orderan</label>
            <select class="form-control" name="asal_id">
                <option value="" selected="selected">Pilih asal orderan</option>
                <?php 
                    foreach ($data as $title=>$id){
                        ?>
                        <option value="<?php echo $id;?>"><?php echo $title;?></option>
                        <?php
                    }
                ?>
                </select>
            </div>


            <div class="col-md-3">
            <label for="validationDefault05">Export Data</label>
            <select class="form-control" name="export">
                <option value="0" selected="selected">Pilih opsi export</option>
                <option value="undian">Export nomor undian</option>
                <option value="email">Export data email</option>
                <option value="nohp">Export data nomor HP</option>
                </select>
            </div>

            <div class="col-md-3">
               
                 <label for="">Dari Tanggal</label>
                 <input type="text" class="form-control" name="tanggal_awal" id="date" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-3">
                 <label for="">Sampai Tanggal</label>
                 <input type="text" class="form-control" name="tanggal_akhir" id="date2" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            <div class="col-md-6">
            <label for="validationDefault05">Tipe Finising</label>
            <select class="form-control" name="finising_type">
                <option value="" selected="selected">Pilih opsi finising</option>
                <option value="0">Masih di pengrajin</option>
                <option value="1">Sudah Finising tapi belum dikantor</option>
                <option value="2">Selesai finising dan sudah di kantor</option>
                </select>
            </div>

            <div class="col-md-6 mt-3">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>
            </div>
        </div>
    
    </form>
                    
    </div>
    </main>
  
@include('layouts.footer');