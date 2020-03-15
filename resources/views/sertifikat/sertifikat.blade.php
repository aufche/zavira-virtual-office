@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Sertificate Page</h1>
          <p>This page contains all sertificate of materials</p>
        </div>
      </div>

    <div class="tile">
        <form action="<?php echo route('searchsertificate');?>" method="post">
          <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
          <input name="q" class="app-search__input form-control" type="text" placeholder="Cari pesanan berdasarkan no orderan" required>
          <button type="submit" class="app-search__button"><i class="fa fa-search"></i></button>
          </form>
      </div>

    <div class="tile">
    
      <?php echo $data->fragment('home')->links();?>
          <table class="table">
              <tr>
                  <td>No Order</td>
                  <td>Kode Cincin</td>
                  <td>Cincin Pria (I)</td>
                  <td>Cincin Wanita (II)</td>
                  <td>No Resi</td>
                  <td>Total</td>
                  <td>Cetak</td>
              </tr>
          <?php
          foreach ($data as $item){
              ?>
              <tr>
                  <td><a href="<?php route('pesanan.detail',['id'=>$item->id]);?>" target="popup" onclick="window.open('<?php echo route('pesanan.detail',['id'=>$item->id]);?>','popup','width=600,height=800'); return false;"><?php echo $item->id;?></a></td>
                  <td><?php echo $item->kodecincin;?></td>
                  <td><?php echo $item->bahanpria()->first()['title'];?> <span class="badge badge-dark"><?php echo aa('',$item->sertifikat_beratpria,'gr');?></span><br /><?php echo rupiah($item->sertifikat_beratpria*$item->sertifikat_hargapria);?></td>
                  <td><?php echo $item->bahanwanita()->first()['title'];?> <span class="badge badge-dark"><?php echo aa('',$item->sertifikat_beratwanita,'gr');?></span><br /><?php echo rupiah($item->sertifikat_beratwanita*$item->sertifikat_hargawanita);?></td>
                  <td><?php echo $item->resi;?></td>
                  <td><?php echo rupiah(($item->sertifikat_beratpria*$item->sertifikat_hargapria)+($item->sertifikat_beratwanita*$item->sertifikat_hargawanita)+$item->ongkos_bikin);?></td>
                  <td><a class="btn btn-info" href="<?php if ($item->ispremium == 1){
                                        echo route('sertifikat.single',['id'=>$item->id]);
                                      }elseif ($item->ispremium == 2){
                                        echo route('sertifikat.premium',['id'=>$item->id]);
                                      }elseif($item->ispremium == 0){ 
                                        echo route('sertifikat.silver',['id'=>$item->id]); 
                                      }
                                      ?>" target="_blank">Cetak</a></td>
              </tr>
              <?php
          }
          ?>
          </table>
          <?php echo $data->fragment('home')->links();?>
      

    </div>
    </main>
  
@include('layouts.footer');