<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link media="screen" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">

    <style type="text/css">
        body{
            font-family: 'Work Sans', sans-serif;
        }
        .card{
            border:0;
        }

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
        .main{
            font-size:18px;
        }


        @media print{
                
            .container{
                    width:148mm;
                    height:210mm;
                    
                }

                body{
                    font-family: 'Lexend Deca', sans-serif;
                    font-size: 12px;
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
                    margin-top:15px;
                }

                .mb-1{
                    margin-bottom:5px;
                    font-size:11px;
                    color:#818187;
                }

                

                .p-5{
                    padding:5px;
                }

                .kiri{
                    float:left;
                    width:50%;
                }

                .kanan{
                    float:right;
                    width:50%;
                }

                .bersih{
                    content: "";
                    clear: both;
                    display: table;
                }

                .table tr td, table thead tr th{
                    font-size:12px;
                }

                .py-3{
                    margin-top:40px;
                    font-size:12px;
                }

                .d-flex{
                    text-align:right;
                }

                .d-right{
                    text-align:right;
                }
  
        }

    </style>
  </head>
  <body>
      
  <div class="container mt-5 mb-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row p-3">
                        <div class="col-md-6 kiri p-5">
                            Nota Pembelian<br />
                            No. <?php echo $data->id;?>
                        </div>

                        <div class="kanan d-right"><img class="img-fluid logo" src="<?php echo asset('images/logo-zavira-gargone.png');?>"></div>
                        <br class="bersih" />
                    </div>

                    <div class="row pb-5 p-5 main">
                        <div class="col-md-6 kiri">
                            <p class="font-weight-bold"><?php echo aa('Kepada Yth ',$data->nama,'');?></p>
                            <p class="mb-1"><?php echo aa('',$data->alamat,'');?><br /><?php echo aa('No HP ',$data->nohp,'');?></p>
                        </div>

                        <div class="col-md-6 kanan">
                            <div class="text-right">
                        <?php
                            if (!empty($data->sertifikat_gambarcincin)){
                                ?>
                                <img src="<?php echo $data->sertifikat_gambarcincin;?>" align="right" class="img-thumbnail" width="200px;" alt="cincin kawin" />
                                <?php
                            }
                            ?></div>
                        </div>

                        <br class="bersih" />
                    </div>

                    <div class="row p-5 main">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="font-weight-bold">No</th>
                                        <th class="font-weight-bold">Item</th>
                                        <th class="font-weight-bold">Material</th>
                                        <th class="font-weight-bold">Berat</th>
                                        <th class="font-weight-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Cincin Pria</td>
                                        <td><?php echo title_logam($data->bahanpria()->first(),'title');?></td>
                                        <td><?php echo aa('',$data->sertifikat_beratpria,'gr');?></td>
                                        <td><?php echo (rupiah($data->sertifikat_beratpria * $data->sertifikat_hargapria));?></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Biaya Produksi Cincin Pria</td>
                                        <td>-</td>
                                        <td>1 unit</td>
                                        <td><?php echo rupiah($data->biaya_produksi_pria);?></td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Cincin Wanita</td>
                                        <td><?php echo title_logam($data->bahanwanita()->first(),'title');?></td>
                                        <td><?php echo aa('',$data->sertifikat_beratwanita,'gr');?></td>
                                        <td><?php echo (rupiah($data->sertifikat_beratwanita * $data->sertifikat_hargawanita));?></td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td >Biaya Produksi Cincin Wanita</td>
                                        <td>-</td>
                                        <td>1 unit</td>
                                        <td><?php echo rupiah($data->biaya_produksi_wanita);?></td>
                                    </tr>
                                    <?php
                                       if (!empty($data->sertifikat_berlian) && !empty($data->sertifikat_harga_berlian)){
                                           ?>
                                            <tr>
                                                <td>5.</td>
                                                <td><?php echo $data->sertifikat_berlian;?></td>
                                                <td>Tertera pada memo/sertifikat berlian</td>
                                                <td>-</td>
                                                <td><?php echo rupiah($data->sertifikat_harga_berlian);?></td>
                                            </tr>
                                           <?php
                                       }     
                                    ?>

                                    <?php
                                       if (!empty($data->promo_id)){
                                           ?>
                                            <tr>
                                                <td>-</td>
                                                <td colspan="2"><?php echo $data->promo->title;?></td>
                                                <td><?php if ($data->promo->nominal != 0 || $data->promo->nominal != null) echo rupiah($data->promo->nominal); else echo '-';?></td>
                                            </tr>
                                           <?php
                                       }     
                                    ?>

                                    <tr>
                                        <td colspan="4" align="right">Total Biaya</td>
                                        <td >
                                        <?php
                                            $pria = $data->sertifikat_beratpria * $data->sertifikat_hargapria + $data->biaya_produksi_pria;
                                            $wanita = $data->sertifikat_beratwanita * $data->sertifikat_hargawanita + $data->biaya_produksi_wanita;
                                            $total = $pria + $wanita;
                                            if (!empty($data->sertifikat_berlian) && !empty($data->sertifikat_harga_berlian)){
                                                $total = $total + $data->sertifikat_harga_berlian;
                                            }
                                            if (!empty($data->promo_id)){
                                                if ($data->promo->nominal != 0){
                                                    $total = $total - $data->promo->nominal;
                                                }
                                                
                                            }
                                            
                                            echo rupiah($total+$data->sertifikat_freeongkir+$data->sertifikat_kotakcincin);
                                        ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                   
                    <div class="kanan">
                        <div class="d-flex p-4 main">
                            <div class="py-3 px-5 text-left">
                                Yogyakarta, <?php echo date('d M Y');?>
                                <div class="mb-5">Hormat Kami</div>
                                <div>PT Zavirafinery Kreasi Indonesia</div>
                            </div>

                        </div>
                    </div>

                    <div class="bersih"></div>
                    <div class="p-5 mb-1">
                     <i>Terimakasih atas kepercayaan Anda kepada Zavira Jewelry</i>
                    </div>

                    <div class="p-5 mb-1">
                    Sekilas mengenai kami<br />
                    <p>Zavira Jewelry adalah perusahaan dibidang pembuatan cincin kawin dan perhiasan secara custom. Kami melayani pembuatan perhiasan dari bahan emas, palladium, platinum dan silver. Saat ini Zavira Jewelry memiliki cabang di kota Gresik dan Tabanan, Bali.</p>
                    <p>Zavira Jewelry sebelumnya bernama Jogjabelanja, berdiri di Yogyakarta pada november 2009. Kemudian re-branding menjadi Zavira Jewelry pada tahun 2016.</p>
                    <p>Follow instagram kami @zavirajewelry</p>
                    
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  </body>
</html>