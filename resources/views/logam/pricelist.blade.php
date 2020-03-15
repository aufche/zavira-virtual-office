<!doctype html>
<html lang="en">
  <head>
    <title>Pricelist</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
    <?php
    $harga = [];
    foreach ($hargapokok as $key => $value){
        //echo $key;
        //echo $value;
        $harga[$value->kunci] = $value->isi;
    }

    $n = 0;
    $materials = [];
    foreach ($logam as $item){
      
      if ($item->jenis == 'palladium'){
        
        $materials[$n]['harga'] = $harga['harga_pokok_palladium'] * ($item->kadar/100) + $item->markup;
        $materials[$n]['title'] = $item->title;
      }

      if ($item->jenis == 'emas'){
     

        $materials[$n]['harga'] = $harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup;
        $materials[$n]['title'] = $item->title;
      }

      if ($item->jenis == 'platinum'){
       

        $materials[$n]['harga'] = $harga['harga_pokok_platinum'] * ($item->kadar/100) + $item->markup;
        $materials[$n]['title'] = $item->title;
      }

      if ($item->jenis == 'ep'){
       

        $materials[$n]['harga'] = $harga['harga_pokok_emas'] * ($item->kadar/100) + $item->markup;
        $materials[$n]['title'] = $item->title;
      }

      if ($item->jenis == 'platidium'){
        

        $materials[$n]['harga'] = (($harga['harga_pokok_platinum'] + $harga['harga_pokok_palladium'])/2) * ($item->kadar/100) + $item->markup;
        $materials[$n]['title'] = $item->title;
      }

     
      $n++;
    }
        ?>     
        <textarea class="form-control" rows="30" readonly>
        
        <?php
        echo '&#10;';
        echo 'Update per '.date('d/m/Y').'&#10;';
        foreach ($materials as $material){
              echo  $material['title'].' = '.rupiah($material['harga']).'&#10;';
          }
          ?>
        </textarea>

  </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>