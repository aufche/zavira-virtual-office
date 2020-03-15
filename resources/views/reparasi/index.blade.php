@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Reparasi</h1>
          <p>This page contains all repair</p>
        </div>
      </div>
      <?php


?>

        <div class="tile">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <?php echo $data->links();?>
            <table class="table">
                <tr>
                    <td>No. Reparasi</td>
                    <td>No. Order</td>
                    <td>Kelengkapan</td>
                    <td>Keterangan</td>
                    <td>Options</td>
                </tr>
            
              <?php
                foreach ($data as $item){
                    ?>
                    <tr>
                        <td><?php echo $item->id;?></td>
                        <td><a href="<?php route('pesanan.detail',['id'=>$item->pesanan_id]);?>" target="popup" onclick="window.open('<?php echo route('pesanan.detail',['id'=>$item->pesanan_id]);?>','popup','width=600,height=800'); return false;"><?php echo $item->pesanan_id;?></a></td>
                        <td><?php echo $item->kelengkapan;?></td>
                        <td><?php echo $item->keterangan;?></td>
                        <td><a href="<?php echo route('reparasi.delete',['id'=>$item->id]);?>" class="btn btn-danger">Delete</a> <a href="<?php echo route('reparasi.cetak',['id'=>$item->id]);?>" target="_blank" class="btn btn-primary">Cetak</a></td>
                    </tr>
                    <?php
                }

              ?>
              </table>
              <?php echo $data->links();?>
        </div>
    </main>
  
@include('layouts.footer');