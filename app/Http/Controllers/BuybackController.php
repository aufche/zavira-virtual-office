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
            $neraca = new \App\Buyback;
            $neraca->nominal = $request->nominal;
            $neraca->namalogam_id = $request->namalogam_id;
            $neraca->berat = $request->berat;
            $neraca->user_id = Auth::id();
            $neraca->pesanan_id = $request->pesanan_id;
            $neraca->status = $request->status;
            $neraca->save();

            return redirect()->route('buyback.edit',['id'=>$neraca->id])->with('status','Data pesanan berhasil disimpan');

        }elseif ($request->isMethod('get')){
            $namalogam = DB::table('namalogam')->where('jenis','emas')->orWhere('jenis','ep')->pluck('id','title');
            return view ('buyback.insert',compact('namalogam'));
        }
    }

    function edit(Request $request,$id = null){
        if ($request->isMethod('post')){
            $id = $request->input('id');
            $neraca = \App\Buyback::find($id);
            $neraca->nominal = $request->input('nominal');
            $neraca->keterangan = $request->input('keterangan');
            $neraca->status = $request->input('status');
            
            $neraca->nominal = $request->input('nominal');
            $neraca->namalogam_id = $request->input('namalogam_id');
            $neraca->berat = $request->input('berat');
            $neraca->user_id = Auth::id();
            $neraca->pesanan_id = $request->input('pesanan_id');
            $neraca->status = $request->input('status');

            $neraca->save();
            return redirect()->route('buyback.edit',['id'=>$id])->with('status','Data pesanan berhasil disimpan');
            
        }else{
            $data = \App\Buyback::find($id);
            $namalogam = DB::table('namalogam')->where('jenis','emas')->orWhere('jenis','ep')->pluck('id','title');
            return view('buyback.edit',compact('data','namalogam'));
        }
    }

    function index(){
       $data = \App\Buyback::orderBy('id','desc')->simplePaginate(10);
       return view('buyback.index',compact('data'));
        
    }

    function hapus($id){
        \App\Neraca::where('id',$id)->delete();
        return redirect()->route('neraca.index')->with('status','Data pesanan berhasil dihapus');
    }
}
