<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
        protected $table = 'users';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pesanan(){
        return $this->hasMany('App\Pesanan');
    }

    public function neraca(){
        return $this->hasMany('App\Neraca');
    }

    public function susut(){
        return $this->hasMany('App\Susut');
    }

    public function lead(){
        return $this->hasMany('App\Lead');
    }

    public function buyback(){
        return $this->hasMany('App\Buyback');
    }
}

