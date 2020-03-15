<!doctype html>
<html lang="en">
  <head>
    <title>Menghitung Biaya Pembelian Logam Produksi</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <div class="rows">
        <div class="col-md-12">
        
        <form action="<?php echo route('pesanan.proseshitung');?>" method="post" class="mt-5">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <a href="<?php echo route('pesanan.riwayat.perhitungan');?>">Riwayat Perhitungan Logam</a><br />
        <label for="validationDefault03">No Order</label>
        <input type="text"  name="ids" class="form-control form-control-lg" >
        <p class="form-text text-muted">
        Pisahkan dengan tanda bintang, misal xxxx*yyyy*qqqq    
        </p>

        <label for="validationDefault03">ID Proses Perhitungan</label>
        <input type="text"  name="identitas" value="<?php echo strtoupper(date('d-M-Y').'-'.str_random(10));?>" class="form-control form-control-lg" >

        <button type="submit" class="btn btn-dark btn-lg btn-block mt-3">Hitung</button>
        

      </form>
        </div>
      </div>
    </div>
  
  </body>
</html>