<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

Class DpController extends Controller{

    function index(){
        $dp = \App\Dp::orderBy('id','desc')->simplePaginate(15);
        $total_dp = \App\Dp::sum('nominal');
        return view('laba.dp',compact('dp','total_dp'));
    }

    function bayar(){
        $siap_bayar = \App\Pesanan::where('logam_sesuai',1)->simplePaginate(15);
        return view('pesanan.siapbayar',compact('siap_bayar'));
    }

    

    
    

}