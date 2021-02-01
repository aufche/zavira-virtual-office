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
          <h1>Cashflow</h1>
          <p>Aliran dana cash keluar masuk</p>
        </div>
      </div>

      
      <div class="container mb-5 mt-5">
            <form method="post" action="<?php echo route('pembukuan.detail');?>">
             <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
             <input type = "hidden" name = "id_buku" value = "<?php echo $id; ?>">

                <div class="form-row">
                    <div class="col-md-6 mb-3">
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

                    <div class="col-md-6 mb-3">
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

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-warning border-dark btn-lg btn-block">Submit</button>
                    </div>
                </div>
                
            </form>
        </div>


      <div class="jumbtron">
      <h2 class="font-weight-light h3"><?php echo $buku->title;?></h2>
      <p id="display" class="display-4"></p>
      </div>

      <div class="tile">
      <div class="float-left">
        <a class="btn btn-lg btn-outline-success mb-3" href="<?php echo route('pembukuan.add',['status'=>1]);?>" role="button">Dana Masuk</a> 
        <a class="btn btn-lg btn-outline-danger mb-3" href="<?php echo route('pembukuan.add',['status'=>0]);?>" role="button">Dana Keluar</a> 
        <a class="btn btn-lg btn-outline-info mb-3" href="<?php echo route('pembukuan.transfer');?>" role="button">Transfer</a> 
        
      </div>

      <div class="float-right">
      
      </div>

      <div class="float-none"></div>
      
      <table class="table table-bordered">
        <tr class="table-dark text-dark">
            <td>Action</td>
            <td>Tanggal</td>
            <td>Keterangan</td>
            <td>Masuk</td>
            <td>Keluar</td>
            <td>Saldo</td>
        </tr>
        <?php
            $saldo_bulan_sebelumnya = $buku->saldo;
            $saldo_sementara = null;
            foreach ($data as $item){
                ?>
                    <tr
                    <?php
                        if ($item->masuk != 0){
                            echo 'class="table-info"';    
                        } else{
                            echo 'class="table-warning"'; 
                        }
                        
                    ?>
                    >
                        <td>
                            <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?php echo route('pembukuan.edit',['id'=>$item->id]);?>">Edit</a>
                                <a class="dropdown-item" onclick="return confirm('Yakin akan menghapus data ini ?')" href="<?php echo route('pembukuan.hapus',['id'=>$item->id,'buku'=>$item->buku]);?>">Hapus</a>
                            </div>
                            </div></td>
                        <td><?php echo tanggal($item->tanggal);?></td>
                        <td><?php echo $item->keterangan;?><br /><small class="text-muted">PJ <?php echo $item->user->name;?></small></td>
                        <td><?php echo rupiah($item->masuk);?></td>
                        <td><?php echo rupiah($item->keluar);?></td>
                        <td><?php 
                            $saldo_sementara = $saldo_sementara + ($item->masuk - $item->keluar);

                            echo rupiah($saldo_sementara + $saldo_bulan_sebelumnya);?>
                        </td>
                    </tr>
                <?php
            }
        ?>
        <tr>
            <td class="text-right" colspan="5">Saldo</td>
            <td><span id="saldo"><?php echo rupiah($saldo_sementara + $saldo_bulan_sebelumnya);?></span></td>
        </tr>

        </table> 
      </div>
<script>
    document.getElementById('display').innerHTML = 'Saldo '+document.getElementById('saldo').innerHTML;
</script>
     
    </main>
@include('layouts.footer');