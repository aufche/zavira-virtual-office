<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SusutController extends Controller
{
    function add(Request $request, $id = null){
        if ($request->isMethod('post')){

            $count = \App\Pesanan::where('id',$request->input('id'))->count();

            if ($count > 0){
                $susut = new \App\Susut;
                $susut->pria = $request->input('pria');
                $susut->wanita = $request->input('wanita');
                $susut->status = $request->input('status');
                $susut->pesanan_id = $request->input('id');
                $susut->user_id = \Auth::id();
                $susut->save();

                history_insert($request->input('id'),\Auth::id(),'Update berat logam dari '.$request->input('status').' berat pria '.$request->input('pria').'gr dan berat wanita '.$request->input('wanita').'');

                return redirect()->route('susut.add',['id'=>$request->input('id')])->with('status','Data no order '.$request->input('id').' berhasil disimpan');
            }else{
                return redirect()->route('susut.add')->with('warning','Data no order '.$request->input('id').' tidak ditemukan');
            }
            
        }else{
            if (!empty($id)){
                $data = \App\Susut::where('pesanan_id',$id)->get();
                return view('susut.add',compact('data'));
            }else{
                return view('susut.add');
            }
            
        }
    }

    function search(Request $request){
        $id = $request->input('q');
        $data = \App\Susut::where('pesanan_id',$id);
        if ($data->count() > 0){
            $data = $data->paginate(10);
            return view('susut.index',compact('data'));
        }else{
            return redirect()->route('susut.index')->with('warning','No order '.$id.' tidak ditemukan');
        }
        
    }

    function index($detail = null){
        if ($detail == null){
            $data = \App\Susut::orderBy('id','desc')->orderBy('pesanan_id','desc')->paginate(10);
        }else{
            $data = \App\Susut::where('pesanan_id',$detail)->orderBy('id','asc')->paginate(10);
        }
        
        return view('susut.index',compact('data'));
    }

    function edit(Request $request, $id = null){
        if ($request->isMethod('post')){
            $id = $request->input('idx');
            $susut = \App\Susut::find($id);
            
            $susut->pria = $request->input('pria');
            $susut->wanita = $request->input('wanita');
            //$susut->status = $request->input('status');
            $susut->user_id = \Auth::id();
            $susut->save();

            history_insert($request->input('id'),\Auth::id(),'[Edit] Update berat logam dari '.$request->input('status').' berat pria '.$request->input('pria').'gr dan berat wanita '.$request->input('wanita').'');

            return redirect()->route('susut.index',['detail' => $request->input('id') ])->with('status','Data no order '.$request->input('id').' berhasil disimpan');

        }else{
            $data = \App\Susut::find($id);
            return view('susut.edit',compact('data'));
        }
    }
}
