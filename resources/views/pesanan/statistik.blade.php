@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Export Data</h1>
        </div>
      </div>
    <div class="tile">
        <table class="table table-bordered table-hover" style="width:50%">
            <tr class="thead-dark">
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td class="text-right">Belum Diproses</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'no_proses']);?>"><?php echo $no_proses;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Masih di Bengkel</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_proses']);?>"><?php echo $on_proses;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Sedang Finising</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_lapis']);?>"><?php echo $on_lapis;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Di Showroom</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_office']);?>"><?php echo $on_office;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Di Showroom dan sudah lunas</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_office_lunas']);?>"><?php echo $on_office_lunas;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Dikirim, resi belum lengkap</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_sent_no_resi']);?>"><?php echo $on_sent_no_resi;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Terkirim</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_sent']);?>"><?php echo $on_sent;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Reparasi</td>
                <td><a href="<?php echo route('pesanan.statistik',['detail'=>'on_reparasi']);?>"><?php echo $on_reparasi;?></a></td>
            </tr>
            <tr>
                <td class="text-right">Total Pesanan</td>
                <td><?php echo $all_order;?></td>
            </tr>
            <tr>
                <td class="text-right">Total Pesanan Yang Belum dikirim</td>
                <td><?php echo $no_proses + $on_proses + $on_lapis + $on_office;?></td>
            </tr>
        </table>
    </div>
    </main>
  
@include('layouts.footer');