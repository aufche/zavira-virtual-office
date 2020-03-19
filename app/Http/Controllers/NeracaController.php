<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NeracaController extends Controller
{
    function insert(Request $request){
        if ($request->isMethod('post')){
            //-- post submited
            $neraca = new \App\Neraca;
            $neraca->nominal = $request->nominal;
            $neraca->keterangan = $request->keterangan;
            $neraca->status = $request->status;
            $neraca->user_id = Auth::id();
            $neraca->save();

            return redirect()->route('neraca.index')->with('status','Data pesanan berhasil disimpan');

        }elseif ($request->isMethod('get')){
            return view ('neraca.insert');
        }
    }

    function index(){
        $currentMonth = date('m');
        $data = \App\Neraca::whereRaw('MONTH(created_at) = ?',[$currentMonth])->orderBy('id','desc')->get();
        return view ('neraca.index',compact('data'));
    }

    function hapus($id){
        \App\Neraca::where('id',$id)->delete();
        eturn redirect()->route('neraca.index')->with('status','Data pesanan berhasil dihapus');
    }
}
