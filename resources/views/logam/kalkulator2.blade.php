<?php /* Template Name: kalkulator */ ?>
<!doctype html>
<html lang="en">
  <head>
    <title>Kalkulator Harga Cincin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">

    <style type="text/css">
      body{
        font-family: 'Livvic', sans-serif;
        font-size:1.1em;
      }
    </style>
    
  </head>
  <body>
  <?php
    $harga = [];
    foreach ($hargapokok as $key => $value){
        $harga[$value->kunci] = $value->isi;
    }
  ?>
    <div class="container text-center mt-4 mb-4">
      
    </div>
     <div class="container">

     <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item"><a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Kalkulator</a></li>
      <li class="nav-item"><a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Harga per gram</a></li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <form>
              <div class="card mt-3 border-dark mb-4">
                <div class="card-header bg-dark text-white">Hitung Biaya Cincin Kawinmu</div>
                <div class="card-body">
                      
                      <div class="form-row mb-4">
                        <div class="col-md-6 col-xs-6">
                            <label for="berat_pria">Berat Cincin Pria</label>
                            <input  type="text" class="form-control" name="berat_pria" id="berat_pria" aria-describedby="berat_pria" value="4" />
                            <small id="berat_pria" class="form-text text-muted">Isikan berat cincin pria</small>  
                        </div>

                        <div class="col-md-6 col-xs-6">
                            <label for="jenis_logam_pria">Jenis logam pria</label>
                            <select  class="form-control" name="jenis_logam_pria" id="jenis_logam_pria">
                            <?php 
                                    foreach ($logam as $item){
                                      if ($item->jenis == 'palladium'){
                                        $value = ($harga['harga_pokok_palladium'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_palladium'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'emas'){
                                        $value = ($harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_emas'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'platinum'){
                                        $value = ($harga['harga_pokok_platinum'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_platinum'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'ep'){
                                        $value = ($harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_emas'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'platidium'){
                                        $value = (($harga['harga_pokok_platinum'] + $harga['harga_pokok_palladium'])/2 * ($item->kadar/100) + $item->markup).'|'.(($harga['harga_harian_platinum'] + $harga['harga_harian_palladium'])/2 * ($item->kadar/100));
                                      }elseif ($item->jenis == 'silver'){
                                        $value = 265000;
                                      }
                                      ?>
                                       <option value="<?php echo $value;?>"><?php echo $item->title;?></option>
                                      <?php
                                    }
                                  ?>
                            </select>
                        </div>
                      </div>
                      <hr /> 
                      <div class="form-row">
                          <div class="col-md-6">
                              <label for="berat_wanita">Berat Cincin Wanita</label>
                              <input  type="text" class="form-control" name="berat_wanita" id="berat_wanita" aria-describedby="berat_pria" value="4">
                              <small id="berat_pria" class="form-text text-muted">Isikan berat cincin wanita</small>
                          </div>
  
                          <div class="col-md-6">
                              <label for="jenis_logam_pria">Jenis logam Wanita</label>
                              <select class="form-control" name="jenis_logam_wanita" id="jenis_logam_wanita">
                              <?php 
                                    foreach ($logam as $item){
                                      if ($item->jenis == 'palladium'){
                                        $value = ($harga['harga_pokok_palladium'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_palladium'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'emas'){
                                        $value = ($harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_emas'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'platinum'){
                                        $value = ($harga['harga_pokok_platinum'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_platinum'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'ep'){
                                        $value = ($harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup).'|'.($harga['harga_harian_emas'] * ($item->kadar/100));
                                      }elseif ($item->jenis == 'platidium'){
                                        $value = (($harga['harga_pokok_platinum'] + $harga['harga_pokok_palladium'])/2 * ($item->kadar/100) + $item->markup).'|'.(($harga['harga_harian_platinum'] + $harga['harga_harian_palladium'])/2 * ($item->kadar/100));
                                      }elseif ($item->jenis == 'silver'){
                                        $value = 265000;
                                      }
                                      ?>
                                       <option value="<?php echo $value;?>"><?php echo $item->title;?></option>
                                      <?php
                                    }
                                  ?>
                              </select>
                          </div>

                          <div class="col-md-12 mt-3">
                          <label for="jenis_logam_pria">Ongkos Pembuatan</label>   
                          <input type="text" name="ongkosbikin" value="880000" id="ongkosbikin" class="form-control" />
                          </div>
                        </div>
                      
  
                      

                      <button type="button" data-toggle="modal" data-target="#exampleModal" onclick="kalkulator();" class="btn btn-dark btn-lg btn-block mt-5 shadow">Hitung!</button>
                </div>
                
              </div>
            </form>    
      </div>
      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
      <?php 
        foreach ($logam as $item){
          if ($item->jenis == 'palladium'){
            $value = ($harga['harga_pokok_palladium'] * ($item->kadar/100) + $item->markup);
          }elseif ($item->jenis == 'emas'){
            $value = ($harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup);
          }elseif ($item->jenis == 'platinum'){
            $value = ($harga['harga_pokok_platinum'] * ($item->kadar/100) + $item->markup);
          }elseif ($item->jenis == 'ep'){
            $value = ($harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup);
          }elseif ($item->jenis == 'platidium'){
            $value = (($harga['harga_pokok_platinum'] + $harga['harga_pokok_palladium'])/2 * ($item->kadar/100) + $item->markup);
          }elseif ($item->jenis == 'silver'){
            $value = 265000;
          }
          
          if ($item->jenis != 'silver'){
            echo $item->title.' '.rupiah($value).'/gram <br />';
          }
          
        }
       ?>                
      </div>
    </div>
             
      </div>

      

      <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hasil Perhitungan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="rincian">
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    

    <script>
    function kalkulator(){
    var berat_pria = parseFloat(document.getElementById('berat_pria').value);
    var berat_wanita = parseFloat(document.getElementById('berat_wanita').value);

   var harga_logam_wanita = parseFloat(document.getElementById('jenis_logam_wanita').value);

    var pria = document.getElementById('jenis_logam_pria');
    var cowok = pria[pria.selectedIndex].value.split("|");
    var harga_pria = parseFloat(cowok[0]);
    var dp_logam_pria = parseFloat(cowok[1]);
    var logam_pria = pria[pria.selectedIndex].text;
    
    


    var wanita = document.getElementById('jenis_logam_wanita');
    var cewek = wanita[wanita.selectedIndex].value.split("|");
    var harga_wanita = parseFloat(cewek[0]);
    var dp_logam_wanita = parseFloat(cewek[1]);
    var logam_wanita = wanita[wanita.selectedIndex].text;
    

    var ongkos = parseFloat(document.getElementById('ongkosbikin').value);

    /*var ongkos = document.getElementById('ongkos_bikin');
    var ongkos_bikin = parseFloat(ongkos[ongkos.selectedIndex].value);
    */

    /*if (document.getElementById('kotakkayu').checked == true){
        var kotakkayu = parseFloat(document.getElementById('kotakkayu').value);
        var text_kkayu = "<br />Kotak cincin kayu exclusive "+toRp(kotakkayu);
    }else{
        var kotakkayu = 0;
        var text_kkayu = "";
    }

    if (document.getElementById('freeongkir').checked == true){
        var freeongkir = parseFloat(document.getElementById('freeongkir').value);
        var text_freeongkir = "<br />Free ongkir ke seluruh Indonesia";
       
    }else{
        var freeongkir = 0;
        var text_freeongkir = "";
    }
    */
    var kotakkayu = 0;
    var freeongkir = 0;

    var text_kkayu = "<br />Kotak cincin kayu exclusive "+toRp(kotakkayu);
    var text_freeongkir = "";
    

    if (document.getElementById('berat_pria').value != '' && document.getElementById('berat_wanita').value == ''){
      //- cincin cowok saja 
      if (logam_pria != "Silver 925"){
        var ongkos_bikin = ongkos;
        var total = (berat_pria * harga_pria) + ongkos_bikin + kotakkayu + freeongkir;
        var dp = total / 2;
        var dp_75 = (berat_pria * dp_logam_pria);
      
        var rincian = "Cincin Pria "+logam_pria+" "+toRp(harga_pria)+" x "+berat_pria+" gram <br />ongkos bikin "+toRp(ongkos_bikin)+text_kkayu+"<br />Total "+toRp(total);
        var paket = "Cincin pria "+logam_pria+" berat "+berat_pria+"gr<br />- Free exclusive ring box<br />- Sertifikat keaslian logam<br />- Free Ukir nama pasangan<br />- Free souvenir cantik<br />"+toRp(total)+"<br /><br />Jumlah DP 50% yaitu "+toRp(dp)+"<br />Jumlah DP untuk transaksi COD "+toRp(dp_75)+"<br /><br /><br />Dilunasi ketika barang sudah jadi";
      }else if (logam_pria == "Silver 925"){
        var rincian = 'Mohon maaf, harga untuk cincin bahan silver 925 (perak) single silahkan hubungi customer service kami. Karena harga cincin perak tidak dihitung per gram, tetapi per model<br />Harga mulai dari Rp 265.000 s/d Rp 450.000 tergantung tingkat kerumitan<br /><a href="https://zavirajewelry.com/chat" target="_blank">Chat dengan CS kami</a></a>';
      }
      

    }else if(document.getElementById('berat_pria').value == '' && document.getElementById('berat_wanita').value != ''){
     //-- cincin cewek saja
      if (logam_wanita != "Silver 925"){
        var ongkos_bikin = ongkos;
        var total = (berat_wanita * harga_wanita) + ongkos_bikin + kotakkayu + freeongkir;
        var dp = total / 2;
        var dp_75 = (berat_wanita * dp_logam_wanita);

        var rincian = "Cincin Wanita "+logam_wanita+" "+toRp(harga_wanita)+" x "+berat_wanita+" gram <br />ongkos bikin "+toRp(ongkos_bikin)+text_kkayu+"<br />Total "+toRp(total)+"<br />Bonus tambahan <br />- Free exclusive ring box<br />- Sertifikat keaslian logam<br />- Free Ukir nama pasangan<br />- Free souvenir cantik<br />"+toRp(total)+"<br /><br />Jumlah DP 50% yaitu "+toRp(dp)+"<br />Jumlah DP untuk transaksi COD "+toRp(dp_75)+"<br /><br />Harga diatas masih bisa kurang, tergantung dengan BERAT logam ketika cincin sudah jadi. Anda hanya membayar seberat logam cincin saja. Rincian harga lebih transparan dari toko sebelah";
      }else if (logam_wanita == "Silver 925"){
        var rincian = 'Mohon maaf, harga untuk cincin bahan silver 925 (perak) single silahkan hubungi customer service kami. Karena harga cincin perak tidak dihitung per gram, tetapi per model<br />Harga mulai dari Rp 265.000 s/d Rp 450.000 tergantung tingkat kerumitan<br /><a href="https://zavirajewelry.com/chat" target="_blank">Chat dengan CS kami</a></a>';
      }
      
      //var paket = "Cincin wanita "+logam_wanita+" berat "+berat_wanita+"gr<br />- Free exclusive ring box<br />- Sertifikat keaslian logam<br />- Free Ukir nama pasangan<br />- Free souvenir cantik<br />"+toRp(total)+"<br /><br />Pembayaran bisa DP dulu 75% yaitu "+toRp(dp)+"<br /><br />Dilunasi ketika barang sudah jadi";

    }else if (document.getElementById('berat_pria').value != '' && document.getElementById('berat_wanita').value != ''){
      //-- cincin couple
      if (logam_pria != "Silver 925" && logam_wanita != "Silver 925"){
        var ongkos_bikin = ongkos;
        var total = (berat_pria * harga_pria) + (berat_wanita * harga_wanita) + ongkos_bikin + kotakkayu + freeongkir;
        var dp = total / 2;
        var dp_75 = (berat_wanita * dp_logam_wanita) + (berat_pria * dp_logam_pria);
      
        var rincian = "Cincin Pria "+logam_pria+" "+toRp(harga_pria)+" x "+berat_pria+" gram <br />Cincin Wanita "+logam_wanita+" "+toRp(harga_wanita)+" x "+berat_wanita+" gram <br />ongkos bikin "+toRp(ongkos_bikin)+"<br />Bonus tambahan <br />- Free exclusive ring box<br />- Sertifikat keaslian logam<br />- Free Ukir nama pasangan<br />- Free souvenir cantik<br />"+toRp(total)+"<br /><br />Jumlah DP 50% yaitu "+toRp(dp)+"<br />Jumlah DP untuk transaksi COD "+toRp(dp_75)+"<br /><br />Dilunasi ketika barang sudah jadi<br /><br />Harga diatas masih bisa kurang, tergantung dengan BERAT logam ketika cincin sudah jadi. Anda hanya membayar seberat logam cincin saja. Rincian harga lebih transparan dari toko sebelah";
        
      }else if (logam_pria == "Silver 925" && logam_wanita != "Silver 925"){
        //-- cincin pria menggunakan perak. 
        var ongkos_bikin = ongkos;
        var total = harga_pria + (berat_wanita * harga_wanita) + ongkos_bikin + kotakkayu + freeongkir;
        var dp = total / 2;
        var dp_75 = (berat_wanita * dp_logam_wanita) + harga_pria;

        var rincian = "Cincin Pria "+logam_pria+" "+toRp(harga_pria)+" berat "+berat_pria+" gram <br />Cincin Wanita "+logam_wanita+" "+toRp(harga_wanita)+" x "+berat_wanita+" gram <br />ongkos bikin "+toRp(ongkos_bikin)+"<br />Bonus tambahan <br />- Free exclusive ring box<br />- Sertifikat keaslian logam<br />- Free Ukir nama pasangan<br />- Free souvenir cantik<br />"+toRp(total)+"<br /><br />Jumlah DP 50% yaitu "+toRp(dp)+"<br />Jumlah DP untuk transaksi COD "+toRp(dp_75)+"<br /><br />Dilunasi ketika barang sudah jadi<br /><br />Harga diatas masih bisa kurang, tergantung dengan BERAT logam ketika cincin sudah jadi. Anda hanya membayar seberat logam cincin saja. Rincian harga lebih transparan dari toko sebelah";
      }else if (logam_pria != "Silver 925" && logam_wanita == "Silver 925"){
        //-- cincin wanita perak

        var ongkos_bikin = ongkos;
        var total = (berat_pria * harga_pria) + harga_wanita + ongkos_bikin + kotakkayu + freeongkir;
        var dp = total / 2;
        var dp_75 = (berat_pria * dp_logam_pria) + harga_wanita;

        var rincian = "Cincin Pria "+logam_pria+" "+toRp(harga_pria)+" x "+berat_pria+" gram <br />Cincin Wanita "+logam_wanita+" "+toRp(harga_wanita)+" berat "+berat_wanita+" gram <br />ongkos bikin "+toRp(ongkos_bikin)+"<br />Bonus tambahan <br />- Free exclusive ring box<br />- Sertifikat keaslian logam<br />- Free Ukir nama pasangan<br />- Free souvenir cantik<br />"+toRp(total)+"<br /><br />Jumlah DP 50% yaitu "+toRp(dp)+"<br />Jumlah DP untuk transaksi COD "+toRp(dp_75)+"<br /><br />Dilunasi ketika barang sudah jadi<br /><br />Harga diatas masih bisa kurang, tergantung dengan BERAT logam ketika cincin sudah jadi. Anda hanya membayar seberat logam cincin saja. Rincian harga lebih transparan dari toko sebelah";
      }else if (logam_pria == "Silver 925" && logam_wanita == "Silver 925"){
        var rincian = 'Mohon maaf, harga untuk cincin bahan silver 925 (perak) couple silahkan hubungi customer service kami. Karena harga cincin perak tidak dihitung per gram, tetapi per model.<br />Harga mulai dari Rp 450.000 s/d Rp 800.000 tergantung tingkat kerumitan<br /><a href="https://zavirajewelry.com/chat" target="_blank">Chat dengan CS kami</a></a>';
      }

    }

    //document.getElementById('kesimpulan').innerHTML = paket;
    document.getElementById('rincian').innerHTML = rincian;
    


 }

 function toRp(angka){
         var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
         var rev2    = '';
         for(var i = 0; i < rev.length; i++){
             rev2  += rev[i];
             if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
                 rev2 += '.';
             }
         }
         return 'Rp. ' + rev2.split('').reverse().join('');
     }
    </script>
  </body>
</html>