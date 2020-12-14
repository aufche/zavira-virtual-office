<!doctype html>
<html lang="en">
  <head>
    <title>Ringkasan Order</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
        <div class="row">
            <div class="col-md-12">

            <div class="card">
            <img src="<?php echo $data->gambar;?>" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">Ringkasan Order</h5>
                <p class="card-text">
                <?php
                    if (!empty($data->ukuranpria)){
                        echo 'Cincin pria : <strong>'.$data->ukuranpria.'</strong><br />';
                        echo 'Bahan : <strong>'.$data->bahanpria()->first()['title'].'</strong><br />';
                        echo 'Grafir : '.$data->grafirpria.'<br />';
                        echo 'Berat maksimal : '.$data->produksi_beratpria.' gram <br /><br /><br />';
                    }



                     if (!empty($data->ukuranwanita)){
                        echo 'Cincin Wanita : <strong>'.$data->ukuranwanita.'</strong><br />';
                        echo 'Bahan : <strong>'.$data->bahanwanita()->first()['title'].'</strong><br />';
                        echo 'Grafir : '.$data->grafirwanita.'<br />';
                        echo 'Berat maksimal : '.$data->produksi_beratwanita.' gram<br /><br /><br />';
                    }    

                    echo '<strong>Keterangan dan finising</strong> <br />'.$data->keterangan.'<br /><br />';
                    echo 'Pengrajin '.$data->pengrajin->nama.'<br />';
                    echo 'Deadline <strong>'.date('d M Y', strtotime($data->deadline)).'</strong><br />';
                ?>
                </p>
                
            </div>
            </div>

                <?php
                   /* if (!empty($data->gambar)){
                        echo '<img src="'.$data->gambar.'" class="img-fluid" />';
                    }

                    if (!empty($data->gambargambar)){
                        $pics = explode(',',$data->gambargambar);
                        foreach ($pics as $pic){
                            echo '<img src="'.$pic.'" class="img-fluid" /><br />';
                        }

                    }
                    */
                ?>
            </div>
            
        </div>
      </div>
  </body>
</html>