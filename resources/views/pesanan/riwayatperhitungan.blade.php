<!doctype html>
<html lang="en">
  <head>
    <title>Daftar Riwayat Perhitungan Biaya Produksi</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
    table.table-bordered{
    border:1px solid #000;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid #000;
}
table.table-bordered > tbody > tr > td{
    border:1px solid #000;
}
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                  <label for="">Cari No Order</label>
                  <input type="text" class="form-control" name="pesanan_id" />
                  <button type="submit" class="btn btn-primary btn-block btn-lg">Cari</button>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <td>Identitas</td>
                        <td>Action</td>
                    </tr>

                    <?php

                    foreach ($data as $item){
                        ?>
                        <tr>
                            <td><a href="<?php echo route('pesanan.riwayat.perhitungan',['detail'=>$item->identitas]);?>"><?php echo $item->identitas;?></a></td>
                            <td><a href="<?php echo route('pesanan.riwayat.perhitungan',['detail'=>$item->identitas,'hapus'=>'hapus']);?>">Hapus</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>

            </div>   
        </div>
    </div>
  </body>
</html>