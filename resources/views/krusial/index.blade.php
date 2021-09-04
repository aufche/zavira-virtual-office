@include('layouts.header')
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
          <h1><i class="fa fa-dashboard"></i> Ticket Permasalahan</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

      

      <div class="tile">

      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

      <table class="table table-bordered">
        <tr class="table-dark text-dark">
            <td>No Order</td>
            <td>Tanggal</td>
            <td>Permasalahan</td>
            <td>Diproses</td>
            <td>Selesai</td>
            <td>Action</td>
        </tr>
        <?php
            
            foreach ($data as $item){
                ?>
                    <tr
                    <?php
                        if ($item->is_done == 0 && $item->is_proses == 0){
                            echo 'class="table-danger"';    
                        } elseif ($item->is_proses == 1 && $item->is_done == 0){
                            echo 'class="table-warning"'; 
                        }else{
                            echo ''; 
                        }
                        
                    ?>
                    >
                        
                        <td><?php echo $item->pesanan_id;?></td>
                        <td><?php echo tanggal($item->created_at);?></td>
                        <td><?php echo $item->catatan;?></td>
                        <td><?php if ($item->is_proses == 0) echo 'Belum'; else echo 'Sedang Diproses'; ?></td>
                        <td><?php if ($item->is_done == 0) echo 'Belum'; else echo 'Sudah Teratasi'; ?></td>
                        <td>
                        <a  href="<?php echo route('penting.edit',['id'=>$item->id]);?>">Proses</a>
                        <a  onclick="return confirm('Yakin akan menghapus data ini ?')" href="<?php echo route('penting.hapus',['id'=>$item->id]);?>">Hapus</a>
                        </td>
                    </tr>
                <?php
            }
        ?>
        </table> 
      </div>     
    </main>
@include('layouts.footer')