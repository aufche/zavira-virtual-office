<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Asal extends Model{
    protected $table = 'asal';
    
    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }

}