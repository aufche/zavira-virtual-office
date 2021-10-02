<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend&family=Lobster&display=swap" rel="stylesheet">

<style>
  body{
    font-family: 'Lexend', sans-serif;
  }

  .table tr td{
    padding:10px;
  }

  .judul{
    font-family: 'Lobster', cursive;
  }

  
</style>

    <title>Kalkulator Baru</title>
  </head>
  <body>
  


<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Menu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       
        <li class="nav-item">
        <a class="nav-link" href="<?php echo route('kalkulator.backend');?>">Kalkulator</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo route('pergram.backend');?>">Harga Logam</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pricelist Couple
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>1]);?>">Paket 1jt-an</a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>2]);?>">Paket 2 - 3jt-an </a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>3]);?>">Paket 4 - 5jt-an </a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>4]);?>">Paket 6 - 7jt-an </a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>5]);?>">Paket 8jt keatas </a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>'ps']);?>">Platinum Series </a></li>
            
            
          </ul>
        </li>
        
      </ul>
     
    </div>
  </div>
</nav>