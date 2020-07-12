@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Promo</h1>
          <p>Daftar Semua Promo</p>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="<?php echo route('stock.insert');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationDefault03">Stock Kelengkapan</label>
                <input type="text" name="title" class="form-control-lg form-control" required>
                
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault03">Jumlah</label>
                <input type="text" name="jumlah" class="form-control-lg form-control" required>
                
                
                </div>

                <div class="col-md-2 mb-3">
                <label for="validationDefault04">Status</label>
                <select name="aktif" class="form-control form-control-lg">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                </div>

                
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
        </form>
      </div>
    </main>
@include('layouts.footer');