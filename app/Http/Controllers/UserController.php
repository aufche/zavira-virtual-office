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
            //-- sumited
            $id = $request->input('id');
            $data = \App\User::find($id);
            $data->name = $request->input('name');
            $data->nama_cs = $request->input('nama_cs');
            $data->wa = $request->input('wa');
            $data->gaji_pokok = $request->input('gaji_pokok');
            $data->tunjangan = $request->input('tunjangan');
            $data->uang_makan = $request->input('uang_makan');
            $data->prioritas = $request->input('prioritas');
            $data->join_cs = $request->input('join_cs');
            $data->save();

            return redirect()->route('users.index')->with('status','Data berhasil disimpan');	

        }else{
            $data = \App\User::find($id);
            return view('user.edit',compact('data'));
        }
    }

}
