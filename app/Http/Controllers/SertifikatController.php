<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Http\UploadedFile;
use JD\Cloudder\Facades\Cloudder;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
   
    // --- sertifikat blok --//
    
    function sertifikatform($id){
        $data = \App\Pesanan::where('id',$id)->get();
        
        return view('sertifikat.sertifikatform')
            ->with('data',$data);
    }

    function prosessertifikat(Request $request){

        $toleransi_susut = -0.3; 
        $toleransi_pria = 0;
        $toleransi_wanita = 0;



        $id = $request->input('id');
        $pesanan = \App\Pesanan::find($id);
        
        if (!empty($request->file('sertifikat_gambarcincin'))){
        
            $this->validate($request,[
                'sertifikat_gambarcincin'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('sertifikat_gambarcincin')->getRealPath();
     
            Cloudder::upload($image_name, null);
            $res = Cloudder::getResult();
            $pesanan->sertifikat_gambarcincin = $res['url'];
        }else{

        }

        $pesanan->sertifikat_beratpria = $request->input('sertifikat_beratpria');
        $pesanan->sertifikat_beratwanita = $request->input('sertifikat_beratwanita');
        $pesanan->ongkos_bikin = $request->input('ongkos_bikin');
        
        $pesanan->sertifikat_berlian = $request->input('sertifikat_berlian');
        $pesanan->sertifikat_harga_berlian = $request->input('sertifikat_harga_berlian');

        if (!empty($request->input('harga_cincin_jika_perak_pria'))){
            $pesanan->sertifikat_hargapria = $request->input('harga_cincin_jika_perak_pria');
        }

        if (!empty($request->input('harga_cincin_jika_perak_wanita'))){
            $pesanan->sertifikat_hargawanita = $request->input('harga_cincin_jika_perak_wanita');
        }
        
        if (!empty($request->input('sertifikat_beratpria')) && !empty($request->input('sertifikat_beratwanita')) && $pesanan->is_premium != 0){
            //-- couple
            /*$produksi_pria = $pesanan->produksi_beratpria * $pesanan->produksi_hargapria;
            $Produksi_wanita = $pesanan->produksi_beratwanita * $pesanan->produksi_hargawanita;
            $total_produksi = $produksi_pria + $Produksi_wanita + $pesanan->modal_pengrajin + $pesanan->modal_lapis;
            */

            $selisih_pria = $request->input('sertifikat_beratpria') - $pesanan->produksi_beratpria;
           
                            
            $selisih_wanita = $request->input('sertifikat_beratwanita') - $pesanan->produksi_beratwanita;

            $text = "No order ".$request->input('id')."\n".
                "Telah dibuat sertifikatnya \n".
                "Berat pria pada sertifikat ".$request->input('sertifikat_beratpria')."gr \n".
                "Logam yg disediakan untuk cincin pria ".$pesanan->produksi_beratpria."gr \n".
                "Selisih ". $selisih_pria."gr \n \n".
                "Berat wanita pada sertifikat ".$request->input('sertifikat_beratwanita')."gr \n".
                "Logam yg disediakan untuk cincin wanita ".$pesanan->produksi_beratwanita."gr \n".
                "Selisih ". $selisih_wanita."gr \n";
            
                if ($selisih_pria < $toleransi_susut){
                      Telegram::sendMessage([
                        'chat_id' => -1001386921740, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => "Susut pria melebihi toleransi yang ditentukan ".$selisih_pria,
                    ]);

                    $toleransi_pria = $selisih_pria;
                }

                if ($selisih_wanita < $toleransi_susut){
                    Telegram::sendMessage([
                        'chat_id' => -1001386921740, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => "Susut wanita melebihi toleransi yang ditentukan ".$selisih_wanita,
                    ]);

                    $toleransi_wanita = $selisih_wanita;
                }

            }elseif (!empty($request->input('sertifikat_beratpria')) && empty($request->input('sertifikat_beratwanita')) && $pesanan->is_premium != 0){
                //-- cincin pria 

                $selisih_pria = $pesanan->produksi_beratpria - $request->input('sertifikat_beratpria');
                
                $text = "No order ".$request->input('id')."\n".
                    "Telah dibuat sertifikatnya \n".
                    "Berat pria pada sertifikat ".$request->input('sertifikat_beratpria')."gr \n".
                    "Logam yg disediakan untuk cincin pria ".$pesanan->produksi_beratpria."gr \n".
                    "Selisih ". $selisih_pria."gr \n";
                
                if ($selisih_pria < $toleransi_susut){
                      Telegram::sendMessage([
                        'chat_id' => -1001386921740, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => "Susut pria melebihi toleransi yang ditentukan ".$selisih_pria,
                    ]);
                }

            }elseif (empty($request->input('sertifikat_beratpria')) && !empty($request->input('sertifikat_beratwanita')) && $pesanan->is_premium !=0 ){
                //-- cincin wanita saja

                $selisih_pria = $pesanan->produksi_beratpria -  $request->input('sertifikat_beratpria');
                $selisih_wanita = $pesanan->produksi_beratwanita - $request->input('sertifikat_beratwanita');

                $text = "No order ".$request->input('id')."\n".
                    "Telah dibuat sertifikatnya \n".
                    "Berat wanita pada sertifikat ".$request->input('sertifikat_beratwanita')."gr \n".
                    "Logam yg disediakan untuk cincin wanita ".$pesanan->produksi_beratwanita."gr \n".
                    "Selisih ". $selisih_wanita."gr \n";

                if ($selisih_wanita < $toleransi_susut){
                    Telegram::sendMessage([
                        'chat_id' => -1001386921740, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => "Susut wanita melebihi toleransi yang ditentukan ".$selisih_wanita,
                    ]);
                }

            }else{
                $text = "Cincin pria dan wanita kosong";
                $pesanan->sertifikat_done = 0;
            }
        
        Telegram::sendMessage([
            'chat_id' => -1001386921740, // zavira virtual office
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
       
        
        
        if ($pesanan->ongkos_bikin == 0 ) $pesanan->sertifikat_done = 1; // perak
        if ($pesanan->ongkos_bikin > 0 ) $pesanan->sertifikat_done = 2; // emas, pall, pl
        

        $pesanan->save();

        if ($toleransi_pria != 0 || $toleransi_wanita != 0){
            //-- insert ke history
            $data = [
                ['pesanan_id' => $id, 'user_id' => Auth::id(), 'keterangan' => 'Susut melebihi toleransi yang diijinkan, yaitu toleransi pria '.$toleransi_pria.' dan toleransi wanita '.$toleransi_wanita ],
                ['pesanan_id' => $id, 'user_id' => Auth::id(), 'keterangan' => 'Sertifikat logam telah dibuat' ],
            ];

            \App\History::insert($data);

        }else{
            history_insert($id,Auth::id(),'Dibuat sertifikat dengan selisih logam pria '.$toleransi_pria.' dan selisih logam wanita '.$toleransi_wanita);
        }

        //-- insert ke tabel susut 
        $data = [
            ['pria' => $request->input('sertifikat_beratpria'), 'wanita' => $request->input('sertifikat_beratwanita'),'status' => 'Berat ketika dibuat sertifikat','pesanan_id' => $id,'user_id' => Auth::id()],
        ];

        \App\Susut::insert($data);



        if ($pesanan->ispremium == 2){
            return redirect()->route('sertifikat.premium',['id'=>$id]);
        }elseif ($pesanan->ispremium == 1){
            return redirect()->route('sertifikat.single',['id'=>$id]);
        }else{
            return redirect()->route('sertifikat.silver',['id'=>$id]);
        }

        
    }

    function printsertifikat($id){
        $data = \App\Pesanan::where('id',$id)->first();
        return view('sertifikat.premium')
            ->with('data',$data);
    }

    function searchsertificate(Request $request){
        $q = $request->input('q');
        $data = \App\Pesanan::where('id',$q)->where('ispremium','=',1)->get();
        $ongkosbikin = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin'])->get();

        return view('sertifikat',compact('data','ongkosbikin'));
    }


    //--- end sertifikat blok--//
}
