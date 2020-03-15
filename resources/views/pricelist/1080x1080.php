<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $package_name;?> Story</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <style type="text/css">
        @media (min-width: 1200px) {
    .container{
        width: 1080px;
        height:1080px;
    }
}
        
        body{
            font-size:25px;
            font-family: 'Livvic', sans-serif;
            height:2200px;
        }
        .header {
  background-image: url("https://i.imgur.com/yKdOl3T.png");
  
        height:400px;
        background-repeat:no-repeat;
        background-size:contain;
background-position:center;
        
}
    </style>
  </head>
  <body>
<div id="capture" width="1080px" height="1080px">
      <div class="container border border-warning mt-3" id="widget">
      <div class="headers text-center mb-5" style="font-size:1.6em;">
            <h1 class="pt-2 display-4" style="font-weight:700"><?php echo $package_name;?></h1>
    </div>
      <div class="row">
      
<?php
$ongkos_bikin = $data_harga[2]['isi'];
$berat_pria = 4;
    $berat_wanita = 4;
    $ongkir = 0;
    $box_kayu = 0;
    $n = 1;

   foreach ($pair as $key => $value){
        $kode = explode('*',$value); //'pria*wanita',
        $pria = array_search($kode[0], array_column($data_logam, 'kode'));
        $wanita = array_search($kode[1], array_column($data_logam, 'kode'));
        
        if ($data_logam[$wanita]['jenis'] == 'palladium'){
            $harga_pokok_wanita = $data_harga[1]['isi'];
        }elseif ($data_logam[$wanita]['jenis'] == 'emas'){
            $harga_pokok_wanita = $data_harga[0]['isi'];
        }elseif ($data_logam[$wanita]['jenis'] == 'platinum'){
            $harga_pokok_wanita = $data_harga[4]['isi'];
        }elseif ($data_logam[$wanita]['jenis'] == 'ep'){
            $harga_pokok_wanita = $data_harga[0]['isi'];
        }elseif ($data_logam[$wanita]['jenis'] == 'silver'){
            $harga_pokok_wanita = 265000;
        }elseif ($data_logam[$wanita]['jenis'] == 'platidium'){
            $harga_pokok_wanita = ($data_harga[4]['isi']+$data_harga[1]['isi']) / 2;
        }

        if ($data_logam[$pria]['jenis'] == 'palladium'){
            $harga_pokok_pria = $data_harga[1]['isi'];
        }elseif ($data_logam[$pria]['jenis'] == 'emas'){
            $harga_pokok_pria = $data_harga[0]['isi'];
        }elseif ($data_logam[$pria]['jenis'] == 'platinum'){
            $harga_pokok_pria = $data_harga[4]['isi'];
        }elseif ($data_logam[$pria]['jenis'] == 'ep'){
            $harga_pokok_pria = $data_harga[0]['isi'];
        }elseif ($data_logam[$pria]['jenis'] == 'silver'){
            $harga_pokok_pria = 265000;
        }elseif ($data_logam[$pria]['jenis'] == 'platidium'){
            $harga_pokok_pria = ($data_harga[4]['isi']+$data_harga[1]['isi']) / 2;
        }

        if ($data_logam[$pria]['jenis'] == 'silver'){
            $ongkos_pembuatan_single = ($ongkos_bikin / 2) + 12500;
            $total = (((($data_logam[$wanita]['kadar']/100) * $harga_pokok_wanita) + $data_logam[$wanita]['markup'])*$berat_wanita) + $harga_pokok_pria + $ongkos_pembuatan_single + $ongkir + $box_kayu;
        }else{
            $total = (((($data_logam[$wanita]['kadar']/100) * $harga_pokok_wanita) + $data_logam[$wanita]['markup'])*$berat_wanita) + (((($data_logam[$pria]['kadar']/100) * $harga_pokok_pria) + $data_logam[$pria]['markup'])*$berat_pria) + $ongkos_bikin + $ongkir + $box_kayu;
        }

        ?>
            <div class="col-md-6 pl-5">
                <h2 class="p-0 mb-3"><span class="bg-warning text-dark p-2 shadow" style="font-weight:700"><img  src="<?php echo asset('images/icon/heart.png');?>" width="32px" /> <?php echo $key;?></span></h2>
                <div class="clearfix border-bottom border-dark mb-3 mt-3">
                    <span class="float-left">Pria </span>
                    <span class="float-right"><?php echo $data_logam[$pria]['title'].' '.$berat_pria.'gr <br />';?></span>
                </div>
                <div class="clearfix border-bottom border-dark mt-3">
                    <span class="float-left">Wanita  </span>
                    <span class="float-right"><?php echo $data_logam[$wanita]['title'].' '.$berat_wanita.'gr <br />';?></span>
                </div>

                <div class="clearfix mt-3">
                    <span class="text-warning float-left" style="font-weight:700">Harga</span>
                    <span class="float-right"> <?php echo rupiah($total);?> <img src="<?php echo asset('images/icon/check-fill.png');?>" width="32px" /></span>
                </div>

                
                <br /><br />
            </div>
        <?php
        
       $n++;
    }
    ?>
    </div> <!-- row -->

    
    <div class="row mb-2">
        <div class="col-md-12 text-center">
        <img src="<?php echo asset('images/logo-pl.png');?>" class="img-fluid" width="300px" />
        </div>
    </div>
    <div class="row mt-2 text-center">
        <div class="col"><img src="<?php echo asset('images/icon/check-fill.png');?>" width="32px" /> Free Exclusive Ring Box</div>
        <div class="col"><img src="<?php echo asset('images/icon/check-fill.png');?>" width="32px" /> Free Engrave Name</div>
        <div class="col"><img src="<?php echo asset('images/icon/check-fill.png');?>" width="32px" /> Sertifikat Logam</div>
        
    </div>

   
      </div><!-- container -->

      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script type="text/javascript">
    

   /* html2canvas(document.querySelector("#capture",{
        width:1080,
        height:1080
    })).then(canvas => {
        document.body.appendChild(canvas)
});
*/
    </script>
  </body>
</html>