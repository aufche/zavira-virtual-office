@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Orders</h1>
          <p>This page contains all orders</p>
        </div>
      </div>
      <?php


?>

        <div class="tile">
            <table class="table">
                <tr>
                    <td>Kelengkapan</td>
                    <td>Keterangan</td>
                    <td>Cetak</td>
                </tr>
            
              <?php
                foreach ($data as $item){
                    ?>
                    <tr>
                        <td><?php echo $item->kelengkapan;?></td>
                        <td><?php echo $item->keterangan;?></td>
                        <td><a href="<?php echo route('reparasi.cetak',['id'=>$item->id]);?>" class="btn btn-primary">Cetak</a></td>
                    </tr>
                    <?php
                }

              ?>
              </table>
        </div>
    </main>
  
@include('layouts.footer');