<!doctype html>
<html lang="en">
  <head>
    <title>Finising</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h2>Pesanan Anda Hampir Siap Kirim!</h2>
        <p>Hallo, <?php echo $pesanan->nama;?></p>
        <p>Pesananmu dengan no order <?php echo $pesanan->id;?> saat ini sudah masuk tahap finising. 
        Proses finising akan memakan waktu sekitar 1-2 hari. Jika sudah dikirim, maka kami akan memberikan no resi via email.</p>

        <p>Terimakasih<br />
        <?php echo env('COMPANY_NAME');?><br />
        <?php echo env('COMPANY_ADD');?>
        </p>
    </div>
  </body>
</html>