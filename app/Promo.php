<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    //
    protected $table = 'promo';

    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }

    public function perhiasan(){
        return $this->hasMany('App\Perhiasan');
    }
}
