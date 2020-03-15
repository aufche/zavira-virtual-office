@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Edit Variasi Logam</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

      

      <div class="tile">

       @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="<?php echo route('logam.edit.save');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                <label for="validationDefault03">Nama Variasi Logam</label>
                <input type="text" name="title" value="<?php echo $data->title; ?>" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Jenis Logam</label>
                <select class="form-control" name="jenis" required>
                    <option value="emas" <?php if ($data->jenis=='emas') {echo 'selected="selected"';}?>>Emas</option>
                    <option value="ep" <?php if ($data->jenis=='ep') {echo 'selected="selected"';}?>>Emas Putih (Au+Pd)</option>
                    <option value="palladium" <?php if ($data->jenis=='palladium') {echo 'selected="selected"';}?>>Palladium</option>
                    <option value="platinum" <?php if ($data->jenis=='platinum') {echo 'selected="selected"';}?>>Platinum</option>
                    <option value="silver" <?php if ($data->jenis=='silver') {echo 'selected="selected"';}?>>Silver</option>
                    <option value="platidium" <?php if ($data->jenis=='platidium') {echo 'selected="selected"';}?>>Platidium</option>
                </select>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Kadar</label>
                <input type="text" name="kadar" class="form-control" value="<?php echo $data->kadar; ?>" required>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Markup</label>
                <input type="text" name="markup" class="form-control" value="<?php echo $data->markup; ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        </form>
      </div>
    </main>
@include('layouts.footer');