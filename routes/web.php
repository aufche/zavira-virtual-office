<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/pl/{package?}/{target?}','LogamController@pricelist')->name('logam.pricelist');
Route::get('/ps/{bahan?}','LogamController@pricelist_single')->name('logam.pricelist.single');
Route::get('/harga/{platinum?}','LogamController@harga_logam')->name('logam.hargalogam');
Route::get('/giveaway',function(){
    return view('pemenang');
})->name('giveaway.pemenang');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();


Route::prefix('pesanan')->group(function () {
    Route::any('/stat', 'PesananController@statistik_perbandingan')->name('pesanan.stat')->middleware('auth');
    Route::get('/statistik/{detail?}', 'PesananController@statistik')->name('pesanan.statistik')->middleware('auth');
    Route::get('/loadpesanan', 'HomeController@loadpesanan')->name('pesanan.loadpesanan')->middleware('auth');
    Route::get('/add', 'HomeController@index')->name('input')->middleware('auth');
    Route::post('/insert', 'HomeController@insert')->name('insert');
    Route::get('/edit/{id}', 'HomeController@edit')->name('edit')->middleware('auth');
    Route::post('/editing', 'HomeController@editing')->name('editing');
    Route::get('/semua', 'HomeController@pesanan')->name('semua')->middleware('auth');
    Route::any('/search', 'HomeController@search')->name('search')->middleware('auth');

    Route::get('/filter','PesananController@filter')->name('pesanan.filter')->middleware('auth');

    Route::any('/filtered', 'PesananController@filtered')->name('pesanan.result.filter')->middleware('auth');

    Route::get('/simplefilter','PesananController@simplefilter')->name('pesanan.simple.filter')->middleware('auth');

    Route::any('/sf', 'HomeController@simplefilter')->name('pesanan.result.simple.filter')->middleware('auth');
   
    /*Route::get('/take/{id}/{template}', function($id,$template){
        $data = \App\Pesanan::orderBy('id','desc')->where('id',$id)->with('pengrajin','asal')->get();
        if ($template=='print'){
            return view('take',compact('data'));
        }elseif($template=='ambil'){
            //return view('ambil',compact('data'));

           // $pdf = PDF::loadView('ambil', ['data'=>$data]);
            //return $pdf->download('invoice.pdf');
            

            $x = ['tes'=>'siap'];

            
    
            Mail::send('emails.welcome', $x, function ($message) use($data) {
                
                
                $pdf = PDF::loadView('ambil', ['data'=>$data]);
                
                $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->to('bimo.hery@gmail.com','Konsumen')->subject('Bukti Pembayaran DP dari Zavira Jewelry');
                $message->attachData($pdf->output(), 'filename.pdf');
            });

            return $pdf->download('invoice.pdf');
            
        }
        
    })->name('take')->middleware('auth');
    */
    Route::get('/take/{id}/{template}','HomeController@take')->name('take')->middleware('auth');

    Route::get('/pelunasan/{id}/{re}', function($id,$re){
        
        $data = \App\Pesanan::find($id);
        return view('pelunasanform')
                ->with('data',$data)
                ->with('redirect',$re);

    })->name('pelunasan')->middleware('auth');

    Route::get('/hapus/{id}', 'PesananController@hapus')->name('hapus')->middleware('auth');

    //Route::post('/prosespelunasan', 'PesananController@prosespelunasan')->name('prosespelunasan')->middleware('auth');
    Route::post('/prosespelunasan', 'PesananController@pelunasan')->name('pesanan.pelunasan')->middleware('auth');
    Route::get('/update',function(){
        return view('update');
    })->name('update')->middleware('auth');

    
    Route::get('/finish',function(){
        return view('finish');
    })->name('pesanan.finish')->middleware('auth');

    Route::post('/finising','HomeController@finising')->name('pesanan.finising')->middleware('auth');

    Route::post('/updateform','HomeController@updateform')->name('updateform')->middleware('auth');
    Route::post('/updating','HomeController@updating')->name('updating')->middleware('auth');

    Route::get('/detail/{id}',function($id){
        $data = \App\Pesanan::find($id);
        return view('detail',compact('data'));
    })->name('pesanan.detail')->middleware('auth');

    Route::get('/hitung',function(){
        return view('pesanan.hitung');
    })->name('pesanan.hitung')->middleware('auth');

    Route::post('/proseshitung','HomeController@proseshitung')->name('pesanan.proseshitung')->middleware('auth');

    Route::get('/riwayatperhitungan/{detail?}/{hapus?}',function($detail=null,$hapus=null){
        if ($detail == null && $hapus == null){
            $data = \App\Biayaproduksi::selectRaw('identitas')->groupBy('identitas')->get();
            return view('pesanan.riwayatperhitungan',compact('data'));
        }
        if ($detail != null && $hapus == null){
            $id = [];
            $data = \App\Biayaproduksi::where('identitas','=',$detail)->get();
            foreach ($data as $item){
                array_push($id,$item->pesanan_id);
            }
            $data_pesanan = \App\Pesanan::whereIn('id',$id)->get();
            $harga = \App\Setting::whereIn('kunci',['harga_harian_emas','harga_harian_palladium','harga_harian_platinum'])->orderBy('kunci','asc')->get();
            return view('pesanan.biayaproduksi',compact('data','data_pesanan','harga'));
        }

        if ($detail != null && $hapus != null){
            \App\Biayaproduksi::where('identitas','=',$detail)->delete();
            return redirect()->route('pesanan.riwayat.perhitungan');
            //return view('pesanan.biayaproduksisds',compact('data'));
        }
    })->name('pesanan.riwayat.perhitungan')->middleware('auth');


    Route::get('/generatekupon/{id}','PesananController@generatecoupon')->name('pesanan.kupon')->middleware('auth');

    //Route::get('/export')

    Route::get('/fix','PesananController@fix')->name('pesanan.fix')->middleware('auth');
    Route::any('/sedekah','PesananController@sedekah')->name('pesanan.sedekah')->middleware('auth');

    Route::get('/woodbox',function(){
        return view('pesanan.woodbox');
    })->name('pesanan.woodbox')->middleware('auth');

    Route::post('/woodbox','PesananController@woodbox_add')->name('pesanan.woodbox.add')->middleware('auth');

    Route::any('/buyback','PesananController@buyback')->name('logam.buyback')->middleware('auth');

    

});

Route::prefix('sertifikat')->group(function () {
    Route::get('/create/{id}', 'SertifikatController@sertifikatform')->name('sertifikatform')->middleware('auth');
    Route::post('/insert', 'SertifikatController@prosessertifikat')->name('prosessertifikat');
    Route::get('/print/{id}', 'SertifikatController@printsertifikat')->name('sertifikat.premium')->middleware('auth');

    Route::get('/printsilver/{id}', function($id){
        $data = \App\Pesanan::where('id',$id)->get();
        return view('sertifikat.silver')
            ->with('data',$data);
    })->name('sertifikat.silver')->middleware('auth');

    Route::get('/single/{id}', function($id){
        $data = \App\Pesanan::where('id',$id)->first();
        return view('sertifikat.single')
            ->with('data',$data);
    })->name('sertifikat.single')->middleware('auth');


    Route::get('/', function(){
        $data = \App\Pesanan::where('sertifikat_done','=','2')->orderBy('id','desc')->Simplepaginate(15);
        return view('sertifikat.sertifikat',compact('data'));
    })->name('sertifikat')->middleware('auth');

    Route::get('/belum',function(){
        $data_belum = \App\Pesanan::where('sertifikat_done','=','0')
        ->orWhereNull('sertifikat_done')    
        ->where('ongkos_bikin','>',0)
            ->orderBy('id','desc')->Simplepaginate(15);
        
        return view('sertifikat.belum',compact('data_belum'));

    })->name('sertifikat.belum')->middleware('auth');

    Route::post('/search', 'SertifikatController@searchsertificate')->name('searchsertificate');
});

Route::prefix('reparasi')->group(function () {
    Route::get('/create/{id}', 'ReparasiController@reparasiform')->name('reparasiform')->middleware('auth');
    Route::post('/insert', 'ReparasiController@prosesreparasiform')->name('prosesreparasiform');
    Route::get('/riwayat/{id}', 'ReparasiController@riwayat')->name('riwayat')->middleware('auth');
    Route::get('/cetak/{id}',function($id){
        $data = \App\Reparasi::find($id);
        return view('reparasi.cetak')->with('data',$data);
    })->name('reparasi.cetak')->middleware('auth');

    Route::get('/',function(){
        $data = \App\Reparasi::with('pesanan')->orderBy('id','desc')->Simplepaginate(10);
        return view('reparasi.index',compact('data'));
    })->name('reparasi.index')->middleware('auth');

    Route::get('/delete/{id}','ReparasiController@delete')->name('reparasi.delete')->middleware('auth');
});

Route::prefix('cetak')->group(function () {
    
    Route::get('/dp/{id}', function($id){
        

        $data = \App\Pesanan::find($id);
        return view('buktidp')->with('data',$data);
        //dd($data);
/*
        if (!empty($data->email)){
            $x = ['tes'=>'siap'];
            Mail::send('emails.welcome', $x, function ($message) use($data) {
                
                $pdf = PDF::loadView('buktidp', ['data'=>$data])->setPaper('a4');            
                $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->to($data->email,$data->nama)->subject('Bukti Pembayaran DP dari Zavira Jewelry');
                $message->attachData($pdf->output(), str_slug($data->nama.$data->id.'.pdf'));
            });

            return redirect()->route('semua')->with('status','Lampiran Bukti DP sudah dikirim ke pelanggan');
        }else{
            return redirect()->route('semua')->with('status','Email pelanggan tidak tersedia');
        }
        */
    })->name('buktidp')->middleware('auth');
    
    
   
    Route::get('/amplop/{id}','PesananController@cetakamplop')->name('cetak.amplop')->middleware('auth');
    Route::get('/garansi/{id}','PesananController@garansi')->name('cetak.garansi')->middleware('auth');

});

Route::prefix('setting')->group(function () {
   
    Route::get('/','SettingController@settingform')->name('setting.all')->middleware('auth');

    Route::post('/simpansetting', 'SettingController@simpansetting')->name('setting.save');
});


Route::prefix('logam')->group(function () {
   
    Route::get('/variasilogam',function(){
        return view('logam.variasilogam');
    })->name('logam.add')->middleware('auth');

    Route::post('/simpanvariasilogam', 'LogamController@simpanvariasilogam')->name('logam.save')->middleware('auth');
    
    Route::get('/editvariasilogam/{id}',function($id){
        $data = \App\Namalogam::find($id);
        return view('logam.editvariasilogam',compact('data'));
    
    })->name('logam.edit')->middleware('auth');
    
    Route::post('/editingvariasi', 'LogamController@editingvariasi')->name('logam.edit.save')->middleware('auth');
    
    Route::get('/logam',function(){
        $data = \App\Namalogam::orderBy('title','asc')->get();
        $harga_pokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','harga_pokok_platinum'])->orderBy('kunci','asc')->get();
        return view('logam.logam',compact('data','harga_pokok'));
    })->name('logam.all')->middleware('auth');
    
    Route::get('/dellogam/{id}',function($id){
        $data = \App\Namalogam::where('id',$id)->delete();
        return redirect()->route('logam.all')->with('status','Data berhasil dihapus');
    })->name('logam.del')->middleware('auth');

    Route::get('/kalkulator/{apa?}','LogamController@kalkulator')->name('logam.kalkulator')->middleware('auth');
    


});




Route::prefix('laba')->group(function () {
   
    Route::any('/', 'LabaController@index')->name('laba.semua')->middleware('auth');
    Route::get('/detail/{id}','LabaController@detail')->name('laba.detail')->middleware('auth');
    Route::any('/gaji','LabaController@gaji')->name('gaji')->middleware('auth');
});

Route::prefix('dp')->group(function () {
    Route::get('/','DpController@index')->name('dp.index')->middleware('auth');
    Route::get('/bayar','DpController@bayar')->name('dp.bayar')->middleware('auth');
});




Route::prefix('pembukuan')->group(function () {
   
    Route::get('/', function(){

        $user_id = Auth::user()->id;
        if (\App\Buku::where('hak_akses','like','%'.$user_id.'%')->count() > 1 ){
            //-- 2 keatas, memiliki hak akses ke lebih dari 1 buku
            $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->get();
            //$data = \App\Pembukuan::where('buku_id','=',$buku[0]->id)->where('bulantahun','=',date('F Y'))->get();
            return view('pembukuan.list',compact('buku'));
        }else{
            // 1 buku saja
            $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->first();
            $data = \App\Pembukuan::where('buku_id','=',$buku->id)
                ->where('bulantahun','=',date('F Y'))
                ->get();
            //return view('pembukuan.semua',compact('data'));
            return redirect()->route('pembukuan.detail',['id'=>1]);
        }
    })->name('pembukuan.semua')->middleware('auth');

    Route::get('/detail/{id}/{bulan?}','PembukuanController@detail')->name('pembukuan.detail')->middleware('auth');
    Route::get('/edit/{id}','PembukuanController@edit')->name('pembukuan.edit')->middleware('auth');

    Route::get('/add/{status}', function($status){
        
        $user_id = Auth::user()->id;
        $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->pluck('id','title');
        $jenis_transaksi = $status;
        
        return view('pembukuan.add',compact('buku','jenis_transaksi'));
    })->name('pembukuan.add')->middleware('auth');

    Route::get('/hapus/{id}/{buku}','PembukuanController@hapus')->name('pembukuan.hapus')->middleware('auth');

    Route::get('/transfer',function(){
        $user_id = Auth::user()->id;
        $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->pluck('id','title');

        return view('pembukuan.transfer',compact('buku'));

    })->name('pembukuan.transfer')->middleware('auth');

    Route::post('/insert/{aksi?}','PembukuanController@insert')->name('pembukuan.insert')->middleware('auth');
    Route::post('/transfering','PembukuanController@transfer')->name('pembukuan.transfering')->middleware('auth');

});


//-- order web

Route::prefix('orderweb')->group(function () {
   
    Route::get('/all','OrderController@all')->name('order.all')->middleware('auth');
    Route::post('/search','OrderController@all')->name('order.search')->middleware('auth');

    Route::get('/detail/{id}',function($id){
        
        $data = \App\Orderweb::find($id);
        return view('orderweb.detail',compact('data'));

    })->name('orderweb.detail')->middleware('auth');

    Route::get('/hapus/{id}',function($id){
        
        \App\Orderweb::where('id',$id)->delete();

        return redirect()->route('order.all')->with('status','Data berhasil dihapus');
    })->name('orderweb.hapus')->middleware('auth');
    
});


Route::prefix('penting')->group(function () {
    
    Route::get('/add/{id}/{tambahan?}','KrusialController@add')->name('penting.add')->middleware('auth');

    Route::post('/insert/{tambahan?}','KrusialController@insert')->name('penting.insert')->middleware('auth');

    Route::get('/',function(){
        $data = \App\Krusial::orderBy('id','desc')->Simplepaginate(10);
        return view('krusial.index',compact('data'));
    })->name('penting.index')->middleware('auth');

    Route::get('/hapus/{id}', function($id){
        
        $data = \App\Krusial::where('id',$id)->delete();
        return redirect()->route('penting.index')->with('status','Data berhasil dihapus');

    })->name('penting.hapus')->middleware('auth');

    Route::get('/edit/{id}',function($id){
        $data = \App\Krusial::find($id);
        return view('krusial.edit',compact('data'));
    
    })->name('penting.edit')->middleware('auth');

    Route::post('/editing','KrusialController@editing')->name('penting.editing')->middleware('auth');
});


Route::prefix('ze')->group(function () {
    Route::get('/detail/{id}','ZexclusiveController@detail')->name('ze.detail')->middleware('auth');
    Route::get('/','ZexclusiveController@index')->name('ze.index')->middleware('auth');
    Route::get('/add','ZexclusiveController@add')->name('ze.add')->middleware('auth');
    Route::post('/insert','ZexclusiveController@insert')->name('ze.insert')->middleware('auth');
});

Route::prefix('ga')->group(function () {
    Route::get('/','GiveawayController@index')->name('ga.index')->middleware('auth');
    Route::post('/search','GiveawayController@search')->name('ga.search')->middleware('auth');
    Route::get('/action/{id}/{act?}','GiveawayController@action')->name('ga.action')->middleware('auth');
    Route::get('/periode/{?bln}','GiveawayController@index')->name('ga.periode')->middleware('auth');
    Route::get('/fetch','GiveawayController@fetch')->name('ga.fetch')->middleware('auth');
    Route::post('/fetch/submit','GiveawayController@fetchig')->name('ga.fetch.submit')->middleware('auth');
    Route::get('/komentar','GiveawayController@komentar')->name('ga.komentar')->middleware('auth');
});

Route::prefix('sementara')->group(function () {
    Route::get('/','HitungsementaraController@index')->name('sementara.index')->middleware('auth');
    Route::get('/del/{identitas}','HitungsementaraController@delete')->name('sementara.delete')->middleware('auth');
});

Route::prefix('bukti')->group(function () {
    Route::get('/','BuktitransferController@index')->name('bukti.index')->middleware('auth');
    Route::get('/insert',function(){
        return view('bukti.add');
    })->name('bukti.insert.get')->middleware('auth');
    Route::post('/insert','BuktitransferController@insert')->name('bukti.insert.post')->middleware('auth');

    Route::get('/cetak/{detail}','BuktitransferController@cetak')->name('bukti.cetak')->middleware('auth');
    Route::post('/search','BuktitransferController@search')->name('bukti.search')->middleware('auth');
});

Route::prefix('neraca')->group(function () {
    Route::any('/insert','NeracaController@insert')->name('neraca.insert')->middleware('auth');
    Route::get('/','NeracaController@index')->name('neraca.index')->middleware('auth');
});

Route::prefix('users')->group(function () {
    
    Route::get('/','UserController@index')->name('users.index')->middleware('auth');
});



//-- end order web

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//Route::post('test','DpController@testbayar')->name('testaja');
/*
Route::get('d',function(){
    
    $data = ['tes'=>'siap'];
    
    Mail::send('emails.welcome', $data, function ($message) {
        
        $pdf = PDF::loadView('pdf.invoice');
        
        $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
        $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
        $message->to('bimo.hery@gmail.com','Zavira Jewelry')->subject('Bukti Pembayaran DP dari Zavira Jewelry');
        $message->attachData($pdf->output(), 'filename.pdf');
    });
});

Route::get('te', function(){
	$buku = \App\Buku::all();
        //$bulan = bulan_lalu();
        $bulan = date('F Y');

        foreach ($buku as $item){
            $pemasukan = \App\Pembukuan::where('bulantahun','!=',$bulan)->where('buku_id','=',$item->id)->sum('masuk');
            $pengeluaran = \App\Pembukuan::where('bulantahun','!=',$bulan)->where('buku_id','=',$item->id)->sum('keluar');
            $saldo = $pemasukan - $pengeluaran;
            //DB::table('buku')->where('id',$item->id)->update(['saldo'=>$saldo,'bulantahun'=>$bulan]);
            echo 'Pengeluaran '.$item->title.' = '.rupiah($pengeluaran);
            echo '<br />';
            echo 'Pemasukan '.$item->title.' = '.rupiah($pemasukan);
            echo '<br />';
            echo $saldo;
            echo '<br /><br />';
            //echo $pemasukan;
        }
});

Route::get('/kurleb',function(){
    $logam = \App\Namalogam::where('jenis','palladium')->get();
    foreach ($logam as $item){
        $arr = explode(' ',$item->title);
        //-- update
        \App\Namalogam::where('id',$item->id)->update(['title'=>$arr[0].' &plusmn; '.$arr[1]]);
    }
});

Route::get('/sh',function(){
    $statistik = DB::table('pesanan')
                 ->select('finising', DB::raw('count(*) as total'))
                 ->where('kirim_ke_pengrajin',1)
                 ->groupBy('finising')
                 ->get();

    $on_proses = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',null)->get()->count();
    /*
                null = sedang di proses di bengkel (pk bejo) jika kirim_ke_pengrajin = 1
                1 = sedang di lapis
                2 = sudah di kantor
                3 = sudah dikirm
                4 = reparasi
                5 = di kantor, tapi sudah LUNAS
                6 = sudah dikirim, resi belum ada. 
           

    $text_telegram = '';
    foreach ($statistik as $item){
        if ($item->finising == 1){
           $text_telegram = "Cincin sedang dilapis/finising :".$item->total.'<br />';
           
        }
        if ($item->finising == 2){
            $text_telegram .= "Cincin di showroom :".$item->total.'<br />';
            $showroom = $item->total;
         }
        if ($item->finising == 3){
            $text_telegram .= "Cincin sudah dikirim :".$item->total.'<br />';
         }
        if ($item->finising == 4){
            $text_telegram .= "Cincin reparasi :".$item->total.'<br />';
         }
        if ($item->finising == 5){
            $text_telegram .= "Cincin dikantor dan  sudah lunas :".$item->total.'<br />';
         }
         if ($item->finising == 6){
            $text_telegram .= "Sudah dikirim tapi belum ada resi :".$item->total.'<br />';
         }

         //$text_telegram .="Total belum dikirim :".$showroom + $on_proses;
         
    }

    $text_telegram .= "Proses di bengkel :".$on_proses;

    echo $text_telegram;
});
*/

Route::get('/sh',function(){
    /*$id = [6995,6993,6991,6992,6981,6984,6986];
    notif_cs($id,1);
    
    $skg = date('Y-m-d');
    $pesanan_terlambat = \App\Pesanan::where('kirim_ke_pengrajin',1)
        ->where('finising',null)
        ->whereDate('deadline','<=',$skg)->get();
    dd($pesanan_terlambat);
    
    $id = [6905,6902];
    //$c = \App\Biayaproduksi::whereIn('pesanan_id',$id)->get();
    //$c = \App\Pesanan::select('id')->where('ispremium','>=',1)->get();
    
    /*$p = [];
    foreach ($c as $d){
        echo $d->id.'<br />';
        //array_push($p,$d->id);
    }
    

    $f = \App\Biayaproduksi::select('pesanan_id')->get();
    foreach ($f as $g){
        echo $g->pesanan_id.'<br />';
    }
    //dd($p);
*/
    $data = [6730,6732,6735,6736,6737,6741,6742,6743,6745,6746,6747,6749,6750,6751,6753,6755,6756,6757,6758,6761,6764,6765,6773,6777,6778,6779,6781,6783,6785,6786,6787,6788,6789,6792,6793,6794,6797,6800,6803,6804,6806,6807,6812,6813,6814,6815,6816,6819,6820,6822,6823,6826,6827,6828,6829,6830,6831,6832,6833,6836,6840,6841,6843,6844,6845,6846,6848,6849,6854,6855,6856,6858,6859,6861,6862,6864,6865,6866,6867,6868,6869,6871,6876,6877,6878,6879,6882,6885,6886,6888,6889,6891,6892,6894,6895,6896,6897,6898,6899,6900,6902,6903,6905,6907,6908,6909,6911,6914,6915,6916,6919,6921,6925,6926,6927,6929,6930,6931,6932,6938,6939,6940,6943,6944,6945,6946,6947,6948,6949,6950,6951,6952,6953,6954,6956,6957,6958,6960,6963,6965,6966,6967,6969,6970,6971,6972,6973,6974,6975,6976,6977,6978,6980,6981,6982,6984,6985,6986,6987,6988,6990,6991,6993,6994,6995,6996,6997,6999,7000,7001,7002,7003,7009,7010,7011,7014,7017,7019,7022,7024,7026,7027,7028,7029,7031,7034,7036,7037,7038,7039,7042,7044,7048,7049,7054,7055,7056,7057,7058,7059,7060,7061,7062,7063,7064,7067,7069,7072,7074,7076,7077,7078,7081,7082,7083,7084,7085,7087,7088,7089,7094,7096,7097,7099,7103,7106,7107,7108,7111,7114,7115,7117,7118,7119,7120,7121,7122,7123,7124,7126,7127,7128,7129,7130,7132,7133,7134,7136,7137,7138,7140,7146,7147,7148,7150,7151,7153,7154,7155,7156,7157,7159,7160,7161,7162,7163,7164,7165,7166,7167,7170,7172,7174,7175,7176,7177,7178,7179,7180,7181,7182,7183,7184,7185,7186,7187,7188,7189,7190,7191,7192,7193,7194,7195,7196,7197,7198,7199,7200,7201,7203,7204,7205,7206,7208,7209,7214,7216,7218,7219,7220,7221,7222,7223,7224,7225,7226,7230,7231,7232,7235,7237,7238,7239,7240,7241,7242,7243,7244,7245,7246,7248,7249,7250,7251,7252,7253,7254,7256,7257,7258,7260,7262,7263,7264,7266,7267,7268,7270,7271,7272,7274,7276,7277,7278,7279,7280,7282,7283,7285,7286,7289,7291,7292,7293,7294,7295,7296,7297,7298,7299,7300,7302,7303,7304,7305,7306];
    $target = [6730,6730,6730,6730,6732,6732,6732,6732,6735,6735,6736,6736,6737,6737,6741,6741,6741,6741,6741,6741,6742,6742,6742,6742,6743,6743,6743,6745,6745,6745,6745,6746,6746,6747,6747,6749,6749,6750,6750,6751,6751,6753,6753,6755,6755,6755,6755,6756,6756,6756,6756,6757,6757,6758,6758,6761,6761,6761,6761,6764,6764,6765,6765,6773,6773,6777,6777,6778,6778,6779,6779,6781,6783,6783,6785,6785,6785,6785,6786,6786,6786,6786,6787,6787,6788,6788,6788,6788,6789,6789,6792,6793,6793,6794,6797,6797,6800,6802,6802,6803,6804,6804,6806,6806,6807,6807,6812,6812,6812,6812,6813,6813,6813,6813,6814,6814,6815,6815,6815,6815,6816,6816,6816,6816,6819,6820,6822,6823,6826,6826,6827,6827,6827,6827,6827,6827,6828,6828,6828,6829,6829,6829,6829,6829,6829,6830,6830,6830,6830,6830,6830,6831,6831,6832,6832,6833,6833,6833,6833,6836,6841,6841,6843,6844,6845,6845,6846,6846,6848,6848,6849,6854,6854,6855,6856,6856,6858,6859,6859,6861,6861,6862,6864,6865,6865,6866,6866,6867,6867,6868,6868,6869,6869,6871,6871,6876,6877,6878,6878,6879,6882,6882,6885,6886,6886,6888,6888,6889,6891,6891,6892,6892,6894,6894,6895,6895,6896,6897,6897,6898,6899,6899,6900,6900,6902,6902,6903,6903,6905,6905,6905,6905,6907,6907,6907,6907,6908,6908,6909,6909,6911,6911,6914,6914,6915,6916,6919,6919,6921,6921,6925,6925,6926,6927,6927,6929,6930,6930,6931,6931,6932,6932,6938,6940,6943,6943,6944,6944,6945,6945,6946,6946,6947,6948,6949,6950,6951,6951,6952,6952,6953,6953,6954,6956,6956,6957,6957,6960,6960,6960,6960,6963,6963,6966,6966,6966,6966,6967,6967,6967,6967,6969,6969,6970,6971,6971,6972,6972,6973,6973,6975,6976,6976,6976,6976,6977,6977,6977,6977,6978,6978,6978,6978,6980,6980,6981,6981,6981,6981,6982,6982,6982,6982,6982,6982,6984,6984,6984,6984,6984,6984,6985,6985,6985,6986,6986,6986,6986,6986,6986,6988,6988,6988,6990,6990,6990,6990,6991,6991,6991,6991,6993,6993,6993,6993,6994,6994,6994,6994,6995,6995,6995,6995,6996,6996,6997,6997,6999,6999,7000,7000,7001,7001,7002,7002,7003,7003,7009,7009,7010,7011,7011,7014,7014,7017,7017,7019,7022,7022,7024,7026,7026,7027,7027,7028,7028,7029,7029,7031,7034,7034,7036,7036,7037,7037,7038,7039,7042,7042,7044,7048,7048,7049,7054,7054,7055,7055,7056,7057,7057,7058,7058,7060,7060,7062,7062,7063,7064,7064,7067,7067,7069,7072,7072,7074,7076,7077,7077,7078,7081,7081,7082,7082,7083,7083,7084,7084,7085,7085,7087,7088,7088,7089,7089,7094,7094,7096,7097,7097,7099,7099,7103,7103,7106,7106,7108,7111,7111,7114,7115,7115,7117,7118,7119,7119,7120,7120,7120,7120,7121,7121,7121,7121,7122,7122,7123,7124,7126,7126,7127,7127,7128,7128,7129,7130,7132,7132,7133,7133,7134,7134,7136,7136,7137,7137,7138,7140,7146,7146,7147,7147,7148,7148,7150,7150,7151,7151,7151,7153,7153,7153,7153,7153,7153,7154,7154,7154,7154,7154,7154,7155,7155,7155,7155,7155,7155,7156,7156,7156,7157,7157,7157,7157,7157,7157,7159,7159,7159,7159,7160,7160,7161,7161,7162,7162,7162,7162,7164,7164,7166,7166,7167,7167,7167,7167,7170,7170,7172,7174,7174,7175,7175,7176,7176,7177,7178,7178,7179,7180,7180,7181,7181,7182,7182,7183,7184,7184,7185,7185,7186,7186,7187,7187,7188,7188,7189,7189,7189,7189,7190,7190,7190,7190,7191,7191,7192,7192,7192,7192,7193,7193,7193,7193,7194,7194,7195,7195,7196,7196,7197,7197,7198,7199,7199,7200,7200,7201,7201,7203,7203,7204,7205,7205,7206,7208,7208,7209,7209,7214,7216,7216,7218,7218,7219,7219,7220,7220,7221,7222,7223,7224,7224,7225,7225,7226,7226,7230,7230,7231,7231,7232,7232,7235,7237,7237,7238,7238,7239,7240,7240,7241,7242,7243,7243,7244,7244,7245,7245,7246,7246,7248,7248,7249,7249,7250,7250,7251,7251,7252,7252,7252,7252,7253,7253,7253,7253,7254,7254,7254,7254,7256,7256,7256,7256,7257,7257,7257,7257,7258,7258,7260,7260,7260,7260,7262,7262,7263,7264,7264,7266,7267,7268,7268,7270,7271,7271,7272,7272,7274,7276,7276,7277,7277,7278,7279,7280,7282,7283,7283,7285,7285,7286,7286,7289,7291,7291,7292,7293,7294,7294,7295,7295,7296,7296,7297,7297,7298,7298,7299,7300,7300,7302,7303,7303,7304,7304,7305,7306,7306];

    foreach ($data as $item){
        if (!in_array($item,$target)){
            echo $item.'<br />';
        }
    }
});