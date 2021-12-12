<!doctype html>
<html lang="en">
  <head>
    <title>Tanda Terima Orderan</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" media="screen" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css"> 
        @media screen{
          table.table-bordered{
            border:1px solid #000;
            margin-top:20px;
            }
            table.table-bordered > thead > tr > th{
                border:1px solid #000;
            }
            table.table-bordered > tbody > tr > td{
                border:1px solid #000;
            }
        }

        @media print{
                @import url('https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap');

                body{
                  font-family: 'Courier Prime', monospace;
                }
                .table {
                    border:1px solid black;
                    border-collapse:collapse;
                    width:100%;
                }
                .table tr td, .table thead tr th{
                    border:1px solid #000;
                    padding:10px;
                }

                .img-fluid{
                    max-width: 100%;
                    height: auto
                }
                .logo{
                    width:40%;
                }
                .mb-5{
                    margin-bottom:50px;
                }

                .mb-1{
                    margin-bottom:10px;
                }

                

                .p-5{
                    padding:5px;
                }

                .kiri{
                    float:left;
                    width:70%;
                }

                .kanan{
                    float:right;
                    width:30%;
                }

                .bersih{
                    content: "";
                    clear: both;
                    display: table;
                }
  
        }
    </style>

  </head>
  <body>
  <div class="container">
      <h1>Surat Tanda Terima Orderan</h1>
      <p>Dengan ini menyatakan bahwa : </p>
      <pre>
      Nama Lengkap : Bejo Slamet
      Alamat       : Bintaran Kulon RT 05, Srimulyo, Piyungan Bantul
      No. KTP      : 3402142807730002
      </pre>
      <p>Telah mengerjakan orderan perhiasan dari Zavira Jewelry dengan spesifikasi sebagai berikut </p>
      <table class="table table-bordered">
        <tr>
            <td>No Order</td>
            <td><?php echo $data->id;?></td>
        </tr>
        <tr>
            <td>Tanggal Order</td>
            <td><?php echo nice_date($data->tglmasuk);?></td>
        </tr>
        <tr>
            <td>Cincin Pria</td>
            <td><?php echo title_logam($data->bahanpria()->first(),'title');?><br />Berat ± <?php echo $data->produksi_beratpria;?> gram</td>
        </tr>
        <tr>
            <td>Cincin Wanita</td>
            <td><?php echo title_logam($data->bahanwanita()->first(),'title');?><br />Berat ± <?php echo $data->produksi_beratwanita;?> gram</td>
        </tr>
        <tr>
            <td valign="top">Foto Cincin</td>
            <td>
            <?php if (!empty($data->sertifikat_gambarcincin)){
                echo '<img src="'.$data->sertifikat_gambarcincin.'" class="img-thumbnail" width="200px;" alt="cincin kawin" />';
            }else{
                echo 'Belum ada';
            }
            ?>
            </td>
        </tr>
      </table>

      <div class="kiri mb-1">
      <br />
      <br />
    Karayawan<br /><br /><br /><br />

    Yuni Wijayanti
      </div>

      <div class="kanan mb-1">
      <br />
      <br />
        Pengrajin<br /><br /><br /><br /><br />

        Bejo Slamet
      </div>
      </div>
  </body>
</html>