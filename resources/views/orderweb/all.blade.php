@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Order from Webs</h1>
          <p>This page contains all order from web</p>
        </div>
      </div>

    <div class="tile">
        <form action="<?php echo route('order.search');?>" method="post">
          <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
          <input name="q" class="app-search__input form-control" type="text" placeholder="Cari pesanan berdasarkan no orderan" required>
          <button type="submit" class="app-search__button"><i class="fa fa-search"></i></button>
          </form>
      </div>


    <div class="tile">
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Nama Pemesan</td>
            <td>No HP</td>
            <td>Email</td>
            <td>Ukuran Pria</td>
            <td>Grafir Pria</td>
            <td>Ukuran Wanita</td>
            <td>Grafir Wanita</td>
            <td>Promo</td>
            <td>Order Link</td>
        </tr>
    <?php
    foreach ($data as $item){
        ?>
        <tr>
            <td><?php echo $item->id;?></td>
            <td><?php echo $item->nama;?><br /><?php echo $item->alamat;?><br />kecamatan <?php echo $item->kecamatan;?> <?php echo $item->kodepost;?></td>
            <td><a href="https://wa.me/<?php echo $item->nohp;?>/?text=Selamat+siang%2C+kami+dari+Zavira+Jewelry.+Pesanan+Anda+sudah+kami+terima%2C+sebentar+kami+hitungkan+dulu+total+belanjanya" target="_blank"><?php echo $item->nohp;?></a></td>
            <td><?php echo $item->email;?> <br />IG <?php echo $item->instagram;?></td>
            <td><?php echo $item->ukuranpria;?></td>
            <td><?php echo $item->grafirpria;?></td>
            <td><?php echo $item->ukuranwanita;?></td>
            <td><?php echo $item->grafirwanita;?></td>
            <td><?php echo $item->promo;?></td>
            <td><a href="<?php echo $item->link;?>" target="_blank">Link</a><br /><a href="<?php route('orderweb.detail',['id'=>$item->id]);?>" target="popup" onclick="window.open('<?php echo route('orderweb.detail',['id'=>$item->id]);?>','popup','width=600,height=800'); return false;">Detail</a><br /><a onclick="return confirm('Apakah kamu yakin akan menghapus data ini?')" href="<?php echo route('orderweb.hapus',['id'=>$item->id]);?>">Hapus</a></td>
        </tr>
        <?php
    }
    ?>
    </table>
    </div>
    </main>
  
@include('layouts.footer');