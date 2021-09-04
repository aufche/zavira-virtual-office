@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Rekap Order</h1>
        </div>
      </div>

      <div class="tile">
      Customer Service <?php echo $data[0]->user->name;?>
      </div>
    <div class="tile">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
           
            <?php echo $data->links();?>
            
                <table class="table">
                    <tr>
                        <td>No</td>
                        <td>No Order</td>
                        <td>Nama Pemesan</td>
                        <td>Tgl Masuk</td>
                        <td>Bahan Pria</td>
                        <td>Bahan Wanita</td>
                    </tr>

                    
                    @foreach ($data as $item)
                    <tr>
                        
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ date('d M Y', strtotime($item->tglmasuk)) }} </td>
                        <td><?php echo title_logam($item->bahanpria()->first(),'title');?></td>
                        <td><?php echo title_logam($item->bahanwanita()->first(),'title');?></td>
                    </tr>
                    @endforeach
                    
                </table>
                <?php echo $data->links();?>
            </div>
        </div>
    </div>
    </div>
    </main>
  
@include('layouts.footer')