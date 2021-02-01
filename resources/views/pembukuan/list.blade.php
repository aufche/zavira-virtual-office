@include('layouts.header');
<main class="app-content">
      
      <div class="container">
      <div class="tile">
        <?php
            foreach ($buku as $item){
                ?>
                    <a href="<?php echo route('pembukuan.detail',['id'=>$item->id]);?>" class="btn btn-lg btn-warning btn-block mb-4 shadow border-dark"><?php echo $item->title;?></a> 
                <?php
            }
        ?>
      </div>
      </div>

      

     
    </main>
@include('layouts.footer');