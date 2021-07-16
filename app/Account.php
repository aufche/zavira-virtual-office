<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //

    $protected $table ='account';

    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }
}
