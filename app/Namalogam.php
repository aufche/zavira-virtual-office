<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Namalogam extends Model{
    protected $table = 'namalogam';
    
    public function buyback(){
        return $this->hasMany('App\Buyback');
    }

}