@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Zavira Jewelry Exclusive</h1>
          <p>Tambah paket penjualan zavira jewelry exclusive</p>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <?php echo $data->links();?>
        <table class="table">
            <tr>
                <td>Kode Paket</td>
                <td>Bahan Pria</td>
                <td>Bahan Wanita</td>
                <td>Status</td>
                <td>Harga</td>
                <td>Tindakan</td>
            </tr>
        <?php
           foreach ($data as $item){
               ?>
                <tr>
                    <td><?php echo $item->kode_paket;?></td>
                    <td><?php echo title_logam($item->bahanpria()->first(),'title');?><br /><?php echo aa('',$item->berat_pria,'gr');?></td>
                    <td><?php echo title_logam($item->bahanwanita()->first(),'title');?><br /><?php echo aa('',$item->berat_wanita,'gr');?></td>
                    <td><?php echo $item->status ?></td>
                    <td><?php echo rupiah($item->harga_paket);?></td>
                    <td><a href="{{route('ze.index',['action'=>'delete','id'=>$item->id])}}">Hapus</a> <a href="{{route('ze.index',['action'=>'edit','id'=>$item->id])}}">Edit</a></td>
                </tr>
               <?php
           }
        ?>
        </table>
        <?php echo $data->links();?>
      </div>
    </main>
@include('layouts.footer')
