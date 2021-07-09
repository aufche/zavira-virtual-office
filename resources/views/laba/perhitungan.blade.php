@include('layouts.header')
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
}
    </style>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-dashboard"></i> Perhitungan</h1>
        </div>
      </div>


      
    <div class="tile">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
            <?php echo $data->links();?>
                <table class="table">
                    <tr>
                        <td>No Order</td>
                        <td>DP</td>
                        <td>Pelunasan</td>
                        <td>Jasa Pengrajin</td>
                        <td>Lapis</td>
                        <td>Harga Final</td>
                        <td>Keuntungan</td>
                    </tr>
                
                <?php
                    foreach ($data as $item){
                        ?>
                            <tr>
                                <td><?php echo $item->id;?></td>
                                <td><?php echo rupiah($item->dp);?></td>
                                <td><?php echo rupiah($item->pelunasan);?></td>
                                <td><?php echo rupiah($item->modal_pengrajin);?></td>
                                <td><?php echo rupiah($item->modal_lapis);?></td>
                                <td><?php echo rupiah($item->harga_final);?></td>
                                <td><?php 
                                    if (!empty($item->harga_final)) echo rupiah(($item->dp + $item->pelunasan) - $item->harga_final);?></td>
                            </tr>
                        <?php
                    }
                ?>
                </table>
                <?php echo $data->links();?>
            </div>
            </div>
            
        </div>
    </div>
    
   
    </main>
  
@include('layouts.footer')