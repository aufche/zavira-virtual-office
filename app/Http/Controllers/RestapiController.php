<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Arr;

Class RestapiController extends Controller{

    function logam(){
        $data = \App\Namalogam::whereNotNull('active')->orderBy('title','asc')->get();

        return response()->json($data, 201);
    }

    function hargapokok(){
        $data = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get();

        return response()->json($data, 201);
    }

    function kalkulator(){

        $nama_logam = \App\Namalogam::whereNotNull('active')->orderBy('title','asc')->get();
        //$harga_pokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get();

        $emas = DB::table('setting')->select('isi')->where('kunci','harga_pokok_emas')->first();
        $palladium = DB::table('setting')->select('isi')->where('kunci','harga_pokok_palladium')->first();
        $platinum = DB::table('setting')->select('isi')->where('kunci','harga_pokok_platinum')->first();
        
        $data = [];
        $data2 = [];

        foreach ($nama_logam as $item){

           if ($item->jenis == 'emas'){
               $price = ( $item->kadar /100 ) * $emas->isi;
           }elseif ($item->jenis == 'palladium'){
                $price = ( $item->kadar /100 ) * $palladium->isi;
           }elseif ($item->jenis == 'platinum'){
                $price = ( $item->kadar /100 ) * $platinum->isi;
           }

//           $data = Arr::add($data, $item->title, $price);
            $data['label'] = $item->title;
            $data['price'] = $price;

            array_push($data2, $data);

           
        }

        return response()->json($data2, 201);
    }

    function resi($id){
        //$data = \App\Pesanan::find($id);
        $data = \App\Pesanan::where('id',$id)->with('kurir')->first();

        return response()->json($data, 201);
    }

    function orderweb(Request $request){
        $orderan = [
            'nama'=>$request->input('nama'),
            'ukuranpria'=>$request->input('ukuranpria'),
            'grafirpria'=>$request->input('grafirpria'),
            'ukuranwanita'=>$request->input('ukuranwanita'),
            'grafirwanita'=>$request->input('grafirwanita'),
            'nohp'=>number_international($request->input('nohp')),
            'instagram'=>$request->input('instagram'),
            'email'=>$request->input('email'),
            'alamat'=>$request->input('alamat'),
            'kecamatan'=>$request->input('kecamatan'),
            'kodepost'=>$request->input('kodepost'),
            'promo'=>$request->input('promo'),
            'link'=>$request->input('link'),
        ];

        $id = DB::table('orderweb')->insertGetId($orderan);

        /*$text = "Horaaayyy....!!! ada pesanan masuk dari toko online. No order".$id."\n";
        $text .= $request->input('nohp')."\n";
        $text .= "Selamat siang, kami dari Zavira Jewelry. Pesanan Anda sudah kami terima, sebentar kami hitungkan dulu total belanjanya";
        */
        $text = '<a href="https://wa.me/'.number_international($request->input('nohp')).'/?text=Selamat+siang%2C+kami+dari+Zavira+Jewelry.+Pesanan+Anda+sudah+kami+terima%2C+sebentar+kami+hitungkan+dulu+total+belanjanya">'.number_international($request->input('nohp')).'</a>';
            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

       return redirect()->away($request->input('zf_redirect_url'));
    }

    function ordercustom(Request $request){
        $orderan = [
            'nama'=>$request->input('nama'),
            'ukuranpria'=>$request->input('ukuranpria'),
            'grafirpria'=>$request->input('grafirpria'),
            'ukuranwanita'=>$request->input('ukuranwanita'),
            'grafirwanita'=>$request->input('grafirwanita'),
            'nohp'=>number_international($request->input('nohp')),
            'email'=>$request->input('email'),
            'alamat'=>$request->input('alamat'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

        if (!empty($request->input('kodecincin'))){
            $orderan = array_add($orderan,'kodecincin',$request->input('kodecincin'));
        }

        if (!empty($request->input('url_gambar_cincin'))){
            $orderan = array_add($orderan,'url_gambar_cincin',$request->input('url_gambar_cincin'));
        }

    

        //if (!empty($request->input('pria'))){
            //-- pesen cincin pria
            $orderan = array_add($orderan,'bahanpria',$request->input('bahanpria'));
            $orderan = array_add($orderan,'ukuranpria',$request->input('ukuranpria'));
            $orderan = array_add($orderan,'grafirpria',$request->input('grafirpria'));
            $orderan = array_add($orderan,'beratpria',$request->input('berat_pria'));
            $orderan = array_add($orderan,'hargapria',$request->input('jenis_logam_pria'));
       // }

       // if (!empty($request->input('wanita'))){
            //-- pesen cincin wanita
            $orderan = array_add($orderan,'bahanwanita',$request->input('bahanwanita'));
            $orderan = array_add($orderan,'ukuranwanita',$request->input('ukuranwanita'));
            $orderan = array_add($orderan,'grafirwanita',$request->input('grafirwanita'));
            $orderan = array_add($orderan,'beratwanita',$request->input('berat_wanita'));
            $orderan = array_add($orderan,'hargawanita',$request->input('jenis_logam_wanita'));
      //  }


        if (!empty($request->file('upload_cincin'))){
        
            $this->validate($request,[
                'upload_cincin'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('upload_cincin')->getRealPath();
     
            
            $orderan = array_add($orderan,'upload_cincin',upload_gambar($image_name));
        }

        if (!empty($request->file('model_cincin_pria'))){
        
            $this->validate($request,[
                'model_cincin_pria'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('model_cincin_pria')->getRealPath();
     
            $orderan = array_add($orderan,'model_cincin_pria',upload_gambar($image_name));
        }

        if (!empty($request->file('model_cincin_wanita'))){
        
            $this->validate($request,[
                'model_cincin_wanita'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('model_cincin_wanita')->getRealPath();
     
           
            $orderan = array_add($orderan,'model_cincin_wanita',upload_gambar($image_name));
        }
        
       

        $id = DB::table('orderweb')->insertGetId($orderan);

        $text = '<a href="https://wa.me/'.number_international($request->input('nohp')).'/?text=Selamat+siang%2C+kami+dari+Zavira+Jewelry.+Pesanan+Anda+sudah+kami+terima%2C+sebentar+kami+hitungkan+dulu+total+belanjanya">'.number_international($request->input('nohp')).'</a>';
            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

       return redirect()->away($request->input('redirect'));
    }

    function joingiveaway(Request $request){
        $peserta = [
            'nama'=>$request->input('nama'),
            'email'=>$request->input('email'),
            'ig'=>$request->input('ig'),
            'periode'=>date('M-Y'),
        ];

        $id = DB::table('giveaway')->insertGetId($peserta);

        $text = 'Ada yang ikut giveaway dengan akun '.$request->input('ig');
            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

       return redirect()->away('https://zavirajewelry.com/join/?success=1');
    }

    function chat(){
        //$cs = \App\User::inRandomOrder()->first();
        $cs = \App\User::where('join_cs',1)
            //->orderBy('prioritas','asc')
            ->orderBy('frekuensi','asc')
            
            ->limit(1)->get();
        //-- update cs terpilih utk menaikkan nilai frekunsi nya
        \App\User::find($cs[0]->id)->increment('frekuensi', $cs[0]->prioritas);
        \App\User::find($cs[0]->id)->increment('lead', 1);

        $text = "New lead didapatkan oleh ".$cs[0]->nama_cs." dengan jumlah lead saat ini ".$cs[0]->lead;
       /** Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
        */
 
        return redirect()->away('https://api.whatsapp.com/send?phone='.$cs[0]->wa.'&text=Hallo%20kak%20'.$cs[0]->nama_cs.'%20Saya%20ingin%20bertanya%20mengenai%20cincin%20kawin');
        //dd($cs);
       // echo $cs[0]->wa;

       //return response()->json($cs, 201);
    }

    function chat_langsung($id = null, $message = null){
        $cs = \App\User::find($id);
        //dd($cs);
        $message = rawurlencode($message);
        return redirect()->away('https://api.whatsapp.com/send?phone='.$cs->wa.'&text='.$message);
        //return redirect()->away('http://google.com');

    }

    function pricelist_single($bahan=null){
        if ($bahan == 'palladium'){
            $hargapokok_pall = \App\Setting::where('kunci','=','harga_pokok_palladium')->first();
            $hargapokok_pt = \App\Setting::where('kunci','=','harga_pokok_platinum')->first();
    
            $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
            
            $data_logam_pall = \App\Namalogam::where('jenis','palladium')->orderBy('kadar','asc')->get();
            $data_logam_pt = \App\Namalogam::where('jenis','platinum')->orderBy('kadar','asc')->get();
    
            $logam = 'Palladium & Platinum';
    
            

            return response()->json([
                'hargapokok_pall' => $hargapokok_pall,
                'hargapokok_pt' => $hargapokok_pt,
                'ongkos_bikin' => $ongkos_bikin,
                'data_logam_pall' => $data_logam_pall,
                'logam' => $logam,
                'data_logam_pt' => $data_logam_pt,
            ],201);
        }
    
        if ($bahan == 'platinum'){
            $hargapokok = \App\Setting::where('kunci','=','harga_pokok_platinum')->first();
            $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
            $data_logam = \App\Namalogam::where('jenis','platinum')->orderBy('kadar','asc')->get();
            $logam = 'Platinum';
    
           

            return response()->json([
                'hargapokok' => $hargapokok,
                'ongkos_bikin' => $ongkos_bikin,
                'data_logam' => $data_logam,
                'logam' => $logam,
            ],201);
        }
    
        if ($bahan == 'emas'){
            $hargapokok = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
            $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
            $data_logam_emas = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['50','54','58','75','83','91','23','95'])->whereNotNull('active')->orderBy('kadar','asc')->get();
            $data_logam_emas_ekonomis = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['12','16','20','25','29'])->whereNotNull('active')->orderBy('kadar','asc')->get();
            $data_logam_emas_mid = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['33','37','41'])->whereNotNull('active')->orderBy('kadar','asc')->get();
            
            $logam = 'Emas';
    
        }
    
        if ($bahan == 'ep'){
            $hargapokok = \App\Setting::where('kunci','=','harga_pokok_emas')->first();
            $ongkos_bikin = \App\Setting::where('kunci','=','ongkos_bikin')->first();
    
            $data_logam_emas_putih = \App\Namalogam::where('jenis','ep')->orderBy('kadar','asc')->get();
            $logam = 'Emas';
    
            

            return response()->json([
                'hargapokok' => $hargapokok,
                'ongkos_bikin' => $ongkos_bikin,
                'logam' => $logam,
                'data_logam_emas_putih' => $data_logam_emas_putih,
            ],201);
        }


        return response()->json([
            'hargapokok' => $hargapokok,
            'ongkos_bikin' => $ongkos_bikin,
            'data_logam_emas' => $data_logam_emas,
            'logam' => $logam,
            'data_logam_emas_ekonomis' => $data_logam_emas_ekonomis,
            'data_logam_emas_mid' => $data_logam_emas_mid,
        ],201);
    
        
    }

    function couple_pricelist(){
        $data_logam = \App\Namalogam::whereNotNull('active')->orderBy('title','asc')->get()->toArray();
        $data_harga = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get()->toArray();
        

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

            return response()->json([
                'data_logam' => $data_logam,
                'data_harga' => $data_harga,
                'pair' => $pair,
                'berat_pria' => 4,
                'berat_wanita' => 4,
                'ongkir' => 0,
                'box_kayu' => 0
            ],201);
    }

    function ai_pricelist(){
        $hargapokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','harga_pokok_platinum','ongkos_bikin'])->get();
        
        $data_logam_pria = \App\Namalogam::whereIn('jenis',['palladium','platinum'])->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('kadar','asc')->get();
        $data_logam_wanita = \App\Namalogam::whereIn('jenis',['emas','palladium','platinum'])->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('kadar','asc')->get();

        return response()->json([
            'logam_pria' => $data_logam_pria,
            'logam_wanita' => $data_logam_wanita,
            'harga_pokok' => $hargapokok,
        ], 201);
    }

    function ai_pricelist_search(Request $request){
        $logam_pria = $request->input('logam_pria');
        $logam_wanita = $request->input('logam_wanita');
        $min = $request->input('min');
        $max = $request->input('max');

        $hargapokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','harga_pokok_platinum','ongkos_bikin'])->get();

        $data_logam_pria = \App\Namalogam::where('jenis',$logam_pria)->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('kadar','asc')->get();
        $data_logam_wanita = \App\Namalogam::where('jenis',$logam_wanita)->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('kadar','asc')->get();

        return response()->json([
            'logam_pria' => $data_logam_pria,
            'logam_wanita' => $data_logam_wanita,
            'harga_pokok' => $hargapokok,
            'min' => $min,
            'max' => $max,
        ], 201);
    }

    function pricelist_single_2(){
        
        $hargapokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','harga_pokok_platinum','ongkos_bikin'])->get();

        $emas = \App\Namalogam::where('jenis','emas')->whereIn('kadar',['50','54','58','75','83','91','95'])->whereNotNull('active')->orderBy('kadar','asc')->get();

        return response()->json([
            'emas' => $emas,
            'harga_pokok' => $hargapokok,
        ], 201);

    }

    function pricelist_depan($logam = 'emas'){
        $data_logam = DB::table('namalogam')->where('jenis',$logam)->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('kadar','asc')->get();

        return response()->json([
            'data_logam' => $data_logam,
        ], 201);
    }

    function calc(Request $request){
        //$hargapokok = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum','harga_harian_emas','harga_harian_palladium','harga_harian_platinum'])->get();
        $logam = \App\Namalogam::whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('jenis','asc')->orderBy('kadar','asc')->get();    

        if ($request->isMethod('post')){

            
            $harga_pria = 0;
            $harga_wanita = 0;
            $kalkulasi = [];
            $kadar_pria = 0;
            $kadar_wanita = 0;
            $biaya_produksi_pria = 0;
            $biaya_produksi_wanita = 0;
    
            /*$hp_emas = $hargapokok[0]->isi;
            $hp_palladium = $hargapokok[1]->isi;
            $ongkos_bikin = $hargapokok[2]->isi;
            //$ongkos_bikin = $request->input('ongkos_bikin');
            $hp_platinum = $hargapokok[4]->isi;
            */
    
            
    
            $id_pria = $request->input('pria');
            $id_wanita = $request->input('wanita');
            $berat_pria = $request->input('berat_pria');
            $berat_wanita = $request->input('berat_wanita');
    
            $kalkulasi['id_pria'] = $id_pria;
            $kalkulasi['id_wanita'] = $id_wanita;
            $kalkulasi['berat_pria'] = $berat_pria;
            $kalkulasi['berat_wanita'] = $berat_wanita;
    
            
    
            if ($berat_pria != null ){
                $pria = \App\Namalogam::find($id_pria);
                //$pria = DB::table('namalogam')->find($id_pria);
                
                if ($pria->jenis != 'silver'){
    
                    /*if ($pria->jenis == 'emas') $x = $hp_emas;
                    if ($pria->jenis == 'ep') $x = $hp_emas;
                    if ($pria->jenis == 'palladium') $x = $hp_palladium;
                    if ($pria->jenis == 'platinum') $x = $hp_platinum;
                    if ($pria->jenis == 'platidium') $x = (($hp_platinum + $hp_palladium) / 2);
                    */
    
                    $harga_pria = ($pria->harga_final * $berat_pria) + $pria->biaya_produksi;
                    $kadar_pria = $pria->kadar;
                    $harga_pria_pergram = $pria->harga_final;
    
                }elseif ($pria->jenis == 'silver'){
                    
                    $harga_pria = 265000;
                    $kadar_pria = 20;
                    $harga_pria_pergram = 0;
                    
                }
    
                $kalkulasi['jenis_pria'] = $pria->jenis;
                $kalkulasi['logam_pria'] = $pria->title;
                $kalkulasi['berat_pria'] = $berat_pria;
                $kalkulasi['harga_pria'] = $harga_pria;
                $kalkulasi['harga_pria_pergram'] = $harga_pria_pergram;
                $kalkulasi['biaya_produksi_pria'] = $pria->biaya_produksi;
                
            }else{
                $kalkulasi['berat_pria']  = null;
            }
    
            if ($berat_wanita != null){
                $wanita = \App\Namalogam::find($id_wanita);
                //$wanita = DB::table('namalogam')->find($id_wanita);
    
                if ($wanita->jenis !='silver'){
                    /*if ($wanita->jenis == 'emas') $x = $hp_emas;
                    if ($wanita->jenis == 'ep') $x = $hp_emas;
                    if ($wanita->jenis == 'palladium') $x = $hp_palladium;
                    if ($wanita->jenis == 'platinum') $x = $hp_platinum;
                    if ($wanita->jenis == 'platidium') $x = (($hp_platinum + $hp_palladium) / 2);
                    */
                
                    $harga_wanita = ($wanita->harga_final * $berat_wanita) + $wanita->biaya_produksi;
                    $harga_wanita_pergram = $wanita->harga_final;
    
    
                    $kadar_wanita = $wanita->kadar;
                }elseif ($wanita->jenis == 'silver'){
                    
                    $harga_wanita = 265000;
                    $kadar_wanita = 20;
                    $harga_wanita_pergram = 0;
    
                }
    
                $kalkulasi['jenis_wanita'] = $wanita->jenis;
                $kalkulasi['logam_wanita'] = $wanita->title;
                $kalkulasi['berat_wanita'] = $berat_wanita;
                $kalkulasi['harga_wanita'] = $harga_wanita;
                $kalkulasi['harga_wanita_pergram'] = $harga_wanita_pergram;
                $kalkulasi['biaya_produksi_wanita'] = $wanita->biaya_produksi;
                
            }else{
                $kalkulasi['berat_wanita']  = null;
                
            }
        
    
            $total = $harga_pria + $harga_wanita;
            $kalkulasi['total'] = $total;
    
            if ($kadar_pria >= 50 || $kadar_wanita >= 50){
                $kalkulasi['dp'] = 70;
            }else {
                $kalkulasi['dp'] = 50;
            }
    
            /*if ($berat_pria != null && $berat_wanita != null){
                $kalkulasi['ongkos_bikin'] = $ongkos_bikin;
            }  else {
                $kalkulasi['ongkos_bikin'] = ($ongkos_bikin/2);
            }
            */
    
            $kalkulasi['detail'] = 1;
    
            //return view('logam.kalkulator3',compact('logam','hargapokok','kalkulasi'));
            return response()->json([
                'kalkulasi' => $kalkulasi,
            ], 201);
            
        }elseif ($request->isMethod('get')){
            return response()->json([
                'logam' => $logam,
            ], 201);
        }
            
        
        
    }
}