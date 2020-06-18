<!doctype html>
<html lang="en">
  <head>
    <title>Update Susut Logam</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container mt-4">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-danger">
                {{ session('warning') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="<?php echo route('susut.add');?>">
                    @csrf
                    <div class="form-row mb-3">
                      <div class="col-md-12">
                        <label for="">Masukkan No Order</label>
                        <input type="number" class="form-control form-control-lg" name="id" id="id" required/>
                        <small id="helpId" class="form-text text-muted">Masukkan no orderan</small>
                      </div>
                      
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-6">
                            <label for="">Berat Cincin Pria</label>
                            <input type="text" class="form-control form-control-lg" name="pria" />
                            <small id="helpId" class="form-text text-muted">(gunakan tanda titik => 3.9)</small>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label for="">Berat Cincin Wanita</label>
                            <input type="text" class="form-control form-control-lg" name="wanita" />
                            <small id="helpId" class="form-text text-muted">(gunakan tanda titik => 3.9)</small>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-12">
                           
                              <label for="">Pilih asal cincin</label>
                              <select class="form-control form-control-lg" name="status">
                                <option value="dari pengrajin">Dari pengrajin</option>
                                <option value="dari bagian lapis">Dari bagian lapis</option>
                                <option value="dari pengrajin (reparasi)">Dari pengrajin (Reparasi)</option>
                                <option value="dari bagian lapis (reparasi)">Dari bagian lapis(Reparasi)</option>
                              </select>
                           
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg btn-block">Update</button>
                </form>

                <?php
                    if (!empty($data)){
                        ?>
                        <table class="table mt-3">
                            <tr>
                                <td>Tanggal</td>
                                <td>Berat Pria</td>
                                <td>Berat Wanita</td>
                                <td>Berat Status</td>
                            </tr>
                        <?php
                        $awal = 0;
                        foreach ($data as $item){
                            
                            ?>
                            <tr>
                                <td><?php echo date('d M Y', strtotime($item->created_at));?></td>
                                <td><?php echo $item->pria;?> gr</td>
                                <td><?php echo $item->wanita;?> gr</td>
                                <td><?php echo $item->status;?></td>
                            </tr>
                            <?php
                        }
                        echo '</table>';
                    }
                ?>
            </div>
        </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>
        document.getElementById("id").focus();
    </script>
  </body>
</html>