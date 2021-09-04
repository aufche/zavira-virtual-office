@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Setting Page</h1>
          <p>In this page, you can adjust price of materials</p>
        </div>
      </div>
      <div class="tile">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
      <form action="<?php echo route('setting.save');?>" method="post" enctype="multipart/form-data">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="card border-dark">
        <div class="card-header bg-dark text-white">Setting dan Konfigurasi Sistem</div>
            <div class="card-body">
                <?php
                /* $i=0;
                foreach ($data as $item){
                  echo $i.' '.$item->kunci.'<br />';
                  $i++;
                }
               
                0 harga_harian_emas
                1 harga_harian_palladium
                2 harga_harian_platinum
                3 harga_pokok_emas
                4 harga_pokok_palladium
                5 harga_pokok_platinum
                6 harga_pokok_silver
                7 ongkos_bikin
                */
                //dd($data);
                ?>
                <div class="form-row mb-3">
                  
                  <div class="col-md-3 mb-3">
                  <label for="harga_pokok_palladium">Harga Pokok Palladium</label>
                  <input type="text" value="<?php echo $data[4]->isi;?>" class="form-control form-control-lg" name="harga_pokok_palladium" id="harga_pokok_palladium" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok palladium</small>
                  </div>

                  <div class="col-md-3 mb-3">
                  <label for="harga_pokok_palladium">Harga Pokok Emas</label>
                  <input type="text" value="<?php echo $data[3]->isi;?>" class="form-control form-control-lg" name="harga_pokok_emas" id="harga_pokok_palladium" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok emas</small>
                  </div>

                  <div class="col-md-3 mb-3">
                  <label for="harga_pokok_palladium">Harga Pokok Platinum</label>
                  <input type="text" value="<?php echo $data[5]->isi;?>" class="form-control form-control-lg" name="harga_pokok_platinum" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok platinum</small>
                  </div>

                  <div class="col-md-3 mb-3">
                  <label for="harga_pokok_silver">Harga Pokok Perak</label>
                  <input type="text" value="<?php echo $data[6]->isi;?>" class="form-control form-control-lg" name="harga_pokok_silver" id="harga_pokok_silver" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok perak</small>
                  </div>

                </div>

                <div class="form-row mb-3">
                  <label for="ongkos_bikin">Ongkos Pembuatan</label>
                  <input type="text"  value="<?php echo $data[7]->isi;?>" class="form-control form-control-lg" name="ongkos_bikin" id="harga_pokok_palladium" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan ongkos pembuatan sepasang</small>
                </div>

<hr />
                <div class="form-row mb-3">
                  
                <div class="col-md-4 mb-3">
                  <label for="markup_palladium_kadar_tinggi">Harga Harian Palladium</label>
                  <input type="text" value="<?php echo $data[1]->isi;?>" class="form-control form-control-lg" name="harga_harian_palladium" id="harga_pokok_palladium" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok palladium</small>
                  </div>

                  <div class="col-md-4 mb-3">
                  <label for="harga_pokok_palladium">Harga Harian Emas</label>
                  <input type="text" value="<?php echo $data[0]->isi;?>" class="form-control form-control-lg" name="harga_harian_emas" id="harga_pokok_palladium" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok emas</small>
                  </div>

                  <div class="col-md-4 mb-3">
                  <label for="markup_palladium_kadar_tinggi">Harga Harian Platinum</label>
                  <input type="text" value="<?php echo $data[2]->isi;?>" class="form-control form-control-lg" name="harga_harian_platinum" id="harga_pokok_palladium" aria-describedby="" placeholder="">
                  <small id="" class="form-text text-muted">Isikan harga pokok palladium</small>
                  </div>
                  
                </div>

            <!-- form-row--->        
            <button type="submit" class="btn btn-dark btn-lg btn-block">Simpan</button>            
            </div>

            

        </div>
        
      </form>
      </div>
      
    </main>
@include('layouts.footer')