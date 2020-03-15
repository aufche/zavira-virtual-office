<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

Class SettingController extends Controller{
    
    function settingform(){
        $data = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','harga_pokok_silver','harga_pokok_platinum','ongkos_bikin','harga_harian_emas','harga_harian_platinum','harga_harian_palladium'])
            ->orderBy('kunci')
            ->get();
        return view('setting.settingform',compact('data'));
    }
    
    function simpansetting(Request $request){
        
        \App\Setting::where('kunci','harga_pokok_palladium')->update(['isi'=>$request->input('harga_pokok_palladium')]);
        \App\Setting::where('kunci','harga_pokok_emas')->update(['isi'=>$request->input('harga_pokok_emas')]);
        \App\Setting::where('kunci','harga_pokok_platinum')->update(['isi'=>$request->input('harga_pokok_platinum')]);
        \App\Setting::where('kunci','harga_pokok_silver')->update(['isi'=>$request->input('harga_pokok_silver')]);

        
        
        \App\Setting::where('kunci','harga_harian_palladium')->update(['isi'=>$request->input('harga_harian_palladium')]);
        \App\Setting::where('kunci','harga_harian_emas')->update(['isi'=>$request->input('harga_harian_emas')]);
        \App\Setting::where('kunci','harga_harian_platinum')->update(['isi'=>$request->input('harga_harian_platinum')]);

        \App\Setting::where('kunci','ongkos_bikin')->update(['isi'=>$request->input('ongkos_bikin')]);
        
        

        return redirect()->route('setting.all')->with('status','Data berhasil disimpan');
    }
}