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
        
            $image_name = $request->file('file')->getRealPath();
     
             $gbr = upload_gambar($image_name);



            $pria = explode('|',$request->pria);
            $wanita = explode('|',$request->wanita);
            $text = "Nama ".$request->nama."\n";
            $text .= "Alamat ".$request->alamat."\n";
            $text .= "No WA ".$request->nohp."\n";
            $text .= "Email ".$request->email."\n";
            $text .= "==============="."\n";
            $text .= "Bahan pria ".$pria[2]."\n";
            $text .= "Berat Pria ".$request->berat_pria."gr \n";
            $text .= "Grafir pria ".$request->grafir_pria."\n";
            $text .= "Biaya Cincin Pria ".rupiah((($pria[0] * $request->berat_pria) + $pria[1]))."\n";

            $text .= "==============="."\n";
            $text .= "Bahan Wanita ".$wanita[2]."\n";
            $text .= "Berat Wanita ".$request->berat_wanita."\n";
            $text .= "Grafir Wanita ".$request->grafir_wanita."\n";
            $text .= "Biaya Cincin Wanita ".rupiah((($wanita[0] * $request->berat_wanita) + $wanita[1]))."\n";
            $text .= "==============="."\n";
            $text .= "Total ".rupiah(((($pria[0] * $request->berat_pria) + $pria[1]) + (($wanita[0] * $request->berat_wanita) + $wanita[1])));
           
            // Telegram::sendMessage([
            //     'chat_id' => -1001386921740, // zavira virtual office
            //     'parse_mode' => 'HTML',
            //     'text' => $text, 
            //     'photo' => 'https://laravelquestions.com/wp-content/uploads/2020/10/GP6a1.png',
            // ]);

            Telegram::sendPhoto([
                'chat_id' =>-1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'photo'=>InputFile::create($gbr, "photo.jpg"),
                 'caption' => $text,
            ]);

       return redirect()->away('https://zavirajewelry.com/terimakasih');
 }
}

