<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Buku extends Model{
    protected $table = 'buku';
    
    public function pembukuan(){
        return $this->hasMany('App\Pembukuan');
    }

}