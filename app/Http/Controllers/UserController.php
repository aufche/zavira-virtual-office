<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    function index(){
        $users = \App\User::orderBy('lead','desc')->get();
        return view('user.index',compact('users'));
    }
}
