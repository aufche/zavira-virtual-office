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

      hr.new3 {
  border-top: 1px dotted red;
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
                          <img src="<?php echo $data->pesanan->gambar;?>" class="img-fluid" alt="cincin"  width="150px" height="auto" /><br />
                          <?php
                        }

                        if (!empty($data->pesanan->gambargambar)){
                          $gambar = explode(',',$data->pesanan->gambargambar);
                            foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-fluid"  width="150px" height="auto" /><br />
                            <?php
                        }
                        }
                      ?>
                </td>
                <td>Keterangan Reparasi:<br /><?php echo $data->keterangan;?>
                <br /><br />
                Finising<br />
                <?php echo $data->pesanan->keterangan;?>
                <br /><br />
                </td>
            </tr>
            
            <?php 
              if ($data->ncincin == 'p' || $data->ncincin == 'c'){
              ?>
            <tr>
              <td>Bahan Pria</td>
              <td><?php echo $data->pesanan->bahanpria()->first()['title'];?><br /><b>Grafir</b> : <?php echo $data->pesanan->grafirpria;?></td>
            </tr>
            <tr>
                <td>Finising Pria</td>
                <td><?php echo $data->pesanan->finising_pria;?></td>
            </tr>
              <?php }
              if ($data->ncincin == 'w' || $data->ncincin == 'c'){
              ?>
            <tr>
              <td>Bahan Wanita</td>
              <td><?php echo $data->pesanan->bahanwanita()->first()['title'];?><br /><b>Grafir</b> : <?php echo $data->pesanan->grafirwanita;?></td>
            </tr>
            <tr>
                <td>Finising Wanita</td>
                <td><?php echo $data->pesanan->finising_wanita;?></td>
            </tr>
              <?php } ?>
            <tr>
              <td>Deadline</td>
              <td><strong><u><?php echo date('d M Y', strtotime($data->tdeadline));?></u></strong></td>
            </tr>
            <tr>
              <td>Pengrajin</td>
              <td><strong><u><?php echo $data->pesanan->pengrajin->nama;?></u></strong></td>
            </tr>
            <?php
             if (!empty($data->pesanan->plated_id)){
               ?>
            <tr>
              <td>Lapis</td>
              <td><strong><u><?php echo $data->pesanan->plated->title;?></u></strong></td>
            </tr>
            <?php
              }
             ?>
             <tr>
              <td>Digrafir oleh </td>
              <td><strong><u><?php echo $data->pesanan->grafir;?></u></strong></td>
            </tr>
        </table>

        .............................potong disini.....................
        <h2>Tanda Terima Reparasi</h2>
        <small>Disimpan untuk arsip kantor</small>
        
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
                          <img src="<?php echo $data->pesanan->gambar;?>" class="img-fluid" alt="cincin" width="60px" height="auto" /><br />
                          <?php
                        }

                        if (!empty($data->pesanan->gambargambar)){
                          $gambar = explode(',',$data->pesanan->gambargambar);
                            foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-fluid"   width="60px" height="auto" /><br />
                            <?php
                        }
                        }
                      ?>
                </td>
                <td>Keterangan Reparasi:<br /><?php echo $data->keterangan;?>
                <br /><br />
                Finising<br />
                <?php echo $data->pesanan->keterangan;?>
                <br /><br />
                </td>
            </tr>
             
            <?php 
              if ($data->ncincin == 'p' || $data->ncincin == 'c'){
              ?>
            <tr>
              <td>Bahan Pria</td>
              <td><?php echo $data->pesanan->bahanpria()->first()['title'];?><br /><b>Grafir</b> : <?php echo $data->pesanan->grafirpria;?></td>
            </tr>
            <tr>
                <td>Finising Pria</td>
                <td><?php echo $data->pesanan->finising_pria;?></td>
            </tr>
              <?php }
              if ($data->ncincin == 'w' || $data->ncincin == 'c'){
              ?>
            <tr>
              <td>Bahan Wanita</td>
              <td><?php echo $data->pesanan->bahanwanita()->first()['title'];?><br /><b>Grafir</b> : <?php echo $data->pesanan->grafirwanita;?></td>
            </tr>
            <tr>
                <td>Finising Wanita</td>
                <td><?php echo $data->pesanan->finising_wanita;?></td>
            </tr>
              <?php } ?>
        </table>
        <p>Cincin ini telah diterima oleh</p>
        <br /><br /><br /><br />
        .........................
  </div>
  
  </body>
</html>