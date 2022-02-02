<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class BuybackController extends Controller
{
    //
    function insert(Request $request){
        if ($request->isMethod('post')){
            //-- post submited
            $buyback = new \App\Buyback;
            $buyback->nominal = $request->nominal;
            $buyback->namalogam_id = $request->namalogam_id;
            $buyback->berat = $request->berat;
            $buyback->user_id = Auth::id();
            $buyback->pesanan_id = $request->pesanan_id;
            $buyback->status = $request->status;
            $buyback->antrian = $request->antrian;
            $buyback->catatan = $request->catatan;
            $buyback->save();

            return redirect()->route('buyback.edit',['id'=>$buyback->id])->with('status','Data pesanan berhasil disimpan');

        }elseif ($request->isMethod('get')){
            $namalogam = DB::table('namalogam')->where('jenis','emas')->orWhere('jenis','ep')->pluck('id','title');
            return view ('buyback.insert',compact('namalogam'));
        }
    }

    function edit(Request $request,$id = null){
        if ($request->isMethod('post')){
            $id = $request->input('id');
            $buyback = \App\Buyback::find($id);
            $buyback->nominal = $request->input('nominal');
            
            $buyback->status = $request->input('status');
            $buyback->antrian = $request->antrian;
            
            
            $buyback->namalogam_id = $request->input('namalogam_id');
            $buyback->berat = $request->input('berat');
            $buyback->user_id = Auth::id();
            $buyback->pesanan_id = $request->input('pesanan_id');
            $buyback->catatan = $request->input('catatan');
            

            $buyback->save();
            return redirect()->route('buyback.index')->with('status','Data pesanan berhasil disimpan');
            
        }else{
            $data = \App\Buyback::find($id);
            $namalogam = DB::table('namalogam')->where('jenis','emas')->orWhere('jenis','ep')->pluck('id','title');
            return view('buyback.edit',compact('data','namalogam'));
        }
    }

    function index(){
       $data = \App\Buyback::orderBy('status','desc')->orderBy('antrian','desc')->simplePaginate(10);
       return view('buyback.index',compact('data'));
        
    }

    function hapus($id){
        \App\Buyback::where('id',$id)->delete();
        return redirect()->route('buyback.index')->with('status','Data berhasil dihapus');
    }
}
