<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\Auth;

class BuktitransferController extends Controller
{
    //

    function insert(Request $request){
        $bukti_ss = explode(',',$request->input('screenshot'));
        $identitas = $request->input('identitas');
        $screenshot = null;

        //-- upload bukti transfer
        foreach ($bukti_ss as $image){
                Cloudder::upload($image, null);
                $result = Cloudder::getResult();
                
                $screenshot = $screenshot.','.$result['url'];
            }
        //-- mencari pesanan_id di table biaya_produksi berdasarkan identitas

        $pesanan_id = DB::table('biaya_produksi')->where('identitas',$identitas)->get();
        $pesanan_id_str = null;
        foreach ($pesanan_id as $item){
            $pesanan_id_str = $pesanan_id_str.$item->pesanan_id.'('.$item->pw.'),';
        }


        
        $bukti_transfer = [
            'identitas' => $request->input('identitas'),
            'bukti_transfer' => $screenshot,
            'pesanan_id' => $pesanan_id_str,
            'created_at'=>\Carbon\Carbon::now(),
        ];

        DB::table('bukti_transfer')->insert($bukti_transfer);

        $neraca = new \App\Neraca;
        $neraca->neraca_insert($request->input('nominal'),'Bayar logam ke pak bejo dengan no identitas '.$request->input('identitas'),0,Auth::id());

        return redirect()->route('bukti.index')->with('status','Data pesanan berhasil disimpan');		
    }

    function index(){
        $bukti_transfer = \App\Buktitransfer::orderBy('id','desc')->simplePaginate(10);
        return view('bukti.index',compact('bukti_transfer'));
    }

    function cetak($detail){
            $id = [];
            $data = \App\Biayaproduksi::where('identitas','=',$detail)->get();
            foreach ($data as $item){
                array_push($id,$item->pesanan_id);
            }
            
            $screenshot = \App\Buktitransfer::where('identitas',$detail)->first();

            $harga = \App\Setting::whereIn('kunci',['harga_harian_emas','harga_harian_palladium','harga_harian_platinum'])->orderBy('kunci','asc')->get();
            return view('pesanan.biayaproduksi',compact('data','harga','screenshot'));
    }

    function search(Request $request){
        $q = $request->input('q');
        $bukti_transfer = \App\Buktitransfer::where('pesanan_id','like','%'.$q.'%')->paginate(15);
        return view('bukti.index',compact('bukti_transfer'));
    }

}
