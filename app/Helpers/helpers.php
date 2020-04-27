<?php


function rupiah($angka){
    if (!empty($angka)){
        return  "Rp " . @number_format($angka,0,',','.');
    }else{
        return 'Rp 0';
    }
}

function text_urgent($id){
    $urgent = array(
        0 =>'Tidak',
        'Ya'
    );

    return $urgent[$id];
}

function cariharga($id_logam){
    $logam = \App\Namalogam::where('id',$id_logam)->first();
    $jenis = $logam->jenis;
    $kadar = $logam->kadar;
    $markup = $logam->markup;

    if ($jenis == 'emas'){
        $harga_pokok = \App\Setting::where('kunci','harga_pokok_emas')->first();
        $hargapergram = ($kadar/100) * $harga_pokok->isi + $markup;
        $hargaproduksipergram = ($kadar/100) * $harga_pokok->isi;
    }elseif ($jenis=='palladium'){
        $harga_pokok = \App\Setting::where('kunci','harga_pokok_palladium')->first();
        $hargapergram = ($kadar/100) * $harga_pokok->isi + $markup;
        $hargaproduksipergram = ($kadar/100) * $harga_pokok->isi;
    }elseif($jenis=='silver'){
        $harga_pokok = \App\Setting::where('kunci','harga_pokok_silver')->first();
        $hargapergram = $harga_pokok->isi;
        $hargaproduksipergram = $harga_pokok->isi;
    }elseif($jenis=='platinum'){
        $harga_pokok = \App\Setting::where('kunci','harga_pokok_platinum')->first();
        $hargapergram = ($kadar/100) * $harga_pokok->isi + $markup;
        $hargaproduksipergram = ($kadar/100) * $harga_pokok->isi;
    }elseif($jenis=='ep'){
        $harga_emas_kuning = \App\Setting::where('kunci','harga_pokok_emas')->first();
        $hargapergram = ($kadar/100) * $harga_emas_kuning->isi + $markup;
        $hargaproduksipergram = ($kadar/100) * $harga_emas_kuning->isi;
    }elseif($jenis=='platidium'){
        $harga_pokok_palladium = \App\Setting::where('kunci','harga_pokok_palladium')->first();
        $harga_pokok_platinum = \App\Setting::where('kunci','harga_pokok_platinum')->first();

        $hargapergram = (($kadar/100) * (($harga_pokok_palladium->isi + $harga_pokok_platinum->isi)/2)) + $markup;
        $hargaproduksipergram = (($kadar/100) * ($harga_pokok_palladium->isi + $harga_pokok_platinum->isi));
    }

    $datalogam['hargapergram'] = $hargapergram;
    $datalogam['jenis'] = $jenis;
    $datalogam['kadar'] = $kadar;
    $datalogam['hargaproduksipergram'] = $hargaproduksipergram;
    $datalogam['title'] = $logam->title;
    return $datalogam;
}



function aa($pre='',$c='',$post=''){
    if (!empty($c)){
        return $pre.$c.$post;
    }
}

function number_international($nohp){
    //if ()
    //$num = substr_replace($number,'+62',0,1);

    // kadang ada penulisan no hp 0811 239 345
    $nohp = str_replace(" ","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace("(","",$nohp);
    // kadang ada penulisan no hp (0274) 778787
    $nohp = str_replace(")","",$nohp);
    // kadang ada penulisan no hp 0811.239.345
    $nohp = str_replace(".","",$nohp);

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($nohp))){
        // cek apakah no hp karakter 1-3 adalah +62
        if(substr(trim($nohp), 0, 3)=='+62'){
            $hp = trim(str_replace("+","",$nohp));
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($nohp), 0, 1)=='0'){
            $hp = '62'.substr(trim($nohp), 1);
        }
        else{
            $hp = $nohp;
        }   
    }


    return $hp;
}

function tanggal($tgl){
    return date('d F Y', strtotime($tgl));
}

function bulan_lalu(){
    return date ("F Y", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ));
}

function kirim_telegram($text,$chat_id){
    Telegram::sendMessage([
        'chat_id' => $chat_id, // zavira virtual office
        'parse_mode' => 'HTML',
        'text' => $text
    ]);
}

function raw($text,$search = '.',$replace = ''){
    return str_replace($search,$replace,$text);
}

function data_lama($data_diproses, $jenis_kelamin){
    if ($data_diproses['jenis'] == 'silver'){
        $data_prosesed['score'] = 0;
        $data_prosesed['premium'] = null;
    }else{
        $data_prosesed['score'] = 1;
        $data_prosesed['premium'] = $jenis_kelamin;
    }

    return $data_prosesed;


}

function hastag($str){
    $str = str_replace(' ','',strtolower($str));
    return $str;
}

function notif_statistik(){
        /*
        null = sedang di proses di bengkel (pk bejo) jika kirim_ke_pengrajin = 1
        1 = sedang di lapis
        2 = sudah di kantor
        3 = sudah dikirm
        4 = reparasi
        5 = di kantor, tapi sudah LUNAS
        6 = sudah dikirim, resi belum ada. 
    */

    $statistik = DB::table('pesanan')
            ->select('finising', DB::raw('count(*) as total'))
            ->where('kirim_ke_pengrajin',1)
            ->groupBy('finising')
            ->get();
    $on_proses = \App\Pesanan::where('kirim_ke_pengrajin',1)->where('finising',null)->get()->count();    
    
        $text_telegram = '';
        foreach ($statistik as $item){
            if ($item->finising == 1){
            $text_telegram = "Cincin sedang dilapis/finising :".$item->total."\n";
            
            }
            if ($item->finising == 2){
                $text_telegram .= "Cincin di showroom :".$item->total."\n";
                $showroom = $item->total;
            }
            if ($item->finising == 3){
                $text_telegram .= "Cincin sudah dikirim :".$item->total."\n";
            }
            if ($item->finising == 4){
                $text_telegram .= "Cincin reparasi :".$item->total."\n";
            }
            if ($item->finising == 5){
                $text_telegram .= "Cincin dikantor dan  sudah lunas :".$item->total."\n";
            }
            if ($item->finising == 6){
                $text_telegram .= "Sudah dikirim tapi belum ada resi :".$item->total."\n";
            }

            //$text_telegram .="Total belum dikirim :".$showroom + $on_proses;
            
        }

        $text_telegram .= "Proses di bengkel :".$on_proses;

        Telegram::sendMessage([
            'chat_id' => -1001386921740, //369990736, //-1001386921740, // zavira virtual office
            'parse_mode' => 'HTML',
            'text' => $text_telegram
        ]);
}

function notif_cs($id,$tipe_finising){
    $list_id =  \App\Pesanan::whereIn('id',$id)->get();
    if ($tipe_finising == 1){
      $end = "\n Masuk ke tahap finising";
    }else{
        $end = "\n Sudah selesai di lapis dan sekarang berada di showroom";
    }
        foreach  ($list_id as $item){
            $text_notif = "\n No Order : ".$item->id."\n".
                        "Nama klien :".$item->nama."\n".
                        "WA :<a href='http://wa.me/".$item->nohp."'>".$item->nohp."</a>\n";

            Telegram::sendMessage([
                'chat_id' => $item->user->chat_id, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text_notif.$end
            ]);  
        }
}

 function history_insert($id,$cs_id,$keterangan){
    $history = new \App\History;
    $history->pesanan_id = $id;
    $history->user_id = $cs_id;
    $history->keterangan = $keterangan;
    $history->save();
 }