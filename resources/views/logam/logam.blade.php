@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Variasi Logam</h1>
          <p>Variation of materials</p>
        </div>
      </div>

      <div class="tile">
        <a name="addvariasilogam" id="addvariasilogam" class="btn btn-success" href="<?php echo route('logam.add');?>" role="button">Tambah Variasi Logam</a>    
      </div>
    <div class="tile">
    @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    <table class="table table-hover">
        <tr>
            <td>ID</td>
            <td>Kode Logam</td>
            <td>Title</td>
            <td>Jenis</td>
            <td>Kadar</td>
            <td>Harga Pokok</td>
            <td>Markup</td>
            <td>Harga Jual</td>
            <td>Opsi</td>
        </tr>
    <?php
    foreach ($data as $item){
        if ($item->jenis == 'emas' || $item->jenis=='ep'){
            $hp = $harga_pokok[0]->isi;
        }elseif ($item->jenis == 'palladium'){
            $hp = $harga_pokok[1]->isi;
        }elseif($item->jenis=='platinum'){
            $hp = $harga_pokok[2]->isi;
        }elseif ($item->jenis == 'silver'){
            $hp = 0;
        }elseif ($item->jenis == 'platidium'){
            $hp = ($harga_pokok[1]->isi + $harga_pokok[2]->isi) / 2;
        }
        ?>
        <tr>
            <td><?php echo $item->id;?></td>
            <td><?php echo $item->kode;?></td>
            <td><?php echo $item->title;?></td>
            <td><?php echo $item->jenis;?></td>
            <td><?php echo $item->kadar;?> %</td>
            <td><?php echo rupiah(($item->kadar/100) * $hp);?></td>
            <td><?php echo rupiah($item->markup);?></td>
            <td><?php echo rupiah(($item->kadar/100) * $hp + $item->markup);?></td>
            <td><a class="btn btn-info" href="<?php echo route('logam.edit',['id'=>$item->id]);?>">Edit</a> <a class="btn btn-danger" href="<?php echo route('logam.del',['id'=>$item->id]);?>">Hapus</a></td>
        </tr>
        <?php
    }
    ?>
    </table>
    </div>
    </main>
  
@include('layouts.footer');