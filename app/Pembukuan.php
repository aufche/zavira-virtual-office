<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Pembukuan extends Model{
    protected $table = 'pembukuan';
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function buku(){
        return $this->belongsTo('App\Buku');
    }

}