@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Edit Stock Kelengkapan Penjualan</h1>
          
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="<?php echo route('stock.insert',['action'=>'edit']);?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationDefault03">Judul Promo</label>
                <input type="text" value = "<?php echo $data->title; ?>" name="title" class="form-control-lg form-control" required>
                
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault03">Nominal</label>
                <input type="text" value = "<?php echo $data->jumlah; ?>" name="jumlah" class="form-control-lg form-control" required>
                
                </div>

                <div class="col-md-2 mb-3">
                <label for="validationDefault04">Status</label>
                <select name="aktif" class="form-control form-control-lg">
                    <option value="1" <?php if ($data->status == 1) echo 'selected="selected"';?>>Aktif</option>
                    <option value="0" <?php if ($data->status == 0) echo 'selected="selected"';?>>Tidak Aktif</option>
                </select>
                </div>

                
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
        </form>
      </div>
    </main>
@include('layouts.footer')