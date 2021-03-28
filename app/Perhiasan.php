<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perhiasan extends Model
{

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function asal(){
        return $this->belongsTo('App\Asal');
    }

    public function promo(){
        return $this->belongsTo('App\Promo');
    }

    public function kurir(){
        return $this->belongsTo('App\Kurir');
    }



    public function history(){
        return $this->hasMany('App\History');
    }

    public function plated(){
        return $this->belongsTo('App\Plated');
    }
}
