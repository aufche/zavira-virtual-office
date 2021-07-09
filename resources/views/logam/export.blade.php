<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
        <div class="col-md-12">
        <pre>
        <?php
            foreach ($data as $item){
                if ($item->jenis == 'emas' || $item->jenis=='ep'){
                  $kode = '1';
                    $hp = $harga_pokok[0]->isi;
                }elseif ($item->jenis == 'palladium'){
                    $hp = $harga_pokok[1]->isi;
                    $kode = '2';
                }elseif($item->jenis=='platinum'){
                    $hp = $harga_pokok[2]->isi;
                    $kode = '3';
                }elseif ($item->jenis == 'silver'){
                    $hp = 0;
                    $kode = '4';
                }elseif ($item->jenis == 'platidium'){
                    $hp = ($harga_pokok[1]->isi + $harga_pokok[2]->isi) / 2;
                    $kode = '4';
                }
                ?>
                '<?php echo $kode;?>|<?php echo $item->kadar;?>|<?php echo $item->markup;?>|<?php echo $item->title;?>' => '<?php echo $item->title;?>',
                <?php
            }
        ?>
        </pre>
        </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
  </body>
</html>