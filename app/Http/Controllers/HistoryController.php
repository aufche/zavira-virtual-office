<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    //

    function detail($id){
        //$history_pesanan = \App\History::orderBy('created_at','desc')->where('pesanan_id',$id)->with('pesanan')->get();
        $history_pesanan = \App\History::where('pesanan_id',$id)->get();
       // $history_pesanan = \App\Pesanan::find($id)->history()->with('pesanan')->get();
        //dd($history_pesanan);    
        return view('history.detail',compact('history_pesanan','id'));
    }
}
