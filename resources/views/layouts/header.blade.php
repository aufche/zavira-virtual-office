<!doctype html>
<html lang="en">
  <head>
    <title>Zavira Jewelry Virtual Office</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href=" <?php echo asset('css/zavira.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('css/daterangepicker.css');?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha256-rByPlHULObEjJ6XQxW/flG2r+22R5dKiAoef+aXWfik=" crossorigin="anonymous" />

    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" />
    
    
  </head>
  <body>


<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark shadow">
  <a class="navbar-brand" href="#">Zavira Jewelry</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
        <li><a class="nav-link  rounded-pill bg-danger active" href="<?php echo route('input');?>"><i class="fa fa-plus-circle"></i> Order</span></a></li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pesanan</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?php echo route('pesanan.finish');?>"><i class=" fa fa-wrench"></i> Update Finising</span></a>
          <a class="dropdown-item" href="<?php echo route('semua');?>"><i class=" fa fa-shopping-bag"></i> Data Pesanan</span></a>
          <a class="dropdown-item" href="<?php echo route('pesanan.lead');?>"><i class="fas fa-comments"></i> Update Chat</span></a>
        </div>
      </li>
       
        

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sertifikat Logam</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?php echo route('sertifikat');?>"><i class=" fa fa-check-circle"></i> Sudah Tersertifikat</a>
          <a class="dropdown-item" href="<?php echo route('sertifikat.belum');?>"><i class=" fa fa-times-circle"></i> Belum Tersertifikat</a>
        </div>
      </li>
      <li><a class="nav-link text-white" href="<?php echo route('reparasi.index');?>"><i class=" fa fa-repeat"></i>Reparasi</span></a></li>
      <li><a class="nav-link text-white" href="<?php echo route('order.all');?>"><i class=" fa fa-snowflake-o"></i>Order dari Web</span></a></li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Transaksi Cash</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?php echo route('pembukuan.semua');?>"><i class=" fa fa-bars"></i> Lihat Transaksi</a>
            <a class="dropdown-item" href="<?php echo route('pembukuan.add',['status'=>1]);?>"><i class=" fa fa-plus"></i> Transaksi Dana Masuk</a>
            <a class="dropdown-item" href="<?php echo route('pembukuan.add',['status'=>0]);?>"><i class=" fa fa-minus"></i> Transaksi Dana Keluar</a>
            <a class="dropdown-item" href="<?php echo route('pembukuan.transfer');?>"><i class="fas fa-exchange-alt"></i> Transfer</a>
        </div>
      </li>


      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Setting</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?php echo route('setting.all');?>"><i class=" fa fa-hand-holding-usd"></i> Harga Logam</a>
          <a class="dropdown-item" href="<?php echo route('logam.all');?>"><i class=" fa fa-boxes"></i> Variasi Logam</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utility</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?php echo route('logam.kalkulator',['apa'=>'pricelist']);?>" target="popup" onclick="window.open('<?php echo route('logam.kalkulator',['apa'=>'pricelist']);?>','popup','width=600,height=800'); return false;"><i class=" fa fa-tags"></i> Pricelist</a>
            <a class="dropdown-item" href="<?php echo route('logam.kalkulator');?>" target="popup" onclick="window.open('<?php echo route('logam.kalkulator');?>','popup','width=600,height=800'); return false;"><i class=" fa fa-calculator"></i> Kalkulator</a>
            <a class="dropdown-item" href="<?php echo route('pesanan.hitung');?>" target="popup" onclick="window.open('<?php echo route('pesanan.hitung');?>','popup','width=600,height=600'); return false;"><i class=" fa fa-calculator"></i> Hitung Kebutuhan Logam</a>
            <a class="dropdown-item" href="<?php echo route('logam.buyback');?>"><i class=" fa fa-meteor"></i> Kalkulator Jual Kembali</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo route('updateform',['action'=>1]);?>" target="popup" onclick="window.open('<?php echo route('updateform',['action'=>1]);?>','popup','width=1200,height=500'); return false;"><i class="fas fa-wrench"></i> Update Biaya Produksi</a>
            <a class="dropdown-item" href="<?php echo route('updateform',['action'=>2]);?>" target="popup" onclick="window.open('<?php echo route('updateform',['action'=>2]);?>','popup','width=1200,height=500'); return false;"><i class="fab fa-pagelines"></i> Update Biaya Lapis</a>
            <a class="dropdown-item" href="<?php echo route('updateform',['action'=>3]);?>" target="popup" onclick="window.open('<?php echo route('updateform',['action'=>3]);?>','popup','width=1200,height=500'); return false;"><i class="fas fa-chalkboard-teacher"></i> Update Biaya Lapis & Produksi</a>
            <div class="dropdown-divider"></div>
            <!--<a class="dropdown-item" href="<?php echo route('pesanan.woodbox');?>" target="popup" onclick="window.open('<?php echo route('pesanan.woodbox');?>','popup','width=600,height=300'); return false;"><i class=" fa fa-edit"></i> Update Woodbox</a>
            <div class="dropdown-divider"></div>-->
            <a class="dropdown-item" href="<?php echo route('bukti.index');?>"><i class=" fa fa-gift"></i> Bukti Transfer Pak Bejo</a>
            <a class="dropdown-item" href="<?php echo route('bukti.insert.get');?>"><i class=" fa fa-gift"></i> Update Bukti Transfer Pak Bejo</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo route('pesanan.filter');?>"><i class=" fa fa-filter"></i> Filter</a>
            <a class="dropdown-item" href="<?php echo route('penting.index');?>"><i class=" fa fa-exclamation-circle"></i> Masalah Krusial</a>
            <!--<a class="dropdown-item" href="<?php echo route('ga.index');?>"><i class=" fa fa-gift"></i> Giveaway</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="https://www.facebook.com/zavirajewelry/inbox/?mailbox_id=1481893255466137&selected_item_id=340282366841710300949128291128235499821" target="_blank"><i class=" fa fa-comment-dots"></i> DM Zavira Jewelry</a>
          <a class="dropdown-item" href="https://www.facebook.com/zavirajewelry.gresik/inbox/?mailbox_id=521313014703153&selected_item_id=340282366841710300949128371083863275972" target="_blank"><i class=" fa fa-comment-dots"></i> DM Zavira Gresik</a>
          <a class="dropdown-item" href="https://www.facebook.com/zavirajewelry.bali/inbox/?mailbox_id=302901269837110&selected_item_id=340282366841710300949128329698656421808" target="_blank"><i class=" fa fa-comment-dots"></i> DM Zavira Bali</a>
          -->
        </div>
      </li>

      <!--<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Paket Penjualan</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
         <a class="dropdown-item" href="<?php echo route('ze.add');?>"><i class=" fa fa-plus-circle"></i> Tambah</a>
         <a class="dropdown-item" href="<?php echo route('ze.index');?>"><i class=" fa fa-tasks"></i> Semua Paket</a>
        </div>
      </li>-->
      <li><a class="nav-link text-white" href="<?php echo route('logout');?>"><i class=" fa fa-repeat"></i>Logout</span></a></li>

    </ul>
    <form class="form-inline mt-2 mt-md-0" action="<?php echo route('search');?>" method="post">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input name="q" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    
  </div>
</nav>
<div class="container-fluid mt-4">
    
