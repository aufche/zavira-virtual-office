<?php


function rupiah($angka){
    if (!empty($angka)){
        return  "Rp " . number_format($angka,0,',','.');
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
    }

    $datalogam['hargapergram'] = $hargapergram;
    $datalogam['jenis'] = $jenis;
    $datalogam['kadar'] = $kadar;
    $datalogam['hargaproduksipergram'] = $hargaproduksipergram;
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