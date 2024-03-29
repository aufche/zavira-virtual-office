<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

Class ZexclusiveController extends Controller{

    function add(){
        $namalogam = DB::table('namalogam')->whereNotNull('persentase_markup')->whereNotNull('active')->orderBy('title','asc')->pluck('id','title');
        return view('ze.add',compact('namalogam'));
    }
    
    function insert(Request $request){
        $paket = new \App\Zepaket;
        $paket->kode_paket = $request->kode_paket;
        $paket->kode_bahan_pria = $request->kode_bahan_pria;
        $paket->kode_bahan_wanita = $request->kode_bahan_wanita;
        $paket->berat_pria = $request->berat_pria;
        $paket->berat_wanita = $request->berat_wanita;

        $pria = cariharga($request->kode_bahan_pria);
        $paket->pria = $pria['title'];
        
        if ($pria['jenis'] == 'silver'){
            $harga_pria = $pria['hargapergram'] + (0.1 * $pria['hargapergram']);
        }else{
            $harga_pria =  ($pria['hargapergram'] * $request->berat_pria) + $pria['biaya_produksi'];
        }

        $wanita = cariharga($request->kode_bahan_wanita);
        if ($wanita['jenis'] == 'silver'){
            $harga_wanita = $wanita['hargapergram'] + (0.1 * $wanita['hargapergram']);
        }else{
            $harga_wanita =  ($wanita['hargapergram'] * $request->berat_wanita) + $wanita['biaya_produksi'];
        }
        $paket->wanita = $wanita['title'];
        

        // $paket->pria_per_gram = $pria['hargapergram'];
        // $paket->pria_biaya_produksi = $pria['biaya_produksi'];

        // $paket->wanita_per_gram = $wanita['hargapergram'];
        // $paket->wanita_biaya_produksi = $wanita['biaya_produksi'];
        // his.harga_final+"|"+this.biaya_produksi+"|"+this.title
        $paket->set_pria = $pria['hargapergram'].'|'.$pria['biaya_produksi'].'|'.$pria['title'];
        $paket->set_wanita = $wanita['hargapergram'].'|'.$wanita['biaya_produksi'].'|'.$wanita['title'];

        $paket->harga_paket = ($harga_pria + $harga_wanita);
        $paket->type = $request->type;


        $paket->save();

        return redirect()->back();
    }

    function edit(Request $request){
        $id = $request->id;
        $paket = \App\Zepaket::find($id);
        $paket->kode_paket = $request->kode_paket;
        $paket->kode_bahan_pria = $request->kode_bahan_pria;
        $paket->kode_bahan_wanita = $request->kode_bahan_wanita;
        $paket->berat_pria = $request->berat_pria;
        $paket->berat_wanita = $request->berat_wanita;

        $pria = cariharga($request->kode_bahan_pria);
        $paket->pria = $pria['title'];
        
        if ($pria['jenis'] == 'silver'){
            $harga_pria = $pria['hargapergram'] + (0.1 * $pria['hargapergram']);
        }else{
            $harga_pria =  ($pria['hargapergram'] * $request->berat_pria) + $pria['biaya_produksi'];
        }

        $wanita = cariharga($request->kode_bahan_wanita);
        if ($wanita['jenis'] == 'silver'){
            $harga_wanita = $wanita['hargapergram'] + (0.1 * $wanita['hargapergram']);
        }else{
            $harga_wanita =  ($wanita['hargapergram'] * $request->berat_wanita) + $wanita['biaya_produksi'];
        }
        $paket->wanita = $wanita['title'];
        

        // $paket->pria_per_gram = $pria['hargapergram'];
        // $paket->pria_biaya_produksi = $pria['biaya_produksi'];

        // $paket->wanita_per_gram = $wanita['hargapergram'];
        // $paket->wanita_biaya_produksi = $wanita['biaya_produksi'];
        // his.harga_final+"|"+this.biaya_produksi+"|"+this.title
        $paket->set_pria = $pria['hargapergram'].'|'.$pria['biaya_produksi'].'|'.$pria['title'];
        $paket->set_wanita = $wanita['hargapergram'].'|'.$wanita['biaya_produksi'].'|'.$wanita['title'];

        $paket->harga_paket = ($harga_pria + $harga_wanita);
        $paket->type = $request->type;

        $paket->save();

        return redirect()->route('ze.index')->with('status','Data pesanan berhasil disimpan');

    }

    function index($action = null, $id=null){
            if ($action == null){
                $data = \App\Zepaket::orderBy('id','desc')->Simplepaginate(10);
                return view('ze.index',compact('data'));
            }elseif ($action == 'delete'){
                DB::table('zepaket')->where('id',$id)->delete();
                return redirect()->back()->with('status','data berhasil dihapus');
            }elseif ($action == 'edit'){
                $namalogam = DB::table('namalogam')->whereNotNull('persentase_markup')->whereNotNull('active')->orderBy('title','asc')->pluck('id','title');
                $data = \App\Zepaket::find($id);
                return view('ze.edit',compact('data','namalogam'));
            }
        
    }

}