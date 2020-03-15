<!doctype html>
<html lang="en">
  <head>
    <title>Price List Cincin Single</title>
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
        height:1920px;
        border:1px solid #AE933D;
    }
}
        
        body{
            font-size:19px;
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


  <div class="container mt-3 px-5">

  <div class=" text-center" style="font-size:40px;"><br />
            <h1 class="display-3" style="font-weight:700"><span class="bg-warning p-2"><?php echo 'Pricelist Cincin Single'; ?></span></h1>
            <p class="display-5"><span class="bg-warning p-2">Material <?php echo $logam;?></span></p>
    </div>
    <span class="p-3 bg-warning shadow font-weight-bold border border-secondary"><i class="far fa-gem"></i> Emas Kuning</span>
    <table class="table mb-5 table-bordered">
        <tr>
			<td rowspan="2" class="align-middle bg-warning text-dark">No</td>
            <td rowspan="2" class="align-middle bg-warning text-dark">Kadar</td>
			<td rowspan="2" class="align-middle bg-warning text-dark">Harga @gram</td>
			<td colspan="4" class="text-center bg-warning text-dark">HARGA CINCIN JADI<br />(sudah termasuk ongkos pembuatan <?php echo rupiah(($ongkos_bikin->isi/2));?>)</td>
		</tr>
		<tr>
            <td class="text-center bg-dark text-white">3 gram</td>
            <td class="text-center bg-dark text-white">3.5 gram</td>
            <td class="text-center bg-dark text-white">4 gram</td>
            <td class="text-center bg-dark text-white">5 gram</td>
        </tr>
        
        <?php 
            $i = 1;
            foreach ($data_logam_emas as $item){
                $hrg_pergram = ($item->kadar/100) * $hargapokok->isi + $item->markup;
                $seni = ($ongkos_bikin->isi/2);
               ?>
                <tr>
                    <td><?php echo $i;?>.</td>
                    <td><?php echo $item->title;?></td>
                    <td><?php echo rupiah($hrg_pergram);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 3) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 3.5) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 4) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 5) + $seni);?></td>
                    
                </tr>
              <?php
              $i++;
            }
        ?>
    </table>

    <span class="p-3 bg-warning shadow font-weight-bold border border-secondary"><i class="far fa-gem"></i> Emas Putih Premium</span>
    <table class="table mb-5 table-bordered">
        <tr>
			<td rowspan="2" class="align-middle bg-warning text-dark">No</td>
            <td rowspan="2" class="align-middle bg-warning text-dark">Kadar</td>
			<td rowspan="2" class="align-middle bg-warning text-dark">Harga @gram</td>
			<td colspan="4" class="text-center bg-warning text-dark">HARGA CINCIN JADI<br />(sudah termasuk ongkos pembuatan <?php echo rupiah(($ongkos_bikin->isi/2));?>)</td>
		</tr>
		<tr>
            <td class="text-center bg-dark text-white">3 gram</td>
            <td class="text-center bg-dark text-white">3.5 gram</td>
            <td class="text-center bg-dark text-white">4 gram</td>
            <td class="text-center bg-dark text-white">5 gram</td>
        </tr>
        
        <?php 
           
            foreach ($data_logam_emas_putih as $item){
                $hrg_pergram = ($item->kadar/100) * $hargapokok->isi + $item->markup;
                $seni = ($ongkos_bikin->isi/2);
               ?>
                <tr>
                    <td><?php echo $i;?>.</td>
                    <td><?php echo $item->title;?></td>
                    <td><?php echo rupiah($hrg_pergram);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 3) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 3.5) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 4) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 5) + $seni);?></td>
                    
                </tr>
              <?php
              $i++;
            }
        ?>
    </table>

    <span class="p-3 bg-warning shadow font-weight-bold border border-secondary"><i class="far fa-gem"></i> Emas Putih/Kuning Standar</span>
    <table class="table table-bordered">
        <tr>
			<td rowspan="2" class="align-middle bg-warning text-dark">No</td>
            <td rowspan="2" class="align-middle bg-warning text-dark">Kadar</td>
			<td rowspan="2" class="align-middle bg-warning text-dark">Harga @gram</td>
			<td colspan="4" class="text-center bg-warning text-dark">HARGA CINCIN JADI<br />(sudah termasuk ongkos pembuatan <?php echo rupiah(($ongkos_bikin->isi/2));?>)</td>
		</tr>
		<tr>
            <td class="text-center bg-dark text-white">3 gram</td>
            <td class="text-center bg-dark text-white">3.5 gram</td>
            <td class="text-center bg-dark text-white">4 gram</td>
            <td class="text-center bg-dark text-white">5 gram</td>
        </tr>
        
        <?php 
           
            foreach ($data_logam_emas_ekonomis as $item){
                $hrg_pergram = ($item->kadar/100) * $hargapokok->isi + $item->markup;
                $seni = ($ongkos_bikin->isi/2);
               ?>
                <tr>
                    <td><?php echo $i;?>.</td>
                    <td><?php echo $item->title;?></td>
                    <td><?php echo rupiah($hrg_pergram);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 3) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 3.5) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 4) + $seni);?></td>
                    <td><?php echo rupiah(($hrg_pergram * 5) + $seni);?></td>
                    
                </tr>
              <?php
              $i++;
            }
        ?>
    </table>
    <h2>Keterangan</h2>
    <div class="row">
        
        <ol>
            <li>Pre order 7 - 14 hari kerja</li>
            <li>Harga untuk 1 buah cincin</li>
            <li>Desain cincin bebas, dengan desain yang sama, kakak bisa memilih menggunakan bahan yang mana aja</li>
        </ol>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 text-center">
        <img src="<?php echo asset('images/logo-pl.png');?>" class="img-fluid" width="200px" />
        </div>
    </div>
    <div class="row mt-5 text-center">
        <div class="col"><i class="fas fa-check-circle"></i> Free Exclusive Ring Box (couple ring)</div>
        <div class="col"><i class="fas fa-check-circle"></i> Free Engrave Name</div>
        <div class="col"><i class="fas fa-check-circle"></i> Sertifikat Logam</div>
        
    </div>

  </div>

  
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>