<!doctype html>
<html lang="en">
  <head>
    <title>Detail Order <?php echo $data->id;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>No Order</td>
                        <td><?php echo $data->id;?> <?php echo $data->nama;?> <?php echo $data->nohp;?></td>
                    </tr>
                    <tr>
                        <td>Tgl Masuk</td>
                        <td><?php echo tanggal($data->tglmasuk);?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?php echo $data->alamat;?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo $data->email;?></td>
                    </tr>
                    <tr>
                        <td>Harga Barang</td>
                        <td><?php echo rupiah($data->hargabarang);?></td>
                    </tr>
                    <tr>
                        <td>Jumlah DP</td>
                        <td><?php echo rupiah($data->dp);?></td>
                    </tr>
                    <tr>
                        <td>Pelunasan</td>
                        <td><?php echo rupiah($data->pelunasan);?></td>
                    </tr>
                    <tr>
                        <td>Ongkir</td>
                        <td><?php echo rupiah($data->ongkir);?></td>
                    </tr>
                    <?php
                    if (!empty($data->ukuranpria)){
                        ?>
                         <tr>
                            <td>Detail Cincin Pria<br />
                            <?php echo $data->bahanpria()->first()['title'];?>
                            </td>
                            <td><?php 
                                $produksi_pria = $data->produksi_beratpria * $data->produksi_hargapria;
                                $jual_pria = $data->sertifikat_beratpria * $data->sertifikat_hargapria;
                                echo 'Harga produksi (logam) '.rupiah($produksi_pria).'<br />';
                                echo 'Harga jual (logam) '.rupiah($jual_pria).'<br />';
                                echo 'Berat logam yang disediakan '.$data->produksi_beratpria.' gr<br />';
                                echo 'Berat hasil jadi '.$data->sertifikat_beratpria.' gr<br />';
                                echo 'Susut logam '.($data->sertifikat_beratpria - $data->produksi_beratpria).' gr';
                                ?></td>
                        </tr>   
                        <?php
                    }
                    ?>

                    <?php
                    if (!empty($data->ukuranwanita)){
                        ?>
                         <tr>
                            <td>Detail Cincin Wanita<br />
                            <?php echo $data->bahanwanita()->first()['title'];?>
                            </td>
                            <td><?php 
                                $produksi_wanita = $data->produksi_beratwanita * $data->produksi_hargawanita;
                                $jual_wanita = $data->sertifikat_beratwanita * $data->sertifikat_hargawanita;
                                echo 'Harga produksi (logam) '.rupiah($produksi_wanita).'<br />';
                                echo 'Harga jual (logam) '.rupiah($jual_wanita).'<br />';
                                echo 'Berat logam yang disediakan '.$data->produksi_beratwanita.' gr<br />';
                                echo 'Berat hasil jadi '.$data->sertifikat_beratwanita.' gr<br />';
                                echo 'Susut logam '.($data->sertifikat_beratwanita - $data->produksi_beratwanita).' gr';
                                ?></td>
                        </tr>   
                        <?php
                    }
                    ?>
                    <tr>
                        <td>Ongkos Bikin</td>
                        <td><?php echo rupiah($data->ongkos_bikin);?></td>
                    </tr>
                    <tr>
                        <td>Lapis</td>
                        <td><?php echo rupiah($data->modal_lapis);?></td>
                    </tr>
                    <tr>
                        <td>Ongkos Pengrajin</td>
                        <td><?php echo rupiah($data->modal_pengrajin);?> <?php echo $data->pengrajin->nama;?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>  
  </body>
</html>