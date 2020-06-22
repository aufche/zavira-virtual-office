<!doctype html>
<html lang="en">
  <head>
    <title>Hasil Perhitungan Biaya Produksi <?php echo $data[0]->identitas;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
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
    </style>

  </head>
  <body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
      
        <table class="table table-bordered">
        <tr class="table-active">
          <td colspan="5" class="text-right"><span class="bg-warning  text-dark"><?php echo $data[0]->identitas;?></span> Tanggal</td>
          <td><?php echo tanggal('now');?></td>
        </tr>
          <tr class="table-warning">
            <td>No Order</td>
            <td>EMAS</td>
            <td>PALLADIUM</td>
            <td>PLATINUM</td>
            <td>+PALLADIUM</td>
            <td>+PLATINUM</td>
          </tr>
        
        <?php
          $emas  = null;
          $palladium  = null;
          $platinum  = null;
          $tambahan  = null;
          $tambahan2  = null;

          $biaya_emas  = null;
          $biaya_palladium  = null;
          $biaya_platinum  = null;
          $biaya_tambahan  = null;
          $biaya_tambahan_2  = null;
          //dd($harga[0]);
          
          foreach ($harga as $h){
              if ($h['kunci']=='harga_harian_emas'){
                  $harga_pokok_harian_emas = $h['isi'];
              }elseif($h['kunci']=='harga_harian_palladium'){
                  $harga_pokok_harian_palladium = $h['isi'];
              }elseif($h['kunci']=='harga_harian_platinum'){
                  $harga_pokok_harian_platinum = $h['isi'];
              }
          }



          foreach ($data as $item){
            ?>
              <tr>
                <td><?php echo $item->pesanan_id;?> (<?php echo $item->pw;?>)</td>
                <td>
                <?php 
                if ($item->jenis == 'EMAS' || $item->jenis == 'EP'){
                  echo aa('',$item->berat,'gr');
                  $emas = $emas+$item->berat;
                  $biaya_emas = $biaya_emas+($item->berat*$item->harga_per_gram);
                }else{
                  echo '-';
                } 
                ?>
                </td>
                <td>
                <?php 
                if ($item->jenis == 'PALLADIUM'){
                  echo aa('',$item->berat,'gr');
                  $palladium = $palladium+$item->berat;
                  $biaya_palladium = $biaya_palladium+($item->berat*$item->harga_per_gram);
                }elseif($item->jenis == 'PLATIDIUM'){
                    echo aa('',$item->berat/2,'gr');
                    $palladium = $palladium + ($item->berat/2);
                    $biaya_palladium = $biaya_palladium+(($item->berat/2)*$harga_pokok_harian_palladium);
                }
                else{
                  echo '-';
                } 
                ?>
                </td>
                <td>
                <?php 
                if ($item->jenis == 'PLATINUM'){
                  echo aa('',$item->berat,'gr');
                  $platinum = $platinum+$item->berat;
                  $biaya_platinum = $biaya_platinum+($item->berat*$item->harga_per_gram);
                }elseif($item->jenis == 'PLATIDIUM'){
                    echo aa('',$item->berat/2,'gr');
                    $platinum = $platinum + ($item->berat/2);
                    $biaya_platinum = $biaya_platinum+(($item->berat/2)*$harga_pokok_harian_platinum);
                }else{
                  echo '-';
                } 
                ?>
                </td>
                <td>
                <?php 
                  if ($item->tambahan_berat != 0){
                    //-- palladium
                    echo aa('',$item->tambahan_berat,'gr');
                    $tambahan = $tambahan+$item->tambahan_berat;
                    $biaya_tambahan = $biaya_tambahan+($item->tambahan_berat*$item->harga_tambahan_berat);
                    

                  }
                ?></td>
                <td>
                <?php 
                  if ($item->tambahan_berat_2 != 0){
                    //-- platinum
                    echo aa('',$item->tambahan_berat_2,'gr');
                    $tambahan2 = $tambahan2+$item->tambahan_berat_2;
                    $biaya_tambahan_2 = $biaya_tambahan_2+($item->tambahan_berat_2*$item->harga_tambahan_berat_2);
                    echo $biaya_tambahan_2;
                  }
                ?></td>
              </tr>
            <?php
          }
        ?>
        <tr class="table-warning">
            <td>TOTAL</td>
            <td><?php echo aa('',$emas,'gr');?></td>
            <td><?php echo aa('',$palladium,'gr');?></td>
            <td><?php echo aa('',$platinum,'gr');?></td>
            <td><?php echo aa('',$tambahan,'gr');?></td>
            <td><?php echo aa('',$tambahan2,'gr');?></td>
        </tr>

        <tr class="table-warning">
            <td>Nominal</td>
            <td><?php echo rupiah($biaya_emas);?></td>
            <td><?php echo rupiah($biaya_palladium);?></td>
            <td><?php echo rupiah($biaya_platinum);?></td>
            <td><?php echo rupiah($biaya_tambahan);?></td>
            <td><?php echo rupiah($biaya_tambahan_2);?></td>
        </tr>

        <tr class="table-primary">
            <td>Harga @gram</td>
            <td><?php 
              if ($emas != 0 || $emas != null){
                echo rupiah($harga_pokok_harian_emas);
              }
            ?></td>
            <td><?php if ($palladium != 0 || $palladium != null){
              echo rupiah($harga_pokok_harian_palladium);
              }?>
            </td>
            <td><?php if ($platinum != 0 || $platinum !=null){
              echo rupiah($harga_pokok_harian_platinum);
            }?></td>
            <td>-</td>
            <td>-</td>
        </tr>

        <tr class="table-success">
            <td colspan="5" class="text-right">Total Biaya Logam</td>
            <td>
            
            <?php
              $grandtotal = $biaya_emas + $biaya_palladium + $biaya_platinum + $biaya_tambahan + $biaya_tambahan_2;
              echo rupiah($grandtotal);
            ?>
            
            </td>
        </tr>

        </table>
        <?php 
          if (!empty($data_pesanan)){
        ?>
        <table class="table table-bordered">
            <tr class="table-warning">
              <td>No Order</td>
              <td>DP</td>
              <td>Pelunasan</td>
              <td>Sub-total</td>
            </tr>

        <?php
          $totalsemua = null;
          foreach ($data_pesanan as $item){
            ?>
              <tr>
                <td><?php echo $item->id;?></td>
                <td><?php echo rupiah($item->dp);?></td>
                <td><?php echo rupiah($item->pelunasan);?></td>
                <td><?php echo rupiah(($item->dp+$item->pelunasan));?></td>
              </tr>
            <?php
            $totalsemua = $totalsemua + ($item->dp+$item->pelunasan);
          }
        ?>
        
          <tr>
            <td colspan="3" class="text-right">Total Harga jual</td>
            <td  class="text-right"><?php echo rupiah($totalsemua);?></td>
          </tr>
        
        </table>
        <?php 
          if ($totalsemua > $grandtotal ){
            echo 'Transaksi menguntungkan '.rupiah(($totalsemua - $grandtotal));
          }else{
            echo 'Transaksi merugikan';
          }
        }

        if (!empty($screenshot)){
            $bukti_transfer_arr = explode(',',$screenshot->bukti_transfer);                 
            foreach ($bukti_transfer_arr as $item2){
                ?>
                    <img src="<?php echo $item2;?>" class="img-fluid" />
                <?php 
            }
        }
        ?>
      </div>
    </div>
  </div>
  </body>
</html>

