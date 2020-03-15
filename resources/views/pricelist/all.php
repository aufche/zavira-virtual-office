<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">
    <style type="text/css">
        body{
            font-size:15px;
             font-family: 'Livvic', sans-serif;
        }
    </style>
  </head>
  <body>
<div class="container"><h1 class="display-4">Pricelist</h1><p class="lead">Cincin kawin couple by Zavira Jewelry</p></div>
  <div class="container">

  <table class="table">
    <thead  class="thead-dark table-hover table-bordered">
        <tr>
        <th>No</th>
        <th>Logam Pria</th>
        <th>Logam Wanita</th>
        <th>Total</th>
    </tr>
    </thead>
    
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
        <tbody>
            <tr>
            <td><?php echo $key;?></td>
            <td><?php echo $data_logam[$pria]['title'];?><br /><?php echo $berat_pria;?> gram</td>
            <td><?php echo $data_logam[$wanita]['title'];?><br /><?php echo $berat_wanita;?> gram</td>
            <td><?php echo rupiah($total);?></td>
        </tr>
        </tbody>
        
        <?php 
        }
   ?>
   </table>
  </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.1.4/jquery.floatThead.min.js" integrity="sha256-GIZQ6RCSwtk+RBhcWRRSQZcCJzcGWZrlLpqYO/2F1mQ=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('table').floatThead({
	position: 'fixed'
});

    </script>

    
  </body>
</html>