@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Bukti Transfer Logam</h1>
          <p>Pada halaman ini kamu bisa menambahkan bukti transfer logam (ke pak bejo)</p>
        </div>
      </div>

      <div class="tile">
      <form method="post" action="<?php echo route('bukti.search');?>" class="form-inline">
        
            @csrf
                
                <input type="text" name="q"  class="form-control mb-2 mr-sm-2 form-control-lg border border-warning" placeholder="no order" aria-describedby="helpId">
                
            <button type="submit" class="btn btn-warning mb-2 btn-lg border border-dark"><i class="fas fa-search"></i> Search</button>
        
      </form>
      <?php echo $bukti_transfer->links();?>
        <table class="table table-hover">
            <tr>
                <td>No.</td>
                <td>Identitas</td>
                <td>Pesanan ID</td>
                <td>Tanggal Dibuat</td>
                <td>Option</td>
            </tr>
            <?php
                foreach ($bukti_transfer as $item){
                    ?>
                    <tr>
                        <td><?php echo $item->id;?></td>
                        <td><a data-toggle="collapse" href="#collapse-<?php echo $item->id;?>" aria-expanded="false" aria-controls="collapse-<?php echo $item->id;?>"><?php echo $item->identitas;?></a>
                            <div class="collapse" id="collapse-<?php echo $item->id;?>">
                                <?php
                                    
                                    $bukti_transfer_arr = explode(',',$item->bukti_transfer);
                                    
                                   
                                    foreach ($bukti_transfer_arr as $item2){
                                        ?>
                                            <img src="<?php echo $item2;?>" class="img-fluid" />
                                        <?php 
                                    }
                                ?>
                            </div>
                        </td>
                        <td><?php echo $item->pesanan_id;?></td>
                        <td><?php echo date('d M Y', strtotime($item->created_at));?></td>
                        <td><a role="button" class="btn btn-warning border border-dark" href="<?php echo route('bukti.cetak',['detail' => $item->identitas ]);?>" target="_blank"><i class="fas fa-print"></i> Cetak</a>
                            <a role="button" class="btn btn-warning border border-dark" href="<?php echo route('bukti.cetak',['detail' => $item->identitas,'export' => 'pdf']);?>"><i class="fas fa-print"></i> Export PDF</a>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        <?php echo $bukti_transfer->links();?>
      </div>

 
    </main>

@include('layouts.footer');