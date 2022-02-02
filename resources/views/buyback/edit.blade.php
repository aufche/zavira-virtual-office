@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Buyback Cincin</h1>
          
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="<?php echo route('buyback.edit');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                <label for="validationDefault03">No Order</label>
                <input type="text" name="pesanan_id" class="form-control-lg form-control" value="<?php echo $data->pesanan_id;?>">
                <p class="form-text text-muted">
                    No order, jika tidak ada bisa dikosongi
                </p>
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault03">Nominal</label>
                <input type="text" name="nominal" class="form-control-lg form-control" required value="<?php echo $data->nominal;?>">
                <p class="form-text text-muted">
                    Nominal atau jumlah uang
                </p>
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault03">Berat</label>
                <input type="text" name="berat" class="form-control-lg form-control" required value="<?php echo $data->berat;?>">
                <p class="form-text text-muted">
                    Berat logam 
                </p>
                </div>


            </div>

            <div class="form-row">

            <div class="col-md-4 mb-3">
                <label for="validationDefault04">Jenis Logam</label>
                <select class="form-control form-control-lg mb-3" name="namalogam_id">
                    <option value="" selected="selected">Pilih logam</option>
                    <?php 
                        foreach ($namalogam as $title=>$id){
                            ?>
                            <option <?php if ($data->namalogam_id == $id) echo 'selected';?> value="<?php echo $id;?>"><?php echo $title;?></option>
                            <?php
                        }
                    ?>
                </select>
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault04">Status</label>
                <select class="form-control form-control-lg mb-3" name="status" required>
                    <option value="1" <?php if ($data->status == 1) echo 'selected';?>>Belum Dilebur</option>
                    <option value="0" <?php if ($data->status == 0) echo 'selected';?>>Sudah Dilebur</option>
                    
                </select>
                </div>

                <div class="col-md-4 mb-3">
                <label for="validationDefault04">Antrian</label>
                <select class="form-control form-control-lg mb-3" name="antrian" required>
                    <option value="1" <?php if ($data->antrian == 1) echo 'selected';?>>Dalam Antrian</option>
                    <option value="0" <?php if ($data->antrian == 0) echo 'selected';?>>Selesai</option>
                    
                </select>
                </div>


                <div class="col-md-12 mb-3">
                    <label for="validationDefault04">Catatan</label>
                    <textarea class="form-control" rows="5" name="catatan"><?php echo $data->catatan;?></textarea>
                </div>

                
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Edit</button>
        </form>
      </div>
    </main>
@include('layouts.footer')