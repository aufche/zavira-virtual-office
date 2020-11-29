<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
        <div class="row">
            <div class="col-md-12">
            <table class="table">
        <tr>
            <td>No Order</td>
            <td>Tanggal Masuk</td>
            <td>Tanggal Selesai</td>
            <td>Deadline</td>
            <td>Urgent</td>
        </tr>
    <?php
        foreach($data as $item){
            ?>
            <tr>
                <td><a  data-toggle="collapse" href="#collapseExample-<?php echo $item->id;?>"><?php echo $item->id;?></a></td>
                <td><?php echo date('d M Y', strtotime($item->tglmasuk))?></td>
                <td><?php echo date('d M Y', strtotime($item->tglselesai))?></td>
                <td><?php echo date('d M Y', strtotime($item->deadline))?></td>
                <td><?php if ($item->urgent == 1) echo 'Ya'; else echo 'Tidak' ;?></td>
            </tr>
            <tr>
                <td colspan="5">
                    <div class="collapse" id="collapseExample-<?php echo $item->id;?>">
                    <?php
                        if (!empty($item->gambar_cincin_pria)){
                          ?>
                          <fieldset>
                            <legend>Cincin Pria</legend>
                            <img src="<?php echo $item->gambar_cincin_pria;?>" class="img-thumbnail img-fluid" alt="cincin" /><br />
                            <?php echo $item->finising_pria;?>
                          </fieldset>
                          <?php
                        }

                        if (!empty($item->gambar_cincin_wanita)){
                          ?>
                          <fieldset>
                            <legend>Cincin Wanita</legend>
                            <img src="<?php echo $item->gambar_cincin_wanita;?>" class="img-thumbnail img-fluid" alt="cincin" /><br />
                            <?php echo $item->finising_pria;?>
                          </fieldset>
                          <?php
                        }

                        if (!empty($item->gambar)){
                          ?>
                          <img src="<?php echo $item->gambar;?>" class="img-thumbnail" alt="cincin" /><br />
                          <?php
                        }

                        if (!empty($item->gambargambar)){
                          $gambar = explode(',',$item->gambargambar);
                            foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-thumbnail" width="200px" /><br />
                            <?php
                        }
                        }

                        if (!empty($item->finising_pria) && (empty($item->gambar_cincin_pria)) ){
                          echo 'Finising Cincin Pria<br />';
                          echo $item->finising_pria;
                          echo '<br />';
                          }
              
                          echo '<hr />';
              
                          if (!empty($item->finising_wanita) && (empty($item->gambar_cincin_wanita))){
                              echo 'Finising Cincin Wanita<br />';
                              echo $item->finising_wanita;
                              echo '<br />';
                          }
                      ?>
                    </div>
                </td>
            </tr>
            <?php      
        }
    ?>
    </table>      
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