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

  <body onload="window.print()">
  <table id="tableId" class="table table-bordered" width="100%">
        <tr>
            <td>CS</td>
            <td><?php echo $data->user->name;?></td>
        </tr>
        <tr>
            <td>No Order</td>
            <td><?php echo $data->id;?> / Tanggal <?php echo date('d M Y', strtotime($data->tglmasuk));?></td>
        </tr>
        <tr>
            <td>Pengrajin</td>
            <td><?php echo $data->pengrajin->nama;?></td>
        </tr>
        <tr>
            <td>Lapis</td>
            <td><?php if (!empty($data->plated_id)) echo $data->plated->title;?></td>
        </tr>
        <tr>
            <td>Deadline</td>
            <td><?php echo date('d M Y', strtotime($data->deadline));?></td>
        </tr>
        
    
        
        <tr>
            <td>
            <?php
                if (!empty($data->gambar)){
                    ?>
                    <img src="<?php echo $data->gambar;?>" class="img-fluid" width="400px;" alt="cincin" /><br />
                    <?php
                  }
            ?>
            </td>
            <td style="line-height:200%">
            KETERANGAN CINCIN COWOK<br />
            <?php
                if (!empty($data->gambar_cincin_pria)){
                ?>
                    <img src="<?php echo $data->gambar_cincin_pria;?>" class="img-fluid" width="400px;" alt="cincin" /><br />
                    <?php echo $data->finising_pria;?><br />
                <?php
                    }
                ?>
            Ukuran : <?php echo $data->ukuranpria;?><br />
            Grafir : <?php echo $data->grafirpria;?><br />
            Bahan : <?php echo title_logam($data->bahanpria()->first(),'title');?><br />
            <?php echo aa('Berat maksimal ',$data->produksi_beratpria,'gr');?>
            <br />
            <br />
            <br />KETERANGAN CINCIN CEWEK<br />
            <?php
                if (!empty($data->gambar_cincin_wanita)){
                ?>
                    <img src="<?php echo $data->gambar_cincin_wanita;?>" class="img-fluid" width="400px;" alt="cincin" /><br />
                    <?php echo $data->finising_wanita;?><br />
                <?php
                    }
                ?>
            Ukuran : <?php echo $data->ukuranwanita;?><br />
            Grafir : <?php echo $data->grafirwanita;?><br />
            Bahan : <?php echo title_logam($data->bahanwanita()->first(),'title');?><br />
            <?php echo aa('Berat maksimal ',$data->produksi_beratwanita,'gr');?>
            </td>
        </tr>
        <tr>
            <td>Berat Akhir Pria:...............</td>
            <td>Berat Akhir Wanita :...............</td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:30px;">
            <?php echo $data->keterangan;?><br />
            </td>
        </tr>
  </table>
  </body>

  </html>