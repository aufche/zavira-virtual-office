<!doctype html>
<html lang="en">
  <head>
    <title>Cetak Amplop</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link media="screen" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
     <link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">
    <style type="text/css">
    @media print {
        body{
                    font-family: 'Lexend Deca', sans-serif;
                    font-size: 12px;
                }

        .pd{
            padding-top:120px;
        }
        
    }
    </style>
  </head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col-md-3">
          Pengirim Bimo Hery Prabowo<br />
          Jl Perintis Kemerdekaan No. 54 Yogyakarta<br />
          089104788585
          </div>

          <div class="col-md-9 pd">
            Kepada Yth <br /><?php echo $data->nama;?><br />
            Alamat <?php echo $data->alamat;?><br />
            No HP <?php echo $data->nohp;?>
          </div>
        </div>
      </div>
  </body>
</html>