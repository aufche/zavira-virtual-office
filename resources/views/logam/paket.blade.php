@include('layouts.kalkulatorheader')
<style type="text/css">
.bgku{
  background-color:#EEE4D3;
}
</style>
<div class="container mt-3" style="width:600px;">
  <div class="row">
  <div class="col-md-12">
    <div class="fs-2 judul text-end">{{$title}}</div>
  <table class="table table-bordered border-warning border-dark">
 

  <tr class="bgku border-dark">
            <td>No.</td>
            <td>Cincin Pria</td>
            <td>Cincin wanita</td>
            <td>Harga</td>
        </tr>

  <?php
        //dd($data_paket);
        $n = 1;

        foreach ($x as $item){
        
            ?>
            <tr>
                <td><?php echo $n;?>.</td>
                <td><?php echo $item['logam_pria'];?></td>
                <td><?php echo $item['logam_wanita'];?></td>
                <td><?php echo rupiah($item['harga']);?></td>
            </tr>
            <?php
            $n++;
        }
  ?>
   <tr>
    <td colspan="4" style="background-color:#EEE4D3" class="text-center">Berat masing-masing cincin 4 gram</td>
  </tr>
    </table>
  </div>
  </div>
</div>
@include('layouts.kalkulatorfooter')



