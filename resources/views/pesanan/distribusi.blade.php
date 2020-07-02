<!doctype html>
<html lang="en">
  <head>
    <title>Distribusi Orderan ke Pengrajin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <div class="container mt-3 mb-3">
    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}<br />
                <a href="#" onClick="window.close()">Tutup</a>
            </div>
            @endif

            <form method="post" action="<?php echo route('pesanan.distribusi');?>">
            @csrf
             <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
                <div class="form-row mb-3">
                    <?php 
                    
                    if (!empty($data->gambar_cincin_pria)){
                        ?>
                            <figure>
                                <img src="<?php echo $data->gambar_cincin_pria;?>" alt="" class="img-fluid img-thumbnail"  />
                                <figcaption>Cincin Pria</figcaption>
                            </figure>
                            
                        <?php
                    }

                    if (!empty($data->gambar_cincin_wanita)){
                        ?>
                            <figure>
                                <img src="<?php echo $data->gambar_cincin_wanita;?>" alt="" class="img-fluid img-thumbnail"  /> 
                                <figcaption>Cincin Wanita</figcaption>
                            </figure>
                            
                        <?php
                    }

                    if (!empty($data->gambar)){
                        ?>
                            <img src="<?php echo $data->gambar;?>" alt="" class="img-fluid img-thumbnail"  />
                        <?php
                    }

                    if (!empty($data->gambargambar)){
                        $gambar = explode(',',$data->gambargambar);
                        foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-fluid img-thumbnail"  />
                            <?php
                        }
                        
                    }
                    ?>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                    <label for="">Keterangan Finising</label>
                    <textarea class="form-control mb-3" name="keterangan" id="" rows="8"><?php echo $data->keterangan;?></textarea>
                  <?php 
                    if ($data->kirim_ke_pengrajin == 0){
                        ?>
                        <div class="alert alert-info" role="alert">
                            <strong>Info:</strong> Pesanan ini belum dikirim ke pengrajin yaitu <?php echo $data->pengrajin->nama;?>
                        </div>
                        <?php
                    }elseif ($data->kirim_ke_pengrajin == 1){
                       ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Info:</strong> Pesanan ini sudah dikirim ke pengrajin yaitu <?php echo $data->pengrajin->nama;?>. Hindari pengiriman 2x
                        </div>
                        <?php 
                    }
                  ?>
                  <button type="submit" class="btn btn-warning btn-block btn-lg border-dark mt-3">Distribusikan ke Pengrajin</button>
                    </div>
                  
                </div>
            </form>
        </div>
    </div>
  </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>