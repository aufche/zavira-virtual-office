<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;

Class RestapiController extends Controller{

    function logam(){
        $data = \App\Namalogam::orderBy('title','asc')->get();

        return response()->json($data, 201);
    }

    function hargapokok(){
        $data = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get();

        return response()->json($data, 201);
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
            //'kecamatan'=>$request->input('kecamatan'),
            //'kodepost'=>$request->input('kodepost'),
            //'promo'=>$request->input('promo'),
            'link'=>$request->input('link'),
        ];

        if (!empty($request->input('kodecincin'))){
            $orderan = array_add($orderan,'kodecincin',$request->input('kodecincin'));
        }

        if (!empty($request->input('url_gambar_cincin'))){
            $orderan = array_add($orderan,'url_gambar_cincin',$request->input('url_gambar_cincin'));
        }

    

        if (!empty($request->input('pria'))){
            //-- pesen cincin pria
            $orderan = array_add($orderan,'bahanpria',$request->input('bahanpria'));
            $orderan = array_add($orderan,'ukuranpria',$request->input('ukuranpria'));
            $orderan = array_add($orderan,'grafirpria',$request->input('grafirpria'));
            $orderan = array_add($orderan,'beratpria',$request->input('berat_pria'));
            $orderan = array_add($orderan,'hargapria',$request->input('jenis_logam_pria'));
        }

        if (!empty($request->input('wanita'))){
            //-- pesen cincin wanita
            $orderan = array_add($orderan,'bahanwanita',$request->input('bahanwanita'));
            $orderan = array_add($orderan,'ukuranwanita',$request->input('ukuranwanita'));
            $orderan = array_add($orderan,'grafirwanita',$request->input('grafirwanita'));
            $orderan = array_add($orderan,'beratwanita',$request->input('berat_wanita'));
            $orderan = array_add($orderan,'hargawanita',$request->input('jenis_logam_wanita'));
        }


        if (!empty($request->file('upload_cincin'))){
        
            $this->validate($request,[
                'upload_cincin'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('upload_cincin')->getRealPath();
     
            Cloudder::upload($image_name, null);
            $res = Cloudder::getResult();
            $orderan = array_add($orderan,'upload_cincin',$res['url']);
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
 
        return redirect()->away('https://api.whatsapp.com/send?phone='.$cs[0]->wa.'&text=Hallo%20kak%20'.$cs[0]->nama_cs.'%20Saya%20ingin%20bertanya%20mengenai%20cincin%20kawin');
        //dd($cs);
       // echo $cs[0]->wa;
    }

    function couple_pricelist(){
        $data_logam = \App\Namalogam::orderBy('title','asc')->get()->toArray();
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
}