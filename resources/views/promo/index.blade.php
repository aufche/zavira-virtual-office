@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-discount"></i> Semua Promo</h1>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <tr>
                <td>ID</td>
                <td>Nama Promo</td>
                <td>Status</td>
                <td>Option</td>
            </tr>
            <?php

            foreach ($promo as $item){
                ?>
            <tr>
                <td><?php echo $item->id;?></td>
                <td><?php echo $item->title;?></td>
                <td><?php if ($item->aktif == 1) echo 'Aktif'; else echo 'Tidak Aktif';?></td>
                <td><a class="btn btn-danger border-dark" href="<?php echo route('promo.insert',['id'=>$item->id,'action'=>'hapus']); ?>">Hapus</a> <a class="border-dark btn btn-warning" href="<?php echo route('promo.insert',['action'=>'edit','id'=>$item->id]); ?>">Edit</a></td>
            </tr>
                <?php
            }
            ?>
            </table>
      </div>
    </main>
@include('layouts.footer');