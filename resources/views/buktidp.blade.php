<!doctype html>
<html lang="en">
  <head>
    <title>Bukti Pembayaran DP</title>
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
  <body onload="window.print();">

  <div class="container text-center mb-5">
    <img class="img-fluid kanan" src="<?php echo asset('images/logo-zavira-gargone.png');?>" width="200px" /> 
    <br />
    <h2>Bukti Pembayaran</h2>
    <p>Lampiran elektronik ini adalah bukti sah pembayaran tahap awal (DP) pembelian perhiasan di Zavira Jewelry</p>
  </div>

  <div class="container mb-5">
      <table class="table table-bordered">
      <tr>
          <td width="40%" class="font-weight-bold">No Order</td>
          <td><?php echo $data->id;?></td>
        </tr>
        <tr>
          <td class="font-weight-bold">Nama Penyetor</td>
          <td><?php echo $data->nama;?>&nbsp;<?php echo 'No HP '.$data->nohp;?></td>
        </tr>
        <tr>
          <td class="font-weight-bold">No HP</td>
          <td><?php echo $data->nohp;?></td>
        </tr>
        <tr>
          <td class="font-weight-bold">Tanggal Pembayaran</td>
          <td><?php echo date('d F Y', strtotime($data->tglmasuk))?></td>
        </tr>
        <tr>
          <td class="font-weight-bold">Nominal DP</td>
          <td><?php echo rupiah($data->dp);?></td>
        </tr>
        <?php
            if (!empty($data->hargabarang)){
                ?>
                <tr>
                    <td class="font-weight-bold">Estimasi Harga Barang</td>
                    <td><?php echo rupiah($data->hargabarang);?></td>
                </tr>
                <?php
            }
        ?>
        <tr>
          <td class="font-weight-bold">Metode Pembayaran</td>
          <td>via <?php echo $data->rekening;?></td>
        </tr>
    </table>
  </div>

  <div class="container text-right">
  Yogyakarta, <?php echo date('d F Y');?>
    <div class="mb-5">Hormat Kami</div>
    <div>Management Zavira Jewelry</div>
  </div>
  
  </body>
</html>