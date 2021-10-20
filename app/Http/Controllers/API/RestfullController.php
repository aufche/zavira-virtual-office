<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Http\UploadedFile;

class RestfullController extends Controller
{
    //

    function update($apa = 'harga_final', Request $request){
        if ($apa == 'harga_final'){
            
            $id = $request->input('id');
            $harga = $request->input('nominal');

            DB::table('pesanan')->where('id',$id)->update([
                'harga_final' => $harga,
            ]);
        }

        if ($apa == 'pelunasan'){
            
            $id = $request->input('id');
            $harga = $request->input('nominal');

            DB::table('pesanan')->where('id',$id)->update([
                'pelunasan' => $harga,
            ]);
        } 
    }
    
    function daftar_harga(){
        //- single
        
        $all = DB::table('namalogam')->whereIn('jenis',['emas','palladium','platinum'])->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('jenis','asc')->orderBy('kadar','asc')->get();

        //-- couple 
        $pair = ['s100*ek12', 's100*ek20', 'p10*ek12', 'p25*ek12', 'p25*ek20', 'p25*ek12', 's100*ek40', 'p30*ek20', 's100*ek33', 's100*ek401', 'p25*ek33', 'p25*ek40', 'pl20*ek40', 'pl30*ek40', 'pl40*ek50', 'pl40*epaudp40', 's100*ek75', 's100*epaudp75', 'p50*ek50', 'p50*ek75', 'pl40*ek75', 'p50*epaudp50', 'p40*epaudp75', 'p25*ek92', 'p50*epaudp75', 'p75*ek75', 'p75*ek92', 'p75*epaudp75', 'p75*ek95'];

        $logam = DB::table('namalogam')->orderBy('kadar','asc')->whereNotNull('active')->whereNotNull('persentase_markup')->get()->toArray();

        

        return response()->json([
            'all' => $all,
            'pair' => $pair,
            'logam' => $logam,
        ], 201);
    }

    function order(Request $request){
        // $orderan = [
        //     'nama'=>$request->input('nama'),
        //     'ukuranpria'=>$request->input('ukuranpria'),
        //     'grafirpria'=>$request->input('grafirpria'),
        //     'ukuranwanita'=>$request->input('ukuranwanita'),
        //     'grafirwanita'=>$request->input('grafirwanita'),
        //     'nohp'=>number_international($request->input('nohp')),
        //     'instagram'=>$request->input('ig'),
        //     'email'=>$request->input('email'),
        //     'alamat'=>$request->input('alamat'),
        // ];

        // $id = DB::table('orderweb')->insertGetId($orderan);

        /*$text = "Horaaayyy....!!! ada pesanan masuk dari toko online. No order".$id."\n";
        $text .= $request->input('nohp')."\n";
        $text .= "Selamat siang, kami dari Zavira Jewelry. Pesanan Anda sudah kami terima, sebentar kami hitungkan dulu total belanjanya";
        */
        //$text = '<a href="https://wa.me/'.number_international($request->input('nohp')).'/?text=Selamat+siang%2C+kami+dari+Zavira+Jewelry.+Pesanan+Anda+sudah+kami+terima%2C+sebentar+kami+hitungkan+dulu+total+belanjanya">'.number_international($request->input('nohp')).'</a>';
        
            $total = 0;
            $deskripsi_pria = null;
            $deskripsi_wanita = null;
            $cincin_pria = 0;
            $cincin_wanita = 0;
            $gambar = array();
            if ($request->hasFile('file')){
                if (count($request->file('file')) >= 2){
                    //-- upload lebih dari 1 gambar
                    foreach ($request->file('file') as $item){
                        $image_name = $item->getRealPath();
                        //$gbr = upload_gambar($image_name);
                        array_push($gambar,upload_gambar($image_name));
                     }
                }else{
                    //-- upload single 
                    $image_name = $request->file('file')[0]->getRealPath();
                    $gbr = upload_gambar($image_name);
                }
            }else{
                $gbr = null;
            }
            
            
            $text = "Nama ".$request->nama."\n";
            $text .= "Alamat ".$request->alamat."\n";
            $text .= "No WA ".$request->nohp."\n";
            $text .= "Email ".$request->email."\n";
            $text .= "Kode cincin ".$request->kode_cincin."\n";

            if ($request->check_pria == 'on' && !empty($request->pria)){
                $pria = explode('|',$request->pria);
                if (!empty($pria[0])){
                    $biaya_pria = (($pria[0] * $request->berat_pria) + $pria[1]);
                }else{
                    $biaya_pria = $pria[1];
                }
                $text .= "==============="."\n";
                $text .= "Bahan pria ".$pria[2]."\n";
                $text .= "Berat Pria ".$request->berat_pria."gr \n";
                $text .= "Ukuran Jari Pria ".$request->size_pria."\n";
                $text .= "Grafir pria ".$request->grafir_pria."\n";
                $text .= "Biaya Cincin Pria ".rupiah($biaya_pria)."\n";
                //$biaya_pria = (($pria[0] * $request->berat_pria) + $pria[1]);
                $total = $total + $biaya_pria;
                $deskripsi_pria = "Cincin pria ".$pria[2]." berat ".$request->berat_pria."gr";
                $cincin_pria = 1;
                
            }
            
            if ($request->check_wanita == 'on' && !empty($request->wanita)){
                $wanita = explode('|',$request->wanita);
                
                if (!empty($wanita[0])){
                    $biaya_wanita = (($wanita[0] * $request->berat_wanita) + $wanita[1]);
                }else{
                    $biaya_wanita = $wanita[1];
                }

                $text .= "==============="."\n";
                $text .= "Bahan Wanita ".$wanita[2]."\n";
                $text .= "Berat Wanita ".$request->berat_wanita."\n";
                $text .= "Ukuran Jari Wanita ".$request->size_wanita."\n";
                $text .= "Grafir Wanita ".$request->grafir_wanita."\n";
                $text .= "Biaya Cincin Wanita ".rupiah($biaya_wanita)."\n";
                //$biaya_wanita = (($wanita[0] * $request->berat_wanita) + $wanita[1]);
                $total = $total + $biaya_wanita;
                $deskripsi_wanita = "Cincin wanita ".$wanita[2]." berat ".$request->berat_wanita."gr ";
                $cincin_wanita = 1;
            }

            if ($request->check_pria == 'on' && $request->check_wanita == 'on'){
                $title = 'Cincin Kawin Couple';
            }else{
                $title = 'Cincin Single';
            }
            
            $text .= "==============="."\n";
            $text .= "Kode Promo ".$request->kode_promo."\n";
            $text .= "Total ".rupiah($total);
           
            

            if (!empty($gambar)){
                foreach ($gambar as $pic){
                    Telegram::sendPhoto([
                        'chat_id' => -730265436, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'photo'=>InputFile::create($pic, "photo.jpg"),
                    ]);  
                }
                
                Telegram::sendMessage([
                    'chat_id' => -730265436, // zavira virtual office
                    'parse_mode' => 'HTML',
                    'text' => $text, 
                ]);

            }else{
                if ($gbr != null){
                    Telegram::sendPhoto([
                        'chat_id' => -730265436, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'photo'=>InputFile::create($gbr, "photo.jpg"),
                        'caption' => $text,
                    ]);
                }else{
                    Telegram::sendMessage([
                        'chat_id' => -730265436, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => $text, 
                    ]);
                }
                
            }
            
            


            //-- bikin invoice
            //if ($request->add_invoice == 'on'){
                //-- buat catatan invoice
                $client = new \GuzzleHttp\Client();
                $url = 'https://akuntansi.zavirajewelry.com/api/front-invoice';
                $response = $client->post($url,['form_params'=> [
                        'nama' => $request->input('nama'),
                        'nohp' => number_international($request->input('nohp')),
                        'alamat' => $request->input('alamat'),
                        'harga' => $total,
                        'cincin_pria' => $cincin_pria,
                        'cincin_wanita' => $cincin_wanita,
                        'deskripsi_pria' => $deskripsi_pria,
                        'deskripsi_wanita' => $deskripsi_wanita,
                        'biaya_pria' => $biaya_pria,
                        'biaya_wanita' => $biaya_wanita,

                    ]
                ]);
           // }
            //--- end bikin invoice
        //dd($response->);
        $res = json_decode($response->getBody(),false);
        //dd($res->link);
        //return redirect()->away($res->link);
        return redirect()->away('https://zavirajewelry.com/terimakasih');
 }

 function detail($id){
    $pesanan = \App\Pesanan::find($id);

    return response()->json([
        'pesanan' => $pesanan,
    ], 201);
 }
}