@include('layouts.header');
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
        <form action="<?php echo route('buyback.insert');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                <label for="validationDefault03">No Order</label>
                <input type="text" name="pesanan_id" class="form-control-lg form-control">
                <p class="form-text text-muted">
                    No order, jika tidak ada bisa dikosongi
                </p>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault03">Nominal</label>
                <input type="text" name="nominal" class="form-control-lg form-control" required>
                <p class="form-text text-muted">
                    Nominal atau jumlah uang
                </p>
                </div>

                <div class="col-md-1 mb-3">
                <label for="validationDefault03">Berat</label>
                <input type="text" name="berat" class="form-control-lg form-control" required>
                <p class="form-text text-muted">
                    Berat logam 
                </p>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Jenis Logam</label>
                <select class="form-control form-control-lg mb-3" name="namalogam_id">
                    <option value="" selected="selected">Pilih logam</option>
                    <?php 
                        foreach ($namalogam as $title=>$id){
                            ?>
                            <option value="<?php echo $id;?>"><?php echo $title;?></option>
                            <?php
                        }
                    ?>
                </select>
                </div>

                <div class="col-md-2 mb-3">
                <label for="validationDefault04">Status</label>
                <select class="form-control form-control-lg mb-3" name="status" required>
                    <option value="1">Belum Dilebur</option>
                    <option value="0">Sudah Dilebur</option>
                    
                </select>
                </div>

                

            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
        </form>
      </div>
    </main>
@include('layouts.footer');