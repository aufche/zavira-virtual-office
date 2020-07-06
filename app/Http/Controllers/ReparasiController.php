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

    function index(){
        $data = \App\Reparasi::with('pesanan')->orderBy('id','desc')->Simplepaginate(10);
        $title = 'Semua Reparasi';
        return view('reparasi.index',compact('data'));
    }
    
    function reparasiform($id){
        $data = \App\Pesanan::where('id',$id)->get();
        return view('reparasiform')->with('data',$data);
    }

    function prosesreparasiform(Request $request){
        /*$id = DB::table('reparasi')->insertGetId(
            [
                'kelengkapan' => $request->input('kelengkapan_paket'),
                'keterangan' => $request->input('keterangan_reparasi'),
                'pesanan_id' => $request->input('id'),
                'created_at' => \Carbon\Carbon::now(),
                'tdeadline' => $request->input('tdeadline'),
            ]
        );
        */

        $reparasi = new \App\Reparasi;
        $reparasi->kelengkapan = $request->input('kelengkapan_paket');
        $reparasi->keterangan = $request->input('keterangan_reparasi');
        $reparasi->pesanan_id = $request->input('id');
        $reparasi->tdeadline = $request->input('tdeadline');
        $reparasi->save();


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

        history_insert($request->input('id'),Auth::id(),'Pesanan masuk ke reparasi dengan '.$request->input('keterangan_reparasi'));

        return redirect()->route('reparasi.index')->with('status','Data reparasi berhasil disimpan');
    }

    function riwayat($id){
        $data = \App\Reparasi::where('pesanan_id',$id)->paginate(10);
        /*$pdf = PDF::loadView('riwayat', ['data'=>$data]);
        return $pdf->download('invoice.pdf');
        */
        return view('reparasi.index',compact('data','id'));
    }

    function delete($id){
        \App\Reparasi::where('id',$id)->delete();
        return redirect()->route('reparasi.index')->with('status','Reparasi sudah dihapus');
    }

}