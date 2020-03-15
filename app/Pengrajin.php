<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Pengrajin extends Model{
    protected $table = 'pengrajin';
    
    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }

}