@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-thumbs-up"></i> Lead and Closing</h1>
          <p>Pencatatan Jumlah Lead dan Pesanan Tiap Hari</p>
        </div>
      </div>
    <div class="tile">

    <form action="<?php echo route('pesanan.lead');?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            
            <div class="col-md-6 mb-3">
               
                 <label for="">Jumlah Lead/Chat</label>
                 <input type="text" class="form-control form-control-lg" name="chat" />
                 
                  
            </div>

            <div class="col-md-6 mb3">
                 <label for="">Jumlah Konsumen Transfer/Closing</label>
                 <input type="text" class="form-control form-control-lg" name="closing" />
                 
            </div>

            <div class="col-md-12">
                <div class="form-group">
                  <label for="catatan">Catatan Khusus</label>
                  <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
                </div>
            </div>

            

            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-warning btn-lg btn-block border-dark">Submit</button>
            </div>
        </div>
    
    </form>
                    
    </div>
    <?php
    if (isset($lead)){
        ?>
    <div class="tile">
    <?php echo $lead->links();?>
    <?php
        $cs = Auth::user();
    ?>
    <div class="h4 mb-5">Nama <?php echo $cs->name;?></div>
    <table class="table">
        <tr>
            <td>Tanggal Input</td>
            <td>Update terakhir</td>
            <td>Jumlah Chat</td>
            <td>Jumlah Closing</td>
            <td>Persentase</td>
            <td>Catatan</td>
            <td>Update</td>
        </tr>
    <?php
        $nchat = 0;
        $nclosing = 0;
        foreach($lead as $item){
            ?>
            <tr>
                <td><?php echo date('d M Y G:i', strtotime($item->created_at))?></td>
                <td><?php echo date('d M Y G:i', strtotime($item->updated_at))?></td>
                <td><?php echo $item->chat;?></td>
                <td><?php echo $item->closing;?></td>
                <td><?php if ($item->chat != 0){
                    echo @($item->closing/$item->chat)*100;
                }else{
                    echo '0';
                }
                    ?>%</td>
                <td><?php echo $item->catatan;?></td>
                <td><a href="<?php echo route('pesanan.lead',['id'=>$item->id,'action'=>'update']);?>">Update</a></td>
            </tr>
            <?php
            $nchat = $nchat+$item->chat;
            $nclosing = $nclosing+$item->closing;
        }
    ?>
        <tr>
            <td colspan="2"></td>
            <td><?php echo $nchat;?></td>
            <td><?php echo $nclosing;?></td>
            <td><?php echo @($nclosing/$nchat)*100;?>%</td>
            <td>-</td>
        </tr>
    </table>
    <?php echo $lead->links();?>
    </div>
            <?php
        }
    ?>
    </main>
  
@include('layouts.footer');