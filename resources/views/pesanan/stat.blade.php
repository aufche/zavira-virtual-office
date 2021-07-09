@include('layouts.header');
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

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-dashboard"></i> Gaji Karyawan</h1>
        </div>
      </div>


      
    <div class="tile">
    <form action="<?php echo route('pesanan.stat');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            
           

            <div class="col-md-4">
            <label for="validationDefault05">Customer Service</label>
            <select class="form-control form-control-lg" name="cs">
                <option value="0" <?php if ($cs_id == 0) echo 'selected="selected"';?>>Semua CS</option>
                <?php 
                    foreach ($cs as $name=>$id){
                        ?>
                        <option value="<?php echo $id;?>" <?php if ($cs_id == $id) echo 'selected="selected"';?>><?php echo $name;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4">
                 <label for="">Bulan</label>
                 <select class="form-control form-control-lg" name="bulan">
                    <option value="0" <?php if ($bulan == '0') echo 'selected="selected"';?>>Semua bulan</option>
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
                 <small id="helpId" class="form-text text-muted">Pilih bulan</small>
            </div>

            <div class="col-md-4">
                 <label for="">Tahun</label>
                 <?php
                 $tahun_sekarang = date('Y');
                     $tahun_awal = 2018;
                     ?>
                 <select class="form-control form-control-lg" name="tahun">
                    <?php
                     for ($tahun_awal;$tahun_awal<=$tahun_sekarang;$tahun_awal++){
                         ?>
                            <option value="<?php echo $tahun_awal;?>" <?php if ($tahun_awal == $tahun) echo 'selected="selected"';?>><?php echo $tahun_awal;?></option>
                         <?php
                         
                     }
                     ?>
                </select>
                 <small id="helpId" class="form-text text-muted">Pilih tahun</small>
            </div>

            <div class="col-md-12">
            <button type="submit" class="btn btn-warning btn-lg btn-block shadow border border-dark mt-3"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>
    
    </form>
    </div>

    <div class="tile">
        <?php
            if (!empty($stat)){
                echo '<div class="display-4">Total order '.$stat->count().'</div>';
                echo '<table class="table">';
                echo '<tr>
                    <td>No</td>
                    <td>No Order</td>
                    <td>Bahan Pria</td>
                    <td>Bahan Wanita</td>
                   <td>Tgl Masuk</td>
                    <td>Tgl Selesai</td>
                </tr>';
                $n = 1;
                foreach ($stat as $item){
                    ?>
                    <tr>
                        <td><?php echo $n;?></td>
                        <td><?php echo $item->id;?></td>
                        <td><?php echo title_logam($item->bahanpria()->first(),'title');?></td>
                        <td><?php echo title_logam($item->bahanwanita()->first(),'title');?></td>
                        <td><?php echo date('d M Y', strtotime($item->tglmasuk));?></td>
                        <td><?php echo date('d M Y', strtotime($item->tglselesai));?></td>
                    </tr>

                    <?php
                    $n++;
                }
                echo '</table>';
            }
        ?>
    </div>

   
    </main>
  
@include('layouts.footer');