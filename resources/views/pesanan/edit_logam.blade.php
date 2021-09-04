@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-gem"></i> Edit Logam <?php echo $data->id;?></h1>
          <p>Sebelum mengubah logam, perlu diperhatikan bahwa harga cincin akan mengikuti  harga logam efektif hari ini.</p>
        </div>
      </div>
    <div class="tile">
@if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
           <form method="post" action="<?php echo route('pesanan.edit.logam');?>">
           <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <input type = "hidden" name = "id" value = "<?php echo $data->id; ?>">
            <input type = "hidden" name = "bahanpria_old" value = "<?php echo $data->bahanpria; ?>">
            <input type = "hidden" name = "bahanwanita_old" value = "<?php echo $data->bahanwanita; ?>">
            <div class="form-row">
                <div class="col-md-6 col-sm-12 mb-3">
                    
                      <label for="bpria">Bahan Cincin Pria</label>
                      <select class="form-control form-control-lg" name="bpria" id="bahanpria" <?php if (empty($data->bahanpria)) echo 'disabled';?>>
                      <option value="" selected="selected">Pilih</option>
                        <?php 
                            foreach ($namalogam as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>|<?php echo $title;?>" <?php if (old('bahanpria',$data->bahanpria) == $id){echo 'selected="selected"';};?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                    
                    </div>

                   

                <div class="col-md-6 col-sm-12 mb-3">
                  
                      <label for="bpria">Bahan Cincin Wanita</label>
                      <select class="form-control form-control-lg" name="bwanita" id="bahanwanita" <?php if (empty($data->bahanwanita)) echo 'disabled';?>>
                        <option value="" selected="selected">Pilih</option>
                        <?php 
                            foreach ($namalogam as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>|<?php echo $title;?>" <?php if (old('bahanwanita',$data->bahanwanita) == $id){echo 'selected="selected"';};?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>

                   
                    </div>

                    
            </div>
            <button type="submit" class="btn btn-warning btn-lg btn-block border-dark">Update</button>
           </form>
    </div>
    </main>
  
@include('layouts.footer')