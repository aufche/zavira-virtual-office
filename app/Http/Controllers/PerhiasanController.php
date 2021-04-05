<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use DB;

class PerhiasanController extends Controller
{
    
    function index(){
        $data = \App\Pesanan::whereNotNull('jenis_perhiasan')->simplePaginate(15);
        $selesai = 0;
        return view('perhiasan.index',compact('data','selesai'));
    }

    function insert(Request $request){
        $namalogam = DB::table('namalogam')->pluck('id','title');
        $pengrajin = DB::table('pengrajin')->pluck('id','nama');
        $plated = DB::table('plated')->pluck('id','title');
        $asal = DB::table('asal')->pluck('id','title');
        $kurir = DB::table('kurir')->pluck('id','title');
        $promo = DB::table('promo')->where('aktif',1)->pluck('id','title');

        if ($request->isMethod('post')){

            $data_pesanan = [
                'kodecincin'=>$request->input('kode'),
                'nama'=>$request->input('nama'),
                'nohp'=>number_international($request->input('nohp')),
                'email'=>$request->input('email'),
                'alamat'=>$request->input('alamat'),
                'kecamatan'=>$request->input('kecamatan'),
                'jenis_kelamin'=>$request->input('jenis_kelamin'),
                'social_media'=>$request->input('social_media'),
                'tgl_lahir'=>$request->input('tgl_lahir'),
                'tahu_dari'=>$request->input('tahu_dari'),
                
                'jenis_perhiasan'=>$request->input('jenis_perhiasan'),
                'bahan_perhiasan'=>$request->input('bahan_perhiasan'),
                'berat_produksi_perhiasan'=>$request->input('berat_produksi_perhiasan'),
                
                
                'tglmasuk'=>$request->input('tmasuk'),
                'tglselesai'=>$request->input('tselesai'),
                'deadline'=>$request->input('tdeadline'),
                'rekening'=>$request->input('rekening'),
                'hargabarang'=>raw($request->input('hargabarang')),
                'dp'=>raw($request->input('dp')),
                'ongkir'=>raw($request->input('ongkir')),
                'asal_id'=>$request->input('asal_id'),
                'pengrajin_id'=>$request->input('pengrajin_id'),
                'urgent'=>$request->input('urgent'),
                'kurir_id'=>$request->input('kurir_id'),
                'plated_id'=>$request->input('plated_id'),
                'user_id'=>Auth::id(),
                'last_edited_by'=>Auth::user()->name,
                
                'kirim_ke_pengrajin'=>0,
                

                
                
                'promo_id'=>$request->input('promo_id'),
                'stock_id' => $request->input('stock_id'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'finising_perhiasan' => $request->input('finising_perhiasan'),
                
                'is_lunas' => $request->input('is_lunas'),
            ];

            if (!empty($request->file('gambar_perhiasan'))){
        
                $this->validate($request,[
                    'gambar_perhiasan'=>'mimes:jpeg,bmp,jpg,png|between:1, 6000',
                ]);
         
                $image_name = $request->file('gambar_perhiasan')->getRealPath();
         
              
                $data_pesanan = array_add($data_pesanan,'gambar_perhiasan',upload_gambar($image_name));
            }

            if (!empty($request->input('bahan_perhiasan'))){
                $perhiasan = cariharga($request->input('bahan_perhiasan'));
                $data_pesanan = array_add($data_pesanan,'harga_sertifikat_perhiasan',$perhiasan['hargapergram']);
                $data_pesanan = array_add($data_pesanan,'harga_produksi_perhiasan',$perhiasan['hargaproduksipergram']);
                $bahan_perhiasan_history = $perhiasan['title'];
    
                /*($hargapria['jenis'] == 'silver' ? $score_pria = 0 : $score_pria = 1);
    
                if ($hargapria['jenis'] == 'silver'){
                    $score_pria = 0;
                    $pria_premium = null;
                    if ($request->input('asal_id') == 1) $komisi_pria = 5000; else $komisi_pria = 0;
                }else{
                    $score_pria = 1;
                    $pria_premium = 'P';
                    if ($request->input('asal_id') == 1) $komisi_pria = 15000; else $komisi_pria = 0;
                }
    
                //-- cari apakah ada stock cincin buyback
                //$buyback = \App\Buyback::where('namalogam_id',$request->input('bpria'))->where('status',1)->get();
                */
            }

            $id = DB::table('pesanan')->insertGetId($data_pesanan);
            if (!empty($id)){
                neraca_insert(($request->input('dp')+$request->input('ongkir')),'DP dan ongkir no order '.$id.' rekening '.$request->input('rekening'),1,Auth::id(),$id,'DP');

            

                if ($request->input('rekening') == 'CASH'){
                    //** add ke pembukuan jika transaksi cash*/
                    $pembukuan = new \App\Pembukuan;
                    $pembukuan->keterangan = 'DP dan ongkir no order '.$id.' rekening '.$request->input('rekening');
                    $pembukuan->buku_id = Auth::user()->buku;
                    $pembukuan->user_id = Auth::user()->id;
                    $pembukuan->bulantahun = date('F Y');
                    $pembukuan->tanggal = $request->input('tmasuk');
                    $pembukuan->jenis_transaksi = 1;
                    $pembukuan->masuk = $request->input('dp')+$request->input('ongkir');
                    $pembukuan->keluar = 0;
                    $pembukuan->save();
                }

           


                    //-- input ke table susutan
                    $susut = new \App\Susut;
                    $susut->pria = $request->input('produksi_beratpria');
                    $susut->wanita = $request->input('produksi_beratwanita');
                    $susut->status = 'Order berhasil di input ';
                    $susut->pesanan_id = $id;
                    $susut->user_id = Auth::id();
                    $susut->save();

                    //-- input ke table history
                    $data_history = [
                        ['pesanan_id' => $id,'user_id' => Auth::id(), 'keterangan' => 'Pesanan berhasil di input','created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ],
                        ['pesanan_id' => $id,'user_id' => Auth::id(), 'keterangan' => 'Berat awal perhiasan '.$request->input('berat_produksi_perhiasan').' gr '.$bahan_perhiasan_history.' CS '.Auth::user()->name.'','created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ],
                    ];

                \App\History::insert($data_history);

                return redirect()->route('perhiasan.edit',['id'=>$id])->with('status','Data pesanan berhasil disimpan');		
            }

        }else{
            //-- get
            
            return view('perhiasan.add',compact('namalogam','pengrajin','plated','asal','kurir','promo'));
        }
    }

    function edit(Request $request,$id){
        $namalogam = DB::table('namalogam')->pluck('id','title');
        $pengrajin = DB::table('pengrajin')->pluck('id','nama');
        $plated = DB::table('plated')->pluck('id','title');
        $asal = DB::table('asal')->pluck('id','title');
        $kurir = DB::table('kurir')->pluck('id','title');
        $promo = DB::table('promo')->where('aktif',1)->pluck('id','title');

        if ($request->isMethod('post')){
            //-- edit code here
        }elseif ($request->isMethod('get')){
            $data_perhiasan = \App\Pesanan::find($id);
            return view('perhiasan.edit',compact('data_perhiasan','namalogam','pengrajin','plated','asal','kurir','promo'));
        }
    }
}
