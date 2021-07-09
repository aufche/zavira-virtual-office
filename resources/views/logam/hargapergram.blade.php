@include('layouts.kalkulatorheader')
<div class="container mt-3">
  <div class="row">
  <div class="col-md-12">
  
    <ul class="list-group list-group-flush" id="emas">
    <li class="list-group-item active" aria-current="true">Emas</li>
    <?php
        foreach ($emas as $e){
            echo '<li class="list-group-item">'.$e->title.' @gram '.rupiah($e->harga_final).'</li>';
        }
    ?>
    </ul>
    <a role="button" id="terkopi" class="mt-1 btn btn-success btn-sm  animate__animated animate__bounceIn animate__delay-1s" href="#" onclick="CopyToClipboard('emas');return false;">Salin harga emas</a>
  </div>

  <div class="col-md-12 mt-3">
  
    <ul class="list-group list-group-flush" id="palladium">
    <li class="list-group-item active" aria-current="true">Palladium</li>
    <?php
        foreach ($palladium as $e){
            echo '<li class="list-group-item">'.$e->title.' @gram '.rupiah($e->harga_final).'</li>';
        }
    ?>
    </ul>
    <a role="button" id="terkopi2" class="mt-1 btn btn-success btn-sm  animate__animated animate__bounceIn animate__delay-2s" href="#" onclick="CopyToClipboard('palladium','terkopi2');return false;">Salin harga palladium</a>
  </div>

  <div class="col-md-12 mt-3">
  
    <ul class="list-group list-group-flush" id="platinum">
    <li class="list-group-item active" aria-current="true">Platinum</li>
    <?php
        foreach ($platinum as $e){
            echo '<li class="list-group-item">'.$e->title.' @gram '.rupiah($e->harga_final).'</li>';
        }
    ?>
    </ul>

    <a role="button" id="terkopi3" class="mt-1 btn btn-success btn-sm  animate__animated animate__bounceIn animate__delay-3s" href="#" onclick="CopyToClipboard('platinum','terkopi3');return false;">Salin harga platinum</a>
  </div>
  <div class="col-md-12 mt-3">
  
    <ul class="list-group list-group-flush" id="ep">
    <li class="list-group-item active" aria-current="true">Emas Putih Premium (Au+Pd)</li>
    <?php
        foreach ($ep as $e){
            echo '<li class="list-group-item">'.$e->title.' @gram '.rupiah($e->harga_final).'</li>';
        }
    ?>
    </ul>

    <a role="button" id="terkopi3" class="mt-1 mb-3 btn btn-success btn-sm  animate__animated animate__bounceIn animate__delay-3s" href="#" onclick="CopyToClipboard('ep','terkopi3');return false;">Salin harga Emas Putih Premium</a>
  </div>

  </div>
</div>
@include('layouts.kalkulatorfooter')
