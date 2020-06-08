<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    table.table-bordered{
    border:1px solid #000;
    margin-top:20px;
      }
    table.table-bordered > thead > tr > th{
        border:1px solid #000;
        
    }
    table.table-bordered > tbody > tr > td{
        border:1px solid #000;
        font-size:12px;
    }
    </style>
  </head>
  <body>
      <div class="container-fluid">
    
        <h1>Transaksi Cash</h1>
        <p class="lead">Periode <?php echo $bulan;?></p>
    
          
              <table class="table table-bordered">
                    <tr class="table-dark text-dark">
                        <td>Tanggal</td>
                        <td>Keterangan</td>
                        <td>Masuk</td>
                        <td>Keluar</td>
                        <td>Saldo</td>
                    </tr>
                    
                  <?php 
                  $saldo_bulan_sebelumnya = $buku->saldo;
                  $saldo_sementara = null;
                  foreach ($data as $item){
                      ?>
                        <tr
                        <?php
                            if ($item->masuk != 0){
                                echo 'class="table-info"';    
                            } else{
                                echo 'class="table-warning"'; 
                            }
                            
                        ?>
                        >
                            
                            <td><?php echo date('d/n/Y', strtotime($item->tanggal));?></td>
                            <td><?php echo $item->keterangan;?><br /><small class="text-muted">PJ <?php echo $item->user->name;?></small></td>
                            <td><?php echo rupiah($item->masuk);?></td>
                            <td><?php echo rupiah($item->keluar);?></td>
                            <td><?php 
                                $saldo_sementara = $saldo_sementara + ($item->masuk - $item->keluar);

                                echo rupiah($saldo_sementara + $saldo_bulan_sebelumnya);?>
                            </td>
                        </tr>
                      <?php
                  }
                  ?>
                  <tr>
                    <td class="text-right" colspan="4">Saldo</td>
                    <td><span id="saldo"><?php echo rupiah($saldo_sementara + $saldo_bulan_sebelumnya);?></span></td>
                </tr>

             </table> 
              
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>