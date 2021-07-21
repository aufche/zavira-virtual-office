<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class RestfullController extends Controller
{
    //

    function update($apa = 'harga_final', Request $request){
        if ($apa == 'harga_final'){
            
            $id = $request->input('id');
            $harga = $request->input('nominal');

            DB::table('pesanan')->where('id',$id)->update([
                'harga_final' => $harga,
            ]);
        }

        if ($apa == 'pelunasan'){
            
            $id = $request->input('id');
            $harga = $request->input('nominal');

            DB::table('pesanan')->where('id',$id)->update([
                'pelunasan' => $harga,
            ]);
        } 
    }
}
