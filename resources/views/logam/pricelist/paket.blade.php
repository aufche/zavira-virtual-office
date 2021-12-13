@include('layouts.kalkulatorheader')
<style type="text/css">
.bgku{
  background-color:#EEE4D3;
}
</style>
<div class="container mt-3" style="width:900px;">
  <div class="row">
  <div class="col-md-12">
    <div class="fs-2 judul text-end"></div>
  <table class="table table-bordered border-warning border-dark">
 
<tr>
<td colspan="5" style="background-color:#EEE4D3">Paket Cincin Kawin Zavira Jewelry</td>
</tr>
  <tr class="bgku border-dark">
            <td>No.</td>
            <td>Nama Paket</td>
            <td>Cincin Pria</td>
            <td>Cincin wanita</td>
            <td>Harga</td>
        </tr>

  <?php
        //dd($data_paket);
        $n = 1;

        foreach ($paket as $item){
        
            ?>
            <tr>
                <td><?php echo $n;?>.</td>
                <td><?php echo $item->kode_paket;?></td>
                <td><?php echo $item->pria;?> (± {{$item->berat_pria}}gr )</td>
                <td><?php echo $item->wanita;?> (± {{$item->berat_wanita}}gr )</td>
                <td><?php echo rupiah($item->harga_paket);?></td>
            </tr>
            <?php
            $n++;
        }
  ?>
        <tr>
            <td colspan="5" style="background-color:#EEE4D3">
                Paket sudah termasuk 
                <ol>
                    <li>Free ukir nama pasangan</li>
                    <li>Exclusive ring box</li>
                    <li>Free ongkir se-Indonesia via JNE</li>
                    <li>Free undangan digital</li>
                    <li>Free asuransi senilai Rp 20jt</li>
                    <li>Garansi seumur hidup</li>
                    <li>Garansi free re-plating (finising ulang) 1x</li>
                </ol>
            </td>
        </tr>
    </table>
  </div>
  </div>
  <h3>Text promo untuk whatsApp</h3>
  <a  class="btn btn-danger" id="terkopi" onClick="CopyToClipboard('promo_wa')">Salin</a>
  <div id="promo_wa">

  
  Paket cincin kawin dari Zavira Jewelry<br />
  @foreach ($paket as $item)
  *{{$item->kode_paket}}*<br />
  Cincin Pria {{html_entity_decode($item->pria)}} ±{{$item->berat_pria}}gr<br />
  Cincin Wanita {{html_entity_decode($item->wanita)}} ±{{$item->berat_wanita}}gr<br />
  ~{{rupiah($item->harga_paket + ((rand(1,10)/100) * $item->harga_paket))}}~  {{rupiah($item->harga_paket)}}<br /><br />
  @endforeach
  </div>
  
</div>
@include('layouts.kalkulatorfooter')



