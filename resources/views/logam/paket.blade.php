@include('layouts.kalkulatorheader')
<div class="container mt-3">
  <div class="row">
  <div class="col-md-12">
    <div class="fs-2 judul text-end">{{$title}}</div>
  <table class="table table-bordered border-warning border-dark">
 

  <tr class="bg-warning border-dark">
            <td>No.</td>
            <td>Cincin Pria</td>
            <td>Cincin wanita</td>
            <td>Harga</td>
        </tr>

  <?php
        //dd($data_paket);
        $n = 1;

        foreach ($pair as $item){
            

            $kode = explode('*',$item); //'pria*wanita',
            $pria = array_search($kode[0], array_column($data_paket, 'kode'));
            $wanita = array_search($kode[1], array_column($data_paket, 'kode'));

            //echo $data_paket[$pria]->title;
            //echo $data_paket[$wanita]->title;

            ?>
            <tr>
                <td><?php echo $n;?>.</td>
                <td><?php echo $data_paket[$pria]->title;?></td>
                <td><?php echo $data_paket[$wanita]->title;?></td>
                <td><?php 
                
                $male = $data_paket[$pria]->harga_final * 4 + $data_paket[$pria]->biaya_produksi;
                $female = $data_paket[$wanita]->harga_final * 4 + $data_paket[$wanita]->biaya_produksi;
            //    echo $data_paket[$wanita]->harga_final;


            echo rupiah($male+$female); ?></td>
            </tr>
            <?php
            $n++;
        }
  ?>
   <tr>
    <td colspan="4" class="text-center bg-warning berat fs-4">Berat masing-masing cincin 4 gram</td>
  </tr>
    </table>
  </div>
  </div>
</div>
@include('layouts.kalkulatorfooter')



