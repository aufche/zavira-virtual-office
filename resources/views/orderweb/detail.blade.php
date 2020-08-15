<!doctype html>
<html lang="en">
  <head>
    <title>Detail Order dari Web</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">
    <style>
    body{
        font-family:Livvic;
    }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>Nama</td>
                        <td><?php echo $data->nama?> <?php echo $data->nohp?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $data->alamat;?><br />kecamatan <?php echo $data->kecamatan;?> <?php echo $data->kodepost;?></td>
                    </tr>
                    <?php if (!empty($data->ukuranpria)){
                        ?>
                        <tr>
                        <td>Cincin Pria</td>
                        <td>
                        <?php
                             if (!empty($data->model_cincin_pria)){
                                echo '<img src="'.$data->model_cincin_pria.'" class="img-fluid" />';
                            }   
                        ?><br />
                        Bahan <?php echo $data->bahanpria;?><br />
                        Berat <?php echo $data->beratpria;?><br />
                        Ukuran <?php echo $data->ukuranpria;?><br />grafir <?php echo $data->grafirpria;?></td>
                    </tr>
                        <?php
                    }
                    ?>
                    <?php if (!empty($data->ukuranwanita)){
                        ?>
                        <tr>
                        <td>Cincin Wanita</td>
                        <td>
                        <?php
                             if (!empty($data->model_cincin_wanita)){
                                echo '<img src="'.$data->model_cincin_wanita.'" class="img-fluid" />';
                            }   
                        ?><br />
                        Bahan <?php echo $data->bahanwanita;?><br />
                        Berat <?php echo $data->beratwanita;?><br />
                        Ukuran <?php echo $data->ukuranwanita;?><br />grafir <?php echo $data->grafirwanita;?></td>
                    </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td>Model Cincin</td>
                        <td><?php 
                        if (!empty($data->kodecincin)){
                            echo 'Kode '.$data->kodecincin;   
                        }
                        if (!empty($data->url_gambar_cincin)){
                            echo '<img src="'.$data->url_gambar_cincin.'" class="img-fluid" />';
                        }
                        if (!empty($data->upload_cincin)){
                            echo '<img src="'.$data->upload_cincin.'" class="img-fluid" />';
                        }
                        if (!empty($data->link)){
                            echo '<a href="'.$data->link.'" target="_blank">Halaman produk</a>';
                        }
                        ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
  </body>
</html>