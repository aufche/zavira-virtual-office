<!doctype html>
<html lang="en">
  <head>
    <title>Price List</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

  <div class="container">
    <div class="row">
        <div class="col-md-4 mt-4">
            <ul class="list-group list-group-flush">
            <li class="list-group-item active">Price List Cetak</li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'luxurious','t'=>'print']);?>" target="_blank">Luxurious</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'luxurious2','t'=>'print']);?>" target="_blank">Luxurious 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'elite','t'=>'print']);?>" target="_blank">Elite</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'elite2','t'=>'print']);?>" target="_blank">Elite 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium','t'=>'print']);?>" target="_blank">Premium</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium2','t'=>'print']);?>" target="_blank">Premium 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium3','t'=>'print']);?>" target="_blank">Premium 3</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'platinum','t'=>'print']);?>" target="_blank">Platinum</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'platidium','t'=>'print']);?>" target="_blank">Platidium</a></li>
        </ul>
        </div>

        <div class="col-md-4 mt-4">
            <ul class="list-group list-group-flush">
            <li class="list-group-item active">Price List Story (1920 x 1080)</li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'luxurious','t'=>'story']);?>" target="_blank">Luxurious</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'luxurious2','t'=>'story']);?>" target="_blank">Luxurious 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'elite','t'=>'story']);?>" target="_blank">Elite</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'elite2','t'=>'story']);?>" target="_blank">Elite 3</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium','t'=>'story']);?>" target="_blank">Premium</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium2','t'=>'story']);?>" target="_blank">Premium 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium3','t'=>'story']);?>" target="_blank">Premium 3</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'platinum','t'=>'story']);?>" target="_blank">Platdinum</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'platidium','t'=>'story']);?>" target="_blank">Platdium</a></li>
        </ul>
        </div>

        <div class="col-md-4 mt-4">
            <ul class="list-group list-group-flush">
            <li class="list-group-item active">Price List Feed (1080 x 1080)</li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'luxurious','t'=>'1080']);?>" target="_blank">Luxurious</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'luxurious2','t'=>'1080']);?>" target="_blank">Luxurious 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'elite','t'=>'1080']);?>" target="_blank">Elite</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'elite2','t'=>'1080']);?>" target="_blank">Elite 3</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium','t'=>'1080']);?>" target="_blank">Premium</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium2','t'=>'1080']);?>" target="_blank">Premium 2</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'premium3','t'=>'1080']);?>" target="_blank">Premium 3</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'platinum','t'=>'1080']);?>" target="_blank">Platdinum</a></li>
            <li class="list-group-item"><a href="<?php echo route('logam.pricelist',['p'=>'platidium','t'=>'1080']);?>" target="_blank">Platdium</a></li>
        </ul>
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