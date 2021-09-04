@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Export Data</h1>
        </div>
      </div>
    <div class="tile">
    <table class="table">
        <tr>
            <td>No</td>
            <td>No. Order</td>
            <td>Nama</td>
            <td>No. HP</td>
            <td>No Undian</td>
        </tr>
        <?php
        $n = 1;
            foreach ($data as $item){
                ?>
                    <tr>
                        <td><?php echo $n;?></td>
                        <td><?php echo $item->id;?></td>
                        <td><?php echo $item->nama;?></td>
                        <td><?php echo $item->nohp;?></td>
                        <td><?php echo $item->undian;?></td>
                    </tr>
                <?php
                $n++;
            }
        ?>
        </table>
    </div>
    </main>
  
@include('layouts.footer')