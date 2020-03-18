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

    function edit(Request $request,$id){
        if ($request->isMethod('post')){

        }else{
            $data = \App\User::find($id);
            return view('user.edit',compact('data'));
        }
    }
}
