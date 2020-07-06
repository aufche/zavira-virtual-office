<!doctype html>
<html lang="en">
  <head>
    <title>Ambil Data Pesanan Zavira Jewelry</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link media="screen" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <style type="text/css">
    @media print{
      @import url('https://fonts.googleapis.com/css?family=PT+Mono&display=swap');

      body{
        font-family: 'PT Mono', monospace;
      }
      .table {
        border:1px solid black;border-collapse:collapse;
      }
      .table tr td{
        border:1px solid #000;
        padding:5px;
      }

      .img-fluid{
        max-width: 100%;
        height: auto
      }
    
    }
  

@media (min-width: 1200px) {
    .container{
        max-width: 800px;
    }
}
    </style>
  </head>
  <body>
    <div class="container">
        <table class="table table-bordered">
            <tr>
              <td>No Reparasi</td>
              <td><?php echo $data->id;?> </td>
            </tr>
            <tr>
              <td>No Order</td>
              <td><?php echo $data->pesanan_id;?></td>
            </tr>
            <tr>
              <td>Tgl Reparasi</td>
              <td><?php echo date('d M Y G:i A', strtotime($data->created_at))?></td>
            </tr>
            <tr>
                <td>
                <?php
                        if (!empty($data->pesanan->gambar)){
                          ?>
                          <img src="<?php echo $data->pesanan->gambar;?>" class="img-fluid" alt="cincin" /><br />
                          <?php
                        }

                        if (!empty($data->pesanan->gambargambar)){
                          $gambar = explode(',',$data->pesanan->gambargambar);
                            foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-fluid"  /><br />
                            <?php
                        }
                        }
                      ?>
                </td>
                <td>Keterangan :<br /><?php echo $data->keterangan;?>
                <br /><br />
                Finising<br />
                <?php echo $data->pesanan->keterangan;?>
                <br /><br />
                <b>Pengrajin <?php echo $data->pesanan->pengrajin->nama;?></b>
                </td>
            </tr>
            <tr>
              <td>Bahan Pria</td>
              <td><?php echo $data->pesanan->bahanpria()->first()['title'];?><br /><b>Grafir</b> : <?php echo $data->pesanan->grafirpria;?></td>
            </tr>
            <tr>
              <td>Bahan Wanita</td>
              <td><?php echo $data->pesanan->bahanwanita()->first()['title'];?><br /><b>Grafir</b> : <?php echo $data->pesanan->grafirwanita;?></td>
            </tr>
            <tr>
              <td>Deadline</td>
              <td><strong><u><?php echo date('d M Y', strtotime($data->tdeadline));?></u></strong></td>
              
            </tr>
        </table>
  </div>
  
  </body>
</html>