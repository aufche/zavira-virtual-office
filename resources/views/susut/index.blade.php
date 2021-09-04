@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Susut Logam</h1>
          <p>Halaman ini memuat history susut logam</p>
        </div>
      </div>

      <div class="tile">
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

        <form method="post" action="<?php echo route('susut.search');?>" class="form-inline">
        
            @csrf
                
                <input type="text" name="q"  class="form-control mb-2 mr-sm-2 form-control-lg border border-warning" placeholder="no order" aria-describedby="helpId">
                
            <button type="submit" class="btn btn-warning mb-2 btn-lg border border-dark"><i class="fas fa-search"></i> Search</button>
        
      </form>
     
        <table class="table table-hover">
            <tr>
                <td>Tanggal</td>
                <td>No Order</td>
                <td class="bg-info text-white">Pria</td>
                <!--<td class="bg-info text-white">Susut Pria</td>-->
                <td class="bg-warning ">Wanita</td>
                <!--<td class="bg-warning ">Susut Wanita</td>-->
                <td>Status</td>
                <td>Penanggung Jawab</td>
                <td>Edit</td>
            </tr>
            <?php
                $n = 1;
                $selisih_susut = 0;
                foreach ($data as $item){
                    if ($n == 1){
                        $berat_awal_wanita = $item->wanita;
                        $berat_awal_pria = $item->pria;
                    }

                    $susut_w = $berat_awal_wanita - $item->wanita;
                    $susut_p = $berat_awal_pria - $item->pria;
                    

                    ?>
                    <tr>
                        <td><?php echo date('d M Y G:i A', strtotime($item->created_at));?></td>
                        <td><a href="<?php echo route('susut.index',['detail' => $item->pesanan_id]);?>"><?php echo $item->pesanan_id;?></a></td>
                        <td class="bg-info text-white"><?php echo $item->pria;?> gr</td>
                        <!--<td class="bg-info text-white"><?php echo $susut_p;?> gr</td>-->
                        <td class="bg-warning "><?php echo $item->wanita;?> gr</td>
                        <!--<td class="bg-warning "><?php echo $susut_w;?> gr</td>-->
                        <td><?php echo $item->status;?></td>
                        <td><?php if (!empty($item->user_id)) echo $item->user->name;?></td>
                        <td><a class="btn btn-warning" href="<?php echo route('susut.edit',['id'=>$item->id]);?>">Edit</a></td>
                    </tr>
                    <?php
                    $n++;
                }
            ?>
        </table>

        <?php echo $data->links();?>
        
      </div>

 
    </main>

@include('layouts.footer')