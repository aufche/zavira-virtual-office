@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Konversi Kadar Logam</h1>
          <p>untuk menghitung logam yang dibutuhkan untuk menaikkan atau menurunkan kadar</p>
        </div>
      </div>

      <div class="tile">
          
      <form>
            <div class="form-group">
              <label for="berat_awal">Berat Awal</label>
              <input value="5" type="text" name="berat_awal" id="berat_awal" class="form-control form-control-lg" placeholder="" aria-describedby="Masukkan berat awal logam">
              <small id="Masukkan berat awal logam" class="text-muted">Masukkan berat awal logam</small>
            </div>

            <div class="form-group">
              <label for="kadar_awal">Kadar Awal</label>
              <input value="0.5" type="text" name="kadar_awal" id="kadar_awal" class="form-control form-control-lg" placeholder="" aria-describedby="Masukkan kadar awal logam">
              <small id="Masukkan kadar awal logam" class="text-muted">Masukkan kadar awal logam</small>
            </div>

            <div class="form-group">
              <label for="berat_awal">Kadar Akhir</label>
              <input value="0.85" type="text" name="kadar_akhir" id="kadar_akhir" class="form-control form-control-lg" placeholder="" aria-describedby="kadar akhir yang diinginkan">
              <small id="Masukkan kadar akhir logam" class="text-muted">Masukkan kadar akhir logam yang diinginkan</small>
            </div>

           <!-- <div class="form-check">
                <label class="form-check-label">
                <input type="radio" class="form-check-input" name="logam" id="emas" value="emas" checked>
                Emas
              </label>
            </div>

            <div class="form-check">
                <label class="form-check-label">
                <input type="radio" class="form-check-input" name="logam" id="palladium" value="palladium">
                Palladium
              </label>
            </div>
        -->

            <input type="button" class="btn btn-danger btn-lg btn-block" onclick="kalkulator()" value="Hitung" />
      </form>

      <div id="tambahan_logam"></div>
      <div id="kadar_akhir_final"></div>
      <div id="berat_akhir_final"></div>

      
      </div>
    </main>

    <script type="text/javascript">
    function kalkulator(){
      //window.alert(document.getElementById('berat_awal').value);
      var berat_awal = document.getElementById('berat_awal').value;
      var kadar_awal = document.getElementById('kadar_awal').value;
      var kadar_akhir = document.getElementById('kadar_akhir').value;
      //var jenis_logam = document.getElementById('logam').value;

      if (kadar_akhir < kadar_awal){
        //-- kadar diturunkan berarti tambah perak
        var emas;
        var perak;

        emas = kadar_awal * berat_awal;
        perak = berat_awal - emas;

        var berat_akhir = emas / kadar_akhir;
        var perak_akhir = berat_akhir - emas;
        var tambahan_perak = perak_akhir - perak;
        var berat_final = tambahan_perak + parseFloat(berat_awal);

        //window.alert(tambahan_perak);
        document.getElementById('tambahan_logam').innerHTML = 'Tambahan perak '+tambahan_perak.toFixed(2)+' gram';
        document.getElementById('berat_akhir_final').innerHTML = 'Berat akhirnya '+berat_final.toFixed(2)+' gram kadarnya '+(kadar_akhir*100)+'%';
      }
      if (kadar_akhir > kadar_awal){
        //--- kadar di naikkan, berari tambah emas
        //window.alert('Logam dinaikkan');
        var emas;
        var perak;

        emas = kadar_awal * berat_awal;
        perak = berat_awal - emas; // 5 - 1.5 = 3.5

        var kadar_perak_akhir = 1 - kadar_akhir;

        var logam_total = perak / kadar_perak_akhir;
        var tambahan_logam_emas = logam_total - emas;
        

        document.getElementById('tambahan_logam').innerHTML = 'Tambahan logam murni '+tambahan_logam_emas.toFixed(2)+' gram';
        document.getElementById('berat_akhir_final').innerHTML = 'Berat akhirnya '+logam_total.toFixed(2)+' gram kadarnya '+ (kadar_akhir*100)+'%';

      }
    }
    </script>
@include('layouts.footer');