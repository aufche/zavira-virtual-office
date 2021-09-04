@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Edit Pengguna Sistem</h1>
          <p>Pada halaman ini kamu bisa mengubah data pengguna sistem</p>
        </div>
      </div>

      <div class="tile">
      
      <form method="post" action="<?php echo route('users.edit',['id'=>$data->id]);?>">
      @csrf
      <input type="hidden"  name="id" value="<?php echo $data->id;?>">
        <div class="form-group">
          <div class="row">
            <div class="col-md-4 mb-3">
                <label for="name">Nama Asli</label>
                <input type="text" class="form-control form-control-lg" name="name" id="name" value="<?php echo $data->name;?>">
                <small id="helpId" class="form-text text-muted">Nama asli cs</small>          
          </div>

          <div class="col-md-4 mb-3">
               <label for="nama_cs">Nama Samaran</label>
                <input type="text" class="form-control form-control-lg" name="nama_cs" id="nama_cs" value="<?php echo $data->nama_cs;?>">
                <small id="helpId" class="form-text text-muted">Nama samaran</small>
          </div>

           <div class="col-md-4 mb-3">
               <label for="">WA</label>
                <input type="text" class="form-control form-control-lg" name="wa" id="" value="<?php echo $data->wa;?>">
                <small id="helpId" class="form-text text-muted">No Whatsapp</small>
          </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
                <label for="name">Gaji Pokok</label>
                <input type="text" class="form-control form-control-lg" name="gaji_pokok" id="name" value="<?php echo $data->gaji_pokok;?>">
                <small id="helpId" class="form-text text-muted">Nama asli cs</small>          
          </div>

          <div class="col-md-4 mb-3">
               <label for="nama_cs">Tunjangan</label>
                <input type="text" class="form-control form-control-lg" name="tunjangan" id="nama_cs" value="<?php echo $data->tunjangan;?>">
                <small id="helpId" class="form-text text-muted">Nama samaran</small>
          </div>

           <div class="col-md-4 mb-3">
               <label for="">Uang Makan</label>
                <input type="text" class="form-control form-control-lg" name="uang_makan" id="" value="<?php echo $data->uang_makan;?>">
                
          </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
                <label for="name">Lead</label>
                <input type="text" class="form-control form-control-lg" name="lead" id="name" value="<?php echo $data->lead;?>" readonly>
                <small id="helpId" class="form-text text-muted">Total lead/client yang diterima</small>          
          </div>

          <div class="col-md-4 mb-3">
               <label for="nama_cs">Prioritas</label>
                <input type="text" class="form-control form-control-lg " name="prioritas" id="nama_cs" value="<?php echo $data->prioritas;?>">
                <small id="helpId" class="form-text text-muted">Semakin rendah nilainya, prioritas semakin tinggi. Minimal nilai 1</small>
          </div>

           <div class="col-md-4 mb-3">
               <label for="">Join CS</label>
                
                <select name="join_cs" class="form-control form-control-lg">
                    <option value="1" <?php if ($data->join_cs == 1) echo 'selected="selected"';?>>Ya</option>
                    <option value="0" <?php if ($data->join_cs == 0) echo 'selected="selected"';?>>Tidak</option>
                </select>

                <small id="helpId" class="form-text text-muted">Apakah termasuk CS</small>
          </div>
          </div>

          <div class="row">
            <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Simpan</button>
            </div>
            
          </div>
          

        </div>
        
        
      </form>
        
      </div>

 
    </main>

@include('layouts.footer')