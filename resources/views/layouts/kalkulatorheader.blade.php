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
        <a class="nav-link" href="<?php echo route('pergram.backend');?>">Pricelist</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Rentang Harga Cincin Sepasang
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">200rb - 700rb</a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>1]);?>">2jt an - 4 jt an</a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>2]);?>">5 jt an - 7 jt an </a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>3]);?>">Lebih dari 7jt </a></li>
            <li><a class="dropdown-item" href="<?php echo route('paket.backend',['no'=>'ps']);?>">Platinum Series </a></li>
            
            
          </ul>
        </li>
        
      </ul>
     
    </div>
  </div>
</nav>