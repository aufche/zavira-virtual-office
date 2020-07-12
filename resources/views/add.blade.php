@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Tambah Data Pesanan</h1>
          <p>Pada halaman ini, kamu bisa menambah data orderan</p>
        </div>
      </div>

     <?php
       if (!empty($errors)){
      ?>
      <div class="alert alert-danger">
      <?php
       
            echo $errors->first('kurir_id').'<br />';
            echo $errors->first('asal_id').'<br />';
            echo $errors->first('pengrajin_id').'<br />';
       
      ?>
      </div>
      <?php
      }
      ?>
      
      <div class="tile" id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                <form autocomplete="off" action="<?php echo route('insert');?>" method="post" enctype="multipart/form-data">
                    <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                        <div class="card shadow border-dark">
                        <div class="card-header bg-dark text-white">Data Pengiriman</div>
                            <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                <label for="validationDefault03">Nama Pemesan</label>
                                <input type="text" name="nama" value="<?php echo old('nama');?>" class="form-control" v-model="nama" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                <label for="validationDefault04">No. HP</label>
                                <input type="text" name="nohp" value="<?php echo old('nohp');?>" class="form-control" v-model="hp" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                <label for="validationDefault05">Email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo old('email');?>">
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
                            <div class="card-header bg-dark text-white">Model Cincin</div>
                            <div class="card-body">
                            <p>Jika cincin pria dan wanita sama (dalam 1 gambar) maka cukup upload gambar melalui input di bawah ini</p>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                        <label for="kodecincin">Kode Cincin</label>
                                        <input type="text" value="<?php echo old('kodecincin');?>" class="form-control" name="kodecincin" id="kodecincin" aria-describedby="kodecincin" placeholder="" required>
                                        <small id="kodecincin" class="form-text text-muted">Masukkan kode cincin, jika tidak tersedia tuliskan custom + nama konsumen</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                    <label for="gambar">Upload gambar cincin pria dan wanita dalam 1 file</label>
                                    <input type="file" class="form-control-file" name="gambar" id="gambar" placeholder="" aria-describedby="gambar">
                                    <small id="gambar" class="form-text text-muted">Upload gambar cincin/model cincin</small> 
                                    </div>

                                    <div class="col-md-4 mb-3">
                                    <label for="kodecincin">Jika banyak gambar, tempel URL disini</label>
                                        <textarea rows="3" class="form-control" name="gambargambar"><?php echo old('gambargambar');?></textarea>
                                        <small id="kodecincin" class="form-text text-muted">Silahkan upload gambar-gambar cincin <a href="https://imgur.com/upload" target="_blank">disini</a></small>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <div class="card mb-3 shadow border-dark">
                    <div class="card-header bg-dark text-white">Detail Cincin Pria</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Ukuran Cincin Pria</label>
                                    <input type="text" name="upria" value="<?php echo old('upria');?>" class="form-control" v-model="ukuran_pria" >
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault04">Grafir Pria</label>
                                    <input type="text" name="gpria" value="<?php echo old('gpria');?>" class="form-control" v-model="grafir_pria" >
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                    <label for="bpria">Bahan</label>
                                    <select class="form-control mb-3" name="bpria" id="bpria" required onchange="disable_silver('PRIA')" v-on:change="ubah($event,'bahan_pria')">
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
                                    <input type="text" v-model="berat_pria" name="produksi_beratpria" value="<?php echo old('produksi_beratpria');?>" class="form-control" id="berat_max_pria" />
                                    <small id="gambar" class="form-text text-muted">Diisi untuk order non perak. Berat maksimal, contoh 4</small> 
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="gambar">Gambar Cincin Pria</label>
                                    <input type="file" class="form-control-file" name="gambar_cincin_pria" placeholder="" aria-describedby="gambar">
                                    <small id="gambar" class="form-text text-muted">Upload gambar cincin cincin pria</small> 
                                    </div>

                                </div>
                                <!-- form-row--->
                            </div>
                        </div>

                        <div class="card mb-3 shadow border-info">
                        <div class="card-header bg-info text-white">Cincin Wanita</div> 
                            <div class="card-body"> 
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault03">Ukuran Cincin Wanita</label>
                                    <input type="text" name="uwanita" value="<?php echo old('uwanita');?>" class="form-control" v-model="ukuran_wanita" >
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault04">Grafir Wanita</label>
                                    <input type="text" name="gwanita" value="<?php echo old('gwanita');?>" class="form-control" v-model="grafir_wanita" >
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                    <label for="validationDefault05">Bahan</label>
                                    <select class="form-control mb-3" name="bwanita" id="bwanita" onchange="disable_silver('WANITA')" v-on:change="ubah($event,'bahan_wanita')">
                                        <option value="" selected="selected">Pilih logam</option>
                                        <?php 
                                            foreach ($namalogam as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    

                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault04">Berat maksimal </label>
                                    <input type="text" v-model="berat_wanita" name="produksi_beratwanita" value="<?php echo old('produksi_beratwanita');?>" class="form-control" id="berat_max_wanita" />
                                    <small id="gambar" class="form-text text-muted">Diisi untuk order non perak. Berat maksimal, contoh 4</small> 
                                    </div>

                                    <div class="col-md-2 mb-3">
                                    <label for="gambar">Gambar Cincin Wanita</label>
                                    <input type="file" class="form-control-file" name="gambar_cincin_wanita" placeholder="" aria-describedby="gambar">
                                    <small id="gambar" class="form-text text-muted">Upload gambar cincin cincin wanita</small> 
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
                                    <input type="text" name="tselesai" id="date2" value="<?php echo old('tselesai');?>" class="form-control" id="datepicker" />
                                    </div>
                                    
                                    <div class="col-md-2 mb-3">
                                    <label for="validationDefault05">Deadline Pengrajin</label>
                                    <input type="text" name="tdeadline" value="<?php echo old('tdeadline');?>" id="date3" class="form-control" >
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
                                    <label for="validationDefault05">Tempat Lapis / Plated <span class="badge badge-pill badge-warning">New</span></label>
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

                                    <div class="col-md-2 mb-3">
                                    <label for="alamat">Kelengkapan <span class="badge badge-pill badge-primary">New</span></label>
                                    <select class="form-control" name="stock_id" required>
                                        <option value="" selected="selected">Pilih kelengkapan produk</option>
                                        <?php 
                                            foreach ($stock as $title=>$id){
                                                ?>
                                                <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>


                                    <div class="col-md-3 mb-3">
                                    <label for="alamat">Finising/Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3"><?php echo old('keterangan');?></textarea>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                    <label for="validationDefault05">Grafir kotak kayu</label>
                                    <textarea class="form-control" name="kotakcincinkayu" id="kotakcincinkayu" rows="3"><?php echo old('kotakcincinkayu');?></textarea>
                                    <small class="text-muted">Isi kan JIKA termasuk free kotak kayu/akrilik</small>
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
                                    <label for="validationDefault05">Jumlah DP</label>
                                    <input type="text" name="dp" class="form-control dp" value="<?php echo old('dp');?>" required v-model="dp">
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
                <div class="col-md-3">
                @verbatim
                <h4>Preview Data Orderan</h4>
                    <table class="table">
                        <tr>
                           <td width="20%">Nama</td>
                           <td>{{ nama }}</td>
                        </tr>
                        <tr>
                           <td>No HP</td>
                           <td>{{ hp }}</td>
                        </tr>
                        <tr>
                           <td>Alamat</td>
                           <td>{{ alamat }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:green">Data cincin Pria</td>
                        </tr>
                        <tr>
                           <td>Ukuran</td>
                           <td>{{ ukuran_pria }}</td>
                        </tr>
                        <tr>
                           <td>Grafir</td>
                           <td>{{ grafir_pria }}</td>
                        </tr>
                        <tr>
                           <td>Bahan</td>
                           <td>{{ bahan_pria }}</td>
                        </tr>
                        <tr>
                           <td>Berat Maksimal</td>
                           <td>{{ berat_pria | add_gram}}</td>
                        </tr>

                        <tr>
                            <td colspan="2" style="background-color:pink">Data cincin Wanita</td>
                        </tr>
                        <tr>
                           <td>Ukuran</td>
                           <td>{{ ukuran_wanita }}</td>
                        </tr>
                        <tr>
                           <td>Grafir</td>
                           <td>{{ grafir_wanita }}</td>
                        </tr>
                        <tr>
                           <td>Bahan</td>
                           <td>{{ bahan_wanita }}</td>
                        </tr>
                        <tr>
                           <td>Berat Maksimal</td>
                           <td>{{ berat_wanita | add_gram }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" style="background-color:pink">Detail Pengrajin</td>
                        </tr>
                        <tr>
                           <td>Tanggal Masuk</td>
                           <td>{{ alamat }}</td>
                        </tr>
                        <tr>
                           <td>Tanggal Selesai</td>
                           <td>{{ alamat }}</td>
                        </tr>
                        <tr>
                           <td>Deadline Pengrajin</td>
                           <td>{{ alamat }}</td>
                        </tr>
                        <tr>
                           <td>Pengrajin</td>
                           <td>{{ pengrajin }}</td>
                        </tr>
                        <tr>
                           <td>Plated/Lapis</td>
                           <td>{{ lapis }}</td>
                        </tr>
                        <tr>
                           <td>Finising / Keterangan</td>
                           <td>{{ finising }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" style="background-color:pink">Data Pembayaran</td>
                        </tr>
                        <tr>
                           <td>Rekening</td>
                           <td>{{ rekening }}</td>
                        </tr>
                        <tr>
                           <td>Jumlah DP</td>
                           <td>{{ dp | rp }}</td>
                        </tr>
                        <tr>
                           <td>Kurir</td>
                           <td>{{ kurir }}</td>
                        </tr>
                        <tr>
                           <td>Promo</td>
                           <td>{{ promo }}</td>
                        </tr>
                        


                    </table>
                @endverbatim
                </div>
            </div>
        </div>
      
      </div>
    </main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js" integrity="sha512-QJsj3afWlCpnQ60XzzYE8Jb3IgHIK1BcGZox9rUSmRRq3Ocz9vQ1yR80eX2/b9jfx/UuT5zYWNdrM8Te/eCMhQ==" crossorigin="anonymous"></script>
<script type="text/javascript">
    var app = new Vue({
        el : '#app',
        data :{
           nama:null,
           alamat:null,
           hp:null,
           ukuran_pria:null,
           grafir_pria:null,
           berat_pria:null,
           ukuran_wanita:null,
           grafir_wanita:null,
           berat_wanita:null,
           bahan_wanita:null,
           bahan_pria:null,
           pengrajin:null,
           lapis:null,
           finising:null,
           rekening:null,
           dp:null,
           promo:null,
           kurir:null
        },

        filters: {
            add_gram (value){
                if (!value) return '';
                return value+' gram';
            },
            
            rp(value){
                if (!value) return '';
                return value;

            }
        },
        
        methods: {
            ubah(event,ciduk){
                if (ciduk == 'bahan_wanita') this.bahan_wanita = event.target.options[event.target.options.selectedIndex].text;
                if (ciduk == 'bahan_pria') this.bahan_pria = event.target.options[event.target.options.selectedIndex].text;
                if (ciduk == 'pengrajin') this.pengrajin = event.target.options[event.target.options.selectedIndex].text;
                if (ciduk == 'lapis') this.lapis = event.target.options[event.target.options.selectedIndex].text;
                if (ciduk == 'rekening') this.rekening = event.target.options[event.target.options.selectedIndex].text;
                if (ciduk == 'promo') this.promo = event.target.options[event.target.options.selectedIndex].text;
                if (ciduk == 'kurir') this.kurir = event.target.options[event.target.options.selectedIndex].text;
                
                
            }
        }
    });

    function disable_silver(blok){
        if (blok == 'WANITA'){
            if (document.getElementById("bwanita").value == 3){
                document.getElementById("berat_max_wanita").value = null;
                document.getElementById("berat_max_wanita").disabled = true;
                
                document.getElementById("lapis_finising_perak_wanita").disabled = false;
            }else{
                document.getElementById("lapis_finising_perak_wanita").disabled = true;
                document.getElementById("lapis_finising_perak_wanita").selectedIndex = 0;
            }
        }

        else if (blok == 'PRIA'){
            if (document.getElementById("bpria").value == 3){
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