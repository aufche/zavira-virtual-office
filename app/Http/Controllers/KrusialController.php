<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Telegram\Bot\Laravel\Facades\Telegram;

Class KrusialController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function insert(Request $request,$tambahan=null){
        if ($tambahan==null){
            $data_krusial = [
                'pesanan_id'=>$request->input('pesanan_id'),
                'catatan'=>$request->input('catatan'),
                'is_done'=>0,
                'is_proses'=>0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
    
            /*$data_krusial = new Krusial;
            $data_krusial->pesanan_id = $request->input('pesanan_id');
            $data_krusial->catatan = $request->input('catatan');
            $data_krusial->pesanan_id = 0;
            $data_krusial->pesanan_id = 0;
            $data_krusial->save();
            */
    
            $id = DB::table('krusial')->insertGetId($data_krusial);
    
            kirim_telegram('Kode 5 : Ada masalah krusial dengan no order '.$request->input('pesanan_id').' tolong segera dicek',-1001386921740);
            history_insert($request->input('pesanan_id'),Auth::id(),'Masalah krusial '.$request->input('catatan'));

    
            return redirect()->route('semua')->with('status','Permasalahan no order '.$request->input('pesanan_id').' telah dibuatkan ticketnya dengan nomor '.$id);
        }elseif ($tambahan == 'lapis'){
            
            $id = $request->input('pesanan_id');
            $pesanan = \App\Pesanan::find($id);

            $pesanan->jumlah_lapis = $request->input('jumlah_lapis');
            $pesanan->keterangan_orderan = $request->input('keterangan_orderan');
            if ($request->input('tujuan') == ''){
                $pesanan->finising = null;
            }else{
                $pesanan->finising = $request->input('tujuan');
            }
            $pesanan->save();

            kirim_telegram('Kode 7 : No order '.$request->input('pesanan_id').' sudah lapis '.$request->input('jumlah_lapis').' kali',-1001386921740);
            history_insert($request->input('pesanan_id'),Auth::id(),'Lapis berulang '.$request->input('jumlah_lapis').' kali');

            
            //-- perlu diperbaiki
            kirim_telegram('Hallo,'.$pesanan->user->name.' Ada masalah dengan pesanan no order '.$request->input('pesanan_id'),$pesanan->user->chat_id);

            return redirect()->route('semua')->with('status','Data berhasil disimpan');
        }
    }

    function editing(Request $request){
        
        $id = $request->input('id');
        $krusial = \App\Krusial::find($id);

        

        
        if ($request->input('is_proses') == 1 && $krusial->is_proses == 0){
            kirim_telegram('Kode 501 : Permasalahan no order '.$krusial->pesanan_id.' sedang diproses',-1001386921740);
        }


        if ($request->input('is_done') == 1 && $krusial->is_done == 0){
            kirim_telegram('Kode 502 : Permasalahan no order '.$krusial->pesanan_id.' telah teratasi',-1001386921740);
            history_insert($id,Auth::id(),'Permasalahan '.$krusial->catatan.' telah teratasi');
        }

        $krusial->catatan = $request->input('catatan');
        $krusial->is_proses = $request->input('is_proses');
        $krusial->is_done = $request->input('is_done');
        
        $krusial->save();

        return redirect()->route('penting.index')->with('status','Data berhasil disimpan');
        

    }

    function add($id,$tambahan=null){
        if ($tambahan == null){
            return view('krusial.add')->with('pesanan_id',$id);
        }elseif ($tambahan == 'lapis'){
            $data = \App\Pesanan::find($id);
            return view('krusial.tambahanlapis',compact('data'));
        }
        
    }

}