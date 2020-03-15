@include('layouts.header');
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Transaksi Cash</h1>
          <p>Pada halaman ini, kamu bisa menambah data transaksi cash</p>
        </div>
      </div>

      <div class="tile">
       <form method="post" action="<?php echo route('penting.insert');?>" autocomplete="off">
       <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
       <input type = "hidden" name = "pesanan_id" value = "<?php echo $pesanan_id; ?>">

       <div class="card">
        <div class="card-header">Data Komplain dan Masalah No. order <?php echo $pesanan_id;?></div>
            <div class="card-body">
            <div class="form-row">

        
            <div class="col-md-12 mb-3">
            <div class="form-group">
              <label for="catatan">Informasi orderan</label>
              <p class="form-text text-muted">
                  Silahkan tuliskan secara lengkap dan detail informasi mengenai orderan, keluhan, masalah dsb pada formulir dibawah ini. Informasi ini nanti akan ditindak lanjuti oleh bagian produksi
              </p>
              <textarea id="editor" class="form-control form-control-lg" name="catatan" id="catatan" rows="10"></textarea>

              
              
            </div>
            
            </div>
            
            </div>

            <button type="submit" class="btn btn-lg btn-block">Simpan</button>

            </div>
        </div>

       </form>
      </div>

     
    </main>
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
  var quill = new Quill('#editor2', {
  modules: {
    toolbar: [
      [{ header: [1, 2, false] }],
      ['bold', 'italic', 'underline'],
      ['image']
    ]
  },
  placeholder: 'Compose an epic...',
  theme: 'snow'  // or 'bubble'
});
</script>
@include('layouts.footer');