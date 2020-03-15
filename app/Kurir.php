<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Kurir extends Model{
    protected $table = 'kurir';


    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }

}