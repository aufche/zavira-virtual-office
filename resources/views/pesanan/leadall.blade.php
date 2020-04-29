@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-thumbs-up"></i> Lead and Closing</h1>
          <p>Pencatatan Jumlah Lead dan Pesanan Tiap Hari</p>
        </div>
      </div>

    <?php
    if (isset($lead)){
        ?>
    <div class="container mb-5 mt-5">
        <form method="post" action="<?php echo route('pesanan.lead',['action'=>'detail']);?>">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            <div class="col-md-4">
                <label>Pilih CS</label>
                <select name="cs_id" class="form-control form-control-lg">
                <?php
                foreach ($cs as $name => $id){
                    ?>
                    <option value="<?php echo $id;?>" <?php if ($id == $cs_id) echo 'selected="selected"';?>><?php echo $name;?></option>
                    <?php
                }
                ?>
                    <option value="0">Semua CS</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                        <label>Pilih Bulan</label>
                        <select class="form-control form-control-lg" name="bulan">
                            <option value="1" <?php if ($currentMonth == '1') echo 'selected="selected"';?>>Januari</option>
                            <option value="2" <?php if ($currentMonth == '2') echo 'selected="selected"';?>>Febuari</option>
                            <option value="3" <?php if ($currentMonth == '3') echo 'selected="selected"';?>>Maret</option>
                            <option value="4" <?php if ($currentMonth == '4') echo 'selected="selected"';?>>April</option>
                            <option value="5" <?php if ($currentMonth == '5') echo 'selected="selected"';?>>Mei</option>
                            <option value="6" <?php if ($currentMonth == '6') echo 'selected="selected"';?>>Juni</option>
                            <option value="7" <?php if ($currentMonth == '7') echo 'selected="selected"';?>>Juli</option>
                            <option value="8" <?php if ($currentMonth == '8') echo 'selected="selected"';?>>Agustus</option>
                            <option value="9" <?php if ($currentMonth == '9') echo 'selected="selected"';?>>September</option>
                            <option value="10" <?php if ($currentMonth == '10') echo 'selected="selected"';?>>Oktober</option>
                            <option value="11" <?php if ($currentMonth == '11') echo 'selected="selected"';?>>November</option>
                            <option value="12" <?php if ($currentMonth == '12') echo 'selected="selected"';?>>Desember</option>
                        </select>
                    </div>

            <div class="col-md-2 mb-3">
                        <?php 
                            $tahun_awal = 2020;
                            $tahun_sekarang = date('Y');
                        ?>
                        <label>Pilih Tahun</label>
                        <select name="tahun" class="form-control form-control-lg">
                            <?php
                                for ($tahun_awal;$tahun_awal<=$tahun_sekarang;$tahun_awal++){
                                    ?>
                                         <option value="<?php echo $tahun_awal;?>" <?php if ($tahun_awal == $currentYear) echo 'selected="selected"';?>><?php echo $tahun_awal;?></option>
                                    <?php
                                }   
                                ?>
                        </select>
                    </div>

            <div class="col-md-2">
            <label>Tekan tombol dibawah</label>
                <button type="submit" class="btn btn-lg btn-block btn-warning border-dark">Cari</button>
            </div>
        </div>
        </form>
    </div>
    <div class="tile">
    
    <?php echo $lead->appends(Request::except('page'))->links();?>
    
    <div class="table-responsive">
    <?php 
        if (isset($sum_lead) && isset($sum_closing)){
            echo 'Jumlah chat '.$sum_lead;
            echo '<br />Jumlah Closing '.$sum_closing;
            echo '<br />';
            echo 'Persentase '.@($sum_closing/$sum_lead)*100;
            echo '%';
        }
    ?>
    <table class="table">
        <tr>
            <td>Tanggal Input</td>
            <td>Update terakhir</td>
            <td>CS</td>
            <td>Jumlah Chat</td>
            <td>Jumlah Closing</td>
            <td>Persentase</td>
            <td>Catatan</td>
            <td>Update</td>
        </tr>
    <?php
        $nchat = 0;
        $nclosing = 0;
        foreach($lead as $item){
            ?>
            <tr>
                <td><?php echo date('d M Y G:i', strtotime($item->created_at))?></td>
                <td><?php echo date('d M Y G:i', strtotime($item->updated_at))?></td>
                <td><?php echo $item->user->name;?></td>
                <td><?php echo $item->chat;?></td>
                <td><?php echo $item->closing;?></td>
                <td><?php if ($item->chat != 0){
                    echo @($item->closing/$item->chat)*100;
                }else{
                    echo '0';
                }
                    ?>%</td>
                <td><?php echo $item->catatan;?></td>
                <td><a href="<?php echo route('pesanan.lead',['id'=>$item->id,'action'=>'update']);?>">Update</a></td>
            </tr>
            <?php
            $nchat = $nchat+$item->chat;
            $nclosing = $nclosing+$item->closing;
        }
    ?>
        <tr>
            <td colspan="3"></td>
            <td><?php echo $nchat;?></td>
            <td><?php echo $nclosing;?></td>
            <td><?php echo @($nclosing/$nchat)*100;?>%</td>
            <td colspan="2">-</td>
        </tr>
    </table>
    </div>
    
    <?php echo $lead->appends(Request::except('page'))->links();?>
    </div>
            <?php
        }
    ?>
    </main>
  
@include('layouts.footer');