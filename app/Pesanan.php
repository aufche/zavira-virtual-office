<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Pesanan extends Model{
    protected $table = 'pesanan';
    
    public function pengrajin(){
        return $this->belongsTo('App\Pengrajin');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function asal(){
        return $this->belongsTo('App\Asal');
    }

    public function promo(){
        return $this->belongsTo('App\Promo');
    }

    public function kurir(){
        return $this->belongsTo('App\Kurir');
    }

    public function reparasi(){
        return $this->hasMany('App\Reparasi');
    }

    public function biayaproduksi(){
        return $this->hasMany('App\Biayaproduksi');
    }

    public function krusial(){
        return $this->hasMany('App\Krusial');
    }

    public function bahanpria(){
        return $this->hasOne('App\Namalogam','id','bahanpria');
    }

    public function bahanwanita(){
        return $this->hasOne('App\Namalogam','id','bahanwanita');
    }

    public function bahan_perhiasan(){
        return $this->hasOne('App\Namalogam','id','bahan_perhiasan');
    }

    public function history(){
        return $this->hasMany('App\History');
    }

    public function plated(){
        return $this->belongsTo('App\Plated');
    }

   

}