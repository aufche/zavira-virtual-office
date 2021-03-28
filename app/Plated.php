<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plated extends Model
{
    
    protected $table = 'plated';

    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }

    public function perhiasan(){
        return $this->hasMany('App\Perhiasan');
    }

}
