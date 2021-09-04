@include('layouts.header')
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Akun IG</th>
                    <th>Jumlah Komentar</th>
                </tr>
            </thead>
            <?php
                foreach ($komentar as $item){
                    ?>
                        <tr>
                            <td><?php echo $item->username;?></td>
                            <td><?php echo $item->jumlah;?></td>
                        </tr>
                    <?php
                }
            ?>
        </table>
        <?php echo $komentar->links();?>
      </div>
    </main>
@include('layouts.footer')