@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Zavira Jewelry Exclusive</h1>
          <p>Tambah paket penjualan zavira jewelry exclusive</p>
        </div>
      </div>

      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <?php
            if (!empty($caption)){
                
                echo 'Kode '.$caption['kode_paket'].'<br /><br />';
                
                if (!empty($caption['caption_logam_pria'])){
                    echo 'Cincin pria dibuat dari '.$caption['caption_logam_pria'].' dengan berat estimasi '.$caption['caption_berat_logam_pria'].'gr<br />';
                }
                if (!empty($caption['caption_logam_wanita'])){
                    echo 'Cincin wanita dibuat dari '.$caption['caption_logam_wanita'].' dengan berat estimasi '.$caption['caption_berat_logam_wanita'].'gr<br />';
                }

                echo '<br />Harga '.rupiah($caption['harga_paket']).'<br />';
                echo '<br />Sudah termasuk<br />
                - Kotak cincin exclusive yang terbuat dari kayu jati belanda <br />
                - Ongkos kirim ke seluruh Indonesia (free ongkir)<br />
                - Ukir nama pasangan<br />
                - Sertifikat keaslian dan garansi penuh<br />';

                echo '<br /><br />';
                echo 'Cara Order<br />';
                echo ''
                echo '#'.$caption['kode_paket'].' #zavirajewelry #cincinkawin #cincinnikah #paketcincinkawin';
                if (!empty($caption['caption_logam_pria']))
                    echo ' #'.hastag($caption['caption_logam_pria']);
                
                if (!empty($caption['caption_logam_wanita']))
                    echo ' #'.hastag($caption['caption_logam_wanita']);

            }
        ?>
      </div>
    </main>
@include('layouts.footer');