@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Edit Order</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
      <form action="<?php echo route('editing');?>" method="post" enctype="multipart/form-data" autocomplete="off">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input type = "hidden" name = "id" value = "<?php echo $data[0]->id; ?>">
      <input type = "hidden" name = "gbr" value = "<?php echo $data[0]->gambar; ?>">
      <input type = "hidden" name = "bahanpria_old" value = "<?php echo $data[0]->bahanpria; ?>">
      <input type = "hidden" name = "bahanwanita_old" value = "<?php echo $data[0]->bahanwanita; ?>">
        <div class="card border-warning">
        <div class="card-header bg-warning text-dark">Data Pengiriman</div>
            <div class="card-body">
            <div class="form-row">
            <div class="col-md-4 mb-3">
            <label for="validationDefault03">Nama Pemesan</label>
            <input type="text" value="<?php echo old('nama',$data[0]->nama);?>" name="nama" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
            <label for="validationDefault04">No. HP</label>
            <input type="text" value="<?php echo $data[0]->nohp;?>" name="nohp" class="form-control" required>
            </div>
            
            <div class="col-md-4 mb-3">
            <label for="validationDefault05">Email</label>
            <input type="text" name="email" value="<?php echo $data[0]->email;?>" class="form-control" />
            </div>

             <div class="col-md-4 mb-3">
                <label for="validationDefault05">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control" value="<?php echo $data[0]->kecamatan;?>">
                </div>

                 <div class="col-md-8 mb-3">
                <label for="alamat">Alamat Pengiriman</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="4" required><?php echo $data[0]->alamat;?></textarea>
                </div>

            </div>
            <!-- form-row--->        
            

            <div class="form-row">
                <div class="col-md-3 mb-3">
                <label for="validationDefault03">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin">
                    <option value="1" <?php if ($data[0]->jenis_kelamin==1) echo 'selected="selected"';?>>Pria</option>
                    <option value="2" <?php if ($data[0]->jenis_kelamin==2) echo 'selected="selected"';?>>Wanita</option>
                </select>
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Akun Instagram/Twitter/Facebook</label>
                <input type="text" name="social_media"  class="form-control" value="<?php echo $data[0]->social_media;?>" />
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Tanggal Lahir</label>
                <input type="text" name="tgl_lahir" id="date"  class="form-control" value="<?php echo $data[0]->tgl_lahir;?>" />
                </div>

                <div class="col-md-3 mb-3">
                <label for="validationDefault04">Tahu Zavira Dari Mana</label>
                <input type="text" name="tahu_dari"  class="form-control" value="<?php echo $data[0]->tahu_dari;?>" />
                </div>

            </div>

            </div>

            

        </div>
        <hr />

       

        <div class="card mb-3 border-warning">
            <div class="card-header bg-warning text-dark">Model Cincin</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                          <label for="kodecincin">Kode Cincin</label>
                          <input required type="text" value="<?php echo old('kodecincin',$data[0]->kodecincin);?>" class="form-control" name="kodecincin" id="kodecincin" aria-describedby="kodecincin" placeholder="">
                          <small id="kodecincin" class="form-text text-muted">Masukkan kode cincin, jika tidak tersedia tuliskan custom + nama konsumen</small>

                          <label for="kodecincin">Jika banyak gambar, tempel URL disini</label>
                          <textarea rows="3" class="form-control" name="gambargambar"><?php echo old('gambargambar',$data[0]->gambargambar);?></textarea>
                          <input type="hidden" name="gambargambarhidden" value="<?php echo $data[0]->gambargambar;?>" />
                          <small id="kodecincin" class="form-text text-muted">Silahkan upload gambar-gambar cincin <a href="https://imgur.com/upload" target="_blank">disini</a></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                    <label for="gambar">Upload Gambar</label>
                    <input type="file" class="form-control-file" name="gambar" id="gambar" placeholder="" aria-describedby="gambar" multiple>
                    <small id="gambar" class="form-text text-muted">Upload gambar cincin/model cincin</small> 
                    </div>

                    <div class="col-md-4 mb-3">
                    <?php 
                    if (!empty($data[0]->gambar)){
                        ?>
                            <img src="<?php echo $data[0]->gambar;?>" alt="" class="img-fluid"  />
                        <?php
                    }

                    if (!empty($data[0]->gambargambar)){
                        $gambar = explode(',',$data[0]->gambargambar);
                        foreach($gambar as $gbr){
                            ?>
                            <img src="<?php echo $gbr;?>" alt="" class="img-fluid"  />
                            <?php
                        }
                        
                    }
                    ?>

                    <label for="alamat">Finising/Keterangan</label>
                    <textarea class="form-control editable  medium-editor-textarea" name="keterangan" id="keterangan" rows="6"><?php echo old('keterangan',$data[0]->keterangan);?></textarea><br />
                    <input type="checkbox" value="1" name="siap_cetak" <?php if ($data[0]->siap_cetak == 1) echo 'checked="checked"';?>/> Centang untuk menandakan orderan ini siap cetak<br />
                    <input type="checkbox" value="1" name="kirim_ke_pengrajin" <?php if ($data[0]->kirim_ke_pengrajin == 1) echo 'checked="checked"';?>/> 
                    <?php if ($data[0]->kirim_ke_pengrajin == 1){
                        echo 'Orderan ini sudah dikirim ke pengrajin';
                    }else{
                        echo 'Kirim pesanan ini ke pengrajin langsung (<a href="#" data-toggle="modal" data-target="#exampleModalLong" onclick="preview();">Preview</a>)';
                    }
                    ?>

                    </div>

                </div>
            </div>
        </div>

       <div class="card mb-3 border-dark">
       <div class="card-header bg-dark text-white">Detail Cincin Pria</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Ukuran Cincin Pria</label>
                    <input type="text" value="<?php echo old('ukuranpria',$data[0]->ukuranpria);?>" name="upria" class="form-control" >
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Grafir Pria</label>
                    <input type="text" name="gpria" value="<?php echo old('grafirpria',$data[0]->grafirpria);?>" class="form-control" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <div class="form-group">
                      <label for="bpria">Bahan</label>
                      <select class="form-control" name="bpria" id="bahanpria" onchange="disable_silver('PRIA')">
                        <option value="0" selected="selected">Pilih logam</option>
                        <?php 
                            foreach ($namalogam as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>|<?php echo $title;?>" <?php if (old('bahanpria',$data[0]->bahanpria) == $id){echo 'selected="selected"';};?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>

                       <!--<label>Pilih finising perak (di Gunawan)</label>
                      <select class="form-control" name="biaya_lapis_perak_pria" id="lapis_finising_perak_pria" disabled="disabled">
                        <option value="0" selected="selected">Pilih jenis finising khusus cincin perak</option>
                        <option value="30000">Putih glossy</option>
                        <option value="30000">Putih doff</option>
                        <option value="10000">Kuning glossy</option>
                        <option value="10000">Rose gold glossy</option>
                        <option value="30000">Hitam glossy</option>
                        <option value="35000">Hitam Doff</option>
                        <option value="40000">Hitam kombinasi</option>
                        <option value="35000">Kombinasi putih dan kuning glossy</option>
                        <option value="35000">Kombinasi rose gold dan putih glossy</option>
                        <option value="40000">Doff Kombinasi kuning dan putih</option>
                        <option value="40000">Doff Kombinasi putih dan rose gold</option>
                        <option value="25000">Doff kuning</option>
                        <option value="25000">Doff rose gold</option>
                      </select> -->
                    </div>
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Berat maksimal</label>
                    <input type="text" id="berat_max_pria" name="produksi_beratpria" value="<?php echo old('produksi_beratpria',$data[0]->produksi_beratpria);?>" class="form-control" >
                    <small id="gambar" class="form-text text-muted">Diisi untuk order non perak. Berat maksimal, contoh 4</small> 
                    </div>

                </div>
                <!-- form-row--->
            </div>
        </div>

        <div class="card mb-3 border-info">
        <div class="card-header bg-info text-white">Cincin Wanita</div> 
            <div class="card-body"> 
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Ukuran Cincin Wanita</label>
                    <input type="text" name="uwanita" value="<?php echo old('ukuranwanita',$data[0]->ukuranwanita);?>" class="form-control" >
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Grafir Wanita</label>
                    <input type="text" name="gwanita" value="<?php echo old('grafirwanita',$data[0]->grafirwanita);?>" class="form-control" >
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Bahan</label>
                    <select class="form-control" name="bwanita" id="bahanwanita" onchange="disable_silver('WANITA')">
                        <option value="0" selected="selected">Pilih logam</option>
                        <?php 
                            foreach ($namalogam as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>|<?php echo $title;?>" <?php if (old('bahanwanita',$data[0]->bahanwanita) == $id){echo 'selected="selected"';};?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>

                      <!--<label>Pilih finising perak (di Gunawan)</label>
                      <select class="form-control" name="biaya_lapis_perak_wanita" id="lapis_finising_perak_wanita" disabled="disabled">
                        <option value="0" selected="selected">Pilih jenis finising khusus cincin perak</option>
                        <option value="30000">Putih glossy</option>
                        <option value="30000">Putih doff</option>
                        <option value="10000">Kuning glossy</option>
                        <option value="10000">Rose gold glossy</option>
                        <option value="30000">Hitam glossy</option>
                        <option value="35000">Hitam Doff</option>
                        <option value="40000">Hitam kombinasi</option>
                        <option value="35000">Kombinasi putih dan kuning glossy</option>
                        <option value="35000">Kombinasi rose gold dan putih glossy</option>
                        <option value="40000">Doff Kombinasi kuning dan putih</option>
                        <option value="40000">Doff Kombinasi putih dan rose gold</option>
                        <option value="25000">Doff kuning</option>
                        <option value="25000">Doff rose gold</option>
                      </select>
-->
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Berat maksimal</label>
                    <input type="text" id="berat_max_wanita" name="produksi_beratwanita" value="<?php echo old('produksi_beratwanita',$data[0]->produksi_beratwanita);?>" class="form-control" >
                    <small id="gambar" class="form-text text-muted">Diisi untuk order non perak. Berat maksimal, contoh 4</small> 
                    </div>

                </div>
                <!-- form-row--->
            </div>
        </div>

        <div class="card mb-3 border-dark">
        <div class="card-header bg-dark text-white">Pengaturan Orderan</div>
        <div class="card-body">
            <div class="form-row">
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault03">Tanggal Masuk</label>
                    <input type="text" name="tmasuk" value="<?php echo old('tglmasuk',$data[0]->tglmasuk);?>" id="date" class="form-control" >
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault04">Tanggal Selesai</label>
                    <input type="text" name="tselesai" value="<?php echo old('tglselesai',$data[0]->tglselesai);?>" id="date2" class="form-control" id="datepicker" />
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Deadline Pengrajin</label>
                    <input type="text" name="tdeadline" value="<?php echo old('deadline',$data[0]->deadline);?>" id="date3" class="form-control" >
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Pengrajin</label>
                    <select class="form-control" name="pengrajin_id" id="pengrajin_id" required>
                        <?php 
                            foreach ($pengrajin as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if (old('pengrajin_id',$data[0]->pengrajin_id) == $id){echo 'selected="selected"';};?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-3 mb-3">
                    <label for="validationDefault05">Asal Orderan</label>
                    <select class="form-control" name="asal" required>
                    <?php 
                            foreach ($asal as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if (old('asal_id',$data[0]->asal_id) == $id){echo 'selected="selected"';};?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                    <label for="alamat">Urgent?</label>
                    <select class="form-control" name="urgent">
                        <option value="0" <?php if (old('urgent',$data[0]->urgent) == 0){echo 'selected="selected"';};?>>Tidak</option>
                        <option value="1" <?php if (old('urgent',$data[0]->urgent) == 1){echo 'selected="selected"';};?>>Urget</option>
                      </select>
                    </div>

                    <div class="col-md-6 mb-3">
                    <label for="validationDefault05">Grafir kotak kayu</label>
                    <textarea class="form-control" name="kotakcincinkayu" id="kotakcincinkayu" rows="3"><?php echo old('kotakcincinkayu');?><?php echo $data[0]->free_woodbox;?></textarea>
                    <small class="text-muted">Isi kan JIKA termasuk free kotak kayu/akrilik</small>
                    </div>

                </div>
                <!-- form-row--->
        </div>
        </div>

        <div class="card mb-3">
        <div class="card-header">Pembayaran</div>
        <div class="card-body">
            <div class="form-row">
                    <div class="col mb-3">
                    <label for="validationDefault03">Tujuan Rekening</label>
                    <select name="rekening" class="form-control" required>
                        <option value="BCA" <?php if ($data[0]->rekening == 'BCA') echo 'selected="selected"';?>>BCA</option>
                        <option value="MANDIRI" <?php if ($data[0]->rekening == 'MANDIRI') echo 'selected="selected"';?>>Mandiri</option>
                        <option value="BNI" <?php if ($data[0]->rekening == 'BNI') echo 'selected="selected"';?>>BNI</option>
                        <option value="BRI" <?php if ($data[0]->rekening == 'BRI') echo 'selected="selected"';?>>BRI</option>
                        <option value="NIAGA" <?php if ($data[0]->rekening == 'NIAGA') echo 'selected="selected"';?>>NIAGA</option>
                        <option value="EDC-BCA" <?php if ($data[0]->rekening == 'EDC-BCA') echo 'selected="selected"';?>>EDC-BCA</option>
                        <option value="EDC-BNI" <?php if ($data[0]->rekening == 'EDC-BNI') echo 'selected="selected"';?>>EDC-BNI</option>
                        <option value="CASH" <?php if ($data[0]->rekening == 'CASH') echo 'selected="selected"';?>>CASH</option>
                    </select>
                    </div>

                    <div class="col mb-3">
                    <label for="validationDefault04">Harga Barang</label>
                    <input type="text" name="hargabarang" value="<?php echo old('hargabarang',$data[0]->hargabarang);?>" class="form-control hargabarang" >
                    </div>
                    
                    <div class="col mb-3">
                    <label for="validationDefault05">Jumlah DP</label>
                    <input type="text" name="dp" value="<?php echo old('dp',$data[0]->dp);?>" class="form-control dp" >
                    </div>

                    <div class="col mb-3">
                    <label for="validationDefault05">Ongkir</label>
                    <input type="text" name="ongkir" value="<?php echo old('ongkir',$data[0]->ongkir);?>" class="form-control ongkir" >
                    </div>

                    <div class="col mb-3">
                    <label for="validationDefault05">Kurir</label>
                    <select class="form-control" name="kurir_id" required>
                    <?php 
                            foreach ($kurir as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if (old('asal_id',$data[0]->kurir_id) == $id){echo 'selected="selected"';}?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                    </div>

                    <div class="col mb-3">
                    <label for="validationDefault05">Promo <span class="badge badge-pill badge-danger">New</span></label>
                    <select class="form-control" name="promo_id" required>
                        <option value="0" selected="selected">Tidak mendapat promo</option>
                        <?php 
                            foreach ($promo as $title=>$id){
                                ?>
                                <option value="<?php echo $id;?>" <?php if (old('asal_id',$data[0]->promo_id) == $id){echo 'selected="selected"';}?>><?php echo $title;?></option>
                                <?php
                            }
                        ?>
                      </select>
                    </div>

                </div>
                <!-- form-row--->
        </div>
        </div>


        <button type="submit" class="btn btn-primary btn-lg btn-block">Simpan</button>
      </form>
      </div>
    </main>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        No order <span id="id"></span><br />
        Pria <span id="upria"></span><br />
        Grafir <span id="gpria"></span><br />
        Bahan <span id="bpria"></span><br />
        <br />
        <br />
        

        Wanita <span id="uwanita"></span><br />
        Grafir <span id="gwanita"></span><br />
        Bahan <span id="bwanita"></span><br />
        <br />
        <br />
        Pengrajin <span id="tukang"></span><br /><br />
        Keterangan 
        <span id="ket"></span><br /><br />

        Deadline <span id="tdeadline"></span>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function preview(){
        document.getElementById('id').innerHTML = document.getElementsByName('id')[0].value;
        document.getElementById('upria').innerHTML = document.getElementsByName('upria')[0].value;
        document.getElementById('gpria').innerHTML = document.getElementsByName('gpria')[0].value;
        
        document.getElementById('uwanita').innerHTML = document.getElementsByName('uwanita')[0].value;
        document.getElementById('gwanita').innerHTML = document.getElementsByName('gwanita')[0].value;
        
        document.getElementById('tdeadline').innerHTML = document.getElementsByName('tdeadline')[0].value;

        document.getElementById('bpria').innerHTML = getSelectedText('bahanpria');
        document.getElementById('bwanita').innerHTML = getSelectedText('bahanwanita');
        document.getElementById('tukang').innerHTML = getSelectedText('pengrajin_id');

        document.getElementById('ket').innerHTML = document.getElementById('keterangan').value;

    }

    function getSelectedText(elementId) {
    var elt = document.getElementById(elementId);

    if (elt.selectedIndex == -1)
        return null;

    return elt.options[elt.selectedIndex].text;
    }

    function disable_silver(blok){
        
        if (blok == 'WANITA'){
            if (document.getElementById("bahanwanita").value == "3|Silver 925"){
                document.getElementById("berat_max_wanita").value = null;
                document.getElementById("berat_max_wanita").disabled = true;
                
                document.getElementById("lapis_finising_perak_wanita").disabled = false;
            }else{
                document.getElementById("lapis_finising_perak_wanita").disabled = true;
                document.getElementById("lapis_finising_perak_wanita").selectedIndex = 0;
            }
        }

        else if (blok == 'PRIA'){
            if (document.getElementById("bahanpria").value == "3|Silver 925"){
                document.getElementById("berat_max_pria").value = null;
                document.getElementById("berat_max_pria").disabled = true;
                
                document.getElementById("lapis_finising_perak_pria").disabled = false;
            }else{
                document.getElementById("lapis_finising_perak_pria").disabled = true;
                document.getElementById("lapis_finising_perak_pria").selectedIndex = 0;

                
            }
        }
    }
</script>

@include('layouts.footer');