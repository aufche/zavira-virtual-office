<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    

    function insert(Request $request,$action = null,$id = null){
        if ($action == null){
            if ($request->isMethod('post')){
            //-- post submited insert
            $promo = new \App\Promo;
            $promo->title = $request->title;
            $promo->aktif = $request->aktif;
            $promo->nominal = $request->nominal;
            $promo->save();

            return redirect()->route('promo.insert',['action'=>'edit','id'=>$promo->id])->with('status','Data pesanan berhasil disimpan');

            }elseif ($request->isMethod('get')){
                //-- insert form
                return view ('promo.insert');
            }
        }elseif ($action == 'edit' && $request->isMethod('post')){
            //-- setelah form edit di submit
            $id = $request->input('id');
            $neraca = \App\Promo::find($id);
            $neraca->title = $request->input('title');
            $neraca->aktif = $request->input('aktif');
            $neraca->nominal = $request->input('nominal');
            
            $neraca->save();
            return redirect()->route('promo.insert',['id'=>$id,'action'=>'edit'])->with('status','Data pesanan berhasil disimpan'); 
        }elseif ($action == 'edit' && $request->isMethod('get')){
            //-- edit form
            $data = \App\Promo::find($id);
            return view('promo.edit',compact('data'));
        }elseif($action == 'hapus' && $request->isMethod('get')){
            // delete action
            \App\Promo::where('id',$id)->delete();
            return redirect()->route('promo.index')->with('status','Data pesanan berhasil dihapus');
        }
        
    }

    function index(){
        $promo = \App\Promo::orderBy('id','desc')->get();
        return view('promo.index',compact('promo'));
    }


}
