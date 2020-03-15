<!doctype html>
<html lang="en">
  <head>
    <title>Ambil Data Pesanan Zavira Jewelry</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link media="screen" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <style type="text/css"> 
        @media screen{
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
        }

        @media print{
                @import url('https://fonts.googleapis.com/css?family=PT+Mono&display=swap');

                body{
                  font-family: 'PT Mono', monospace;
                }
                .table {
                    border:1px solid black;
                    border-collapse:collapse;
                    width:100%;
                }
                .table tr td, .table thead tr th{
                    border:1px solid #000;
                    padding:10px;
                }

                .img-fluid{
                    max-width: 100%;
                    height: auto
                }
                .logo{
                    width:40%;
                }
                .mb-5{
                    margin-bottom:50px;
                }

                .mb-1{
                    margin-bottom:10px;
                }

                

                .p-5{
                    padding:5px;
                }

                .kiri{
                    float:left;
                    width:70%;
                }

                .kanan{
                    float:right;
                    width:30%;
                }

                .bersih{
                    content: "";
                    clear: both;
                    display: table;
                }
  
        }
    </style>
  </head>
  <!-- onload="window.print();" -->
  <body onload="window.print();">
    <div class="container mt-2">
    <?php
    foreach ($data as $item){
            if ($item->couple == 1){
                $row_span = 11;
            }else{
                $row_span = 6;
            }
        ?>

        <table id="tableId" class="table table-bordered" width="100%">
        <tr>
            <td rowspan="3">Catatan Khusus:</td>
            <td>Tanggal Order</td>
            <td><?php echo date('d M Y');?></td>
          </tr>
          <tr>
            <td>Deadline</td>
            <td><?php echo date('d M Y', strtotime($item->deadline));?></td>
          </tr>
          <tr>
            <td>No Order</td>  
            <td><?php echo $item->id;?></td>
          </tr>
          <tr>
            <td rowspan="<?php echo $row_span;?>">
            <?php
            if (!empty($item->gambar)){
              ?>
              <img src="<?php echo $item->gambar;?>" class="img-fluid" width="300px" alt="cincin" /><br />
              <?php
            }
    
            if (!empty($item->gambargambar)){
              $gambar = explode(',',$item->gambargambar);
                foreach($gambar as $gbr){
                ?>
                <img src="<?php echo $gbr;?>" alt="" class="img-fluid" width="300px" /><br />
                <?php
            }
            }
            ?>
            </td>
        </tr>
            <?php if (!empty($item->ukuranpria) || !empty($item->bahanpria)){
                ?>
                <tr>
                     <td colspan="2"><strong>Cincin Pria</strong></td>
                </tr>
                <tr>
                    <td >Size</td>
                    <td ><?php echo $item->ukuranpria;?></td>
                </tr>
                <tr>
                    <td >Bahan</td>
                    <td ><?php echo $item->bahanpria()->first()['title'];?><br /><?php echo aa('Berat maksimal ',$item->produksi_beratpria,'gr');?></td>
                </tr>
                <tr>
                    <td>Grafir</td>
                    <td><?php echo $item->grafirpria;?></td>
                </tr>
                <tr>
                    <td>Berat akhir cincin pria<br /><i>*Diisi oleh pengrajin</i></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <?php
                }
                ?>
        
        <?php if (!empty($item->ukuranwanita) || !empty($item->bahanwanita)){
            ?>
    <tr>
            <td colspan="2"><strong>Cincin Wanita</strong></td>
          </tr>
          <tr>
            <td>Size</td>
            <td><?php echo $item->ukuranwanita;?></td>
          </tr>
          <tr>
            <td>Bahan</td>
            <td><?php echo $item->bahanwanita()->first()['title'];?><br /><?php echo aa('Berat maksimal ',$item->produksi_beratwanita,'gr');?></td>
          </tr>
          <tr>
            <td>Grafir</td>
            <td><?php echo $item->grafirwanita;?></td>
          </tr>
           <tr>
            <td>Berat akhir cincin wanita<br /><i>*Diisi oleh pengrajin</i></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
            <?php
        }
        ?>
          
         
          <tr>
            <td colspan="2">Finising<br /><?php echo $item->keterangan;?></td>
            <td>Pengrajin<br /><?php echo $item->pengrajin->nama;?></td>
          </tr>
        </table>
        <?php
    }
  ?>
  </div>
  
  </body>
</html>