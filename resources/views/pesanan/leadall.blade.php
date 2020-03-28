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
    <div class="tile">
    <table class="table">
        <tr>
            <td>Tanggal Input</td>
            <td>Update terakhir</td>
            <td>CS</td>
            <td>Jumlah Chat</td>
            <td>Jumlah Closing</td>
            <td>Persentase</td>
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
    </div>
            <?php
        }
    ?>
    </main>
  
@include('layouts.footer');