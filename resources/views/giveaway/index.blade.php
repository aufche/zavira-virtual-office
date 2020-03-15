@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Peserta Giveaway</h1>
        </div>
      </div>
      
      <div class="tile">

      <form class="form-inline" method="post" action="<?php echo route('ga.search');?>">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-group mb-2 mr-3">
                <label for="inputPassword2" class="sr-only">Password</label>
                <input type="text" name="q" class="form-control" placeholder="Kata kunci" />
            </div>
            <button type="submit" class="btn btn-primary mb-2">Cari</button>
        </form>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        Jumlah peserta <?php echo $jumlah;?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Akun IG</th>
                    <th>Email</th>
                    <th>Periode</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
                foreach ($peserta as $item){
                    ?>
                        <tr>
                            <td><?php echo $item->nama;?></td>
                            <td><?php echo $item->ig;?></td>
                            <td><?php echo $item->email;?></td>
                            <td><?php echo $item->periode;?></td>
                            <td><a href="<?php echo route('ga.action',['id'=>$item->id,'act'=>'delete']);?>">Hapus</a></td>
                        </tr>
                    <?php
                }
            ?>
        </table>
        <?php echo $peserta->links();?>
      </div>
    </main>
@include('layouts.footer');