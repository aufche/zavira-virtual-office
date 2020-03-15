<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use DB;

Class ReparasiController extends Controller{

    function reparasiform($id){
        $data = \App\Pesanan::where('id',$id)->get();
        return view('reparasiform')->with('data',$data);
    }

    function prosesreparasiform(Request $request){
        $id = DB::table('reparasi')->insertGetId(
            [
                'kelengkapan' => $request->input('kelengkapan_paket'),
                'keterangan' => $request->input('keterangan_reparasi'),
                'pesanan_id' => $request->input('id'),
                'created_at' => \Carbon\Carbon::now(),
                'tdeadline' => $request->input('tdeadline'),
            ]
        );

        //-- update finising menjadi finising=4
        \App\Pesanan::where('id',$request->input('id'))->update(
            [
                'finising'=>4
            ]);

        $text = "Ada reparasi baru dengan no order ".$request->input('id')."\n".
                "Keterangan reparasi ".$request->input('keterangan_reparasi');
        
        //-- notifikasi kepada owner
        Telegram::sendMessage([
            'chat_id' => -1001386921740, // zavira virtual office
            'parse_mode' => 'HTML',
            'text' => $text
        ]);

        //--- notifikasi kepada cs bersangkutan
        $pesanan = \App\Pesanan::where('id',$request->input('id'))->first();

        
        //-- notifikasi kepada CS
        $text_notif = "Hallo, ".$pesanan->user->name.", Client kamu dengan nomor orderan ".$request->input('id')." telah diproses masuk reparasi";
        Telegram::sendMessage([
            'chat_id' => $pesanan->user->chat_id, // zavira virtual office
            'parse_mode' => 'HTML',
            'text' => $text_notif
        ]);

        return redirect()->route('semua');
    }

    function riwayat($id){
        $data = \App\Reparasi::where('pesanan_id',$id)->get();
        /*$pdf = PDF::loadView('riwayat', ['data'=>$data]);
        return $pdf->download('invoice.pdf');
        */
        return view('riwayat')->with('data',$data);
    }

    function delete($id){
        \App\Reparasi::where('id',$id)->delete();
        return redirect()->route('reparasi.index')->with('status','Reparasi sudah dihapus');
    }

}