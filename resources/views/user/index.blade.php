@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Pengguna Sistem</h1>
          <p>Pada halaman ini kamu melihat seluruh pengguna sistem</p>
        </div>
      </div>

      <div class="tile">
      
     
        <table class="table table-hover">
            <tr>
                <td>Nama</td>
                <td>Nama CS</td>
                <td>Email</td>
                <td>WA</td>
                <td>Gaji Pokok</td>
                <td>Tunjangan</td>
                <td>Uang Makan</td>
                <td>Jumlah Lead</td>
                <td>Prioritas</td>
            </tr>
            <?php
                foreach ($users as $item){
                    ?>
                    <tr>
                        <td><?php echo $item->name;?></td>
                        <td><?php echo $item->nama_cs;?></td>
                        <td><?php echo $item->email;?></td>
                        <td><?php echo $item->wa;?></td>
                        <td><?php echo $item->gaji_pokok;?></td>
                        <td><?php echo $item->tunjangan;?></td>
                        <td><?php echo $item->uang_makan;?></td>
                        <td><?php echo $item->lead;?></td>
                        <td><?php echo $item->prioritas;?></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        
      </div>

 
    </main>

@include('layouts.footer');