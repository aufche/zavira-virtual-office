@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Reparasi</h1>
        </div>
      </div>
      <?php


?>

        <div class="tile">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <?php echo $data->links();?>
            <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No. Reparasi</th>
                    <th>No. Order</th>
                    <th>Kelengkapan</th>
                    <th>Keterangan</th>
                    <th>Cincin yang direparasi</th>
                    <th>Tanggal Input</th>
                    <th>Customer Service</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
              <?php
                foreach ($data as $item){
                    ?>
                    <tr>
                        <td><?php echo $item->id;?></td>
                        <td><a href="<?php route('pesanan.detail',['id'=>$item->pesanan_id]);?>" target="popup" onclick="window.open('<?php echo route('pesanan.detail',['id'=>$item->pesanan_id]);?>','popup','width=600,height=800'); return false;"><?php echo $item->pesanan_id;?></a></td>
                        <td><?php echo $item->kelengkapan;?></td>
                        <td><?php echo $item->keterangan;?></td>
                        <td><?php 
                          if ($item->ncincin == 'p') echo 'Pria saja';
                          if ($item->ncincin == 'w') echo 'Wanita saja';
                          if ($item->ncincin == 'c') echo 'Couple';
                        ?></td>
                        <td><?php echo date('d M Y G:i A', strtotime($item->created_at));?></td>
                        <td><?php echo $item->pesanan->user->name;?><br /><small class="text-muted">Diproses oleh <?php echo $item->pj;?></small></td>
                        <td>
                        <div class="btn-group shadow" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu shadow" aria-labelledby="btnGroupDrop1">
                            <a href="<?php echo route('reparasi.cetak',['id'=>$item->id]);?>" target="_blank" class="dropdown-item btn btn-primary">Cetak</a>
                            <a href="<?php echo route('reparasi.delete',['id'=>$item->id]);?>" class="dropdown-item btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                          </div>
                        </div>
                        
                         </td>
                    </tr>
                    <?php
                }

              ?>
              </tbody>
              </table>
              <?php echo $data->links();?>
        </div>
    </main>
  
@include('layouts.footer')