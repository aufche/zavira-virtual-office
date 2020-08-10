@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-thumbs-up"></i> Chart</h1>
          <p>Grafik pesanan</p>
        </div>
      </div>

      <div class="container mb-5 mt-5">
            <form method="post" action="<?php echo route('pesanan.chart');?>">
             <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Pilih Bulan</label>
                        <select class="form-control form-control-lg" name="bulan">
                            <option value="1" <?php if ($bulan == '1') echo 'selected="selected"';?>>Januari</option>
                            <option value="2" <?php if ($bulan == '2') echo 'selected="selected"';?>>Febuari</option>
                            <option value="3" <?php if ($bulan == '3') echo 'selected="selected"';?>>Maret</option>
                            <option value="4" <?php if ($bulan == '4') echo 'selected="selected"';?>>April</option>
                            <option value="5" <?php if ($bulan == '5') echo 'selected="selected"';?>>Mei</option>
                            <option value="6" <?php if ($bulan == '6') echo 'selected="selected"';?>>Juni</option>
                            <option value="7" <?php if ($bulan == '7') echo 'selected="selected"';?>>Juli</option>
                            <option value="8" <?php if ($bulan == '8') echo 'selected="selected"';?>>Agustus</option>
                            <option value="9" <?php if ($bulan == '9') echo 'selected="selected"';?>>September</option>
                            <option value="10" <?php if ($bulan == '10') echo 'selected="selected"';?>>Oktober</option>
                            <option value="11" <?php if ($bulan == '11') echo 'selected="selected"';?>>November</option>
                            <option value="12" <?php if ($bulan == '12') echo 'selected="selected"';?>>Desember</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <?php 
                            $tahun_awal = 2018;
                            $tahun_sekarang = date('Y');
                        ?>
                        <label>Pilih Tahun</label>
                        <select name="tahun" class="form-control form-control-lg">
                            <?php
                                for ($tahun_awal;$tahun_awal<=$tahun_sekarang;$tahun_awal++){
                                    ?>
                                         <option value="<?php echo $tahun_awal;?>" <?php if ($tahun_awal == $tahun) echo 'selected="selected"';?>><?php echo $tahun_awal;?></option>
                                    <?php
                                }   
                                ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-warning border-dark btn-lg btn-block">Submit</button>
                    </div>
                </div>
                
            </form>
        </div>
   
    <div class="tile">


    <div class="container">
    <?php
        $n = 0;
        foreach ($data as $item){
            ?>
            <div class="progress mb-4" style="height:75px;">
                
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning text-dark" role="progressbar" style="width: <?php echo ($item->views * 100);?>px" aria-valuenow="<?php echo $item->views;?>" aria-valuemin="0" aria-valuemax="100"><a href="<?php echo route('pesanan.bydate',['date'=>$item->date]);?>">Tanggal <?php echo date('d M Y', strtotime($item->date));?> = <?php echo $item->views;?> order</a></div>
          </div>
            <?php
            $n = $n + $item->views;
        }
    ?>
    Alhamdulillah, bulan ini ada total <?php echo $n; ?> orders
    </div>
    
    </div>
            
    </main>
  
@include('layouts.footer');