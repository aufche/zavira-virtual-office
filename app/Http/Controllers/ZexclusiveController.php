<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

Class ZexclusiveController extends Controller{

    function add(){
        $namalogam = DB::table('namalogam')->pluck('id','title');
        return view('ze.add',compact('namalogam'));
    }
    
    function insert(Request $request){
       /* $data_paket = [
            'kode_bahan_pria' => $request->input('kode_bahan_pria'),
            'kode_bahan_wanita' => $request->input('kode_bahan_wanita'),
            'berat_pria' => $request->input('berat_pria'),
            'berat_wanita' => $request->input('berat_wanita'),
        ];
        */
        $ongkos_bikin_couple = 750000;
        $ongkos_bikin_single = 400000;
        $data_paket = [];
        $caption = [];
        
        if (!empty($request->input('berat_pria'))){
            $data_paket = array_add($data_paket,'berat_pria',$request->input('berat_pria'));
            $data_paket = array_add($data_paket,'kode_bahan_pria',$request->input('kode_bahan_pria'));
            $pria = cariharga($request->input('kode_bahan_pria'));
            $caption = array_add($caption,'caption_logam_pria',$pria['title']);
            $caption = array_add($caption,'caption_berat_logam_pria',$request->input('berat_pria'));
            $total_pria = $pria['hargapergram'] * $request->input('berat_pria');
            $score_pria = 1;
        }else{
            $total_pria = 0;
            $score_pria = 0;
        }

        if (!empty($request->input('berat_wanita'))){
            $data_paket = array_add($data_paket,'berat_wanita',$request->input('berat_wanita'));
            $data_paket = array_add($data_paket,'kode_bahan_wanita',$request->input('kode_bahan_wanita'));
            $wanita = cariharga($request->input('kode_bahan_wanita'));

            $caption = array_add($caption,'caption_logam_wanita',$wanita['title']);
            $caption = array_add($caption,'caption_berat_logam_wanita',$request->input('berat_wanita'));

            $total_wanita = $wanita['hargapergram'] * $request->input('berat_pria');
            $score_wanita = 1;
        }else{
            $total_wanita = 0;
            $score_wanita = 0;
        }

        if (($score_pria + $score_wanita) == 2){
            //-- coupole
            $ongkos_bikin = $ongkos_bikin_couple;
        }else{
            $ongkos_bikin = $ongkos_bikin_single;
        }
        $kotak_kayu = 300000;
        $ongkir = 100000;

        $total = $ongkos_bikin + $total_pria + $total_wanita + $kotak_kayu + $ongkir;

        $caption = array_add($caption,'harga_paket',$total);
        
        $data_paket = array_add($data_paket,'harga_paket',$total);

        $id = DB::table('zepaket')->insertGetId($data_paket);

        $caption = array_add($caption,'kode_paket','ZE'.$id);
        
        DB::table('zepaket')->where('id',$id)->update(['kode_paket'=>'ZE'.$id]);

        

        return view('ze.insert',compact('caption'));
    }

    function index($id=null){
        
            $data = \App\Zepaket::orderBy('id','desc')->Simplepaginate(10);
            return view('ze.index',compact('data'));
        
        
    }

    function detail($id){
            $data = \App\Zepaket::find($id);
            $caption = [];

            $caption = array_add($caption,'harga_paket',$data->harga_paket);
            $caption = array_add($caption,'kode_paket',$data->kode_paket);

            $caption = array_add($caption,'caption_logam_wanita',title_logam($data->bahanwanita()->first(),'title'));
            $caption = array_add($caption,'caption_berat_logam_wanita',$data->berat_wanita);

            $caption = array_add($caption,'caption_logam_pria',title_logam($data->bahanpria()->first(),'title'));
            $caption = array_add($caption,'caption_berat_logam_pria',$data->berat_pria);

            return view('ze.insert',compact('caption'));
    }
}