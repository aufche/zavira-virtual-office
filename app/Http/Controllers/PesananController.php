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

        \App\Pesanan::whereNotNull('resi')->update(['finising'=>3]);

        return redirect()->route('pesanan.statistik')->with('status','Data telah berhasil diperbaiki');
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
            $on_proses = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',null)->where('arsipkan',0)->get()->count();
            $on_lapis = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',1)->where('arsipkan',0)->get()->count();
            $on_office = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',2)->where('arsipkan',0)->get()->count();
            $on_sent = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',3)->where('arsipkan',0)->get()->count();
            $on_office_lunas = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',5)->where('arsipkan',0)->get()->count();
            $on_sent_no_resi = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',6)->where('arsipkan',0)->get()->count();
            $on_reparasi = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',4)->where('arsipkan',0)->get()->count();
            $all_order = \App\Pesanan::get()->count();

            return view('pesanan.statistik',compact('on_proses','on_lapis','on_office','on_sent','all_order','no_proses','on_office_lunas','on_sent_no_resi','on_reparasi'));
        }else{
            if ($detail == 'no_proses')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',0)->where('finising',null)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_proses')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',null)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_lapis')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',1)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_office')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',2)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_sent')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',3)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_office_lunas')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',5)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_sent_no_resi')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',6)->where('arsipkan',0)->simplePaginate(15);
            if ($detail == 'on_reparasi')
                $data = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',4)->where('arsipkan',0)->simplePaginate(15);
            
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
           //$neraca = new \App\Neraca;  
           //$neraca->neraca_insert($target,'Pelunasan no order '.$id,1,Auth::id());

           
           //neraca_insert($target,'Pelunasan no order '.$id,1,Auth::id(),$id,'PELUNASAN');
           \App\Neraca::updateOrCreate(['pesanan_id' => $id, 'identitas' => 'PELUNASAN'],
            [
                'nominal' => $target,
                'keterangan' => 'Pelunasan no order '.$id,
                'status' => 1,
                'user_id' => Auth::id(),
                'identitas' => 'PELUNASAN',
                'pesanan_id' => $id
                ]);

           //-- kirim notifikasi via telegram

           Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => "No orderan ".$id." telah dilunasi sebesar ".rupiah($target)
            ]);
            history_insert($id,Auth::id(),'Pesanan sudah dilunasi');

       }elseif ($jenis == 'resi'){
           /*if (!empty($pesanan->pelunasan)){
               $pesanan->finising = 5;
           }
           */
            $pesanan->finising = 3;
            $pesanan->resi = $target;
            $pesanan->save();

            //-- kirim notifikasi via telegram

           Telegram::sendMessage([
                'chat_id' => $pesanan->user->chat_id, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => "No orderan ".$id." telah ada no resinya ".$target,
            ]);
       }

        notif_statistik();

        //return redirect()->route('semua')->with('status','Data berhasil disimpan');
        history_insert($id,Auth::id(),'Pesanan sudah dikirim dengan no resi '.$target);	
        return redirect()->back();	
    }

    function pembayaran_pelunasan(Request $request, $id = null){
        if ($request->isMethod('post')){
        
        $id = $request->input('id');
        $jenis =  $request->input('jenis');
        $target =  $request->input('nominal');

           $pesanan = \App\Pesanan::find($id);

           if ($jenis == 1){
               //-- pelunasan reguler atau utama
               if (!empty($pesanan->resi)){
                    $pesanan->finising = 3; 
                }else{
                   $pesanan->finising = 5;  
                }
                $pesanan->pelunasan = $target;
                $pesanan->save();

                \App\Neraca::updateOrCreate(['pesanan_id' => $id, 'identitas' => 'PELUNASAN'],
                    [
                        'nominal' => $target,
                        'keterangan' => 'Pelunasan no order '.$id,
                        'status' => 1,
                        'user_id' => Auth::id(),
                        'identitas' => 'PELUNASAN',
                        'pesanan_id' => $id
                        ]);

                    //-- kirim notifikasi via telegram

                    Telegram::sendMessage([
                        'chat_id' => -1001386921740, // zavira virtual office
                        'parse_mode' => 'HTML',
                        'text' => "No orderan ".$id." telah dilunasi sebesar ".rupiah($target)
                    ]);
                    history_insert($id,Auth::id(),'Pesanan sudah dilunasi');
           }elseif ($jenis == 2){
               // pelunasan tambahan                
                $pesanan->pelunasan = ($pesanan->pelunasan + $target);
                $pesanan->save();

                neraca_insert($target,'Pembayaran tambahan no order '.$id,1,Auth::id(),$id);
                history_insert($id,Auth::id(),'Ada pembayaran tambahan');
           }
           
           //return view('utility.close');
           return redirect()->route('pesanan.pembayaran.pelunasan',['id'=>$id])->with('status','Data pelunasan berhasil diupdate');

        }elseif ($request->isMethod('get')){
            $data = DB::table('pesanan')->select('id','pelunasan')->where('id',$id)->first();
            return view('pesanan.pelunasan',compact('data'));
        }
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
        
        history_insert($id,Auth::id(),'Data pesanan dihapus atau diarsipkan');

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
                $lead = \App\Lead::orderBy('created_at','asc')->where('user_id',$user_id)->simplePaginate(15);
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
            
            $currentMonth = date('m');
            $currentYear = date('Y');
            $cs_id = 1;
            $cs = \App\User::all()->pluck('id','name');
            $lead = \App\Lead::orderBy('created_at','desc')->simplePaginate(45);
            return view('pesanan.leadall',compact('lead','cs','currentYear','currentMonth','cs_id'));

        }elseif ($action == 'detail'){
            $cs = \App\User::all()->pluck('id','name');
            $cs_id = $request->input('cs_id');
            $currentMonth = $request->input('bulan');
            $currentYear = $request->input('tahun');
            if ($cs_id != 0){
                $lead = \App\Lead::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('created_at','desc')->where('user_id',$cs_id)->simplePaginate(30);

                $sum_lead = \App\Lead::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('created_at','desc')->where('user_id',$cs_id)->sum('chat');
                $sum_closing = \App\Lead::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('created_at','desc')->where('user_id',$cs_id)->sum('closing');
            }elseif ($cs_id == 0){
                $lead = \App\Lead::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('created_at','desc')->simplePaginate(45);

                $sum_lead = \App\Lead::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('created_at','desc')->sum('chat');
                $sum_closing = \App\Lead::whereRaw('MONTH(created_at) = ?',[$currentMonth])->whereRaw('YEAR(created_at) = ?',[$currentYear])->orderBy('created_at','desc')->sum('closing');
            }
            
            return view('pesanan.leadall',compact('lead','cs','currentMonth','currentYear','cs_id','sum_lead','sum_closing'));

        }
        
    }


    function updateform(Request $request, $action = null){
        if ($request->isMethod('post')){
            $id = $request->input('no');
            $update_apa = $request->input('update_apa');
            $data = \App\Pesanan::where('id',$id)->first();
            if ($data!=null){
                return view('updateform',compact('data','update_apa'));
            }else{
                return view('notfound');
            }
        }elseif ($request->isMethod('get')){
            return view('update',compact('action'));
        }
        
        
    }

    function updating(Request $request){
        

        $id = $request->input('no');
        $pesanan = \App\Pesanan::find($id);
        

        if ($request->update_apa == '1'){
            $nominal = $request->input('modal_pengrajin');
        }elseif ($request->update_apa == '2'){
            $nominal = $request->input('modal_lapis');
        }elseif($request->update_apa == '3'){
            $nominal = ($request->input('modal_lapis') + $request->input('modal_pengrajin'));
        }

        //--  lapis sudah berulang-ulang
        if (($request->update_apa == 2 || $request->update_apa == 3) && $request->input('lapis_berulang') == 1 && !empty($pesanan->modal_lapis)){
            $nlapis = new \App\Lapis;
            $nlapis->pesanan_id = $id;
            $nlapis->nominal = $request->input('modal_lapis');
            $nlapis->save();
        }

        $hitung_sementara = [
            'identitas' => date('d-D-M-Y'),
            'nominal' => $nominal,
            'pesanan_id'=>$id,
        ];
        


        if (DB::table('hitung_sementara')->insert($hitung_sementara)){
            $pesanan->produksi_beratpria = $request->input('produksi_beratpria');
            $pesanan->produksi_beratwanita = $request->input('produksi_beratwanita');
            $pesanan->modal_pengrajin = $request->input('modal_pengrajin');
            $pesanan->modal_lapis = $request->input('modal_lapis');
           /* if (!empty($request->input('logam_sesuai'))){
                $pesanan->logam_sesuai = $request->input('logam_sesuai');
            }
            */
            $pesanan->save();
        }
        

        
         

        

        /*$text = "<b>Data produksi no order ".$id."</b> \n".
            "Telah diupdate";

        Telegram::sendMessage([
            'chat_id' => -1001386921740, // zavira virtual office
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        */
        return redirect()->route('updateform',['action'=>$request->input('update_apa')])->with('status','Data No order '.$id.' berhasil disimpan ');
    }

    function finising(Request $request){
        $ids = $request->input('ids');
        $id = explode('*',$ids);
        $tipe_finising = $request->input('tipe_finising');
        //dd($request);

        if ($tipe_finising == 1){
            DB::table('pesanan')->whereIn('id', $id)->update(
                [
                    'finising' => $request->input('tipe_finising'),
                    'jumlah_lapis' => 1,
                ]);

            $text = "<b>Kode 601 : Data produksi no order ".$ids."</b> \n".
            "Telah masuk tahap finising";
            
            notif_cs($id,$tipe_finising);

            $orders = [];
            foreach ($id as $item){
                if (!empty($item)){
                    $now = \Carbon\Carbon::now();

                    $orders[] = [
                        'pesanan_id' => $item,
                        'user_id' => Auth::id(),
                        'keterangan' => 'Masuk finising atau lapis',
                        'updated_at' => $now,  // remove if not using timestamps
                        'created_at' => $now   // remove if not using timestamps
                    ];

                }
            }

            \App\History::insert($orders);

        }elseif ($tipe_finising == 2){
            
            DB::table('pesanan')->whereIn('id', $id)->update(['finising' => $request->input('tipe_finising')]);

            $text = "<b>Kode 602 : Data produksi no order ".$ids."</b> \n".
            "Telah kembali ke kantor";

            notif_cs($id,$tipe_finising);

            $orders = [];
            foreach ($id as $item){
                if (!empty($item)){
                    $now = \Carbon\Carbon::now();

                    $orders[] = [
                        'pesanan_id' => $item,
                        'user_id' => Auth::id(),
                        'keterangan' => 'Barang sudah dilapis dan telah kembali ke kantor',
                        'updated_at' => $now,  // remove if not using timestamps
                        'created_at' => $now   // remove if not using timestamps
                    ];

                }
            }

            \App\History::insert($orders);

        }
           

            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

       /* foreach ($id as $item){
            $pesanan = \App\Pesanan::find($item);
            if (!empty($pesanan->email)){
                //-- kirim email
                
                \Mail::send('emails.finising', ['pesanan'=>$pesanan], function ($message) use($pesanan) {
               
                    $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
                    $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
                    $message->to($pesanan->email,$pesanan->nama)->subject('No Resi Kiriman dari Zavira Jewelry');
                });

            }
        }
        */

        //-- kirim notifikasi ke cs 
        

        notif_statistik();
           
        return redirect()->route('semua')->with('status','Proses finising '.$ids.' berhasil di update');
    }

    function lapis_berulang(){
        $data = \App\Lapis::orderBy('pesanan_id','asc')->orderBy('id','desc')->simplePaginate(15);
        return view('pesanan.lapis',compact('data'));
    }

    function edit_logam(Request $request, $id = null){
        if ($request->isMethod('post')){
            //-- post

            $score_pria = 0;
            $score_wanita = 0;
            $pria_premium = null;
            $wanita_premium = null;
            $komisi_pria = 0;
            $komisi_wanita = 0;

            $id = $request->input('id');
            $pesanan = \App\Pesanan::find($id);

            if (!empty($request->input('bpria'))){
                
            $pria = explode('|',$request->input('bpria'));
            if ($pria[0] != $request->input('bahanpria_old')){
                
                $hargapria = cariharga($pria[0]);
                $pesanan->sertifikat_hargapria = $hargapria['hargapergram'];
                $pesanan->produksi_hargapria = $hargapria['hargaproduksipergram'];
                $pesanan->bahanpria = $pria[0];

                    //($hargapria['jenis'] == 'silver' ? $score_pria = 0 : $score_pria = 1);

                    if ($hargapria['jenis'] == 'silver'){
                        $score_pria = 0;
                        $pria_premium = null;
                        if ($request->input('asal_id') == 1) $komisi_pria = 5000; else $komisi_pria = 0;
                    }else{
                        $score_pria = 1;
                        $pria_premium = 'P';
                        if ($request->input('asal_id') == 1) $komisi_pria = 15000; else $komisi_pria = 0;
                    }
                }else{
                    $data_pria = cariharga($pria[0]);
                    $data_pria_lama = data_lama($data_pria,'P');
                    $score_pria = $data_pria_lama['score'];
                    $pria_premium = $data_pria_lama['premium'];
                }
                
            }

            if (!empty($request->input('bwanita'))){
                $wanita = explode('|',$request->input('bwanita'));
                if ($wanita[0] != $request->input('bahanwanita_old')){
                    $hargawanita = cariharga($wanita[0]);
                    $pesanan->sertifikat_hargawanita = $hargawanita['hargapergram'];
                    $pesanan->produksi_hargawanita = $hargawanita['hargaproduksipergram'];
                    $pesanan->bahanwanita = $wanita[0];

                    //($hargawanita['jenis'] == 'silver' ? $score_wanita = 0 : $score_wanita = 1);

                    if ($hargawanita['jenis'] == 'silver'){
                        $score_wanita = 0;
                        $wanita_premium = null;
                        if ($request->input('asal_id') == 1) $komisi_wanita = 5000; else $komisi_wanita = 0;
                    }else{
                        $score_wanita = 1;
                        $wanita_premium = 'W';
                        if ($request->input('asal_id') == 1) $komisi_wanita = 15000; else $komisi_wanita = 0;
                    }
                }else{
                    $data_wanita = cariharga($wanita[0]);
                    $data_wanita_lama = data_lama($data_wanita,'W');
                    $score_wanita = $data_wanita_lama['score'];
                    $wanita_premium = $data_wanita_lama['premium'];
                }
                
            }

            /*$pesanan->komisi = $komisi_pria+$komisi_wanita;
            $pesanan->ispremium = $score_pria+$score_wanita;
            $pesanan->yang_premium = $pria_premium.$wanita_premium;
*/
            if (($score_pria+$score_wanita)==2){
            //-- couple
                $ongkos = \App\Setting::where('kunci','ongkos_bikin')->first();
                $pesanan->ongkos_bikin = $ongkos->isi;
            }elseif (($score_pria+$score_wanita)==1){
                $ongkos = \App\Setting::where('kunci','ongkos_bikin')->first();
                $pesanan->ongkos_bikin = ($ongkos->isi/2)+12500;
            }elseif (($score_pria+$score_wanita)==0){
                $pesanan->ongkos_bikin = 0;
            }

            $pesanan->save();

            return redirect()->route('pesanan.edit.logam',['id'=>$id])->with('status','Logam no order '.$id.' berhasil di ubah');

        }elseif ($request->isMethod('get') && !empty($id)){
            //-- get, fill form 
            $data = DB::table('pesanan')->where('id',$id)->first();
            $namalogam = DB::table('namalogam')->pluck('id','title');
            return view('pesanan.edit_logam',compact('data','namalogam'));
        }
    }

    function distribusi(Request $request, $id = null){
        if ($request->isMethod('post')){
            
            $text = "";
            $id = $request->input('id');
            $pesanan = \App\Pesanan::find($id);
            $pesanan->keterangan = $request->input('keterangan');
            $pesanan->kirim_ke_pengrajin = 1;
            
            ///dd($pesanan);
            //-- kiirim via telegram 
            $text .= "No order ".$id."\n \n";
            if (!empty($pesanan->ukuranpria)){
                  $text .= "Pria ".$pesanan->ukuranpria."\n".
                  "Grafir ".$pesanan->grafirpria."\n".
                  "Bahan ".$pesanan->bahanpria()->first()['title']."\n".
                  "Berat maksimal ".$pesanan->produksi_beratpria."\n".
                  "\n".
                  "\n";      
                }

            if (!empty($pesanan->ukuranwanita)){
                $text .= "Wanita ".$pesanan->ukuranwanita."\n".
                "Grafir ".$pesanan->grafirwanita."\n".
                "Bahan ".$pesanan->bahanwanita()->first()['title']."\n".
                "Berat maksimal ".$pesanan->produksi_beratwanita."\n".
                "\n".
                "\n";
            }


            
            $text .= "Pengrajin ".$pesanan->pengrajin->nama."\n";   
            $text .= "<b>Keterangan</b> \n".$pesanan->keterangan."\n \n \n".
                    "<b>Deadline</b> ".date('d M Y', strtotime($pesanan->deadline))."\n".
                    "\n \n".
                    "Pengrajin ".$pesanan->pengrajin->nama."\n".
                    "Matur nuwun \n \n".
                    "Ttd \n".Auth::user()->name;

                if (!empty($pesanan->gambar_cincin_pria)){
                   Telegram::setAccessToken($pesanan->pengrajin->token);
                   Telegram::sendPhoto([
                            'chat_id' => $pesanan->pengrajin->id_chat, // zavira virtual office
                            'parse_mode' => 'HTML',
                            'photo'=>InputFile::create($pesanan->gambar_cincin_pria, "photo.jpg"),
                             'caption' => "Gambar cincin pria untuk no order ".$id
                        ]); 
                }

                if (!empty($pesanan->gambar_cincin_wanita)){
                    Telegram::setAccessToken($pesanan->pengrajin->token);
                    Telegram::sendPhoto([
                             'chat_id' => $pesanan->pengrajin->id_chat, // zavira virtual office
                             'parse_mode' => 'HTML',
                             'photo'=>InputFile::create($pesanan->gambar_cincin_wanita, "photo.jpg"),
                              'caption' => "Gambar cincin wanita untuk no order ".$id
                         ]); 
                 }

                if (!empty($pesanan->gambar)){
                    Telegram::setAccessToken($pesanan->pengrajin->token);
                    Telegram::sendPhoto([
                             'chat_id' => $pesanan->pengrajin->id_chat, // zavira virtual office
                             'parse_mode' => 'HTML',
                             'photo'=>InputFile::create($pesanan->gambar, "photo.jpg"),
                              'caption' => "Gambar untuk no order ".$id
                         ]); 
                 }
                        
                
                if (!empty($pesanan->gambargambar)){
                    $pics = explode(',',$pesanan->gambargambar);
                    foreach ($pics as $pic){
                        Telegram::setAccessToken($pesanan->pengrajin->token);
                        Telegram::sendPhoto([
                            'chat_id' => $pesanan->pengrajin->id_chat, // zavira virtual office
                            'parse_mode' => 'HTML',
                            'photo'=>InputFile::create($pic, "photo.jpg"),
                            'caption' => "Gambar untuk no order ".$id
                        ]);   
                    }
                }
                Telegram::setAccessToken($pesanan->pengrajin->token);
                Telegram::sendMessage([
                    'chat_id' => $pesanan->pengrajin->id_chat, // zavira virtual office
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);

                history_insert($id,Auth::id(),'Data pesanan telah masuk ke bengkel pengrajin');

                $pesanan->save();

                return redirect()->route('pesanan.distribusi',['id'=>$pesanan->id])->with('status','Orderan berhasil didistribusikan');

        }elseif ($request->isMethod('get')){
            $data = \App\Pesanan::find($id);
            return view('pesanan.distribusi',compact('data'));
        }
    }

    function update_harga_pergram(Request $request, $id = null){
        if ($request->isMethod('post')){
            // post
            $id = $request->input('id');
            DB::table('pesanan')->where('id',$id)->update(
                [
                    'sertifikat_hargapria' => $request->input('sertifikat_hargapria'),
                    'sertifikat_hargawanita' => $request->input('sertifikat_hargawanita'),
                ]
            );

            history_insert($id,Auth::id(),'Harga logam diedit secara langsung');

            return redirect()->route('semua')->with('status','Data harga berhasil diubah');

        }else{
            $data = DB::table('pesanan')->select('id','sertifikat_hargapria','sertifikat_hargawanita')->where('id',$id)->first();
            return view('pesanan.force_edit',compact('data'));
        }
    }

    

    

}