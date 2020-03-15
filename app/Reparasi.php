<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Reparasi extends Model{
    protected $table = 'reparasi';
    
    public function pesanan(){
        return $this->belongsTo('App\Pesanan');
    }

}