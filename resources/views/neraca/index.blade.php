@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-wallet"></i> Neraca</h1>
          <p>Keluar Masuk Uang</p>
        </div>
      </div>

      <div class="container mb-5 mt-5">
            <form method="post" action="<?php echo route('neraca.index');?>">
             <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Pilih Bulan</label>
                        <select class="form-control form-control-lg" name="bulan">
                            <option value="1" <?php if ($currentMonth == '1') echo 'selected="selected"';?>>Januari</option>
                            <option value="2" <?php if ($currentMonth == '2') echo 'selected="selected"';?>>Febuari</option>
                            <option value="3" <?php if ($currentMonth == '3') echo 'selected="selected"';?>>Maret</option>
                            <option value="4" <?php if ($currentMonth == '4') echo 'selected="selected"';?>>April</option>
                            <option value="5" <?php if ($currentMonth == '5') echo 'selected="selected"';?>>Mei</option>
                            <option value="6" <?php if ($currentMonth == '6') echo 'selected="selected"';?>>Juni</option>
                            <option value="7" <?php if ($currentMonth == '7') echo 'selected="selected"';?>>Juli</option>
                            <option value="8" <?php if ($currentMonth == '8') echo 'selected="selected"';?>>Agustus</option>
                            <option value="9" <?php if ($currentMonth == '9') echo 'selected="selected"';?>>September</option>
                            <option value="10" <?php if ($currentMonth == '10') echo 'selected="selected"';?>>Oktober</option>
                            <option value="11" <?php if ($currentMonth == '11') echo 'selected="selected"';?>>November</option>
                            <option value="12" <?php if ($currentMonth == '12') echo 'selected="selected"';?>>Desember</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <?php 
                            $tahun_awal = 2020;
                            $tahun_sekarang = date('Y');
                        ?>
                        <label>Pilih Tahun</label>
                        <select name="tahun" class="form-control form-control-lg">
                            <?php
                                for ($tahun_awal;$tahun_awal<=$tahun_sekarang;$tahun_awal++){
                                    ?>
                                         <option value="<?php echo $tahun_awal;?>" <?php if ($tahun_awal == $currentYear) echo 'selected="selected"';?>><?php echo $tahun_awal;?></option>
                                    <?php
                                }   
                                ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-warning border-dark btn-lg btn-block">Submit</button>
                    </div>
                </div>
                
            </form>
        </div>



      <div class="tile">
        <a class="btn btn-warning mb-3 border-dark" href="<?php echo route('neraca.insert');?>">Tambah</a>
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <table class="table">
            <tr>
                <td>No.</td>
                <td>Tanggal</td>
                <td>Keterangan</td>
                <td>No. Order</td>
                <td>No. Pembukuan</td>
                <td>Penanggung Jawab</td>
                <td>Masuk</td>
                <td>Keluar</td>
                <td>Option</td>
            </tr>
        <?php
            $pemasukan = 0;
            $pengeluaran = 0;
            $n = 1;
            foreach ($data as $item){
                ?>
                <tr>
                    <td><?php echo $n;?>. </td>
                    <td><?php echo date('d M Y', strtotime($item->created_at));?></td>
                    <td><?php echo $item->keterangan;?></td>
                    <td><?php echo $item->pesanan_id;?></td>
                    <td><?php echo $item->pembukuan_id;?></td>
                    <td><?php echo $item->user->name;?></td>
                    <td><?php if ($item->status == 1) {
                         echo rupiah($item->nominal);
                         $pemasukan = (int)$pemasukan + (int)$item->nominal;  
                    }
                         else echo '-';?></td>
                    <td><?php if ($item->status == 0){
                        echo rupiah($item->nominal);
                        $pengeluaran = (int)$pengeluaran + (int)$item->nominal; 
                    } else echo '-';?></td>
                    <td>
                    
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="<?php echo route('neraca.hapus',['id'=>$item->id]); ?>">Hapus</a>
                        <a class="dropdown-item" href="<?php echo route('neraca.edit',['id'=>$item->id]); ?>">Edit</a>
                        </div>
                    </div>
                    
                    </td>
                </tr>
                <?php
                $n++;
            }
        ?>
            <tr>
                <td colspan="6">Summary</td>
                <td><?php echo rupiah($pemasukan);?></td>
                <td><?php echo rupiah($pengeluaran);?></td>
                <td><strong><?php echo rupiah( (int)$pemasukan - (int)$pengeluaran);?></strong></td>
            </tr>
        </table>
      </div>
    </main>
@include('layouts.footer');