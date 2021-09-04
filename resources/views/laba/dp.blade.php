@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Variasi Logam</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

      <div class="tile">
      <h2 class="display-4">Total DP <?php echo rupiah($total_dp);?></h2>
       <table class="table">
        <tr>
          <td>No order</td>
          <td>Nominal</td>
          <td>Created</td>
        </tr>
        <?php
          foreach ($dp as $item){
            ?>
            <tr>
              <td><a href="<?php echo route('pesanan.detail',['id'=>$item->pesanan_id]);?>"><?php echo $item->pesanan_id;?></a></td>
              <td><?php echo rupiah($item->nominal);?></td>
              <td><?php echo $item->created_at;?></td>
            </tr>
            <?php
          }
        ?>
       </table>
      </div>
    </main>
@include('layouts.footer')