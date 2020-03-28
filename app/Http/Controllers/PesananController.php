<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use DB;

Class PesananController extends Controller{

    function cetakamplop($id){
        $pesanan = \App\Pesanan::where('id',$id)->first();
        return view('pesanan.amplop')->with('data',$pesanan);
    }

    function filter(){
        $data = \App\Asal::all()->pluck('id','title');
        return view('pesanan.filter',compact('data'));
    }

    function simplefilter(){
        return view('pesanan.simplefilter');
    }

    function generatecoupon($id){
        $voucher = strtoupper($id.str_random(7));
        $undian = strtoupper($id.str_random(7));
        DB::table('pesanan')->where('id', $id)->update(['voucher' => $voucher, 'undian'=>$undian]);

        return redirect()->route('semua')->with('status','Kode voucher '.$voucher.' dan nomor undian '.$undian.' berhasil dibuat. Silahkan informasikan kepada konsumen');
    }

    function filtered(Request $request){
       
        $asal = $request->input('asal_id');
        $awal = $request->input('tanggal_awal');
        $akhir = $request->input('tanggal_akhir');
        $finising_type = $request->input('finising_type');

        if ($request->input('export') == '0'){
             
            if ($asal == 0){
                $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                    ->where('finising',$finising_type)    
                    ->with('user','pengrajin','asal','kurir')->simplePaginate(15);
                
                $data_count = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])
                    ->where('finising',$finising_type)    
                    ->with('user','pengrajin','asal','kurir')->get()->count();
    
                $bahanpria = \App\Pesanan::select('bahanpria', DB::raw('count(*) as total'))
                    ->whereBetween('tglmasuk',[$awal,$akhir])
                    ->groupBy('bahanpria')
                    ->get();
    
                $bahanwanita = \App\Pesanan::select('bahanwanita', DB::raw('count(*) as total'))
                    ->whereBetween('tglmasuk',[$awal,$akhir])
                    ->groupBy('bahanwanita')
                    ->get();
    
                $finising = \App\Pesanan::select('finising', DB::raw('count(*) as total'))
                    ->whereBetween('tglmasuk',[$awal,$akhir])
                    ->groupBy('finising')
                    ->get();
                
    
            }else{
                $data = \App\Pesanan::where('asal_id',$asal)
                    ->where('finising',$finising_type)    
                    ->whereBetween('tglmasuk',[$awal,$akhir])->with('user','pengrajin','asal','kurir')->simplePaginate(15);

                $data_count = \App\Pesanan::where('asal_id',$asal)
                    ->where('finising',$finising_type)    
                    ->whereBetween('tglmasuk',[$awal,$akhir])->with('user','pengrajin','asal','kurir')->get()->count();
    
                
                $bahanpria = \App\Pesanan::select('bahanpria', DB::raw('count(*) as total'))
                    ->where('asal_id',$asal)
                    ->whereBetween('tglmasuk',[$awal,$akhir])
                    ->groupBy('bahanpria')
                    ->get();
    
                $bahanwanita = \App\Pesanan::select('bahanwanita', DB::raw('count(*) as total'))
                    ->where('asal_id',$asal)
                    ->whereBetween('tglmasuk',[$awal,$akhir])
                    ->groupBy('bahanwanita')
                    ->get();
    
                $finising = \App\Pesanan::select('finising', DB::raw('count(*) as total'))
                    ->where('asal_id',$asal)
                    ->whereBetween('tglmasuk',[$awal,$akhir])
                    ->groupBy('finising')
                    ->get();
            }
            
            return view('pesanan',compact('data','bahanpria','bahanwanita','finising','data_count'));
        }else{
            $data = \App\Pesanan::select('id','nama','nohp',$request->input('export'))->whereBetween('tglmasuk',[$awal,$akhir])->orderBy('id','asc')->get();
            return view('pesanan.export',compact('data'));
        }
    }

    function fix(){
        $data_pesanan = \App\Pesanan::all();
        $id_array = [];
        $sekarang = date('d M Y');
        foreach ($data_pesanan as $item){
            //-- jika no resi sudah ada, langsung di update ke finsiing = 
            /*
            null = pesanan dimasukkan ke database dan jika sudah di kirim_ke_pengrajin = 1, maka status pesanan sudah dikerjakan oleh pengrajin
            1 = pesanan masuk finising (lapis)
            2 = pesanan kembali ke showroom 
            3 = pesanan sudah dikirim dengan no resi ter-input
            */

            //if ((!empty($item->resi) && $item->finising != 3) || (!empty($item->resi) && $item->finising == 2) || (!empty($item->resi) && $item->finising == 1) || (!empty($item->resi) && $item->finising == null)){
            if (empty($item->resi) && !empty($item->pelunasan)){
                //- kumpulkan ke dalam array
                array_push($id_array,$item->id);
            }

            if (!empty($item->resi) && !empty($item->pelunasan) && ($sekarang > date('d M Y', strtotime($item->tglselesai)))){
                array_push($id_array,$item->id);
            }
        }
        if (!empty($id_array)){
            // update ke database
            \App\Pesanan::whereIn('id',$id_array)->update(['finising'=>3,'resi'=>'DIAMBIL/COD']);
            $id_array = []; //-- kosoingkan lagi untuk proses selanjutnya
        }

        return redirect()->route('semua')->with('status','Data telah berhasil diperbaiki');
    }

    function statistik($detail=null){
        if ($detail == null){
                /*
            null = pesanan dimasukkan ke database dan jika sudah di kirim_ke_pengrajin = 1, maka status pesanan sudah dikerjakan oleh pengrajin
            1 = pesanan masuk finising (lapis)
            2 = pesanan kembali ke showroom 
            3 = pesanan sudah dikirim dengan no resi ter-input
            */
            $no_proses = \App\Pesanan::where('kirim_ke_pengrajin',0)->where('finising',null)->where('arsipkan',0)->get()->count();
            $on_proses = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',null)->get()->count();
            $on_lapis = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',1)->get()->count();
            $on_office = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',2)->get()->count();
            $on_sent = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',3)->get()->count();
            $on_office_lunas = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',5)->get()->count();
            $on_sent_no_resi = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',6)->get()->count();
            $on_reparasi = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',4)->get()->count();
            $all_order = \App\Pesanan::get()->count();

            return view('pesanan.statistik',compact('on_proses','on_lapis','on_office','on_sent','all_order','no_proses','on_office_lunas','on_sent_no_resi','on_reparasi'));
        }else{
            if ($detail == 'no_proses')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',0)->where('finising',null)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_proses')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',null)->simplePaginate(15);
            if ($detail == 'on_lapis')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',1)->simplePaginate(15);
            if ($detail == 'on_office')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',2)->simplePaginate(15);
            if ($detail == 'on_sent')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',3)->simplePaginate(15);
            if ($detail == 'on_office_lunas')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',5)->simplePaginate(15);
            if ($detail == 'on_sent_no_resi')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',6)->simplePaginate(15);
            if ($detail == 'on_reparasi')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',4)->simplePaginate(15);
            
            return view('pesanan',compact('data'));
        
            
        }
        
    }

    function sedekah(Request $request){
        if ($request->all()){
            $awal = $request->input('tanggal_awal');
            $akhir = $request->input('tanggal_akhir');

            $data_pesanan = \App\Pesanan::whereBetween('tglmasuk', [$awal, $akhir])->get();
            return view('pesanan.sedekah',compact('data_pesanan'));
        }else{
            return view('pesanan.sedekah');
        }
        
    }

    function garansi($id){
        $data = DB::table('pesanan')->where('id',$id)->first();
        return view('pesanan.garansi',compact('data'));
    }

    function pelunasan(Request $request){
       $id = $request->input('id');
       $jenis =  $request->input('jenis');
       $target =  $request->input('nominal');

        $pesanan = \App\Pesanan::find($id);

       if ($jenis == 'pelunasan'){
           
           if (!empty($pesanan->resi)){
              $pesanan->finising = 3; 
           }
           $pesanan->pelunasan = $target;
           $pesanan->save();

        //-- simpan ke neraca
           $neraca = new \App\Neraca;  
           $neraca->neraca_insert($target,'Pelunasan no order '.$id,1,Auth::id());

           //-- kirim notifikasi via telegram

           Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => "No orderan ".$id." telah dilunasi sebesar ".rupiah($target)
            ]);

       }elseif ($jenis == 'resi'){
           if (!empty($pesanan->pelunasan)){
               $pesanan->finising = 5;
           }
            $pesanan->resi = $target;
            $pesanan->save();

            //-- kirim notifikasi via telegram

           Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => "No orderan ".$id." telah ada no resinya ".$target,
            ]);
       }

        notif_statistik();

        return redirect()->route('semua')->with('status','Data berhasil disimpan');		
    }
    
    /*function prosespelunasan(Request $request){
        $id = $request->input('id');
        $redirect = $request->input('re');
        $pesanan = \App\Pesanan::find($id);

        if (!empty($request->input('resi')) && !empty($request->input('pelunasan'))){
            //-- status 3 adalah barang sudah dikirim dan sudah ada no resi nya dan sudah dilunasi
            $pesanan->finising = 3;
            kirim_telegram('Hallo,'.$pesanan->user->name.' orderan anda dengan no orderan '.$id.' sudah dikirim dan memiliki no resi '.$request->input('resi'),$pesanan->user->chat_id);

        }elseif (empty($request->input('resi')) && !empty($request->input('pelunasan'))){
            //-- status 5 adalah barang belum dikirim (masih di showroom) tapi SUDAH dilunasi
            $pesanan->finising = 5;
            kirim_telegram('Hallo,'.$pesanan->user->name.' orderan anda dengan no orderan '.$id.' belum dikirim tetapi sudah lunas',$pesanan->user->chat_id);
        }elseif (!empty($request->input('resi')) && empty($request->input('pelunasan'))){
            //-- status 6 adalah barang sudah dikirim, tapi belum ada pelunasan
            $pesanan->finising = 6;

            kirim_telegram('Hallo,'.$pesanan->user->name.' orderan anda dengan no orderan '.$id.' sudah dikirim tetapi belum ada data pelunasan',$pesanan->user->chat_id);
        }
        
        $pesanan->resi = $request->input('resi');
        $pesanan->pelunasan = $request->input('pelunasan');
        $pesanan->ongkir = $request->input('ongkir');
        $pesanan->save();

        if (empty($request->input('resi'))){
            $text = "No order ".$request->input('id')."\n".
            "Telah dilunasi dengan nominal ".rupiah($request->input('pelunasan'))." dan memiliki no resi pengiriman ".$request->input('resi');

            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
            
            notif_statistik();
            
        }        

       /* if (!empty($request->input('resi')) && !empty($pesanan->email)){
            //-- kirim email 
            $resi = [
                'resi'=>$request->input('resi'),
                'kurir'=>$pesanan->kurir->title,
            ];
            \Mail::send('emails.resi', ['resi'=>$resi], function ($message) use($pesanan) {
               
                $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->to($pesanan->email,$pesanan->nama)->subject('No Resi Kiriman dari Zavira Jewelry');
            });
        }
        

        if ($redirect == 'cetak.amplop'){
            return redirect()->route($redirect,['id'=>$id])->with('status','Data berhasil di update');
        }else{
            return redirect()->route($redirect)->with('status','Data berhasil di update');
        }
    }
    */

    function woodbox_add(Request $request){
        $ids = $request->input('id');
        $id_arr = explode('*',$ids);
        //dd($id_arr);
        DB::table('pesanan')->whereIn('id',$id_arr)->update(['woodbox_ok'=>1]);
        $data_grafir = DB::table('pesanan')->select('free_woodbox')->whereIn('id',$id_arr)->get();

        return view('pesanan.woodbox',compact('data_grafir'));

    }

    function statistik_perbandingan(Request $request){
        $cs = DB::table('users')->pluck('id','name');
        $tgl_sekarang = date('Y-m-d');
        $cs_id = 0;
        $bulan = date('m');
        $tahun = date('Y');
        if ($request->isMethod('post')){
            //-- form submited 
            $cs_id = $request->input('cs');
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');
            if ($cs_id != 0 && $bulan !=0 ){
                $stat = \App\Pesanan::where('user_id',$cs_id)->whereMonth('tglmasuk',$bulan)->whereYear('tglmasuk',$tahun)->where('arsipkan',0)->get();
            }elseif($cs_id != 0 && $bulan == 0){
                $stat = \App\Pesanan::where('user_id',$cs_id)->whereYear('tglmasuk',$tahun)->where('arsipkan',0)->get();
            }elseif($cs_id == 0 && $bulan == 0){
                $stat = \App\Pesanan::whereYear('tglmasuk',$tahun)->where('arsipkan',0)->get();
            }
            else{
                $stat = \App\Pesanan::whereMonth('tglmasuk',$bulan)->whereYear('tglmasuk',$tahun)->where('arsipkan',0)->get();
            }
            
            return view('pesanan.stat',compact('stat','cs_id','cs','bulan','tahun'));
            /*$tgl_sekarang = $request->input('titik_tanggal');
            $date = new \DateTime($tgl_sekarang);
            $date->modify('-1 month');
            $satu_bulan_lalu = $date->format('Y-m-d');

            $date->modify('-2 months');
            $dua_bulan_lalu = $date->format('Y-m-d');

            
            $date->modify('-3 months');
            $tiga_bulan_lalu = $date->format('Y-m-d');

            $cs_id = $request->input('cs');
            
            $stat = [];
            if ($cs_id != 0){
                $data = \App\Pesanan::where('user_id',$cs_id)->whereBetween('tglmasuk',[$satu_bulan_lalu,$tgl_sekarang])->get();
            //array_add($stat,'data',$data->count());
            

                $data2 = \App\Pesanan::where('user_id',$cs_id)->whereBetween('tglmasuk',[$dua_bulan_lalu,$satu_bulan_lalu])->get();
                //array_add($stat,'data 2',$data2->count());

                $data3 = \App\Pesanan::where('user_id',$cs_id)->whereBetween('tglmasuk',[$tiga_bulan_lalu,$dua_bulan_lalu])->get();
            }else{
                $data = \App\Pesanan::whereBetween('tglmasuk',[$satu_bulan_lalu,$tgl_sekarang])->get();
            
            

                $data2 = \App\Pesanan::whereBetween('tglmasuk',[$dua_bulan_lalu,$satu_bulan_lalu])->get();
                

                $data3 = \App\Pesanan::whereBetween('tglmasuk',[$tiga_bulan_lalu,$dua_bulan_lalu])->get();
            }
            
            //array_add($stat,'data 3',$data3->count());

            array_push($stat,[
                date('d M Y',strtotime($satu_bulan_lalu)).' s/d '.date('d M Y',strtotime($tgl_sekarang))  => $data->count(),
                date('d M Y',strtotime($dua_bulan_lalu)).' s/d '.date('d M Y',strtotime($satu_bulan_lalu)) => $data2->count(),
                date('d M Y',strtotime($tiga_bulan_lalu)).' s/d '.date('d M Y',strtotime($dua_bulan_lalu)) => $data3->count(),
                ]);

           print_r($stat);
           
           
           

           return view('pesanan.stat',compact('cs','cs_id','stat','tgl_sekarang'));
         
           */
        }

        return view('pesanan.stat',compact('cs','cs_id','tahun','bulan'));
    }


    function buyback(Request $request){
        if ($request->isMethod('post')){
            //-- posted
            $berat = $request->input('berat');
            $kadar = $request->input('kadar')/100;
            $potongan = 150000;
            $harga_harian_emas = \App\Setting::where('kunci','harga_harian_emas')->first();

            $harga_buyback = ($berat * ($kadar * $harga_harian_emas->isi)) - 150000;
            $data = [];
            array_push($data,['berat'=>$berat,'harga_buyback'=>$harga_buyback,'kadar'=>$kadar]);
            return view('logam.buyback',compact('data'));
        }
        return view('logam.buyback');
    }

    function hapus($id){
        DB::table('pesanan')->where('id',$id)->update(['arsipkan'=>1]);
        \App\Neraca::where('pesanan_id',$id)->delete();
        return redirect()->route('semua')->with('status','Data berhasil diarsipkan/dihapus');
    }

    function lead($action=null,$id=null,Request $request){
        if ($action == null){
           if ($request->isMethod('post')){
            
            $lead = new \App\Lead;
            $lead->chat = $request->input('chat');
            $lead->closing = $request->input('closing');
            $lead->user_id = Auth::id();
            $lead->catatan = $request->input('catatan');
            $lead->save();

            $cs = Auth::user();


            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $cs->name." telah memasukkan data chat. Chat : ".$request->input('chat')." Closing : ".$request->input('closing'),
            ]);

            return redirect()->route('pesanan.lead')->with('status','Data pesanan berhasil disimpan');

            }else{
                $user_id = Auth::id();
                $lead = \App\Lead::orderBy('created_at','asc')->where('user_id',$user_id)->get();
                return view('pesanan.lead',compact('lead'));
            } 
        }elseif($action == 'update'){
            if ($request->isMethod('post')){
                $id = $request->input('id');
                $lead = \App\Lead::find($id);
                $lead->chat = $request->input('chat');
                $lead->closing = $request->input('closing');
                $lead->catatan = $request->input('catatan');
                $lead->save();

                return redirect()->route('pesanan.lead')->with('status','Data pesanan berhasil disimpan');

            }else{
                $data = \App\Lead::find($id);
                return view('pesanan.editlead',compact('data'));
            }
        }elseif($action == 'all'){
            $lead = \App\Lead::orderBy('created_at','asc')->simplePaginate(15);
            return view('pesanan.leadall',compact('lead'));
        }
        
    }

}