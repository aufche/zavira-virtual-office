@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Neraca</h1>
          <p>Keluar Masuk Uang</p>
        </div>
      </div>

      <div class="tile">
        <form action="<?php echo route('neraca.insert');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                <label for="validationDefault03">Nominal</label>
                <input type="text" name="nominal" class="form-control-lg form-control" required>
                <p class="form-text text-muted">
                    Nominal atau jumlah uang
                </p>
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault04">Dana masuk atau keluar</label>
                <select name="status" class="form-control form-control-lg">
                    <option value="1">Masuk</option>
                    <option value="0">Keluar</option>
                </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="validationDefault04">Keterangan</label>
                    <textarea name="keterangan" class="form-control form-control-lg"></textarea>
                </div>

            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Hitung</button>
        </form>
      </div>
    </main>
@include('layouts.footer')