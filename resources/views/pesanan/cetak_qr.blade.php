<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>Cetak QR Code</title>
  </head>
  <body>
    <div class="canvas" style="margin-top:100px;padding-left:50px; width:400px;">
        <table>
           <tr>
               <td valign="top">
                   No. Seri <?php echo $response['id'] ?><br />
                   <?php echo $response['nama'] ?><br />
                   +<?php echo $response['nohp'] ?><br /><br />
                   <?php echo $response['bahan_cincin'] ?><br /> <?php echo $response['berat'] ?>gr 
               </td>
               <td>
               
                   <img width="100px;" height="100px" src="http://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode('https://zavirajewelry.com/sertifikat?ref='.$response['undian'].'&item='.$response['item']);?>" />
               </td>
           </tr>
        </table>
    </div>
  </body>
</html>