@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Neraca</h1>
          <p>Keluar Masuk Uang</p>
        </div>
      </div>

      <div class="tile">
        <a class="btn btn-warning mb-3 border-dark" href="<?php echo route('neraca.insert');?>">Tambah</a>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <tr>
                <td>No.</td>
                <td>Tanggal</td>
                <td>Keterangan</td>
                <td>Penanggung Jawab</td>
                <td>Masuk</td>
                <td>Keluar</td>
                <td>Option</td>
            </tr>
        <?php
            $pemasukan = 0;
            $pengeluaran = 0;
            $n = 1;
            foreach ($data as $item){
                ?>
                <tr>
                    <td><?php echo $n;?>. </td>
                    <td><?php echo date('d M Y', strtotime($item->created_at));?></td>
                    <td><?php echo $item->keterangan;?></td>
                    <td><?php echo $item->user->name;?></td>
                    <td><?php if ($item->status == 1) {
                         echo rupiah($item->nominal);
                         $pemasukan = $pemasukan+$item->nominal;  
                    }
                         else echo '-';?></td>
                    <td><?php if ($item->status == 0){
                        echo rupiah($item->nominal);
                        $pengeluaran = $pengeluaran+$item->nominal; 
                    } else echo '-';?></td>
                    <td><a href="<?php echo route('neraca.hapus',['id'=>$item->id]); ?>">Hapus</a></td>
                </tr>
                <?php
                $n++;
            }
        ?>
            <tr>
                <td colspan="4">-</td>
                <td><?php echo rupiah($pemasukan);?></td>
                <td><?php echo rupiah($pengeluaran);?></td>
                
            </tr>
        </table>
      </div>
    </main>
@include('layouts.footer');