@include('layouts.kalkulatorheader')

  <form method="post" action="<?php echo route('kalkulator.backend');?>">
  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
  <div class="container mt-3">
    <div class="col-12">
    <div class="row g-2">
        <div class="col-md-6 col-xs-2">
            <div class="form-floating">
            <input type="number" step="0.1" name="berat_pria" class="form-control" id="floatingInputGrid" placeholder="4" <?php if (isset($kalkulasi)){ echo 'value='.$kalkulasi['berat_pria'].'';} else {echo 'value="4"';  }  ?>>
            <label for="floatingInputGrid">Berat Cincin Pria</label>
            </div>
        </div>
        <div class="col-md-6 col-xs-2">
            <div class="form-floating">
            <select class="form-select" name="pria" id="floatingSelectGrid" aria-label="Floating label select example">
            <!-- <option value="0" selected="selected">Pilih</option> -->
            <?php 
                foreach ($logam as $item){
                    ?>
                    <option <?php if (isset($kalkulasi)){ if ($kalkulasi['id_pria'] == $item->id) echo 'selected';}  ?> value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
                    <?php
                }
                ?>
            </select>
            <label for="floatingSelectGrid">Pilih logam cincin pria</label>
            </div>
        </div>
        </div>
    </div>

    <div class="col-12 mt-3">
    <div class="row g-2">
        <div class="col-md-6 col-xs-2">
            <div class="form-floating">
            <input type="number" step="0.1" class="form-control" name="berat_wanita" id="floatingInputGrid" placeholder="4" <?php if (isset($kalkulasi)){ echo 'value='.$kalkulasi['berat_wanita'].'';} else {echo 'value="4"';  }  ?>>
            <label for="floatingInputGrid">Berat cincin wanita</label>
            </div>
        </div>
        <div class="col-md-6 col-xs-2">
            <div class="form-floating">
            <select class="form-select" name="wanita" id="floatingSelectGrid" aria-label="Floating label select example">
                <!--<option value="0" selected="selected">Pilih</option> -->
            <?php 
                foreach ($logam as $item){
                    ?>
                    <option <?php if (isset($kalkulasi)){ if ($kalkulasi['id_wanita'] == $item->id) echo 'selected';}  ?> value="<?php echo $item->id;?>"><?php echo $item->title;?></option>
                    <?php
                }
                ?>
            </select>
            <label for="floatingSelectGrid">Pilih logam cincin wanita</label>
            </div>
        </div>
        <div class="form-check">
  <input class="form-check-input" type="checkbox" value="on" name="detail" <?php if (isset($kalkulasi)){
      if ($kalkulasi['detail'] == 1)
      echo 'checked';
  } 
  ?>>
  <label class="form-check-label" for="flexCheckDefault">
    Centang jika ingin menampilkan detail harga
  </label>
</div>
        
        </div>
        
        <div class="d-grid gap-2">
        
        <input class="btn btn-primary btn-lg mt-3 btn-block" type="submit" value="Hitung">
        </div>
    </div>
            <?php
            

                if (isset($kalkulasi)){

                    //dd($kalkulasi);

                    if ($kalkulasi['detail'] == 0){
                        echo '<div class="alert alert-info mt-1 shadow animate__animated animate__bounce" role="alert" id="sample">';
                        if (isset($kalkulasi['berat_pria'])){
                            echo 'Cincin pria '.$kalkulasi['logam_pria'].' berat &plusmn;'.$kalkulasi['berat_pria'].'gr<br />';
                        }
                        
                        if (isset($kalkulasi['berat_wanita'])){
                            echo 'Cincin wanita '.$kalkulasi['logam_wanita'].' berat &plusmn;'.$kalkulasi['berat_wanita'].'gr<br />';
                        }
                        
                        echo 'Total biaya '.rupiah($kalkulasi['total']).'<br /><br />';
                        echo 'Pembayaran DP minimal '.rupiah($kalkulasi['dp']);
                        echo '</div>';
                    }elseif ($kalkulasi['detail'] == 1){
                        echo '<div class="alert alert-info mt-1 shadow animate__animated animate__bounce small" role="alert" id="sample">';
                        if ($kalkulasi['berat_pria'] != null && $kalkulasi['jenis_pria'] != 'silver'){
                            echo 'Cincin pria '.$kalkulasi['logam_pria'].' berat &plusmn;'.$kalkulasi['berat_pria'].'gr<br /> ('.$kalkulasi['berat_pria'].'gr x '.rupiah($kalkulasi['harga_pria_pergram']).' + '.rupiah($kalkulasi['biaya_produksi_pria']).' = '.rupiah($kalkulasi['harga_pria']).')<br />';
                            echo 'Biaya produksi cincin pria '.rupiah($kalkulasi['biaya_produksi_pria']).'<br /><br />';
                        }elseif ($kalkulasi['berat_pria'] != null && $kalkulasi['jenis_pria'] == 'silver'){
                            echo 'Cincin pria '.$kalkulasi['logam_pria'].' berat &plusmn;'.$kalkulasi['berat_pria'].'gr harga '.rupiah($kalkulasi['harga_pria']).'<br /><br />';
                        }
                        
                        if ($kalkulasi['berat_wanita'] != null && $kalkulasi['jenis_wanita'] != 'silver'){
                            echo 'Cincin wanita '.$kalkulasi['logam_wanita'].' berat &plusmn;'.$kalkulasi['berat_wanita'].'gr<br />('.$kalkulasi['berat_wanita'].'gr x '.rupiah($kalkulasi['harga_wanita_pergram']).' + '.rupiah($kalkulasi['biaya_produksi_wanita']).' = '.rupiah($kalkulasi['harga_wanita']).')<br />';
                            echo 'Biaya produksi cincin wanita '.rupiah($kalkulasi['biaya_produksi_wanita']).'<br /><br />';
                        }elseif ($kalkulasi['berat_wanita'] != null && $kalkulasi['jenis_wanita'] == 'silver'){
                            echo 'Cincin wanita '.$kalkulasi['logam_wanita'].' berat &plusmn;'.$kalkulasi['berat_wanita'].'gr harga '.rupiah($kalkulasi['harga_wanita']).'<br /><br />';
                        }
                        
                        if ($kalkulasi['berat_pria'] != null || $kalkulasi['berat_wanita'] != null ){
                            //echo 'Biaya Produksi '.rupiah($kalkulasi['ongkos_bikin']).'<br />';
                            echo 'Total biaya '.rupiah($kalkulasi['total']).'<br /><br />';
                            echo 'Pembayaran DP minimal '.rupiah($kalkulasi['dp']);
                        }else{
                            
                        }
                        echo '</div>';

                        ?>
                        <a role="button" id="terkopi" class="mt-1 mb-3 btn btn-info btn-sm  animate__animated animate__fadeInUp animate__delay-1s" href="#" onclick="CopyToClipboard('sample');return false;">Salin harga detail</a>
                        <?php


                        echo '<div class="alert alert-success mt-1 shadow animate__animated animate__bounce small" role="alert" id="sample2">';
                        if ($kalkulasi['berat_pria'] != null && $kalkulasi['jenis_pria'] != 'silver'){
                            echo 'Cincin pria '.$kalkulasi['logam_pria'].'  &plusmn;'.$kalkulasi['berat_pria'].'gr<br />';
                        }elseif ($kalkulasi['berat_pria'] != null && $kalkulasi['jenis_pria'] == 'silver'){
                            echo 'Cincin pria '.$kalkulasi['logam_pria'].'  &plusmn;'.$kalkulasi['berat_pria'].'gr harga '.rupiah($kalkulasi['harga_pria']).'<br /><br />';
                        }
                        
                        if ($kalkulasi['berat_wanita'] != null && $kalkulasi['jenis_wanita'] != 'silver'){
                            echo 'Cincin wanita '.$kalkulasi['logam_wanita'].'  &plusmn;'.$kalkulasi['berat_wanita'].'gr<br />';
                        }elseif ($kalkulasi['berat_wanita'] != null && $kalkulasi['jenis_wanita'] == 'silver'){
                            echo 'Cincin wanita '.$kalkulasi['logam_wanita'].'  &plusmn;'.$kalkulasi['berat_wanita'].'gr harga '.rupiah($kalkulasi['harga_wanita']).'<br /><br />';
                        }
                        
                        if ($kalkulasi['berat_pria'] != null || $kalkulasi['berat_wanita'] != null ){
                            //echo 'Biaya Produksi '.rupiah($kalkulasi['ongkos_bikin']).'<br />';
                            echo 'Total biaya '.rupiah($kalkulasi['total']).'<br /><br />';
                            echo 'Pembayaran DP minimal '.rupiah($kalkulasi['dp']);
                        }else{
                            
                        }
                        echo '</div>';
                    }
                    
                    ?>
                    <a role="button" id="terkopi" class="mt-1 mb-3 btn btn-success btn-sm  animate__animated animate__fadeInUp animate__delay-1s" href="#" onclick="CopyToClipboard('sample');return false;">Salin harga paket</a>
                    <?php
                    
                }
            ?>
  </div>
  </form>
  @include('layouts.kalkulatorfooter')