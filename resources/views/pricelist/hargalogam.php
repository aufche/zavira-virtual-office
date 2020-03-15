<!doctype html>
<html lang="en">
  <head>
    <title>Harga Logam</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <style type="text/css">
        @media (min-width: 1200px) {
    .container{
        width: 1080px;
        height:1080px;
        border:1px solid #AE933D;
    }
}
        
        body{
            font-size:17px;
            font-family: 'Livvic', sans-serif;
            height:2200px;
        }
        .header {
  background-image: url("https://i.imgur.com/yKdOl3T.png");
  
        height:400px;
        background-repeat:no-repeat;
        background-size:contain;
background-position:center;
        
}
    table.table-bordered{
    border:1px solid #000;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid #AE933D;
}
table.table-bordered > tbody > tr > td{
    border:1px solid #AE933D;
}

 .header {
  background-image: url(<?php echo asset('images/header.png');?>);
  
        height:350px;
        background-repeat:no-repeat;
        background-size:contain;
background-position:center;
        
}
.head{

}
    </style>
  </head>
  <body>
      <div class="container mt-3">

       <div class="header text-center" style="font-size:40px;"><br />
            <h1 class="display-3" style="font-weight:700"><?php echo 'harga logam mulia'; ?></h1>
            <p class="display-5">Per 1 gram</p>
            
    </div>

        <div class="row">
            <div class="col-md-6">
               <span class="p-3 bg-warning shadow font-weight-bold"><i class="far fa-gem"></i> Emas</span>
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-warning text-dark">
                        <th>No</th>
                        <th>Kadar</th>
                        <th>Harga @gram</th>
                    </tr>
                    </thead>
                    <?php
                        $i = 1;
                        foreach ($kadar_emas as $item){
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php 
                                    echo $item->title;
                                    if ($item->kadar < 50)
                                        echo ' (emas putih)';
                                    else
                                        echo ' (emas kuning)';
                                ?></td>
                                <td><?php echo rupiah(($item->kadar/100) * $emas->isi + $item->markup);?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    ?>
                </table>
            </div>
            <div class="col-md-6">
                <span class="p-3 bg-warning shadow font-weight-bold"><i class="far fa-gem"></i> Emas Putih Premium</span>
                <table class="table table-bordered mb-3">
                    <thead>
                    <tr class="bg-warning text-dark">
                        <th>No</th>
                        <th>Kadar</th>
                        <th>Harga @gram</th>
                    </tr>
                    </thead>
                    <?php
                        $i = 1;
                        foreach ($kadar_emas_putih as $item){
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $item->title;?></td>
                                <td><?php echo rupiah(($item->kadar/100) * $emas->isi + $item->markup);?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    ?>
                </table>

                <span class="p-3 bg-warning shadow font-weight-bold"><i class="far fa-gem"></i> Palladium</span>
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-warning text-dark">
                        <th>No</th>
                        <th>Kadar</th>
                        <th>Harga @gram</th>
                    </tr>
                    </thead>
                    <?php
                        $i = 1;
                        foreach ($kadar_palladium as $item){
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $item->title;?></td>
                                <td><?php echo rupiah(($item->kadar/100) * $palladium->isi + $item->markup);?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    ?>
                </table>
            </div>
            
        </div>

        <div class="row mb-5">
        <div class="col-md-12 text-center">
        <img src="<?php echo asset('images/logo-pl.png');?>" class="img-fluid" width="150px" />
        </div>
    </div>
    
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>