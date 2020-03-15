<!doctype html>
<html lang="en">
  <head>
    <title>Terimakasih</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>

  <div class="container">
      <h2>Terimakasih!</h2>

      <p>Kami dari Zavira Jewelry mengucapkan terimakasih banyak atas kepercayaan Anda. Saat ini pesanan anda sudah kami proses. Berikut ini data-data pesanan Anda.</p>
      <p>

      <table class="table">
        <tr>
            <td>Nama Pemesan</td>
            <td><?php echo $pesanan['nama'];?></td>
        </tr>
        <tr>
            <td>No HP</td>
            <td><?php echo $pesanan['nohp'];?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?php echo $pesanan['alamat'];?></td>
        </tr>
        <tr>
            <td>Ukuran Cincin Pria</td>
            <td><?php echo $pesanan['ukuranpria'];?><br />Grafir <?php echo $pesanan['grafirpria'];?><br />Bahan <?php echo $pesanan['bahanpria'];?></td>
        </tr>
        <tr>
            <td>Ukuran Cincin Wanita</td>
            <td><?php echo $pesanan['ukuranwanita'];?><br />Grafir <?php echo $pesanan['grafirwanita'];?><br />Bahan <?php echo $pesanan['bahanwanita'];?></td>
        </tr>
        <tr>
            <td>Estimasi Selesai</td>
            <td><?php echo $pesanan['tglselesai'];?></td>
        </tr>
      </table>
      </p>

      <p>Terimakasih,<br />
      <?php echo env('COMPANY_NAME');?><br />
      <?php echo env('COMPANY_ADD');?>
      </p>
  </div>
    
  </body>
</html>
