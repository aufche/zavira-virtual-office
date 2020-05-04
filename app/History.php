<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $table = 'history';
    

    public function pesanan(){
        return $this->belongsTo('App\Pesanan');
    }
}
