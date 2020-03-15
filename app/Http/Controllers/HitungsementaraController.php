<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

Class HitungsementaraController extends Controller{
    
    public function index(){
            $data_sementara = DB::table('hitung_sementara')->get();
              //$data_sementara = \App\Hitung::groupBy('identitas')->select('identitas', \DB::raw('count(*) as total'))->get();
        
        return view('sementara.index',compact('data_sementara'));
    }

    public function delete($identitas){
        \App\Hitung::where('identitas',$identitas)->delete();
        return redirect()->route('sementara.index')->with('status','Data pesanan berhasil dihapus');		
    }

}
