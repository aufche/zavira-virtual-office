<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  </head>
  <body>

  <div class="container mt-5">
  <div class="row">
    <div class="col-md-5">
    <?php echo 'No order '.$data->id;?>
    <form action="<?php echo route('updating');?>" method="post">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <input type = "hidden" name = "no" value = "<?php echo $data->id ?>">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationDefault03">Berat Bahan Cincin Pria</label>
                <input type="text" id="textboxID" value="<?php echo $data->produksi_beratpria;?>" name="produksi_beratpria" class="form-control" >
                </div>

                <div class="col-md-6 mb-3">
                <label for="validationDefault04">Berat Bahan Cincin Wanita</label>
                <input type="text" value="<?php echo $data->produksi_beratwanita;?>" name="produksi_beratwanita" class="form-control" >
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationDefault03">Ongkos Pengrajin</label><br />
                <?php if ($data->pengrajin_id == 2 && empty($data->modal_pengrajin)) echo '<small class="text-muted">Data belum disini, sugesti ongkos pengrajin seperti dibawah</small>';?>
                <input type="text" value="<?php if ($data->pengrajin_id == 2 && empty($data->modal_pengrajin) && $data->couple == 1) echo '100000'; elseif($data->pengrajin_id == 2 && empty($data->modal_pengrajin) && $data->couple == 0) echo '50000'; else echo $data->modal_pengrajin;?>" name="modal_pengrajin" class="form-control" >
                </div>

                <div class="col-md-6 mb-3">
                <label for="validationDefault04">Ongkos Lapis</label><br />
                <?php if ($data->pengrajin_id == 2 && empty($data->modal_lapis)) echo '<small class="text-muted">Data belum disini, sugesti biaya lapis seperti dibawah</small>';?>
                <input type="text" value="<?php if ($data->pengrajin_id == 2 && empty($data->modal_lapis) && $data->couple == 1) echo '60000';  elseif($data->pengrajin_id == 2 && empty($data->modal_lapis) && $data->couple == 0) echo '30000'; else  echo $data->modal_lapis;?>" name="modal_lapis" class="form-control" >
                <?php
                  if ($data->jumlah_lapis > 1){
                    echo '<p class="text-danger">Orderan ini sudah berulang lapis sampai '.$data->jumlah_lapis.' kali</p>';
                    echo $data->keterangan_orderan;
                  }
                ?>
                </div>

                <div class="col-md-12 mb-3">
                <div class="form-check">
                  <!--<label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="logam_sesuai" value="1" <?php if ($data->logam_sesuai == 1 || $data->logam_sesuai == 2) echo 'checked'; if ($data->logam_sesuai == 2) echo ' disabled';?> />
                    Data logam produksi telah sesuai dengan kertas dari pengrajin
                  </label>
                  -->
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="update_apa"  value="1">
                    <label class="form-check-label" for="inlineRadio1">Update : Ongkos Pengrajin</label>
                    </div><br />
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="update_apa" value="2">
                    <label class="form-check-label" for="inlineRadio2">Update : Biaya Lapis</label>
                    </div><br />
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="update_apa" value="3">
                    <label class="form-check-label" for="inlineRadio3">Update : Ongkos Pengrajin + Lapis</label>
                    </div>
                </div>
                </div>
            </div>

              

            
            <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
        </form>
    </div>

    <div class="col-md-7">
        <table class="table table-bordered">
             <tr>
                <td width="20%">Pengrajin</td>
                <td width="80%"><?php echo $data->pengrajin->nama;?></td>
            </tr>
             <tr>
                <td width="20%">Tgl Masuk</td>
                <td width="80%"><?php echo date('d M Y', strtotime($data->tglmasuk));?></td>
            </tr>
            <tr>
                <td>Bahan Pria</td>
                <td><?php echo $data->bahanpria()->first()['title'];?><br />Berat akhir <?php echo $data->sertifikat_beratpria;?></td>
            </tr>
            <tr>
                <td>Bahan Wanita</td>
                <td><?php echo $data->bahanwanita()->first()['title'];?><br />Berat akhir <?php echo $data->sertifikat_beratwanita;?></td>   
            </tr>
            <?php if (!empty($data->keterangan_orderan)){
              ?>
                <tr>
                    <td colspan="2">Catatan keluhan: <br /><?php echo $data->keterangan_orderan;?></td>
                </tr>
              <?php
            }
            ?>
            <tr>
              <td>Reparasi</td>
              <td>
                <?php 
                $n = 1;
                foreach ($data->reparasi as $rep){
                  echo $n.'. '.$rep->keterangan;
                  $n++;
                }?>
              </td>
            </tr>
            <tr>
                <td>Finising</td>
                <td><?php echo $data->keterangan;?></td>   
            </tr>
        </table>
    </div>
  </div>
  
  </div>

  <script type="text/javascript">
        document.getElementById('textboxID').focus();
    </script>
  </body>
</html>