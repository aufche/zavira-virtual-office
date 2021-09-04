@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Lead and Closing</h1>
          <p>Pencatatan Jumlah Lead dan Pesanan Tiap Hari</p>
        </div>
      </div>
    <div class="tile">

    <form action="<?php echo route('pesanan.lead',['action'=>'update']);?>" method="post" autocomplete="off">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
    <input type = "hidden" name = "id" value="<?php echo $data->id;?>">
        <div class="form-row">
            
            <div class="col-md-6 mb-3">
               
                 <label for="">Jumlah Lead/Chat</label>
                 <input type="text" class="form-control form-control-lg" name="chat" value="<?php echo $data->chat;?>" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal awal</small>
                  
            </div>

            <div class="col-md-6 mb3">
                 <label for="">Jumlah Konsumen Transfer/Closing</label>
                 <input type="text" class="form-control form-control-lg" name="closing" value="<?php echo $data->closing;?>" />
                 <small id="helpId" class="form-text text-muted">Pilih tanggal akhir</small>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                  <label for="catatan">Catatan Khusus</label>
                  <textarea class="form-control" name="catatan" id="catatan" rows="3"><?php echo $data->catatan;?></textarea>
                </div>
            </div>

            

            <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-warning btn-lg btn-block border-dark">Submit</button>
            </div>
        </div>
    
    </form>
                    
    </div>
    </main>
  
@include('layouts.footer')