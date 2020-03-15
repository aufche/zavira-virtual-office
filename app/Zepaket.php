<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class Zepaket extends Model{
    protected $table = 'zepaket';

    public function bahanpria(){
        return $this->hasOne('App\Namalogam','id','kode_bahan_pria');
    }

    public function bahanwanita(){
        return $this->hasOne('App\Namalogam','id','kode_bahan_wanita');
    }
    
    

}