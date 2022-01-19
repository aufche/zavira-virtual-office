@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Hitung Harga Jual Kembali</h1>
          <p>Harga jual kembali khusus cincin emas kuning dan emas putih dengan campuran perak</p>
        </div>
      </div>

      <div class="tile container">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="<?php echo route('logam.buyback');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-row">
                
            <div class="col-md-4 mb-3">
                <label for="validationDefault03">No Order</label>
                <input type="text" name="no_order" class="form-control-lg form-control" required>
                
                </div>

            <div class="col-md-4 mb-3">
                <label for="validationDefault03">Berat Cincin</label>
                <input type="text" name="berat" class="form-control-lg form-control" required>
                <p class="form-text text-muted">
                    Berat cincin terbaru, bukan yang tertulis pada nota
                </p>
                </div>

                

                <div class="col-md-4 mb-3">
                <label for="validationDefault03">Cincin Yang Mana</label>
                <select class="form-control form-control-lg"  name="item">
                        <option value="pria">Cincin Pria</option>
                        <option value="wanita">Cincin Wanita</option>
                    </select>
                </div>

               

               

            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Hitung</button>
        </form>
        
        @if (!empty($data))
            <div class="alert alert-warning p-4 mt-3">
            Prioritas 1 :<br />
            Jika dihitung berdasarkan harga pada nota pembelian<br />
            Bahan {{$data[0]['bahan']}}<br />
            Berat {{$data[0]['berat']}}gr <br />
            Harga buyback {{rupiah($data[0]['harga_buyback'])}}<br />
            </div>

            <div class="alert alert-danger p-4 mt-3">
            Prioritas 2 :<br />
            Jika dihitung menggunakan harga emas pada hari ini.<br />
            Bahan {{$data[0]['bahan']}}<br />
            Berat {{$data[0]['berat']}}gr <br />
            Harga buyback {{rupiah($data[0]['harga_buyback_update'])}}<br />
            </div>
            
           
        @endif
        <?php
            // if (isset($data)){
            //     echo 'Bahan '.$data[0]['bahan'];
            //     echo 'Berat cincin '.$data[0]['berat'].'gr<br />';
            //     //echo 'Kadar logam '.($data[0]['kadar']*100).'%<br />';
            //     echo 'Harga jual kembali '.rupiah($data[0]['harga_buyback']);
            //     echo 'Harga beli '.rupiah($data[0]['harga_beli']);
            //     echo 'Selisih '.rupiah($data[0]['harga_beli'] - $data[0]['harga_buyback']);
            //     echo 'pergram '.rupiah($data[0]['pergram']);
                
            // }
        ?>
      </div>
    </main>
@include('layouts.footer')