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

        $namalogam = \App\Namalogam::whereNotNull('persentase_markup')->whereNotNull('active')->get();

        foreach ($namalogam as $item){
            if ($item->jenis == 'emas'){
                $markup = ($item->persentase_markup / 100) * $request->input('harga_pokok_emas');
                DB::table('namalogam')->where('id',$item->id)->update([
                    'markup' => $markup,
                    'harga_final' => $markup + (($item->kadar/100) * $request->input('harga_pokok_emas')),
                ]);
            }

            if ($item->jenis == 'palladium'){
                $markup = ($item->persentase_markup / 100) * $request->input('harga_pokok_palladium');
                DB::table('namalogam')->where('id',$item->id)->update([
                    'markup' => $markup,
                    'harga_final' => $markup + (($item->kadar/100) * $request->input('harga_pokok_palladium')),
                ]);
            }

            if ($item->jenis == 'platinum'){
                $markup = ($item->persentase_markup / 100) * $request->input('harga_pokok_platinum');
                DB::table('namalogam')->where('id',$item->id)->update([
                    'markup' => $markup,
                    'harga_final' => $markup + (($item->kadar/100) * $request->input('harga_pokok_platinum')),
                ]);
            }

            if ($item->jenis == 'platidium'){
                $harga_gabungan = ( $request->input('harga_pokok_platinum') + $request->input('harga_pokok_palladium')) / 2;
                $markup = ($item->persentase_markup / 100) * $harga_gabungan;
                DB::table('namalogam')->where('id',$item->id)->update([
                    'markup' => $markup,
                    'harga_final' => $markup +  ($item->kadar/100) * $harga_gabungan,
                ]);
            }

            if ($item->jenis == 'ep'){
                $tambahan_platinum = 0.125 * $request->input('harga_pokok_platinum'); // murni
                $tambahan_palladium = 0.125 * $request->input('harga_pokok_palladium'); // murni
                $harga_gabungan = $request->input('harga_pokok_emas') + $tambahan_platinum + $tambahan_palladium; // murni
                
                $markup = ($item->persentase_markup / 100) * $harga_gabungan;
                DB::table('namalogam')->where('id',$item->id)->update([
                    'markup' => $markup,
                    'harga_final' => $markup + ($item->kadar/100) * $harga_gabungan,
                ]);
            }
        }
        
        

        return redirect()->route('setting.all')->with('status','Data berhasil disimpan');
    }
}