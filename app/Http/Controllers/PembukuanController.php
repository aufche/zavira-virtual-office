<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;

Class PembukuanController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function insert(Request $request, $aksi=null){
        if ($aksi == null){
            $data_keuangan = [
                'keterangan'=>$request->input('keterangan'),
                'buku_id'=>$request->input('buku_id'),
                'user_id'=>Auth::user()->id,
                'bulantahun'=>date('F Y'),
                'tanggal'=>$request->input('tanggal'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
    
            if ($request->input('jenis_transaksi') == 1){
                $data_keuangan = array_add($data_keuangan,'masuk',$request->input('nominal'));
                $data_keuangan = array_add($data_keuangan,'keluar',0);
                $data_keuangan = array_add($data_keuangan,'jenis_transaksi',1);
                $text = 'Ada uang cash masuk sejumlah '.rupiah($request->input('nominal')).' penanggung jawab '.Auth::user()->name.' keterangan :'.$request->input('keterangan');
                $neraca_nominal = $request->input('nominal');
                $neraca_status = 1;
            }
    
            if ($request->input('jenis_transaksi') == 0){
                $data_keuangan = array_add($data_keuangan,'keluar',$request->input('nominal'));
                $data_keuangan = array_add($data_keuangan,'masuk',0);
                $data_keuangan = array_add($data_keuangan,'jenis_transaksi',0);
                $text = 'Ada uang cash keluar sejumlah '.rupiah($request->input('nominal')).' penanggung jawab '.Auth::user()->name.' keterangan :'.$request->input('keterangan');
                $neraca_nominal = $request->input('nominal');
                $neraca_status = 0;
            }

            if (!empty($request->input('pesanan_id'))){
                $data_keuangan = array_add($data_keuangan,'pesanan_id',$request->input('pesanan_id'));
            }
            
            $id = DB::table('pembukuan')->insertGetId($data_keuangan);

            //-- edit pesanan jadi lunasi sesuai dgn nominal 
            if ($request->input('jenis_transaksi') == 1 && !empty($request->input('pesanan_id'))){
                $jenis = $request->input('jenis');
                if ($jenis == 1){
                    //-- pelunasan reguler atau utama
                    DB::table('pesanan')
                        ->where('id',$request->input('pesanan_id'))
                        ->update([
                            'pelunasan'=>$request->input('nominal'),
                            'finising'=>3,
                            'resi'=>'DIAMBIL/COD'
                        ]);
                }elseif ($jenis == 2){
                    // pembayaran lain-lain
                    DB::table('pesanan')->where('id',$request->input('pesanan_id'))->increment('pelunasan',$request->input('nominal'));
                }
                
         
                
                
                \App\Neraca::updateOrCreate(['pesanan_id' => $request->input('pesanan_id'), 'identitas' => 'PELUNASAN'],
                    [
                        'nominal' => $neraca_nominal,
                        'keterangan' => $request->input('keterangan'),
                        'status' => $neraca_status,
                        'user_id' => Auth::id(),
                        'identitas' => 'PELUNASAN',
                        'pesanan_id' => $request->input('pesanan_id'),
                        'pembukuan_id' => $id,
                    ]);
            }else{
                //-- DP cash atau penerimaan lain

                $neraca = new \App\Neraca;
                $neraca->nominal = $neraca_nominal;
                $neraca->keterangan = $request->input('keterangan');
                $neraca->status = $neraca_status;
                $neraca->user_id = Auth::id();
                $neraca->pembukuan_id = $id;
                $neraca->save();

            }
    
            

            //-- add record to neraca

            

            
    
            if ($id){
                kirim_telegram($text,-1001386921740);
                return redirect()->route('pembukuan.detail',['id'=>$request->input('buku_id')]);
            }
        }elseif ($aksi == 'edit'){
            $id = $request->input('id');
            $data_pembukuan = \App\Pembukuan::find($id);
            $data_pembukuan->tanggal = $request->input('tanggal');
            $data_pembukuan->buku_id = $request->input('buku_id');
            if ($request->input('jenis_transaksi') == 1){
                $data_pembukuan->masuk = $request->input('nominal');
                $neraca_status = 1;

                /*if ($data_pembukuan->masuk > $request->input('nominal'))
                    DB::table('pesanan')->where('id',$data_pembukuan->pesanan_id)->decrement('pelunasan',$request->input('nominal'));
                else
                    DB::table('pesanan')->where('id',$data_pembukuan->pesanan_id)->increment('pelunasan',$request->input('nominal'));
                */
            }else{
                $data_pembukuan->keluar = $request->input('nominal');
                $neraca_status = 0;
            }
            $data_pembukuan->keterangan = $request->input('keterangan');
            $data_pembukuan->jenis_transaksi = $request->input('jenis_transaksi');



            $data_pembukuan->save();
            
            //== update di neraca
            \App\Neraca::where('pembukuan_id',$id)->update(['nominal'=>$request->input('nominal'),'status'=>$neraca_status,'keterangan'=>$request->input('keterangan')]);

            
            //DB::table('pesanan')->where('id',$data_pembukuan->pesanan_id)->decrement('pelunasan',)
        
            return redirect()->route('pembukuan.edit',['id'=>$id])->with('status','Data berhasil di ubah');
        }
    }
    
    public function detail($id = null,Request $request){
        if ($request->isMethod('get')){
            $currentMonth = date('m');
            $currentYear = date('Y');

            $user_id = Auth::user()->id;
            if (\App\Buku::where('hak_akses','like','%'.$user_id.'%')->where('id','=',$id)->count() > 0){
                $buku = \App\Buku::find($id);
                $data = \App\Pembukuan::where('buku_id',$id)->whereMonth('created_at',$currentMonth)->whereYear('created_at',$currentYear)->orderBy('id','asc')->get();
                return view('pembukuan.semua',compact('data','buku','currentMonth','currentYear','id'));
            }else{
                return view('notfound');
            }
        }elseif ($request->isMethod('post')){
            $currentMonth = $request->input('bulan');
            $currentYear = $request->input('tahun');
            $id = $request->input('id_buku');
            $buku = \App\Buku::find($id);
            $data = \App\Pembukuan::where('buku_id',$id)->whereMonth('created_at',$currentMonth)->whereYear('created_at',$currentYear)->orderBy('id','asc')->get();
            return view('pembukuan.semua',compact('data','currentMonth','currentYear','id','buku')); 
        }
        
    }

    function detail2(Request $request){
        $currentMonth = $request->input('bulan');
        $currentYear = $request->input('tahun');
        $id = $request->input('id_buku');
        $buku = \App\Buku::find($id);
        $data = \App\Pembukuan::where('buku_id',$id)->whereMonth('created_at',$currentMonth)->whereYear('created_at',$currentYear)->orderBy('id','asc')->get();
        return view('pembukuan.semua',compact('data','currentMonth','currentYear','id','buku'));

    }

    function export_pembukuan($id,$bulan){
        $data = \App\Pembukuan::where('buku_id','=',$id)
            ->where('bulantahun','=',urldecode($bulan))
            ->orderBy('tanggal','asc')
            ->get();
        $buku = \App\Buku::find($id);

        $pdf = \PDF::loadView('pdf.pembukuan',['data' => $data,'buku' => $buku, 'bulan' => $bulan]);

        return $pdf->download('pembukuan.pdf');
    }

    

    public function edit($id){
        $user_id = Auth::user()->id;
        $buku = \App\Buku::where('hak_akses','like','%'.$user_id.'%')->pluck('id','title');

        $data = \App\Pembukuan::find($id);

        return view('pembukuan.edit',compact('buku','data'));
    }

    public function transfer(Request $request){
        $nominal = $request->input('nominal');
        $asal_buku_id = explode('|',$request->input('asal_buku_id'));
        $asal = $asal_buku_id[0];

        $tujuan_buku_id = explode('|',$request->input('tujuan_buku_id'));
        $tujuan = $tujuan_buku_id[0];
        $keterangan = $request->input('keterangan');

        //-- kurangi pembukuan asal 
        $data_pengurangan = [
            'masuk'=>0,
            'keluar'=>$nominal,
            'bulantahun'=>date('F Y'),
            'tanggal'=>$request->input('tanggal'),
            'buku_id'=>$asal,
            'keterangan'=>'Transfer dikirim ke '.$tujuan_buku_id[1],
            'user_id'=>Auth::user()->id,

        ];

        $id = DB::table('pembukuan')->insertGetId($data_pengurangan);

        if ($id){
           
            $data_penambahan = [
                'masuk'=>$nominal,
                'keluar'=>0,
                'bulantahun'=>date('F Y'),
                'tanggal'=>$request->input('tanggal'),
                'buku_id'=>$tujuan,
                'keterangan'=>'Transfer diterima dari '.$asal_buku_id[1],
                'user_id'=>Auth::user()->id,
            ];

            $id_pengurangan = DB::table('pembukuan')->insertGetId($data_penambahan);

            if ($id_pengurangan){
                $text = 'Ada uang cash yang di transfer antar pembukuan sejumlah '.$nominal.' penanggung jawab '.Auth::user()->name;
                kirim_telegram($text,-1001386921740);

                return redirect()->route('pembukuan.detail',['id'=>$request->input('tujuan_buku_id')]);
            }

        }
    }

    function hapus($id,$buku){
        \App\Pembukuan::where('id','=',$id)->delete();

        kirim_telegram('Ada catatan transaksi cash yang di hapus oleh '.Auth::user()->name,-1001386921740);
        \App\Neraca::where('pembukuan_id',$id)->delete();
        return redirect()->route('pembukuan.detail',['buku'=>$buku]);
    }

    
}
