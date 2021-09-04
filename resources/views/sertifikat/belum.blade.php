@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Sertificate Page</h1>
          <p>Halaman ini berisi pesanan yang belum dibuat sertifikatnya</p>
        </div>
      </div>

<div class="tile">
      
<?php echo $data_belum->links();?>
          <table class="table">
              <tr>
                  <td>No Order</td>
                  <td>Kode Cincin</td>
                  <td>Cincin Pria (I)</td>
                  <td>Cincin Wanita (II)</td>
                  <td>No Resi</td>
              </tr>
          <?php
          //-- belum dibuat sertifikatnya
          foreach ($data_belum as $item){
              ?>
              <tr>
              <td><a href="<?php route('pesanan.detail',['id'=>$item->id]);?>" target="popup" onclick="window.open('<?php echo route('pesanan.detail',['id'=>$item->id]);?>','popup','width=600,height=800'); return false;"><?php echo $item->id;?></a></td>
                  <td><?php echo $item->kodecincin;?></td>
                  <td><?php echo title_logam($item->bahanpria()->first(),'title');?> </td>
                  <td><?php echo title_logam($item->bahanwanita()->first(),'title');?> </td>
                  <td><?php echo $item->resi;?></td>
              </tr>
              <?php
          }
          ?>
          </table>
          <?php echo $data_belum->links();?>
      
      </div>
   
    </main>
  
@include('layouts.footer')