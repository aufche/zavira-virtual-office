<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

Class LabaController extends Controller{

    function index(Request $request){
        
        //-- hitung saldo cash 
        $buku = \App\Buku::all();
        $saldo = [];
        foreach ($buku as $item){
            $bulan = date('F Y');
            $saldo_buku = $item->saldo;
            $pemasukan = \App\Pembukuan::where('bulantahun','=',$bulan)->where('buku_id','=',$item->id)->sum('masuk');
            $pengeluaran = \App\Pembukuan::where('bulantahun','=',$bulan)->where('buku_id','=',$item->id)->sum('keluar');
            $total = $saldo_buku + ($pemasukan - $pengeluaran);
            
            $saldo = array_add($saldo,$item->title,$total);
        }
        //-- end hitung saldo 

        $showroom = \App\Asal::all()->pluck('id','title');
        
        if (empty($request->all())){
            //$data = \App\Pesanan::where('sertifikat_done','>=',1)->orderBy('id','desc')->Simplepaginate(15);
            $data = \App\Pesanan::where('sertifikat_done','>=',1)->orderBy('id','desc')->Simplepaginate(15);
            //dd($data);
        }else{
            $asal = $request->input('asal_id');
            $awal = $request->input('tanggal_awal');
            $akhir = $request->input('tanggal_akhir');
            $no_order = $request->input('no_order');

            if (!empty($asal)){
                $data = \App\Pesanan::where('sertifikat_done','>=',1)->whereBetween('tglmasuk',[$awal,$akhir])->where('asal_id',$asal)->orderBy('id','desc')->Simplepaginate(15);
                $keuangan = \App\Pesanan::where('sertifikat_done','>=',1)->whereBetween('tglmasuk',[$awal,$akhir])->where('asal_id',$asal)->orderBy('id','desc')->get();
            }elseif (!empty($no_order)){
                $data = \App\Pesanan::where('id',$no_order)->where('sertifikat_done','>=',1)->orderBy('id','desc')->Simplepaginate(15);
                $keuangan = \App\Pesanan::where('id',$no_order)->where('sertifikat_done','>=',1)->orderBy('id','desc')->get();
            }else{
                $data = \App\Pesanan::where('sertifikat_done','>=',1)->whereBetween('tglmasuk',[$awal,$akhir])->orderBy('id','desc')->Simplepaginate(15);
                $keuangan = \App\Pesanan::where('sertifikat_done','>=',1)->whereBetween('tglmasuk',[$awal,$akhir])->orderBy('id','desc')->get();
            }
            $laba = 0;
            $ongkos_perak = 0;
            $ongkos_premium = 0;
            $data_ongkos_kosong_perak = 0;
            $data_ongkos_kosong_premium = 0;
            
            foreach ($keuangan as $item){
                //-- cari modal produksinya
                if ($item->sertifikat_done == 2){
                    //-- semuanya emas /pall, bisa sepasang atau 1
                    if ($item->yang_premium == 'PW'){
                        $modal_produksi = ($item->produksi_beratpria*$item->produksi_hargapria)+($item->produksi_beratwanita*$item->produksi_hargawanita)+$item->modal_pengrajin+$item->modal_lapis;
                        $jual = ($item->sertifikat_beratpria*$item->sertifikat_hargapria)+($item->sertifikat_beratwanita*$item->sertifikat_hargawanita)+$item->ongkos_bikin;
                    }
                    
                    if ($item->yang_premium == 'P'){
                        $modal_produksi = ($item->produksi_beratpria*$item->produksi_hargapria)+$item->modal_pengrajin+$item->modal_lapis;
                        $jual = ($item->sertifikat_beratpria*$item->sertifikat_hargapria)+$item->ongkos_bikin;
                    }
                    
                    if ($item->yang_premium == 'W'){
                        $modal_produksi = ($item->produksi_beratwanita*$item->produksi_hargawanita)+$item->modal_pengrajin+$item->modal_lapis;
                        $jual = ($item->sertifikat_beratwanita*$item->sertifikat_hargawanita)+$item->ongkos_bikin;
                    }

                    if (empty($item->modal_pengrajin)){
                        $data_ongkos_kosong_premium = $data_ongkos_kosong_premium + 1;
                    }
                    $ongkos_premium = $ongkos_premium + $item->modal_pengrajin;
                    
                }elseif ($item->sertifikat_done == 1){
                    $modal_produksi = $modal_produksi = ($item->produksi_beratpria*$item->produksi_hargapria)+($item->produksi_beratwanita*$item->produksi_hargawanita)+$item->modal_pengrajin+$item->modal_lapis;
                    $jual = $item->hargabarang;
                    $ongkos_perak = $ongkos_perak + $item->modal_pengrajin;

                    if (empty($item->modal_pengrajin)){
                        $data_ongkos_kosong_perak = $data_ongkos_kosong_perak + 1;
                    }

                }

                $laba = (int)$laba+((int)$jual - (int)$modal_produksi);
                $data_tambahan = [];
                $data_tambahan = array_add($data_tambahan,'awal',$awal);
                $data_tambahan = array_add($data_tambahan,'akhir',$akhir);
                $data_tambahan = array_add($data_tambahan,'laba',$laba);
                $data_tambahan = array_add($data_tambahan,'ongkos_premium',$ongkos_premium);
                $data_tambahan = array_add($data_tambahan,'ongkos_perak',$ongkos_perak);
                $data_tambahan = array_add($data_tambahan,'data_ongkos_kosong_perak',$data_ongkos_kosong_perak);
                $data_tambahan = array_add($data_tambahan,'data_ongkos_kosong_premium',$data_ongkos_kosong_premium);
            }
        }
        
        return view('laba.lihatlaba',compact('data','showroom','data_tambahan','saldo'));
    }

    function detail($id){
        $data = \App\Pesanan::find($id);
        return view('laba.detail',compact('data'));
    }

    function saldocash(){
        $buku = \App\Buku::all();
        $saldo = [];
        foreach ($buku as $item){
            $bulan = date('F Y');
            $saldo_buku = $item->saldo;
            $pemasukan = \App\Pembukuan::where('bulantahun','=',$bulan)->where('buku_id','=',$item->id)->sum('masuk');
            $pengeluaran = \App\Pembukuan::where('bulantahun','=',$bulan)->where('buku_id','=',$item->id)->sum('keluar');
            $total = $saldo_buku + ($pemasukan - $pengeluaran);
            
            $saldo = array_add($saldo,$item->title,$total);
        }
    }

    function gaji(Request $request){
        //$cs = DB::table('users')->whereNotIn('id',[2])->pluck('id','name');
        $cs = DB::table('users')->pluck('id','name');
        $awal = date('Y-m-d');
        $akhir = date('Y-m-d');
        $cs_id = 0;
        $status_order = 'done';
        $include_reseller = '0';
        
        if ($request->isMethod('post')) {
            $awal = $request->input('tanggal_awal');
            $akhir = $request->input('tanggal_akhir');
            $cs_id = $request->input('cs');
            $status_order = $request->input('status_order');
            $include_reseller = $request->input('include_reseller');

           /* $query = new \App\Pesanan;
            //$query->whereBetween('tglmasuk',[$awal,$akhir]);
            
            /*if ($status_order == 'done'){
                //-- orderan selesai, berarti modal pengrajin, lapis dan ongkir sudah terisi
                $query->whereNotNull('modal_pengrajin');
                $query->whereNotNull('modal_lapis');
                $query->whereNotNull('ongkir');
            }
            
                 $query->whereNotNull('modal_pengrajin');
                $query->whereNotNull('modal_lapis');
                $query->whereNotNull('ongkir');
                $query->where('user_id',$cs_id);
            $data = $query->get();
*/
            if ($status_order == 'done' && $include_reseller == 1){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                    ->whereNotNull('modal_pengrajin')
                    ->whereNotNull('modal_lapis')
                    ->whereNotNull('ongkir')
                    ->whereIn('asal_id',[5,6])
                    ->where('user_id',$cs_id)->where('arsipkan',0)->get();
            }elseif ($status_order == 'not' && $include_reseller == 0){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                    ->whereNotIn('asal_id',[5,6])
                    ->where('user_id',$cs_id)->where('arsipkan',0)->get();
            }elseif ($status_order == 'done' && $include_reseller == 0){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                    ->whereNotNull('modal_pengrajin')
                    ->whereNotNull('modal_lapis')
                    ->whereNotNull('ongkir')
                    ->whereNotIn('asal_id',[5,6])
                    ->where('user_id',$cs_id)->where('arsipkan',0)->get();
            }elseif ($status_order == 'not' && $include_reseller == 1){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                ->whereIn('asal_id',[5,6])
                ->where('user_id',$cs_id)->get();
            }elseif ($status_order == 'all'){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                ->where('user_id',$cs_id)->where('arsipkan',0)->get();
            }elseif ($status_order == 'all' && $include_reseller == 0){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                ->whereNotIn('asal_id',[5,6])
                ->where('user_id',$cs_id)->where('arsipkan',0)->get();
            }
          
            

            //whereNotNull('modal_pengrajin')->whereNotNull('modal_lapis')->whereNotNull('ongkir')->where('user_id',$cs_id)->get();

            //->whereBetween('tglmasuk',[$awal,$akhir])->where('user_id',$cs_id)->get();

            
            //$data = \App\Pesanan::where('user_id',$cs_id)->whereNotIn('asal_id',[5,6,7])->where('arsipkan',0)->whereBetween('tglmasuk',[$awal,$akhir])->get();

            $elemen_gaji = DB::table('users')->where('id',$cs_id)->first();
            return view('laba.gaji',compact('cs','data','elemen_gaji','awal','akhir','cs_id','status_order','include_reseller'));    
                                        
        } 
        return view('laba.gaji',compact('cs','awal','akhir','cs_id','status_order','include_reseller'));
    }

    
}