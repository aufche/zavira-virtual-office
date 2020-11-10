<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyback extends Model
{
    protected $table = 'buyback';

    public function namalogam(){
        return $this->belongsTo('App\Namalogam');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
