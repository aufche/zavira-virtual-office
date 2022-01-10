@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Zavira Jewelry Exclusive</h1>
          <p>Tambah paket penjualan zavira jewelry exclusive</p>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="<?php echo route('ze.edit');?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <input type = "hidden" name = "id" value = "<?php echo $data->id ?>">
            <div class="form-row">
            <div class="col-md-6 mb-3">
            <label for="berat_pria">Kode Paket</label>
                <input type="text" class="form-control" name="kode_paket" id="kode_paket" aria-describedby="helpId" placeholder="" value = "<?php echo $data->kode_paket ?>">
                <small id="helpId" class="form-text text-muted">Kode Paket / Nama Paket</small>
            </div>  
            <div class="col-md-6 mb-3">
            <label for="berat_pria">Type</label>
                <input type="text" class="form-control" name="type" id="type" aria-describedby="helpId" placeholder="" value = "<?php echo $data->type ?>">
                <small id="helpId" class="form-text text-muted">Tipe</small>
            </div> 
              <div class="col-md-6">
                <label for="berat_pria">Berat cincin pria</label>
                <input type="text" class="form-control" name="berat_pria" id="berat_pria" aria-describedby="helpId" placeholder="" value = "<?php echo $data->berat_pria ?>">
                <small id="helpId" class="form-text text-muted">Masukkan berat cincin pria</small>
                </div>

                <div class="col-md-6">
                <label for="kode_bahan_pria">Jenis logam</label>
                <select class="form-control" name="kode_bahan_pria" id="bwanita">
                        <option value="" selected="selected">Pilih logam</option>
                        <?php 
                            foreach ($namalogam as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if ($data->kode_bahan_pria == $id) echo 'selected';?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                <small id="helpId" class="form-text text-muted">Pilih jenis logam untuk cincin pria</small>
                </div>

            </div>

            <div class="form-row mt-4">
                <div class="col-md-6">
                <label for="berat_wanita">Berat cincin wanita</label>
                <input type="text" class="form-control" name="berat_wanita" id="berat_wanita" aria-describedby="helpId" placeholder="" value = "<?php echo $data->berat_wanita ?>">
                <small id="helpId" class="form-text text-muted">Masukkan berat cincin pria</small>
                </div>

                <div class="col-md-6">
                <label for="kode_bahan_pria">Jenis logam</label>
                <select class="form-control" name="kode_bahan_wanita">
                        <option value="" selected="selected">Pilih logam</option>
                        <?php 
                            foreach ($namalogam as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if ($data->kode_bahan_wanita == $id) echo 'selected';?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                <small id="helpId" class="form-text text-muted">Pilih jenis logam untuk cincin wanita</small>
                </div>

            </div>

          <!--  <div class="form-row mt-4">
              <div class="col-md-12">
              <label for="kode_bahan_pria">Caption</label>           
                <textarea class="form-control" name="" id="" rows="10"></textarea>       
              </div>
            </div>
            -->

            <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Simpan</button>

        </form>
      
      </div>
    </main>
@include('layouts.footer')