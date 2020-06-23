@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1>Edit Susut Logam</h1>
          <p>Pada halaman ini kamu melihat seluruh pengguna sistem</p>
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
        <form method="post" action="<?php echo route('susut.edit');?>">
                <input type="hidden" value="<?php echo $data->id;?>" name="idx" />
                    @csrf
                    <div class="form-row mb-3">
                      <div class="col-md-12">
                        <label for="">Masukkan No Order</label>
                        <input readonly value="<?php echo $data->pesanan_id;?>" type="number" class="form-control form-control-lg" name="id" id="id" required/>
                        <small id="helpId" class="form-text text-muted">Masukkan no orderan</small>
                      </div>
                      
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-6 col-sm-6">
                            <label for="">Berat Cincin Pria</label>
                            <input value="<?php echo $data->pria;?>" type="text" class="form-control form-control-lg" name="pria"  />
                            <small id="helpId" class="form-text text-muted">(gunakan tanda titik => 3.9)</small>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label for="">Berat Cincin Wanita</label>
                            <input value="<?php echo $data->wanita;?>" type="text" class="form-control form-control-lg" name="wanita" />
                            <small id="helpId" class="form-text text-muted">(gunakan tanda titik => 3.9)</small>
                        </div>
                    </div>

                    <!--<div class="form-row mb-3">
                        <div class="col-md-12">
                           
                              <label for="">Pilih asal cincin</label>
                              <select class="form-control form-control-lg" name="status">
                                <option <?php if ($data->status == 'dari pengrajin') echo 'selected="selected"';?> value="dari pengrajin">Dari pengrajin</option>
                                <option <?php if ($data->status == 'dari bagian lapis') echo 'selected="selected"';?> value="dari bagian lapis">Dari bagian lapis</option>
                                <option <?php if ($data->status == 'dari pengrajin (reparasi)') echo 'selected="selected"';?> value="dari pengrajin (reparasi)">Dari pengrajin (Reparasi)</option>
                                <option <?php if ($data->status == 'dari bagian lapis (reparasi)') echo 'selected="selected"';?> value="dari bagian lapis (reparasi)">Dari bagian lapis(Reparasi)</option>
                              </select>
                           
                        </div>
                    </div> -->

                    <button type="submit" class="btn btn-warning btn-lg btn-block">Update</button>
                </form>
      </div>

 
    </main>

@include('layouts.footer');