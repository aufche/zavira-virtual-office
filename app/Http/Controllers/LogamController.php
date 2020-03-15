<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

Class LogamController extends Controller{

    
    function simpanvariasilogam(Request $request){
        if ($request->input('jenis')=='emas') $kode = 'ek'.$request->input('kadar');
        if ($request->input('jenis')=='palladium') $kode = 'p'.$request->input('kadar');
        if ($request->input('jenis')=='platinum') $kode = 'pl'.$request->input('kadar');
        if ($request->input('jenis')=='silver') $kode = 's'.$request->input('kadar');
        if ($request->input('jenis')=='ep') $kode = 'epaudp'.$request->input('kadar');
        if ($request->input('jenis')=='platidium') $kode = 'plpall'.$request->input('kadar');

        $data = [
            'title'=>$request->input('title'),
            'kadar'=>$request->input('kadar'),
            'jenis'=>$request->input('jenis'),
            'markup'=>$request->input('markup'),
            'kode'=>$kode,
        ];
        $id = DB::table('namalogam')->insertGetId($data);

        return redirect()->route('logam.edit',['id'=>$id])->with('status','Data berhasil disimpan');
    }

    function editingvariasi(Request $request){
        $id = $request->input('id');
        $namalogam = \App\Namalogam::find($id);
        $namalogam->title = $request->input('title');
        $namalogam->kadar = $request->input('kadar');
        $namalogam->jenis = $request->input('jenis');
        $namalogam->markup = $request->input('markup');

        if ($request->input('jenis')=='emas') $kode = 'ek'.$request->input('kadar');
        if ($request->input('jenis')=='palladium') $kode = 'p'.$request->input('kadar');
        if ($request->input('jenis')=='platinum') $kode = 'pl'.$request->input('kadar');
        if ($request->input('jenis')=='silver') $kode = 's'.$request->input('kadar');
        if ($request->input('jenis')=='ep') $kode = 'epaudp'.$request->input('kadar');
        if ($request->input('jenis')=='platidium') $kode = 'plpall'.$request->input('kadar');

        $namalogam->kode = $kode;

        $namalogam->save();

        return redirect()->route('logam.edit',['id'=>$id])->with('status','Data berhasil disimpan');
    }

    function pricelist($p=null,$t=null){
        $data_logam = \App\Namalogam::orderBy('title','asc')->get()->toArray();
        $data_harga = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get()->toArray();
        $berat_pria = 4;
        $berat_wanita = 4;
        $ongkir = 0;
        $box_kayu = 0;
        if ($p == 'luxurious'){
            $pair = [
                'Seri A' =>'p75*p75',
                'Seri B' =>'p75*epaudp75',
                'Seri C' =>'p75*ek75',
                'Seri D' =>'p75*ek85',
                'Seri E' =>'p75*ek90',
                'Seri F' =>'p75*ek100',
            ];
            $package_name = 'LUXURIOUS PACKAGE';
        }elseif ($p == 'luxurious2'){
            $pair = [
                'Seri A' =>'p50*p50',
                'Seri B' =>'p50*epaudp50',
                'Seri C' =>'p50*ek75',
                'Seri D' =>'p50*ek80',
                'Seri E' =>'p50*ek100',
                'Seri F' =>'p50*epaudp75',
            // 'Seri G' =>'p50*ek50',
            ];
            $package_name = 'LUXURIOUS 2 PACKAGE';
        }elseif ($p == 'elite'){
            $pair = [
                'Seri A' =>'p40*p40',
                'Seri B' =>'p40*epaudp50',
                'Seri C' =>'p40*ek75',
                'Seri D' =>'p40*ek80',
                'Seri E' =>'p40*epaudp75',
                'Seri F' =>'p40*ek85',
            // 'Seri G' =>'p40*ek40',
                ];
                $package_name = 'ELITE PACKAGE';
        }elseif ($p == 'elite2'){
            $pair = [
                'Seri A' =>'p30*p30',
                'Seri B' =>'p30*epaudp50',
                'Seri C' =>'p30*ek75',
                'Seri D' =>'p30*ek80',
                'Seri E' =>'p30*epaudp75',
                'Seri F' =>'p30*p50',
                //'Seri G' =>'p30*ek50',
                ];
                $package_name = 'ELITE 2 PACKAGE';
        }elseif ($p == 'premium'){
            $pair = [
                'Seri A' =>'p25*p25',
                'Seri B' =>'p25*epaudp50',
                'Seri C' =>'p25*ek75',
                'Seri D' =>'p25*ek30',
                'Seri E' =>'p25*epaudp75',
                'Seri F' =>'p25*p50',
                //'Seri G' =>'p25*ek50',
                ];

                $package_name = 'PREMIUM PACKAGE';
        }elseif ($p == 'premium2'){
            $pair = [
                'Seri A' =>'p10*p10',
                'Seri B' =>'p10*epaudp40',
                'Seri C' =>'p10*ek30',
                'Seri D' =>'p10*ek25',
                'Seri E' =>'p10*ek75',
                'Seri F' =>'p10*p30',
                //'Seri G' =>'p10*ek50',
                ];

                $package_name = 'PREMIUM 2 PACKAGE';
        }elseif ($p == 'premium3'){
            $pair = [
                'Seri A' =>'s100*ek40',
                'Seri B' =>'s100*epaudp75',
                'Seri C' =>'s100*ek100',
                'Seri D' =>'s100*ek50',
                'Seri E' =>'s100*ek75',
                'Seri F' =>'s100*p50',
                //'Seri G' =>'s100*ek10',
                ];

                $package_name = 'PREMIUM 3 PACKAGE';
        }elseif ($p == 'platinum'){
            $pair = [
                'Seri A' =>'pl40*pl40',
                'Seri B' =>'pl30*pl30',
                'Seri C' =>'pl25*pl25',
                'Seri D' =>'pl20*pl20',
                'Seri E' =>'pl10*pl10',
                ];
                $package_name = 'PLATINUM PACKAGE';
        }elseif ($p == 'platidium'){
            $pair = [
                'Seri A' =>'plpall50*plpall50',
                'Seri B' =>'plpall40*plpall40',
                'Seri C' =>'plpall30*plpall30',
                'Seri D' =>'plpall20*plpall20',
                'Seri E' =>'plpall10*plpall10',
                ];

                $package_name = 'PLATIDIUM PACKAGE';
        }elseif ($p == 'all'){
            $pair = [
                1=>'p75*p75',
                2=>'p75*epaudp75',
                3=>'p75*ek75',
                4=>'p75*ek85',
                5=>'p75*ek90',
                6=>'p75*ek100',
                7=>'p50*p50',
                8=>'p50*epaudp50',
                9=>'p50*ek75',
                10=>'p50*ek80',
                11=>'p50*ek100',
                12=>'p50*epaudp75',
                13=>'p40*p40',
                14=>'p40*epaudp50',
                15=>'p40*ek75',
                16=>'p40*ek80',
                17=>'p40*epaudp75',
                18=>'p40*ek85',
                19=>'p30*p30',
                20=>'p30*epaudp50',
                21=>'p30*ek75',
                22=>'p30*ek80',
                23=>'p30*epaudp75',
                24=>'p30*p50',
                25=>'p25*p25',
                26=>'p25*epaudp50',
                27=>'p25*ek75',
                28=>'p25*ek30',
                29=>'p25*epaudp75',
                30=>'p25*p50',
                31=>'p10*p10',
                32=>'p10*epaudp40',
                33=>'p10*ek30',
                34=>'p10*ek25',
                35=>'p10*ek75',
                36=>'p10*p30',
                37=>'s100*ek40',
                38=>'s100*epaudp75',
                39=>'s100*ek100',
                40=>'s100*ek50',
                41=>'s100*ek75',
                42=>'s100*p50',
                43=>'pl40*pl40',
                44=>'pl30*pl30',
                45=>'pl25*pl25',
                46=>'pl20*pl20',
                47=>'pl10*pl10',
                48=>'plpall50*plpall50',
                49=>'plpall40*plpall40',
                50=>'plpall30*plpall30',
                51=>'plpall20*plpall20',
                52=>'plpall10*plpall10',

            ];

            $package_name = 'PLATIDIUM PACKAGE';
        }
        if ($t == 'print'){
            return view('pricelist.index',compact('pair','data_logam','data_harga','package_name'));
        }elseif ($t == 'story'){
            return view('pricelist.story',compact('pair','data_logam','data_harga','package_name'));
        }elseif ($t == '1080'){
            return view('pricelist.1080x1080',compact('pair','data_logam','data_harga','package_name'));
        }elseif ($t == 'all'){
            return view('pricelist.all',compact('pair','data_logam','data_harga','package_name'));
        }else{
            return view('pricelist.menu');
        }
}

function kalkulator($apa=null){
    $hargapokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get();
    $logam = \App\Namalogam::orderBy('title','asc')->get();
    if ($apa == null){
        return view('logam.kalkulator',compact('logam','hargapokok'));    
    }elseif ($apa == 'pricelist'){
        return view('logam.pricelist',compact('logam','hargapokok'));    
    }
    
}

function pricelist_single($bahan=null){
    if ($bahan == 'palladium'){
        $hargapokok_pall = \App\Setting::where('kunci','=','harga_pokok_palladium')->first();
        $hargapokok_pt = \App\Setting::where('kunci','=','harga_pokok_platinum')->first();

        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
        
        $data_logam_pall = \App\Namalogam::where('jenis','palladium')->orderBy('kadar','asc')->get();
        $data_logam_pt = \App\Namalogam::where('jenis','platinum')->orderBy('kadar','asc')->get();

        $logam = 'Palladium & Platinum';

        return view('pricelist.single_pall_pt',compact('hargapokok_pall','hargapokok_pt','ongkos_bikin','data_logam_pall','logam','data_logam_pt'));
    }

    if ($bahan == 'platinum'){
        $hargapokok = \App\Setting::where('kunci','=','harga_pokok_platinum')->first();
        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
        $data_logam = \App\Namalogam::where('jenis','platinum')->orderBy('kadar','asc')->get();
        $logam = 'Platinum';

        return view('pricelist.single',compact('hargapokok','ongkos_bikin','data_logam','logam'));
    }

    if ($bahan == 'emas'){
        $hargapokok = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
        $data_logam_emas = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['50','75','80','85','90'])->orderBy('kadar','asc')->get();
        $data_logam_emas_ekonomis = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['10','20','25','30','40'])->orderBy('kadar','asc')->get();
        $data_logam_emas_putih = \App\Namalogam::where('jenis','ep')->orderBy('kadar','asc')->get();
        $logam = 'Emas';

        return view('pricelist.single',compact('hargapokok','ongkos_bikin','data_logam_emas','logam','data_logam_emas_ekonomis','data_logam_emas_putih'));
    }

    /*if ($bahan == 'emas-ekonomis'){
        $hargapokok = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
        $data_logam = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['10','20','25','30','40'])->orderBy('kadar','asc')->get();
        $logam = 'Emas Putih/Kuning';

        return view('pricelist.single',compact('hargapokok','ongkos_bikin','data_logam','logam'));
    }


    if ($bahan == 'ep'){
        $hargapokok = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
        $data_logam = \App\Namalogam::where('jenis','ep')->orderBy('kadar','asc')->get();
        $logam = 'Emas Putih';

        return view('pricelist.single',compact('hargapokok','ongkos_bikin','data_logam','logam'));
    }
    */
    /*if ($bahan == 'platidium'){
        $hargapokok = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
        $data_logam = \App\Namalogam::where('jenis','ep')->orderBy('kadar','asc')->get();
        $logam = 'Emas Putih';

        return view('pricelist.single',compact('hargapokok','ongkos_bikin','data_logam','logam'));
    }
    */
}

function harga_logam($platinum=null){
        
        $emas = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
        $palladium = \App\Setting::where('kunci','=','harga_pokok_palladium')->first();
        $platinum = \App\Setting::where('kunci','=','harga_pokok_platinum')->first();

        $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();

        $kadar_emas = \App\Namalogam::where('jenis','emas')->orderBy('kadar','asc')->get();
        $kadar_emas_putih = \App\Namalogam::where('jenis','ep')->orderBy('kadar','asc')->get();
        $kadar_palladium = \App\Namalogam::where('jenis','palladium')->orderBy('kadar','asc')->get();
        $kadar_platinum = \App\Namalogam::where('jenis','platinum')->orderBy('kadar','asc')->get();
        $kadar_platidium = \App\Namalogam::where('jenis','platidium')->orderBy('kadar','asc')->get();
        

        //$kadar = DB::table('namalogam')->groupBy('jenis')->get();
        if ($platinum == null){
            return view('pricelist.hargalogam',compact('emas','palladium','platinum','ongkos_bikin','kadar_emas','kadar_palladium','kadar_platinum','kadar_emas_putih'));    
        }else{
            return view('pricelist.platinum',compact('platinum','palladium','kadar_platinum','kadar_platidium'));    
        }
        
        //dd($kadar);
}
    


}