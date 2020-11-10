@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Buyback Cincin</h1>
          
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
     <table class="table">
        <tr>
            <td>PJ</td>
            <td>No Order</td>
            <td>Nominal</td>
            <td>Berat</td>
            <td>Jenis Logam</td>
            <td>Status</td>
            <td>Buy Date</td>
        </tr>
        <?php 
            foreach ($data as $item){
                ?>
                <tr>
                    <td><?php echo $item->user->name;?></td>
                    <td><?php echo $item->pesanan_id;?></td>
                    <td><?php echo rupiah($item->nominal);?></td>
                    <td><?php echo $item->berat;?>gr</td>
                    <td><?php echo $item->namalogam->title;?></td>
                    <td><?php if ($item->status == 1) echo 'Belum Dilebur'; else echo 'Belum Dilebur'; ?></td>
                    <td><?php echo date('d M Y', strtotime($item->created_at));?></td>
                </tr>
                <?php
            }
        ?>
     </table>
     <?php echo $data->links();?>
      </div>
    </main>
@include('layouts.footer');