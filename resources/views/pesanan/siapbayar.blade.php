@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Orderan Yang Siap Dibayar ke Pengrajin</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

      <div class="tile">
      <form action="<?php echo route('pesanan.proseshitung');?>" method="post">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input type = "hidden" name = "identitas" value = "<?php echo 'TERBAYAR/'.strtoupper(date('d-M-Y').'-'.str_random(10));?>">
       <table class="table">
        <tr>
          <td>No order</td>
          <td>Nominal DP</td>
          <td>Berat Logam Pria (Produksi)</td>
          <td>Berat Logam Wanita (Produksi)</td>
        </tr>
        <?php
          foreach ($siap_bayar as $item){
            ?>
            <tr>
              <td><div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="ids[]" value="<?php echo $item->id;?>">
                <a href="<?php echo route('pesanan.detail',['id'=>$item->id]);?>"><?php echo $item->id;?></a>
              </label>
            </div></td>
              <td><?php echo $item->dp;?></td>
              <td><?php echo $item->produksi_beratpria;?></td>
              <td><?php echo $item->produksi_beratwanita;?></td>
            </tr>
            <?php
          }
        ?>
       </table>

       <button type="submit" class="btn btn-primary">Bayar</button>
       </form>
      </div>
    </main>
@include('layouts.footer');