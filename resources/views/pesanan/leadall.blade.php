@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-thumbs-up"></i> Lead and Closing</h1>
          <p>Pencatatan Jumlah Lead dan Pesanan Tiap Hari</p>
        </div>
      </div>

    <?php
    if (isset($lead)){
        ?>
    <div class="container mb-5 mt-5">
        <form method="post" action="<?php echo route('pesanan.lead',['action'=>'detail']);?>">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-row">
            <div class="col-md-8">
                <select name="cs_id" class="form-control form-control-lg">
                <?php
                foreach ($cs as $name => $id){
                    ?>
                    <option value="<?php echo $id;?>"><?php echo $name;?></option>
                    <?php
                }
                ?>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-lg btn-block btn-warning border-dark">Cari</button>
            </div>
        </div>
        </form>
    </div>
    <div class="tile">
    <?php echo $lead->appends(Request::except('page'))->links();?>
    <table class="table">
        <tr>
            <td>Tanggal Input</td>
            <td>Update terakhir</td>
            <td>CS</td>
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
                <td><?php echo $item->user->name;?></td>
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
            <td colspan="3"></td>
            <td><?php echo $nchat;?></td>
            <td><?php echo $nclosing;?></td>
            <td><?php echo @($nclosing/$nchat)*100;?>%</td>
            <td>-</td>
        </tr>
    </table>
    <?php echo $lead->appends(Request::except('page'))->links();?>
    </div>
            <?php
        }
    ?>
    </main>
  
@include('layouts.footer');