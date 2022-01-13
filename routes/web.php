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

Route::get('/pakbejo','PesananController@pakbejo')->name('pesanan.pakbejo');

Route::prefix('calc')->group(function (){
    Route::any('/','LogamController@calc')->name('kalkulator.backend');
    Route::get('/pricelist','LogamController@pergram')->name('pergram.backend');
    Route::get('/paket/{no?}','LogamController@paket')->name('paket.backend');
    Route::get('/simple-package',function(){
        $paket = DB::table('zepaket')->where('status',1)->orderBy('harga_paket','asc')->get();
        //dd($paket);
        return view('logam.pricelist.paket',compact('paket'));
    })->name('simple-package.backend');
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

Route::prefix('perhiasan')->group(function (){
    Route::get('/', 'PerhiasanController@index')->name('perhiasan.index')->middleware('acl');
    Route::any('/add', 'PerhiasanController@insert')->name('perhiasan.add')->middleware('acl');
    Route::any('/edit/{id?}', 'PerhiasanController@edit')->name('perhiasan.edit')->middleware('acl');
});


Route::prefix('pesanan')->group(function () {
    Route::any('/stat', 'PesananController@statistik_perbandingan')->name('pesanan.stat')->middleware('acl');
    Route::get('/statistik/{detail?}', 'PesananController@statistik')->name('pesanan.statistik')->middleware('auth');
    Route::get('/loadpesanan', 'HomeController@loadpesanan')->name('pesanan.loadpesanan')->middleware('auth');
    Route::get('/add', 'HomeController@index')->name('input')->middleware('acl');
    Route::post('/insert', 'HomeController@insert')->name('insert');
    Route::get('/edit/{id}', 'HomeController@edit')->name('edit')->middleware('acl');
    Route::post('/editing', 'HomeController@editing')->name('editing');
    Route::get('/semua', 'HomeController@pesanan')->name('semua')->middleware('acl');
    Route::get('/aku', 'PesananController@my_order')->name('pesanan.aku')->middleware('acl');
    Route::any('/search', 'HomeController@search')->name('search')->middleware('acl');

    Route::get('/filter','PesananController@filter')->name('pesanan.filter')->middleware('auth');

    Route::any('/filtered', 'PesananController@filtered')->name('pesanan.result.filter')->middleware('auth');

    Route::get('/simplefilter','PesananController@simplefilter')->name('pesanan.simple.filter')->middleware('auth');

    Route::any('/sf', 'HomeController@simplefilter')->name('pesanan.result.simple.filter')->middleware('acl');
    Route::any('/lead/{action?}/{id?}', 'PesananController@lead')->name('pesanan.lead')->middleware('auth');
    Route::any('/editlogam/{id?}', 'PesananController@edit_logam')->name('pesanan.edit.logam')->middleware('auth');
    Route::any('/distribusi/{id?}', 'PesananController@distribusi')->name('pesanan.distribusi')->middleware('acl');
   
    
    Route::get('/take/{id}/{template}','HomeController@take')->name('take')->middleware('acl');

    Route::get('/pelunasan/{id}/{re}', function($id,$re){
        
        $data = \App\Pesanan::find($id);
        return view('pelunasanform')
                ->with('data',$data)
                ->with('redirect',$re);

    })->name('pelunasan')->middleware('acl');

    Route::get('/hapus/{id}', 'PesananController@hapus')->name('hapus')->middleware('auth');

    //Route::post('/prosespelunasan', 'PesananController@prosespelunasan')->name('prosespelunasan')->middleware('auth');
    Route::post('/prosespelunasan', 'PesananController@pelunasan')->name('pesanan.pelunasan')->middleware('auth');
    Route::any('/pembayaran-pelunasan/{id?}','PesananController@pembayaran_pelunasan')->name('pesanan.pembayaran.pelunasan')->middleware('acl');
    

    
    Route::get('/finish',function(){
        return view('pesanan.finish');
    })->name('pesanan.finish')->middleware('acl');

    

    Route::post('/finising','PesananController@finising')->name('pesanan.finising')->middleware('auth');

    Route::any('/updateform/{action?}','PesananController@updateform')->name('updateform')->middleware('acl');
    Route::post('/updating','PesananController@updating')->name('updating')->middleware('auth');
    
    Route::get('/update',function(){
        return view('update');
    })->name('update')->middleware('acl');
    
    Route::get('/detail/{id}',function($id){
        $data = \App\Pesanan::find($id);
        return view('detail',compact('data'));
    })->name('pesanan.detail')->middleware('acl');

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
    Route::get('/lapis','PesananController@lapis_berulang')->name('pesanan.lapis')->middleware('acl');

    //Route::get('/export')

    Route::get('/fix','PesananController@fix')->name('pesanan.fix')->middleware('auth');
    Route::any('/sedekah','PesananController@sedekah')->name('pesanan.sedekah')->middleware('auth');

    Route::get('/woodbox',function(){
        return view('pesanan.woodbox');
    })->name('pesanan.woodbox')->middleware('auth');

    Route::post('/woodbox','PesananController@woodbox_add')->name('pesanan.woodbox.add')->middleware('auth');

    Route::any('/buyback','PesananController@buyback')->name('logam.buyback')->middleware('auth');
    Route::any('/force-edit/{id?}','PesananController@update_harga_pergram')->name('pesanan.force.edit')->middleware('auth');
    Route::any('/chart','PesananController@chart')->name('pesanan.chart')->middleware('auth');
    Route::get('/bydate/{date}','PesananController@by_date')->name('pesanan.bydate')->middleware('auth');
    Route::get('/rekap/{id}','PesananController@rekap')->name('pesanan.rekap')->middleware('acl');
    Route::get('/tandaterima/{id}','PesananController@tandaterima')->name('pesanan.tandaterima')->middleware('acl');
    
    Route::any('/ujixrf/{id?}','PesananController@uji_xrf')->name('pesanan.ujixrf')->middleware('acl');
    Route::get('/cetak_qr/{id}/{item}','PesananController@cetak_qr')->name('pesanan.cetak_qr')->middleware('acl');
    

});

Route::prefix('sertifikat')->group(function () {
    Route::get('/create/{id}', 'SertifikatController@sertifikatform')->name('sertifikatform')->middleware('acl');
    Route::post('/insert', 'SertifikatController@prosessertifikat')->name('prosessertifikat');
    Route::get('/print/{id}', 'SertifikatController@printsertifikat')->name('sertifikat.premium')->middleware('acl');
    Route::get('/flashsale/{id}', 'SertifikatController@printsertifikat')->name('sertifikat.flashsale')->middleware('acl');

    Route::get('/printsilver/{id}', function($id){
        $data = \App\Pesanan::where('id',$id)->first();
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

    Route::get('/nota/{id}/{material}','SertifikatController@nota')->name('nota');
});

Route::prefix('reparasi')->group(function () {
    Route::get('/create/{id}', 'ReparasiController@reparasiform')->name('reparasiform')->middleware('acl');
    Route::post('/insert', 'ReparasiController@prosesreparasiform')->name('prosesreparasiform');
    Route::get('/riwayat/{id}', 'ReparasiController@riwayat')->name('riwayat')->middleware('acl');
    Route::get('/cetak/{id}',function($id){
        $data = \App\Reparasi::find($id);
        return view('reparasi.cetak')->with('data',$data);
    })->name('reparasi.cetak')->middleware('acl');

    Route::get('/','ReparasiController@index')->name('reparasi.index')->middleware('auth');

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
    })->name('buktidp')->middleware('acl');
    
    
   
    Route::get('/amplop/{id}','PesananController@cetakamplop')->name('cetak.amplop')->middleware('acl');
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
    
    Route::get('/','LogamController@index')->name('logam.all')->middleware('auth');
    
    Route::get('/dellogam/{id}',function($id){
        $data = \App\Namalogam::where('id',$id)->delete();
        return redirect()->route('logam.all')->with('status','Data berhasil dihapus');
    })->name('logam.del')->middleware('auth');

    Route::get('/kalkulator/{apa?}','LogamController@kalkulator')->name('logam.kalkulator')->middleware('auth');
    Route::get('/calc',function(){
        return view('logam.calc');
    })->name('logam.konversi')->middleware('auth');

    Route::any('/em','LogamController@edit_markup')->name('logam.em')->middleware('auth');

    Route::get('/export','LogamController@export')->name('logam.export')->middleware('auth');
    
    Route::get('/down/{jenis}',function($jenis){
        $logam = \App\Namalogam::where('jenis',$jenis)->whereNotNull('active')->whereNotNull('persentase_markup')->get();
        foreach ($logam as $item){  
            DB::table('namalogam')->where('id',$item->id)->decrement('persentase_markup',5);
        }
    })->middleware('auth');


});




Route::prefix('laba')->group(function () {
   
    Route::any('/', 'LabaController@index')->name('laba.semua')->middleware('auth');
    Route::get('/detail/{id}','LabaController@detail')->name('laba.detail')->middleware('auth');
    Route::any('/gaji','LabaController@gaji')->name('gaji')->middleware('auth');
    Route::get('/perhitungan','LabaController@perhitungan')->name('perhitungan')->middleware('auth');
    Route::any('/update','LabaController@update_perhitungan')->name('perhitungan.update')->middleware('auth');
});

Route::prefix('dp')->group(function () {
    Route::get('/','DpController@index')->name('dp.index')->middleware('auth');
    Route::get('/bayar','DpController@bayar')->name('dp.bayar')->middleware('auth');
});

Route::prefix('buyback')->group(function () {
    Route::any('/insert','BuybackController@insert')->name('buyback.insert')->middleware('auth');
    Route::any('/edit/{id?}','BuybackController@edit')->name('buyback.edit')->middleware('auth');
    Route::any('/','BuybackController@index')->name('buyback.index')->middleware('auth');
    Route::any('/hapus/{id?}','BuybackController@hapus')->name('buyback.hapus')->middleware('auth');
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
            return redirect()->route('pembukuan.detail',['id'=>4]);
        }
    })->name('pembukuan.semua')->middleware('auth');

    Route::any('/detail/{id?}','PembukuanController@detail')->name('pembukuan.detail')->middleware('acl');
    Route::get('/edit/{id}','PembukuanController@edit')->name('pembukuan.edit')->middleware('acl');

    Route::post('/detail2','PembukuanController@detail2')->name('pembukuan.detail2')->middleware('acl');

    Route::get('/add/{status}', function($status){
        
        $user_id = Auth::user()->id;
        $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->pluck('id','title');
        $jenis_transaksi = $status;
        
        return view('pembukuan.add',compact('buku','jenis_transaksi'));
    })->name('pembukuan.add')->middleware('acl');

    Route::get('/hapus/{id}/{buku}','PembukuanController@hapus')->name('pembukuan.hapus')->middleware('auth');

    Route::get('/transfer',function(){
        $user_id = Auth::user()->id;
        $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->pluck('id','title');

        return view('pembukuan.transfer',compact('buku'));

    })->name('pembukuan.transfer')->middleware('auth');

    Route::get('/export/{id?}/{bulan?}','PembukuanController@export_pembukuan')->name('pembukuan.export')->middleware('auth');
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
    Route::get('/add','ZexclusiveController@add')->name('ze.add')->middleware('auth');
    Route::post('/insert','ZexclusiveController@insert')->name('ze.insert')->middleware('auth');
    Route::post('/edit','ZexclusiveController@edit')->name('ze.edit')->middleware('auth');
    Route::get('/{action?}/{id?}','ZexclusiveController@index')->name('ze.index')->middleware('auth');
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

    Route::get('/cetak/{detail}/{export?}','BuktitransferController@cetak')->name('bukti.cetak')->middleware('auth');
    Route::post('/search','BuktitransferController@search')->name('bukti.search')->middleware('auth');
});

Route::prefix('neraca')->group(function () {
    Route::any('/insert','NeracaController@insert')->name('neraca.insert')->middleware('auth');
    Route::any('/edit/{id?}','NeracaController@edit')->name('neraca.edit')->middleware('auth');
    Route::any('/','NeracaController@index')->name('neraca.index')->middleware('auth');
    Route::get('/hapus/{id}','NeracaController@hapus')->name('neraca.hapus')->middleware('auth');
});

Route::prefix('users')->group(function () {
    Route::any('/edit/{id?}','UserController@edit')->name('users.edit')->middleware('auth');
    Route::get('/','UserController@index')->name('users.index')->middleware('auth');
});

Route::prefix('promo')->group(function () {
    Route::any('/insert/{action?}/{id?}','PromoController@insert')->name('promo.insert')->middleware('auth');
    Route::get('/','PromoController@index')->name('promo.index')->middleware('auth');
});

Route::prefix('stock')->group(function () {
    Route::any('/insert/{action?}/{id?}','StockController@insert')->name('stock.insert')->middleware('auth');
    Route::get('/','StockController@index')->name('stock.index')->middleware('auth');
});

Route::prefix('timeline')->group(function () {
    Route::get('/{id}','HistoryController@detail')->name('timeline.index')->middleware('auth');
});

Route::prefix('susut')->group(function () {
    Route::any('/add/{id?}','SusutController@add')->name('susut.add')->middleware('auth');
    Route::any('/edit/{id?}','SusutController@edit')->name('susut.edit')->middleware('auth');
    Route::post('/search','SusutController@search')->name('susut.search')->middleware('auth');
    Route::get('/{detail?}','SusutController@index')->name('susut.index')->middleware('auth');
});

Route::get('saldo', function(){
    Artisan::call('saldo:jumlahkan');
});

//-- end order web
Route::get('cart',function(){
    $event = new Spatie\GoogleCalendar\Event;

    $event->name = 'A new event';
    $event->description = 'ini deskrispo';
    $event->startDateTime = Carbon\Carbon::now();
    $event->endDateTime = Carbon\Carbon::now()->addHour();
    $event->location = 'Yogyakarta';
    $event->remindersOverridesMethod = 'popup';
    $event->save();
});

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
    

    $imageKit = new ImageKit\ImageKit(
        "public_QGjMcmRVUHL3bqGZJyz9VOFckLg=",
        "private_ufGJBwcPeHMwZCZ8CoN9g9Cw7jI=",
        "https://ik.imagekit.io/rxghkuxrj"
    );  

    $uploadFile = $imageKit->uploadFiles(array(
        "file" => "http://www.africau.edu/images/default/sample.pdf", // required
        "fileName" => "your_file_name.pdf", // required
        "useUniqueFileName" => true // optional
        
    ));
    $response = json_decode(json_encode($uploadFile), true);
    
    echo $binaryFileUploadURL = $response["success"]["url"];
});

Route::get('/das',function(){
    // $client = new \GuzzleHttp\Client();
    // $url = 'http://akuntansi.test/api/invoice';
    // $request = $client->post($url,['form_params'=> [
    //         'nama' => 'dono',
    //         'nohp' => '23432432',
    //         'alamat' => 'Yogya',
    //         'harga' => '90000',
    //         'pesanan_id' => 12304,
    //         'title' => 'cincin kawin ',
    //         'deskripsi' => 'cowok emas cewk pall',
    //         'harga' => '90000',

    //     ]
    // ]);

    echo str_random(40);
});




