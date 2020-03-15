<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Neraca extends Model
{
    protected $table = 'neraca';

    public function user(){
        return $this->belongsTo('App\User');
    }

    function neraca_insert($nominal,$keterangan,$status,$user_id){
            $neraca = new \App\Neraca;
            $neraca->nominal = $nominal;
            $neraca->keterangan = $keterangan;
            $neraca->status = $status;
            $neraca->user_id = $user_id;
            $neraca->save();
    }
}
