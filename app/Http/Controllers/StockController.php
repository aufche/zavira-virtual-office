<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    function insert(Request $request,$action = null,$id = null){
        if ($action == null){
            if ($request->isMethod('post')){
            //-- post submited insert
            $stock = new \App\Stock;
            $stock->title = $request->title;
            $stock->status = $request->aktif;
            $stock->jumlah = $request->jumlah;
            $stock->save();

            return redirect()->route('stock.insert',['action'=>'edit','id'=>$stock->id])->with('status','Data stock berhasil disimpan');

            }elseif ($request->isMethod('get')){
                //-- insert form
                return view ('stock.insert');
            }
        }elseif ($action == 'edit' && $request->isMethod('post')){
            //-- setelah form edit di submit
            $id = $request->input('id');
            $stock = \App\Stock::find($id);
            $stock->title = $request->input('title');
            $stock->status = $request->input('aktif');
            $stock->jumlah = $request->input('jumlah');
            
            $stock->save();
            return redirect()->route('stock.insert',['id'=>$id,'action'=>'edit'])->with('status','Data pesanan berhasil disimpan'); 
        }elseif ($action == 'edit' && $request->isMethod('get')){
            //-- edit form
            $data = \App\Stock::find($id);
            return view('stock.edit',compact('data'));
        }elseif($action == 'hapus' && $request->isMethod('get')){
            // delete action
            \App\Stock::where('id',$id)->delete();
            return redirect()->route('stock.index')->with('status','Data pesanan berhasil dihapus');
        }
        
    }

    function index(){
        $stock = \App\Stock::orderBy('id','desc')->get();
        return view('stock.index',compact('stock'));
    }
}
