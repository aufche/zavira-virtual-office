@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Hitung Harga Jual Kembali</h1>
          <p>Harga jual kembali khusus cincin emas kuning dan emas putih dengan campuran perak</p>
        </div>
      </div>

      <div class="tile">
        <form action="<?php echo route('logam.buyback');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationDefault03">Berat Cincin</label>
                <input type="text" name="berat" class="form-control-lg form-control" required>
                <p class="form-text text-muted">
                    Pastikan cincin sudah ditimbang ulang, perhatikan kipas angin dan hembusan ac, karena mempengaruhi akurasi timbangan.
                </p>
                </div>

                <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Pilihan:</label>
                    <select class="form-control form-control-lg" id="book" name="kadar">
                    @foreach ($namalogam as $harga_final => $title)
                        <option value="{{$harga_final}}">{{$title}}</option>
                    @endforeach
                    </select>
                </div>
                </div>

            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Hitung</button>
        </form>

        <?php
            if (isset($data)){
                echo 'Berat cincin '.$data[0]['berat'].'gr<br />';
                //echo 'Kadar logam '.($data[0]['kadar']*100).'%<br />';
                echo 'Harga jual kembali '.rupiah($data[0]['harga_buyback']);
                
            }
        ?>
      </div>
    </main>
@include('layouts.footer')