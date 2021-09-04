@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Order from Webs</h1>
          <p>This page contains all order from web</p>
        </div>
      </div>

   <div class="container">
  <form action="<?php echo route('order.search');?>" method="post">
    <div class="input-group mb-3 shadow m-4">
    
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input type="text" class="form-control form-control-lg" placeholder="Cari pesanan berdasarkan no orderan" name="q" required>
      <div class="input-group-append">
        <button class="btn btn-warning btn-lg" type="button" id="button-addon2">Cari</button>
      </div>
      
    </div>
</form>
      
</div>

    <div class="tile">
    <?php echo $data->links();?>
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Nama Pemesan</td>
            <td>No HP</td>
            <td>Tanggal Input</td>
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
            <td><?php echo date('d M Y', strtotime($item->created_at));?></td>
            <td><?php echo $item->ukuranpria;?></td>
            <td><?php echo $item->grafirpria;?></td>
            <td><?php echo $item->ukuranwanita;?></td>
            <td><?php echo $item->grafirwanita;?></td>
            <td><?php echo $item->promo;?></td>
            <td><div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-warning btn-lg shadow dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Action
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
    <a href="<?php echo $item->link;?>" target="_blank" class="dropdown-item">Link</a>
    <a class="dropdown-item" href="<?php route('orderweb.detail',['id'=>$item->id]);?>" target="popup" onclick="window.open('<?php echo route('orderweb.detail',['id'=>$item->id]);?>','popup','width=600,height=800'); return false;">Detail</a>
    <a class="dropdown-item" onclick="return confirm('Apakah kamu yakin akan menghapus data ini?')" href="<?php echo route('orderweb.hapus',['id'=>$item->id]);?>">Hapus</a>
    </div>
  </div></td>        </tr>
        <?php
    }
    ?>
    </table>
    <?php echo $data->links();?>
    </div>
    </main>
  
@include('layouts.footer')