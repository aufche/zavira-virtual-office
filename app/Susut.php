<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Susut extends Model
{
    protected $table = 'susut';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
