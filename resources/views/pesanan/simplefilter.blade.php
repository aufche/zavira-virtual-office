@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Orders</h1>
          <p>This page contains all orders</p>
        </div>
      </div>
    <div class="tile">

    <form action="<?php echo route('pesanan.result.simple.filter');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            
            <div class="col-md-4">
               
                 <label for="">Dari Tanggal</label>
                 <input type="text" class="form-control" name="tanggal_awal" id="date" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-4">
                 <label for="">Sampai Tanggal</label>
                 <input type="text" class="form-control" name="tanggal_akhir" id="date2" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            <div class="col-md-4">
            <label for="validationDefault05">Tipe Finising</label>
            <select class="form-control" name="finising_type">
                <option value="" selected="selected">Masih dikerjakan</option>
                <option value="1">Proses Finising</option>
                <option value="2">Selesai finising dan sudah di kantor</option>
                <option value="3">Sudah dikirim</option>
                </select>
            </div>

            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>
            </div>
        </div>
    
    </form>
                    
    </div>
    </main>
  
@include('layouts.footer')