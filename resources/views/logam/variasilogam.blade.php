@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Variasi Logam</h1>
          <p></p>
        </div>
      </div>

      <div class="tile">
        <form action="<?php echo route('logam.save');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                <label for="validationDefault03">Nama Variasi Logam</label>
                <input type="text" name="title" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Jenis Logam</label>
                <select class="form-control" name="jenis" required>
                    <option value="emas">Emas</option>
                    <option value="ep">Emas Putih (Au+Pd)</option>
                    <option value="palladium">Palladium</option>
                    <option value="platinum">Platinum</option>
                    <option value="silver">Silver</option>
                    <option value="platidium">Platidium</option>
                </select>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Kadar</label>
                <input type="text" name="kadar" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Markup</label>
                <input type="text" name="markup" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        </form>
      </div>
    </main>
@include('layouts.footer');