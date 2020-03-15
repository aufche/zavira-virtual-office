@include('layouts.header');
<style type="text/css">
    table.table-bordered{
    border:1px solid #000;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid #000;
}
table.table-bordered > tbody > tr > td{
    border:1px solid #000;
}
    </style>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Pesanan</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

      <div class="tile">
      <h2 class="font-weight-light h3 text-uppercase"><?php echo $buku->title;?></h2>
      <p id="display"></p>
      </div>

      <div class="tile">
      <div class="float-left">
        <a class="btn btn-lg btn-outline-success mb-3" href="<?php echo route('pembukuan.add',['status'=>1]);?>" role="button">Dana Masuk</a> 
        <a class="btn btn-lg btn-outline-danger mb-3" href="<?php echo route('pembukuan.add',['status'=>0]);?>" role="button">Dana Keluar</a> 
        <a class="btn btn-lg btn-outline-info mb-3" href="<?php echo route('pembukuan.transfer');?>" role="button">Transfer</a> 
      </div>

      <div class="float-right">
      <div class="dropdown">
        <button class="btn btn-success btn-lg dropdown-toggle mb-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pilih Bulan</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php 
                foreach ($old as $bulan){
                    ?>
                    <a class="dropdown-item" href="<?php echo route('pembukuan.detail',['id'=>$buku->id,'bulan'=>$bulan->bulantahun]);?>"><?php echo $bulan->bulantahun;?></a>
                    <?php
                }
            ?>
        </div>
        </div>
      </div>

      <div class="float-none"></div>
      
      <table class="table table-bordered">
        <tr class="table-dark text-dark">
            <td>Action</td>
            <td>Tanggal</td>
            <td>Keterangan</td>
            <td>Masuk</td>
            <td>Keluar</td>
            <td>Saldo</td>
        </tr>
        <?php
            $saldo_bulan_sebelumnya = $buku->saldo;
            $saldo_sementara = null;
            foreach ($data as $item){
                ?>
                    <tr
                    <?php
                        if ($item->masuk != 0){
                            echo 'class="table-info"';    
                        } else{
                            echo 'class="table-warning"'; 
                        }
                        
                    ?>
                    >
                        <td>
                            <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?php echo route('pembukuan.edit',['id'=>$item->id]);?>">Edit</a>
                                <a class="dropdown-item" onclick="return confirm('Yakin akan menghapus data ini ?')" href="<?php echo route('pembukuan.hapus',['id'=>$item->id]);?>">Hapus</a>
                            </div>
                            </div></td>
                        <td><?php echo tanggal($item->tanggal);?></td>
                        <td><?php echo $item->keterangan;?><br /><small class="text-muted">PJ <?php echo $item->user->name;?></small></td>
                        <td><?php echo rupiah($item->masuk);?></td>
                        <td><?php echo rupiah($item->keluar);?></td>
                        <td><?php 
                            $saldo_sementara = $saldo_sementara + ($item->masuk - $item->keluar);

                            echo rupiah($saldo_sementara + $saldo_bulan_sebelumnya);?>
                        </td>
                    </tr>
                <?php
            }
        ?>
        <tr>
            <td class="text-right" colspan="5">Saldo</td>
            <td><span id="saldo"><?php echo rupiah($saldo_sementara + $saldo_bulan_sebelumnya);?></span></td>
        </tr>

        </table> 
      </div>
<script>
    document.getElementById('display').innerHTML = 'Saldo '+document.getElementById('saldo').innerHTML;
</script>
     
    </main>
@include('layouts.footer');