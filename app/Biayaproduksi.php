<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Biayaproduksi extends Model{
    protected $table = 'biaya_produksi';
    
    public function pesanan(){
        return $this->belongsTo('App\Pesanan');
    }

}