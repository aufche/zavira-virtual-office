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
  <!--<body> -->
    <div class="container mt-2">
    <?php
        $item = $data;
            if ($item->couple == 1){
                $row_span = 11;
            }else{
                $row_span = 6;
            }
        ?>

        <table id="tableId" class="table table-bordered" width="100%">
        <tr>
            <td rowspan="6" valign="top"><strong>CS <?php echo $item->user->name;?></strong><br />Catatan Khusus:</td>
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
            <td>Pengrajin</td>  
            <td><?php echo $item->pengrajin->nama;?></td>
          </tr>
          <tr>
            <td>Lapis</td>  
            <td><?php if (!empty($item->plated_id)) echo $item->plated->title;?></td>
          </tr>
          <tr>
            <td>Grafir di </td>  
            <td><?php echo $item->grafir;?></td>
          </tr>
          <tr>
            <td rowspan="<?php echo $row_span;?>">
            <?php
                if (!empty($item->gambar_cincin_pria)){
                ?>
                   <fieldset>
                        <legend>Gambar cincin pria :</legend>
                        <img src="<?php echo $item->gambar_cincin_pria;?>" class="img-fluid" width="300px" alt="cincin" /><br />
                        <?php echo $item->finising_pria;?>
                    </fieldset>
                <?php
                }

                if (!empty($item->gambar_cincin_wanita)){
                    ?>
                        <fieldset>
                        <legend>Gambar cincin wanita :</legend>
                        <img src="<?php echo $item->gambar_cincin_wanita;?>" class="img-fluid" width="300px" alt="cincin" />
                        <?php echo $item->finising_wanita;?>
                        </fieldset>
                    <?php
                    }

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

            if (!empty($item->finising_pria) && (empty($item->gambar_cincin_pria)) ){
                echo 'Finising Cincin Pria<br />';
                echo $item->finising_pria;
                echo '<br />';
            }

            echo '<hr />';

            if (!empty($item->finising_wanita) && (empty($item->gambar_cincin_wanita))){
                echo 'Finising Cincin Wanita<br />';
                echo $item->finising_wanita;
                echo '<br />';
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
                    <td >Bahan<br />
                       <?php
                        $jenis = $item->bahanpria()->first()['jenis'];
                        $kadar = title_logam($item->bahanpria()->first(),'kadar') / 100;
                        
                        if ($jenis == 'emas' || $jenis == 'palladium' || $jenis == 'platinum'){
                            echo $item->bahanpria()->first()['jenis'].' murni : '.$kadar * $item->produksi_beratpria.' gram<br />';
                            echo 'Campuran perak '.($item->produksi_beratpria - ($kadar * $item->produksi_beratpria)).' gram';
                        }elseif ($jenis == 'ep'){
                            if (title_logam($item->bahanpria()->first(),'kadar') <= 50){
                                // campuran pall 0.5 gram
                                $campuran_palladium = 0.5;
                                $text = 'Palladium : 0.5gram';
                                $total_tambahan = 0.5;
                                
                            }elseif (title_logam($item->bahanpria()->first(),'kadar') > 50 ){
                                $campuran_palladium = 0.5; 
                                $campuran_platinum = 0.5;
                                $text = 'Palladium : 0.5 gram<br />Platinum : 0.5gram';
                                $total_tambahan = 1;

                                //-- campuran pall 0.5 gram
                                //-- platinum 0.5 gram
                            }

                            echo 'Emas murni '.($kadar * $item->produksi_beratpria).' gram<br />';
                            echo $text.'<br />';
                            $tambahan_perak = ($item->produksi_beratpria - (($kadar * $item->produksi_beratpria) + $total_tambahan));
                            if ($tambahan_perak > 0 ){
                                echo 'Tambahan perak '.$tambahan_perak.' gram';
                            }
                        }elseif ($jenis == 'platidium'){
                            $pall_pt = $kadar * $item->produksi_beratpria / 2;
                            echo 'Palladium murni  : '.$pall_pt.' gram <br />';
                            echo 'Platinum murni  : '.$pall_pt.' gram <br />';
                            $tambahan_perak = $item->produksi_beratpria - ($kadar * $item->produksi_beratpria);
                            if ($tambahan_perak > 0){
                                echo 'Tamabahan perak '.$tambahan_perak.' gram';
                            }
                        }elseif ($jenis == 'silver'){
                    
                        }
                            
                    ?>
                    </td>
                    <td ><?php echo title_logam($item->bahanpria()->first(),'title');?> (kandungan <?php echo title_logam($item->bahanpria()->first(),'kadar');?>% murni <?php echo $item->bahanpria()->first()['jenis'];?>) <br /><?php echo aa('Berat maksimal ',$item->produksi_beratpria,'gr');?></td>
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
            <td>Bahan<br />
            <?php
                $jenis = $item->bahanwanita()->first()['jenis'];
                $kadar = title_logam($item->bahanwanita()->first(),'kadar') / 100;
                
                if ($jenis == 'emas' || $jenis == 'palladium' || $jenis == 'platinum'){
                    echo $item->bahanwanita()->first()['jenis'].' murni : '.$kadar * $item->produksi_beratwanita.' gram<br />';
                    echo 'Campuran perak '.($item->produksi_beratwanita - ($kadar * $item->produksi_beratwanita)).' gram';
                }elseif ($jenis == 'ep'){
                    if (title_logam($item->bahanwanita()->first(),'kadar') <= 50){
                        // campuran pall 0.5 gram
                        $campuran_palladium = 0.5;
                        $text = 'Palladium : 0.5gram';
                        $total_tambahan = 0.5;
                        
                    }elseif (title_logam($item->bahanwanita()->first(),'kadar') > 50 ){
                        $campuran_palladium = 0.5; 
                        $campuran_platinum = 0.5;
                        $text = 'Palladium : 0.5 gram<br />Platinum : 0.5gram';
                        $total_tambahan = 1;

                        //-- campuran pall 0.5 gram
                        //-- platinum 0.5 gram
                    }

                    echo 'Emas murni '.($kadar * $item->produksi_beratwanita).' gram<br />';
                    echo $text.'<br />';
                    $tambahan_perak = ($item->produksi_beratwanita - (($kadar * $item->produksi_beratwanita) + $total_tambahan));
                    if ($tambahan_perak > 0 ){
                        echo 'Tambahan perak '.$tambahan_perak.' gram';
                    }
                }elseif ($jenis == 'platidium'){
                    $pall_pt = $kadar * $item->produksi_beratwanita / 2;
                    echo 'Palladium murni  : '.$pall_pt.' gram <br />';
                    echo 'Platinum murni  : '.$pall_pt.' gram <br />';
                    $tambahan_perak = $item->produksi_beratwanita - ($kadar * $item->produksi_beratwanita);
                    if ($tambahan_perak > 0){
                        echo 'Tamabahan perak '.$tambahan_perak.' gram';
                    }
                }elseif ($jenis == 'silver'){
                    
                }
                            
             ?>
            </td>
            <td><?php echo title_logam($item->bahanwanita()->first(),'title');?> (kandungan <?php echo title_logam($item->bahanwanita()->first(),'kadar');?>% murni <?php echo $item->bahanwanita()->first()['jenis'];?>)<br /><?php echo aa('Berat maksimal ',$item->produksi_beratwanita,'gr');?></td>
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
            <td colspan="3" style="font-size:40px;font-weight:600">Keterangan<br /><?php echo $item->keterangan;?></td>
          </tr>
        </table>
        
  </div>
  
  </body>
</html>