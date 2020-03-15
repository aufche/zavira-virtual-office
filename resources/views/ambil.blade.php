<!doctype html>
<html lang="en">
  <head>
    <title>Ambil Data Pesanan Zavira Jewelry</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
    <?php
    foreach ($data as $item){
        ?>
        No Order <?php echo $item->id;?><br />
        Size Pria <?php echo $item->ukuranpria;?> grafir <?php echo $item->grafirpria;?><br />
        Bahan Pria <?php echo $item->bahanpria;?><br />
        Size Wanita <?php echo $item->ukuranwanita;?> grafir <?php echo $item->grafirwanita;?><br />
        Bahan Wanita <?php echo $item->bahanwanita;?><br /><br />
        Keterangan <?php echo $item->keterangan;?><br /><br />
        Pengrajin <?php echo $item->pengrajin->nama;?><br />
        Deadline <?php echo $item->deadline;?><br />
        <?php
       
        if (!empty($item->gambar)){
          ?>
          <img src="<?php echo $item->gambar;?>" class="img-thumbnail" alt="cincin" /><br />
          <?php
        }

        if (!empty($item->gambargambar)){
          $gambar = explode(',',$item->gambargambar);
            foreach($gambar as $gbr){
            ?>
            <img src="<?php echo $gbr;?>" alt="" class="img-thumbnail" width="200px" /><br />
            <?php
        }
        }
    }
  ?>
  </body>
</html>