@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Update Finising</h1>
          <p>Pada halaman ini, kamu bisa mengupdate status finising produksi</p>
        </div>
      </div>
    <div class="tile">

    <form action="<?php echo route('pesanan.finising');?>" method="post">
    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
        <div class="form-group">
          <label for="ids">Masukkan No Order</label>
          <input type="text" class="form-control form-control-lg" name="ids" id="ids" />
          <p>Pisahkan dengan tanda bintang ( * ) untuk setiap no order</p>
          <div class="row">
            <div class="col-md-6">
            
            <div class="card border-success">
                <div class="card-header bg-success text-white">Pilihan 1 (pertama)</div>
                <div class="card-body">
                  <p>Pilih nomor 1 (box warna hijau) jika :</p>
                  <ol>
                    <li>Pak Bejo atau istrinya atau karyawan atau dari pengrajin lain datang ke showroom untuk memberikan hasil pekerjaannya</li>
                    <li>Cincin/orderan reparasi yang <u><b>SUDAH SELESAI</b></u> dikerjakan oleh pak bejo/pengrajin lainnya</li>
                  </ol>
                  <p>Untuk kemudian cincin/orderan tersebut <u><b>DITERUSKAN</b></u> kepada mas wahyudi atau bagian lapis lainnya. Cincin keluar dari showroom untuk dilapis</p>
                  
                  <div class="form-check">
                  <input type="radio" value="1" class="form-check-input" name="tipe_finising" required /> Pilih disini
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-6">
            
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">Pilihan 2 (kedua)</div>
                <div class="card-body">
                    <p>Pilih nomor 2 (box warna kuning) jika : </p>
                    <ol>
                      <li>Indi, Nita atau Bimo atau karyawan lainnya atau mas yanto atau mas wahyudi datang ke showroom membawa cincin yang <u><b>SUDAH SELESAI</b></u> difinising (dilapis)</li>
                      <li>Termasuk orderan reparasi, bikin ulang dan ngeropos</li>
                      <li>Cincin dari mas yanto yang SUDAH TERLAPIS</li>
                    </ol>
                    <p>Artinya cincin atau orderan sudah kembali lagi ke showroom</p>
                    <div class="form-check">
                      <input type="radio" value="2" class="form-check-input" name="tipe_finising" required /> Pilih disini
                    </div>
                </div>
              </div>

            </div>
          </div>
        
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Update Finising</button>
    </form>
                    
    </div>
    </main>
  
@include('layouts.footer')