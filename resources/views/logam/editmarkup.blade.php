@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Edit Harga Logam</h1>
          <p>Bisa menaikkan atau menurunkan harga</p>
        </div>
      </div>

      

      <div class="tile">

       @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
       <form method="post" action="<?php echo route('logam.em');?>">
       @csrf
            <div class="form-row">
                <div class="col-md-4">
                   
                      <label for="">Jenis Logam</label>
                      <select class="form-control form-control-lg" name="jenis">
                        <option value="" selected>Pilih</option>
                        <option value="emas">Emas</option>
                        <option value="palladium">Palladium</option>
                        <option value="platinum">Platinum</option>
                        <option value="ep">Emas Putih</option>
                      </select>
                    
                </div>

                <div class="col-md-4">
                   
                      <label for="">Jenis Edit</label>
                      <select class="form-control form-control-lg" name="status">
                        <option value="" selected>Pilih</option>
                        <option value="1">Menaikkan Harga</option>
                        <option value="0">Menurunkan Harga</option>
                      </select>
                    
                </div>

                <div class="col-md-4">
                    <label>Nominal</label>
                    <input type="text" name="nominal" class="form-control form-control-lg" />
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-warning border-dark btn-block btn-lg">Submit</button>
                </div>

            </div>

            
       </form>
      </div>
    </main>
@include('layouts.footer');