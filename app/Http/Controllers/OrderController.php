<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

Class OrderController extends Controller{

    function all(){
        $data = \App\Orderweb::orderBy('id','desc')->paginate(15);
        return view('orderweb.all',compact('data'));
    }

    function search(Request $request){
        $q = $request->input('q');

        $data = \App\Pesanan::where('nama','like','%'.$q.'%')
            ->orWhere('alamat','like','%'.$q.'%')
            ->orWhere('nohp','like','%'.$q.'%')
            ->orWhere('grafirwanita','like','%'.$q.'%')
            ->orWhere('grafirpria','like','%'.$q.'%')
            ->orWhere('id','=',$q)
            ->orderBy('id','desc')->paginate(15);
        return view('orderweb.all',compact('data'));
    }

    
}