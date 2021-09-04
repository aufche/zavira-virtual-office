@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Bukti Transfer Logam</h1>
          <p>Pada halaman ini kamu bisa menambahkan bukti transfer logam (ke pak bejo)</p>
        </div>
      </div>

      <div class="tile">
        <form method="post" action="<?php echo route('bukti.insert.post');?>">
        @csrf
             <div class="form-group mb-2">
              <label>Identitas Transfer</label>
              <input type="text" class="form-control form-control-lg" name="identitas" />
              <small id="helpId" class="form-text text-muted">Identitas adalah kode unik yang dimiliki sekelompok nomor orderan (ID)</small>
            </div>

            <div class="form-group mb-2">
              <label>Nominal</label>
              <input type="text" class="form-control form-control-lg" name="nominal" />
              <small id="helpId" class="form-text text-muted">Nominal</small>
            </div>

              <div class="form-group mb-4">
                <label for="">URL Bukti Screenshot</label>
                <textarea class="form-control form-control-lg" name="screenshot" id="" rows="3"></textarea>
              </div>

              <button type="submit" class="btn btn-warning btn-block btn-lg border border-dark">Submit</button>

            
        </form>
      </div>

 
    </main>

@include('layouts.footer')