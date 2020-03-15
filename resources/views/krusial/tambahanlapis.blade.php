@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Finising Lapis Lagi</h1>
          <p>Pada halaman ini, kamu bisa menambah data transaksi cash</p>
        </div>
      </div>

      <div class="tile">
       <form method="post" action="<?php echo route('penting.insert',['tambahan'=>'lapis']);?>" autocomplete="off">
       <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
       <input type = "hidden" name = "pesanan_id" value = "<?php echo $data->id; ?>">

       <div class="card">
        <div class="card-header">Catatan Orderan/Finising No. order <?php echo $data->id;?></div>
            <div class="card-body">
            <h2 class="display-2">No Order <?php echo $data->id;?></h2>
            <table class="table table-bordered">
              <tr class="bg-dark text-white">
                <td>Nama</td>
                <td>Bahan Pria</td>
                <td>Bahan Wanita</td>
                <td>Pengrajin</td>
                <td>Status</td>
              </tr>
              <tr>
                <td><?php echo $data->nama;?></td>
                <td><?php echo $data->bahanpria()->first()['title'];?><br /><?php echo aa('Ukuran ',$data->ukuranpria);?><br /><?php echo aa('Grafir ',$data->grafirpria);?></td>
                <td><?php echo $data->bahanwanita()->first()['title'];?><br /><?php echo aa('Ukuran ',$data->ukuranwanita);?><br /><?php echo aa('Grafir ',$data->grafirwanita);?></td>
                <td><?php echo $data->pengrajin->nama;?></td>
                <td>
                <?php
                          if ($data->arsipkan == 1){
                            echo 'Data ini sudah dihapus';
                          }elseif ($data->siap_cetak == 1 && $data->finising == null && $data->kirim_ke_pengrajin == 0){
                            echo 'Order siap cetak';
                          }elseif ($data->siap_cetak == 1 && $data->finising == null && $data->kirim_ke_pengrajin == 1){
                            echo 'Order sedang dikerjakan oleh '.$data->pengrajin->nama.'';
                          }elseif ($data->siap_cetak == 1 && $data->finising == 3 && $data->kirim_ke_pengrajin == 1){
                            echo 'Pesanan sudah dikirim dengan no resi '.$data->resi.' dan sudah dilunasi';
                          }elseif ($data->siap_cetak == 1 && $data->finising == 1 && $data->kirim_ke_pengrajin == 1){
                            echo 'Sedang difinising/lapis';
                          }elseif ($data->siap_cetak == 1 && $data->finising == 2 && $data->kirim_ke_pengrajin == 1){
                            echo 'Orderan sudah di kantor';
                          }elseif ($data->siap_cetak == 0 && $data->finising == null && $data->kirim_ke_pengrajin == 0){
                            echo 'Order berhasil diinput ke database';
                          }elseif ($data->siap_cetak == 1 && $data->finising == 4 && $data->kirim_ke_pengrajin == 1){
                            echo 'Sedang proses reparasi';
                          }elseif ($data->siap_cetak == 1 && $data->finising == 5 && $data->kirim_ke_pengrajin == 1){
                            echo 'Barang masih di showroom, tapi SUDAH dilunasi';
                          }elseif ($data->siap_cetak == 1 && $data->finising == 6 && $data->kirim_ke_pengrajin == 1){
                            echo 'Barang sudah dikirim, tapi belum ada data pelunasan';
                          }
                        ?>
                </td>
              </tr>
            </table>
            <div class="form-row">
            <div class="col-md-2">
            <label for="catatan">Sudah berapa kali lapis? <?php echo $data->jumlah_lapis;?></label>
                <input type="number" name="jumlah_lapis" class="form-control form-control-lg mb-3" value="<?php echo $data->jumlah_lapis;?>" />
            
            <label>Cincin akan dikembalikan ke ?</label>
            <select name="tujuan" class="form-control form-control-lg">
              <option value="2">Tetap di showroom</option>
              <option value="">Pengrajin <?php echo $data->pengrajin->nama;?></option>
              <option value="1">Lapis Mas wahyudi</option>
            </select>
            </div>

            <div class="col-md-10">
            <label for="catatan">Catatan orderan</label>
              <textarea class="form-control form-control-lg" name="keterangan_orderan" rows="5"><?php echo $data->keterangan_orderan;?></textarea>
              <p class="form-text text-muted">Isikan keterangan kerusakan atau permasalahan yang berkaitan dengan orderan ini. Misal ngeropos, bahan tidak campur dsb.</p>
            </div>
            
            
            
            
            </div>

            <button type="submit" class="btn btn-lg btn-block btn-primary mt-4">Simpan</button>

            </div>
        </div>

       </form>
      </div>

     
    </main>
@include('layouts.footer');