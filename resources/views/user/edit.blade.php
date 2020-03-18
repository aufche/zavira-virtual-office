@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Edit Pengguna Sistem</h1>
          <p>Pada halaman ini kamu bisa mengubah data pengguna sistem</p>
        </div>
      </div>

      <div class="tile">
      
      <form method="post" action="<?php echo route('users.edit');?>">
        <div class="form-group">
          <label for="name">Nama Asli</label>
          <input type="text" class="form-control" name="name" id="name" value="<?php echo $data->name;?>">
          <small id="helpId" class="form-text text-muted">Nama asli cs</small>
        </div>
        <div class="form-group">
          <label for="nama_cs">Nama Samaran</label>
          <input type="text" class="form-control" name="nama_cs" id="nama_cs" aria-describedby="helpId" placeholder="">
          <small id="helpId" class="form-text text-muted">Nama samaran</small>
        </div>
        <div class="form-group">
          <label for="">WA</label>
          <input type="text" class="form-control" name="whatsapp" id="" aria-describedby="helpId" placeholder="">
          <small id="helpId" class="form-text text-muted">No Whatsapp</small>
        </div>
      </form>
        
      </div>

 
    </main>

@include('layouts.footer');