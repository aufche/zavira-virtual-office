@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="far fa-gem"></i> Tambah Pesanan Perhiasan</h1>
          <p>Pada halaman ini, kamu bisa mengubah data orderan</p>
        </div>
      </div>
      <div class="tile">
      
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        
        <form autocomplete="off" action="<?php echo route('perhiasan.add');?>" method="post" enctype="multipart/form-data">
          <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

          <div class="card shadow border-dark">
                        <div class="card-header bg-dark text-white">Data Pengiriman</div>
                            <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                <label for="validationDefault03">Nama Pemesan</label>
                                <input type="text" name="nama" value="<?php echo $data_perhiasan->nama;?>" class="form-control" v-model="nama" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                <label for="validationDefault04">No. HP</label>
                                <input type="text" name="nohp" value="<?php echo $data_perhiasan->nohp;?>" class="form-control" v-model="hp" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                <label for="validationDefault05">Email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo $data_perhiasan->email;?>">
                                </div>

                                <div class="col-md-4 mb-3">
                                <label for="validationDefault05">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" value="<?php echo old('email');?>">
                                </div>

                                <div class="col-md-8 mb-3">
                                <label for="alamat">Alamat Pengiriman</label>
                                <textarea v-model="alamat" class="form-control" name="alamat" id="alamat" rows="4" required><?php echo old('alamat');?></textarea>
                                </div>
                            </div>
                            <!-- form-row--->        
                        

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                <label for="validationDefault03">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin">
                                    <option value="1" selected="selected">Pria</option>
                                    <option value="2">Wanita</option>
                                </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                <label for="validationDefault04">Akun Instagram/Twitter/Facebook</label>
                                <input type="text" name="social_media"  class="form-control" />
                                </div>

                                <div class="col-md-3 mb-3">
                                <label for="validationDefault04">Tanggal Lahir</label>
                                <input type="text" name="tgl_lahir" id="date"  class="form-control" />
                                </div>

                                <div class="col-md-3 mb-3">
                                <label for="validationDefault04">Tahu Zavira Dari Mana</label>
                                <input type="text" name="tahu_dari"  class="form-control" />
                                </div>

                            </div>
                            </div>
                        </div>
                        <hr />

                       

                        <div class="card mb-3 shadow border-dark">
                        <div class="card-header bg-dark text-white">Detail Perhiasan</div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                        <label for="validationDefault03">Jenis Perhiasan</label>
                                        <input type="text" name="jenis_perhiasan" value="<?php echo $data_perhiasan->jenis_perhiasan;?>" class="form-control" v-model="ukuran_pria" placeholder="Gelang, Kalung, Anting atau Liontin" >
                                        </div>

                                        
                                        
                                        <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                        <label for="bpria">Bahan</label>
                                        <select class="form-control mb-3" name="bahan_perhiasan"  required  v-on:change="ubah($event,'bahan_pria')">
                                            <option value="0" selected="selected">Pilih logam</option>
                                            <?php 
                                                foreach ($namalogam as $title=>$id){
                                                    ?>
                                                    <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    
                                        </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                        <label for="validationDefault04">Berat maksimal</label>
                                        <input type="text" v-model="berat" name="berat_produksi_perhiasan" value="<?php echo old('produksi_beratpria');?>" class="form-control" id="berat_max_pria" />
                                        <small id="gambar" class="form-text text-muted">Diisi untuk order non perak. Berat maksimal, contoh 4</small> 
                                        </div>

                                        <div class="col-md-2 mb-3">
                                        <label for="gambar">Gambar Perhiasan</label>
                                        <input type="file" class="form-control-file" name="gambar_perhiasan" placeholder="" aria-describedby="gambar" @change="onFileChange($event,'pria')">
                                        <small id="gambar" class="form-text text-muted">Upload gambar cincin cincin pria</small> 
                                        </div>

                                        <div class="col-md-12 mb-3">
                                        <label for="gambar">Detail Finising</label>
                                          <textarea class="form-control" rows="4" name="finising_perhiasan" v-model="finising_pria"><?php echo $data_perhiasan->finising_perhiasan;?></textarea>
                                        </div>

                                    </div>
                                    <!-- form-row--->
                                </div>
                        </div>

                        
                        <div class="card mb-3 shadow border-dark">
                        <div class="card-header bg-dark text-white">Pengaturan Orderan</div>
                        <div class="card-body">
                            <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                    <label for="validationDefault03">Tanggal Masuk</label>
                                    <input type="text" name="tmasuk" id="date" value="<?php echo old('tmasuk');?>" class="form-control" >
                                    </div>

                                    <div class="col-md-3 mb-3">
                                    <label for="validationDefault04">Tanggal Selesai</label>
                                    <input  type="text" name="tselesai" id="date2" value="<?php echo old('tselesai');?>" class="form-control" id="datepicker" />
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault05">Deadline Pengrajin</label>
                                    <input  type="text" name="tdeadline" value="<?php echo old('tdeadline');?>" id="date3" class="form-control" >
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault05">Pengrajin</label>
                                    <select class="form-control" name="pengrajin_id" id="pengrajin_id" v-on:change="ubah($event,'pengrajin')" required>
                                        <option value="" selected="selected">Pilih pengrajin</option>
                                        <?php 
                                            foreach ($pengrajin as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>

                                    
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault05">Tempat Lapis / Plated</label>
                                    <select class="form-control" name="plated_id" required v-on:change="ubah($event,'lapis')">
                                        <option value="" selected="selected">Pilih tempat lapis</option>
                                        <?php 
                                            foreach ($plated as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>

                                    
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault05">Asal Orderan</label>
                                    <select class="form-control" name="asal_id" required>
                                        <option value="" selected="selected">Pilih asal orderan</option>
                                        <?php 
                                            foreach ($asal as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                    <label for="alamat">Urgent?</label>
                                    <select class="form-control" name="urgent" id="pengrajin_id">
                                        <option value="0" selected="selected">Tidak</option>
                                        <option value="1">Urgent</option>
                                    </select>
                                    </div>

                                    


                                    <div class="col-md-8 mb-3">
                                    <label for="alamat">Keterangan Tambahan</label>
                                    <textarea v-model="finising" class="form-control" name="keterangan" id="keterangan" rows="3"><?php echo old('keterangan');?></textarea>
                                    </div>

                                    


                                </div>
                                <!-- form-row--->
                        </div>
                        </div>

                        <div class="card mb-3 shadow border-dark">
                        <div class="card-header bg-dark text-white">Pembayaran</div>
                        <div class="card-body">
                            <div class="form-row">
                                    <div class="col mb-3 ">
                                    <label for="validationDefault03">Tujuan Rekening <span class="badge badge-pill badge-warning">Penting</span></label>
                                    <select name="rekening" class="form-control" required v-on:change="ubah($event,'rekening')">
                                        <option value="BCA">BCA</option>
                                        <option value="MANDIRI">Mandiri</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BRI">BRI</option>
                                        <option value="NIAGA">NIAGA</option>
                                        <option value="EDC-BCA">EDC-BCA</option>
                                        <option value="EDC-BNI">EDC-BNI</option>
                                        <option value="CASH">CASH</option>
                                        <option value="SHOPEE">SHOPEE</option>
                                    </select>
                                    <small class="text-muted">Harus dipilih sesuai dengan keadaan sebenarnya</small>
                                    </div>

                                    <div class="col mb-3 ">
                                    <label for="validationDefault04">Harga Barang</label>
                                    <input type="text" name="hargabarang" value="<?php echo old('hargabarang');?>" class="form-control hargabarang" >
                                    </div>
                                    
                                    <div class="col mb-3 ">
                                    <label for="validationDefault05">Jumlah DP/Lunas</label>
                                    <input type="text" name="dp" class="form-control dp" value="<?php echo old('dp');?>" required v-model="dp">
                                    <input type="checkbox" name="is_lunas" /> Centang jika lunas
                                    </div>

                                    <div class="col mb-3 ">
                                    <label for="validationDefault05">Ongkir</label>
                                    <input type="text" name="ongkir" class="form-control ongkir" value="<?php echo old('ongkir');?>" >
                                    </div>

                                    <div class="col mb-3">
                                    <label for="validationDefault05">Kurir</label>
                                    <select class="form-control" name="kurir_id" required v-on:change="ubah($event,'kurir')">
                                        <option value="" selected="selected">Pilih kurir</option>
                                        <?php 
                                            foreach ($kurir as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>

                                    <div class="col mb-3">
                                    <label for="validationDefault05">Promo <span class="badge badge-pill badge-danger">New</span></label>
                                    <select class="form-control" name="promo_id" required v-on:change="ubah($event,'promo')">
                                        <option value="0" selected="selected">Tidak mendapat promo</option>
                                        <?php 
                                            foreach ($promo as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
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
@include('layouts.footer')
