<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Http\UploadedFile;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
   
    // --- sertifikat blok --//
    
    function sertifikatform($id){
        $data = \App\Pesanan::where('id',$id)->first();
        
        return view('sertifikat.sertifikatform')
            ->with('data',$data);
    }

    function prosessertifikat(Request $request){

        $toleransi_susut = -0.3; 
        $toleransi_pria = 0;
        $toleransi_wanita = 0;
        $men = 0;
        $women = 0;
        $url_foto = 0;



        $id = $request->input('id');
        $pesanan = \App\Pesanan::find($id);
        
        if (!empty($request->file('sertifikat_gambarcincin'))){
        
            $this->validate($request,[
                'sertifikat_gambarcincin'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('sertifikat_gambarcincin')->getRealPath();
            
            $url_foto = upload_gambar($image_name);
            $pesanan->sertifikat_gambarcincin = $url_foto;
           
        }else{

        }

        $pesanan->sertifikat_beratpria = $request->input('sertifikat_beratpria');
        $pesanan->sertifikat_beratwanita = $request->input('sertifikat_beratwanita');
        $pesanan->ongkos_bikin = $request->input('ongkos_bikin');
        
        $pesanan->sertifikat_berlian = $request->input('sertifikat_berlian');
        $pesanan->sertifikat_harga_berlian = $request->input('sertifikat_harga_berlian');

        if (!empty($request->input('harga_cincin_jika_perak_pria'))){
            $pesanan->sertifikat_hargapria = $request->input('harga_cincin_jika_perak_pria');
            $men = $request->input('harga_cincin_jika_perak_pria');
        }else{
            $men = ($pesanan->sertifikat_hargapria * $request->input('sertifikat_beratpria')) + $request->input('biaya_produksi_pria');
        }

        if (!empty($request->input('harga_cincin_jika_perak_wanita'))){
            $pesanan->sertifikat_hargawanita = $request->input('harga_cincin_jika_perak_wanita');
            $women = $request->input('harga_cincin_jika_perak_wanita');
        }else{
            $women = ($pesanan->sertifikat_hargawanita * $request->sertifikat_beratwanita) + $request->biaya_produksi_wanita;
        }

        
        
        if (!empty($request->input('sertifikat_beratpria')) && !empty($request->input('sertifikat_beratwanita')) && $pesanan->ispremium != 0){
            //-- couple
            /*$produksi_pria = $pesanan->produksi_beratpria * $pesanan->produksi_hargapria;
            $Produksi_wanita = $pesanan->produksi_beratwanita * $pesanan->produksi_hargawanita;
            $total_produksi = $produksi_pria + $Produksi_wanita + $pesanan->modal_pengrajin + $pesanan->modal_lapis;
            */

            ///$nominal_update = ($pesanan->sertifikat_hargapria * $request->input('sertifikat_beratpria')) + $request->input('biaya_produksi_pria') +  ($pesanan->sertifikat_hargawanita * $request->sertifikat_beratwanita) + $request->biaya_produksi_wanita;

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
                        'text' => "No Order ".$request->input('id')." Susut pria melebihi toleransi yang ditentukan ".$selisih_pria,
                    ]);

                    $toleransi_pria = $selisih_pria;
                }

                if ($selisih_wanita < $toleransi_susut){
                    Telegram::sendMessage([
                        'chat_id' => -1001386921740, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => "No Order ".$request->input('id')." Susut wanita melebihi toleransi yang ditentukan ".$selisih_wanita,
                    ]);

                    $toleransi_wanita = $selisih_wanita;
                }

            }elseif (!empty($request->input('sertifikat_beratpria')) && empty($request->input('sertifikat_beratwanita')) && $pesanan->ispremium != 0){
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
                        'text' => "No Order ".$request->input('id')." Susut pria melebihi toleransi yang ditentukan ".$selisih_pria,
                    ]);
                }

            }elseif (empty($request->input('sertifikat_beratpria')) && !empty($request->input('sertifikat_beratwanita')) && $pesanan->ispremium !=0 ){
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
                        'text' => "No Order ".$request->input('id')." Susut wanita melebihi toleransi yang ditentukan ".$selisih_wanita,
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
                ['created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'pesanan_id' => $id, 'user_id' => Auth::id(), 'keterangan' => 'Susut melebihi toleransi yang diijinkan, yaitu toleransi pria '.$toleransi_pria.' dan toleransi wanita '.$toleransi_wanita ],
                ['created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'pesanan_id' => $id, 'user_id' => Auth::id(), 'keterangan' => 'Sertifikat logam telah dibuat' ],
            ];

            \App\History::insert($data);

        }else{
            history_insert($id,Auth::id(),'Dibuat sertifikat dengan selisih logam pria '.$toleransi_pria.' dan selisih logam wanita '.$toleransi_wanita);
        }

        //-- insert ke tabel susut 
        
        $susut = new \App\Susut;
        $susut->pria = $request->input('sertifikat_beratpria');
        $susut->wanita = $request->input('sertifikat_beratwanita');
        $susut->status = 'Berat ketika dibuat sertifikat';
        $susut->pesanan_id = $id;
        $susut->user_id = Auth::id();
        $susut->save();


       /* if ($item->ispremium == 1 && $item->skema_baru == null) echo route('sertifikat.single',['id'=>$item->id]);
        if ($item->ispremium == 2 && $item->skema_baru == null) echo route('sertifikat.premium',['id'=>$item->id]);
        if ($item->ispremium == 0 && $item->skema_baru == null) echo route('sertifikat.silver',['id'=>$item->id]);
        if ($item->ispremium == 2 && $item->skema_baru == 1) echo route('nota',['id'=>$item->id, 'material' => 'premium']);
        if ($item->ispremium == 1 && $item->skema_baru == 1) echo route('nota',['id'=>$item->id, 'material' => 'halfpremium']);
        if ($item->ispremium == 0 && $item->skema_baru == 1) echo route('sertifikat.silver',['id'=>$item->id]);
        */

        //-- update ke aplikasi akuntasi
        
        //$nominal_update = ($pesanan->sertifikat_hargapria * $request->input('sertifikat_beratpria')) + $request->input('biaya_produksi_pria') +  ($pesanan->sertifikat_hargawanita * $request->sertifikat_beratwanita) + $request->biaya_produksi_wanita;
        //$wanita = ($pesanan->sertifikat_hargawanita * $request->sertifikat_beratwanita) + $request->biaya_produksi_wanita;
        $nominal_update = $men + $women;

        //dd($request->all());

        $client = new \GuzzleHttp\Client();
        $url = 'https://akuntansi.zavirajewelry.com/api/sync';
        if ($url_foto != 0){
            $request = $client->post($url,['form_params'=> 
                [
                    'nominal_update' => $nominal_update,
                    'pesanan_id' => $id,
                    'foto' => $url_foto,
                ]
            ]);
        }else{
            $request = $client->post($url,['form_params'=> 
            [
                'nominal_update' => $nominal_update,
                'pesanan_id' => $id,
            ]
        ]);
        }
        


        if ($pesanan->ispremium == 2 && $pesanan->skema_baru == null) return redirect()->route('sertifikat.premium',['id'=>$id]);
        if ($pesanan->ispremium == 1 && $pesanan->skema_baru == null) return redirect()->route('sertifikat.single',['id'=>$id]);
        if ($pesanan->ispremium == 0 && $pesanan->skema_baru == null ) return redirect()->route('sertifikat.silver',['id'=>$id]);

        if ($pesanan->ispremium == 2 && $pesanan->skema_baru == 1) return redirect()->route('nota',['id'=>$pesanan->id, 'material' => 'premium']);
        if ($pesanan->ispremium == 1 && $pesanan->skema_baru == 1) return redirect()->route('nota',['id'=>$pesanan->id, 'material' => 'halfpremium']);
        if ($pesanan->ispremium == 0 && $pesanan->skema_baru == 1) return redirect()->route('sertifikat.silver',['id'=>$pesanan->id]);

            
       
        
    }

    function printsertifikat($id){
        $data = \App\Pesanan::where('id',$id)->first();
        if ($data->promo_id == 8){
            return view('sertifikat.flashsale')->with('data',$data);
        }else{
            return view('sertifikat.premium')->with('data',$data);
        }
        
            
    }

    

    function searchsertificate(Request $request){
        $q = $request->input('q');
        $data = \App\Pesanan::where('id',$q)->where('ispremium','=',1)->get();
        $ongkosbikin = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin'])->get();

        return view('sertifikat',compact('data','ongkosbikin'));
    }


    function nota($id,$material){
        
        $data = \App\Pesanan::where('id',$id)->first();
        if ($material == 'premium') return view('sertifikat.skemabaru.premium',compact('data'));
        if ($material == 'halfpremium' && $data->couple == 1) return view('sertifikat.skemabaru.halfpremiumplus',compact('data')); // ada tambahan cinci perak
        if ($material == 'halfpremium' && $data->couple == 0) return view('sertifikat.skemabaru.halfpremium',compact('data'));
        if ($material == 'silver') return view('sertifikat.silver',compact('data'));
    }
}
