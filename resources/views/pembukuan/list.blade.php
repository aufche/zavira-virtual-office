@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Pembukuan</h1>
          <p>Pada halaman ini, kamu bisa melihat daftar pembukuan yang kamu kelola</p>
        </div>
      </div>

      <div class="tile">
        <?php
            foreach ($buku as $item){
                ?>
                    <a href="<?php echo route('pembukuan.detail',['id'=>$item->id]);?>" class="btn btn-lg btn-outline-primary"><?php echo $item->title;?></a> 
                <?php
            }
        ?>
      </div>

     
    </main>
@include('layouts.footer');