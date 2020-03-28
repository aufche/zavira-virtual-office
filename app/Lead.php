<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    //
    protected $table = 'lead';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
