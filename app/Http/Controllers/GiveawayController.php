<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GiveawayController extends Controller{

    function index($periode=null){
        if ($periode == null){
            $peserta = DB::table('giveaway')
                ->orderBy('id','desc')    
                ->simplePaginate(15);
        }else{
            $peserta = DB::table('giveaway')
                ->where('periode',$periode)
                ->orderBy('id','desc')    
                ->simplePaginate(15);
        }
        $jumlah = DB::table('giveaway')->count();
        return view('giveaway.index',compact('peserta','jumlah'));
    }

    function search(Request $request){
        $q = $request->input('q');
        $peserta = DB::table('giveaway')
            ->where('nama','like','%'.$q.'%')
            ->orWhere('ig','like','%'.$q.'%')
            ->orWhere('email','like','%'.$q.'%')
            ->orderBy('id','desc')
            ->simplePaginate(15);

        return view('giveaway.index',compact('peserta'));
    }

    function action($id,$act=null){
        if ($act == 'delete'){
            DB::table('giveaway')
                ->where('id',$id)
                ->delete();
        }

        return redirect()->route('ga.index')->with('status','Data berhasil dihapus');
    }

    function fetch(){
        return view('giveaway.fetch');
    }
    
    function fetchig(Request $request){
        $client = new \GuzzleHttp\Client();
        $res = $client->get($request->input('url').'?__a=1');
        //echo $res->getStatusCode(); // 200
        $jsondata = $res->getBody();
        $arraydata = json_decode($jsondata,true);
        $komentar = $arraydata['graphql']['shortcode_media']['edge_media_to_parent_comment']['edges'];
        //dd($komentar);
        foreach ($komentar as $item){
            $username = DB::table('komentar')->where('username',$item['node']['owner']['username'])->first();
            if ($username == null ){
                // username IG belum ada, maka di input
                DB::table('komentar')->insert(
                    [
                        'username'=>$item['node']['owner']['username'],
                        'jumlah'=>1,
                    ]
                    );
            }else{
                DB::table('komentar')->where('id',$username->id)->increment('jumlah', 1);
            }
            //echo $item['node']['owner']['username'];
        }

        return redirect()->route('ga.fetch')->with('status','Data berhasil diinput');
    }

    function komentar(){
        $komentar = DB::table('komentar')->orderBy('jumlah','desc')->simplePaginate(15);
        return view('giveaway.komentar',compact('komentar'));
    }
}