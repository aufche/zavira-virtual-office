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

    function edit(Request $request,$id){
        if ($request->isMethod('post')){
            $id = $request->input('id');
            $neraca = \App\Neraca::find($id);
            $neraca->nominal = $request->input('nominal');
            $neraca->keterangan = $request->input('keterangan');
            $neraca->status = $request->input('status');
            $neraca->save();
            return redirect()->route('neraca.edit',['id'=>$id])->with('status','Data pesanan berhasil disimpan');
            
        }else{
            $data = \App\Neraca::find($id);
            return view('neraca.edit',compact('data'));
        }
    }

    function index(Request $request){
        if ($request->isMethod('get')){
            $currentMonth = date('m');
            $currentYear = date('Y');
            $data = \App\Neraca::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('id','desc')->get();
            return view ('neraca.index',compact('data','currentMonth','currentYear'));
        }elseif ($request->isMethod('post')){
            $currentMonth = $request->input('bulan');
            $currentYear = $request->input('tahun');
            $data = \App\Neraca::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('id','desc')->get();
            return view ('neraca.index',compact('data','currentYear','currentMonth'));
        }
        
    }

    function hapus($id){
        \App\Neraca::where('id',$id)->delete();
        return redirect()->route('neraca.index')->with('status','Data pesanan berhasil dihapus');
    }
}
