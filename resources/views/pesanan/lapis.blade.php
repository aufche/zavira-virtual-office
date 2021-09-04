@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-thumbs-up"></i> Catatan Lapis Berulang</h1>
          <p>Pencatatan lapis berulang</p>
        </div>
      </div>
   
    <div class="tile">

    <?php echo $data->links();?>
    <table class="table">
        <tr>
            <td>No</td>
            <td>Tanggal Input</td>
            <td>Order ID</td>
            <td>Nominal</td>
        </tr>
    <?php
        $nchat = 0;
        $nclosing = 0;
        foreach($data as $item){
            ?>
            <tr>
                <td><?php echo $item->id;?></td>
                <td><?php echo date('d M Y G:i', strtotime($item->created_at))?></td>
                <td><?php echo $item->pesanan_id;?></td>
                <td><?php echo rupiah($item->nominal);?></td>
            </tr>
            <?php      
        }
    ?>
    </table>
    <?php echo $data->links();?>
    </div>
            
    </main>
  
@include('layouts.footer')