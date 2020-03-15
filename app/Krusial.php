<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Krusial extends Model{
    protected $table = 'krusial';
    
    public function pesanan(){
        return $this->belongsTo('App\Pesanan');
    }

}