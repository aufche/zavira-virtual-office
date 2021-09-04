@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Orders</h1>
          <p>This page contains all orders</p>
          <p id="man"></p>
        </div>
      </div>

      <div class="tile">
        <form action="<?php echo route('search');?>" method="post">
          <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
          <input name="q" class="app-search__input form-control" type="text" placeholder="Cari pesanan berdasarkan no orderan atau alamat atau nama">
          <button type="submit" class="app-search__button"><i class="fa fa-search"></i></button>
          </form>
      </div>

      <div class="tile">

    <form action="<?php echo route('pesanan.sedekah');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            
            <div class="col-md-6">
               
                 <label for="">Dari Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_awal" id="date" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-6">
                 <label for="">Sampai Tanggal</label>
                 <input type="text" class="form-control form-control-lg" name="tanggal_akhir" id="date2" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            
            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>
            </div>
        </div>
    
    </form>

    <?php
        if (!empty($data_pesanan)){
            ?>
            <table class="table mt-4">
                <tr>
                    <th>DP</th>
                    <th>Pelunasan</th>
                    <th>Ongkir</th>
                    <th>Modal Lapis</th>
                    <th>Modal Pengrajin</th>
                    <th>Biaya Produksi Pria</th>
                    <th>Biaya Produksi Wanita</th>
                </tr>
            <?php
            foreach ($data_pesanan as $item){
                ?>
                    <tr>
                        <td><?php echo rupiah($item->dp);?></td>
                        <td><?php echo rupiah($item->pelunasan);?></td>
                        <td><?php echo rupiah($item->ongkir);?></td>
                        <td><?php echo rupiah(($item->modal_lapis+$item->ongkir));?></td>
                        <td><?php echo rupiah($item->modal_pengrajin);?></td>
                        <td><?php echo rupiah($item->produksi_beratpria*$item->produksi_hargapria);?></td>
                        <td><?php echo rupiah($item->produksi_beratwanita*$item->produksi_hargawanita);?></td>
                    </tr>
                    
                <?php
            }
            echo '</table>';
        }
    ?>
                    
    </div>
    </main>
@include('layouts.footer')
