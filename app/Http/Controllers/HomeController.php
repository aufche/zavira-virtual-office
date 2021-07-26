<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengrajin = DB::table('pengrajin')->pluck('id','nama');
        $namalogam = DB::table('namalogam')->whereNotNull('active')->whereNotNull('persentase_markup')->orderBy('jenis','asc')->pluck('id','title');
        $asal = DB::table('asal')->pluck('id','title');
        $kurir = DB::table('kurir')->pluck('id','title');
        $plated = DB::table('plated')->pluck('id','title');
        $promo = DB::table('promo')->where('aktif',1)->pluck('id','title');
        $stock = DB::table('stock')->where('status',1)->pluck('id','title');
        $account = DB::table('account')->pluck('id','title');

        //print_r($namalogam);
        return view('add')
            ->with('pengrajin',$pengrajin)
            ->with('asal',$asal)
            ->with('kurir',$kurir)
            ->with('promo',$promo)
            ->with('plated',$plated)
            ->with('stock',$stock)
            ->with('account',$account)
            ->with('namalogam',$namalogam);
    }

    function insert(Request $request){
        
        $bpria_history = '';
        $bwanita_history = '';

        $validatedData = $request->validate([
            'asal_id' => 'required',
            'kurir_id' => 'required',
            'pengrajin_id' => 'required',
        ],
        [
            'asal_id.required' => 'Asal orderan harus di tentukan',
            'kurir_id.required' => 'Kurir harus dipilih',
            'pengrajin_id.required' => 'Pengrajin orderan harus di tentukan',
        ]
        );

        $score_pria = 0;
        $score_wanita = 0;
        $pria_premium = null;
        $wanita_premium = null;
        $komisi_pria = 0;
        $komisi_wanita = 0;
        
        if (!empty($request->input('upria')) && !empty($request->input('uwanita'))){
            $iscouple = 1;
        }elseif (!empty($request->input('upria')) || !empty($request->input('uwanita'))){
            $iscouple = 0;
        }else{
            $iscouple = 3;
        }

        $data_pesanan = [
            'nama'=>$request->input('nama'),
            'nohp'=>number_international($request->input('nohp')),
            'email'=>$request->input('email'),
            'alamat'=>$request->input('alamat'),
            'kecamatan'=>$request->input('kecamatan'),
            'jenis_kelamin'=>$request->input('jenis_kelamin'),
            'social_media'=>$request->input('social_media'),
            'tgl_lahir'=>$request->input('tgl_lahir'),
            'tahu_dari'=>$request->input('tahu_dari'),
            'kodecincin'=>$request->input('kodecincin'),
            'ukuranpria'=>$request->input('upria'),
            'grafirpria'=>$request->input('gpria'),
            'bahanpria'=>$request->input('bpria'),
            'ukuranwanita'=>$request->input('uwanita'),
            'grafirwanita'=>$request->input('gwanita'),
            'bahanwanita'=>$request->input('bwanita'),
            'keterangan'=>$request->input('keterangan'),
            'tglmasuk'=>$request->input('tmasuk'),
            'tglselesai'=>$request->input('tselesai'),
            'deadline'=>$request->input('tdeadline'),
            //'rekening'=>$request->input('rekening'),
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
            'couple'=>$iscouple,
            'kirim_ke_pengrajin'=>0,
            'produksi_beratpria'=>$request->input('produksi_beratpria'),
            'produksi_beratwanita'=>$request->input('produksi_beratwanita'),
            'free_woodbox'=>$request->input('kotakcincinkayu'),
            'promo_id'=>$request->input('promo_id'),
            'stock_id' => $request->input('stock_id'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'finising_pria' => $request->input('finising_pria'),
            'finising_wanita' => $request->input('finising_wanita'),
            'is_lunas' => $request->input('is_lunas'),
            'grafir' => $request->input('grafir'),
            'skema_baru' => 1,
            'account_id' => $request->input('account_id'),
        ];

        if (!empty($request->file('gambar'))){
        
            /*$this->validate($request,[
                'gambar'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
            */
     
            $image_name = $request->file('gambar')->getRealPath();
     
            
            $data_pesanan = array_add($data_pesanan,'gambar',upload_gambar($image_name));
        }

        if (!empty($request->file('gambar_cincin_pria'))){
        
            $this->validate($request,[
                'gambar_cincin_pria'=>'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('gambar_cincin_pria')->getRealPath();
     
            $data_pesanan = array_add($data_pesanan,'gambar_cincin_pria',upload_gambar($image_name));
        }

        if (!empty($request->file('gambar_cincin_wanita'))){
        
            $this->validate($request,[
                'gambar_cincin_wanita'=>'mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
     
            $image_name = $request->file('gambar_cincin_wanita')->getRealPath();
     
            
            $data_pesanan = array_add($data_pesanan,'gambar_cincin_wanita',upload_gambar($image_name));
        }

        if (!empty($request->input('gambargambar'))){
            $gambar = [];
            $images = explode(',',$request->input('gambargambar'));
            foreach ($images as $image){
                array_push($gambar,upload_gambar($image));
            }
            $data_pesanan = array_add($data_pesanan,'gambargambar',implode(',',$gambar));
        }

        if (!empty($request->input('bpria'))){
            $hargapria = cariharga($request->input('bpria'));
            $data_pesanan = array_add($data_pesanan,'sertifikat_hargapria',$hargapria['hargapergram']);
            $data_pesanan = array_add($data_pesanan,'produksi_hargapria',$hargapria['hargaproduksipergram']);
            $data_pesanan = array_add($data_pesanan,'biaya_produksi_pria',$hargapria['biaya_produksi']);
            $bpria_history = $hargapria['title'];

            //($hargapria['jenis'] == 'silver' ? $score_pria = 0 : $score_pria = 1);

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
        }

        if (!empty($request->input('bwanita'))){
            $hargawanita = cariharga($request->input('bwanita'));
            $data_pesanan = array_add($data_pesanan,'sertifikat_hargawanita',$hargawanita['hargapergram']);
            $data_pesanan = array_add($data_pesanan,'produksi_hargawanita',$hargawanita['hargaproduksipergram']);
            $data_pesanan = array_add($data_pesanan,'biaya_produksi_wanita',$hargawanita['biaya_produksi']);
            $bwanita_history = $hargawanita['title'];

            //($hargawanita['jenis'] == 'silver' ? $score_wanita = 0 : $score_wanita = 1);

            if ($hargawanita['jenis'] == 'silver'){
                $score_wanita = 0;
                $wanita_premium = null;
                if ($request->input('asal_id') == 1) $komisi_wanita = 5000; else $komisi_wanita = 0;
            }else{
                $score_wanita = 1;
                $wanita_premium = 'W';
                if ($request->input('asal_id') == 1) $komisi_wanita = 15000; else $komisi_wanita = 0;
            }
        }

        /*if ($request->input('pengrajin_id') == 2){ // jika pengrajinnya mas yanto, otomatis lapisnya di tempat mas gunawan
           $modal_lapis = $request->input('biaya_lapis_perak_pria') + $request->input('biaya_lapis_perak_wanita');
           $data_pesanan = array_add($data_pesanan,'modal_lapis',$modal_lapis); 
        }
        */
        //-- ini perlu di koreksi lagi

        //(($score_pria+$score_wanita) == 2 ? $data_pesanan = array_add($data_pesanan,'ispremium',1) : $data_pesanan = array_add($data_pesanan,'ispremium',0));
        $data_pesanan = array_add($data_pesanan,'komisi',$komisi_pria+$komisi_wanita);
        $data_pesanan = array_add($data_pesanan,'ispremium',$score_pria+$score_wanita);
        $data_pesanan = array_add($data_pesanan,'yang_premium',$pria_premium.$wanita_premium);

        

        /**
         * update biaya ongkos per cincin
         */

        /*if (($score_pria + $score_wanita)==2){
            //-- couple emas/pall/pl
            $ongkos = \App\Setting::where('kunci','ongkos_bikin')->first();
            $data_pesanan = array_add($data_pesanan,'ongkos_bikin',$ongkos->isi);
        }elseif (($score_pria+$score_wanita)==1){
            // single premium 
            $ongkos = \App\Setting::where('kunci','ongkos_bikin')->first();
            $data_pesanan = array_add($data_pesanan,'ongkos_bikin',($ongkos->isi/2)+12500);
        }elseif (($score_pria+$score_wanita)==0){
            // perak
            $data_pesanan = array_add($data_pesanan,'ongkos_bikin',0);
        }
        */

        
        //dd($data_pesanan);
        $id = DB::table('pesanan')->insertGetId($data_pesanan);
        if (!empty($id)){

            //-- update voucher dan no undian 
            /*$voucher = strtoupper($id.str_random(7));
            $undian = strtoupper($id.str_random(7));
            DB::table('pesanan')->where('id', $id)->update(['voucher' => $voucher, 'undian'=>$undian]);
            */

            /*
            masukkan data ke tabel DP sesuai dengan no pesanan / no order
            ==============================
            */
            // if ($score_pria + $score_wanita != 0){
            //     $data_dp = [
            //         'pesanan_id'=>$id,
            //         'nominal'=>$request->input('dp'),
            //         'created_at'=>\Carbon\Carbon::now(),
            //     ];
            //     DB::table('dp')->insert($data_dp);
            // }
            

            /*
            ====================
            add ke neraca
            

            $neraca = new \App\Neraca;
            $neraca->nominal = $request->input('dp')+$request->input('ongkir');
            $neraca->keterangan = 'DP dan ongkir no order '.$id.' rekening '.$request->input('rekening');
            $neraca->status = 1;
            $neraca->pesanan_id = $id;
            $neraca->user_id = Auth::id();
            $neraca->save();

            */

            //neraca_insert(($request->input('dp')+$request->input('ongkir')),'DP dan ongkir no order '.$id.' rekening '.$request->input('rekening'),1,Auth::id(),$id,'DP');

            

            // if ($request->input('rekening') == 'CASH'){
            //     //** add ke pembukuan jika transaksi cash*/
            //     $pembukuan = new \App\Pembukuan;
            //     $pembukuan->keterangan = 'DP dan ongkir no order '.$id.' rekening '.$request->input('rekening');
            //     $pembukuan->buku_id = Auth::user()->buku;
            //     $pembukuan->user_id = Auth::user()->id;
            //     $pembukuan->bulantahun = date('F Y');
            //     $pembukuan->tanggal = $request->input('tmasuk');
            //     $pembukuan->jenis_transaksi = 1;
            //     $pembukuan->masuk = $request->input('dp')+$request->input('ongkir');
            //     $pembukuan->keluar = 0;
            //     $pembukuan->save();
            // }

            /*$history = new \App\History;
            $history->pesanan_id = $id;
            $history->user_id = Auth::id();
            $history->keterangan = 'Data pesanan berhasil diinput';
            $history->save();
*/
            ///history_insert($id,Auth::id(),'Data pesanan berhasil diinput');


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
                ['pesanan_id' => $id,'user_id' => Auth::id(), 'keterangan' => 'Berat awal cincin pria '.$request->input('produksi_beratpria').' gr dengan bahan '.$bpria_history.' ukuran '.$request->input('upria').' dan  berat awal cincin wanita '.$request->input('produksi_beratwanita').' gr dengan bahan '.$bwanita_history.' ukuran '.$request->input('uwanita').' CS '.Auth::user()->name.'','created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ],
            ];

           \App\History::insert($data_history);

           if (!empty($request->input('stock_id'))){
               \App\Stock::decrement('jumlah',1);
           }
            
            
            //-- kirim notif via telegram
            //$text = 'Pesanan baru telah di masukkan ke database dengan no order '.$id;
            $text = "Pesanan baru telah dimasukkan oleh ".Auth::user()->name."\n";
            if (!empty($request->input('upria'))){
                $text.= "Bahan cincin pria ".$bpria_history."\n";
                $text.= "Ukuran cincin pria ".$request->input('upria')."\n";
                $text.= "Grafir ".$request->input('gpria')."\n\n\n";
            }

            if (!empty($request->input('uwanita'))){
                $text.= "Bahan cincin pria ".$bwanita_history."\n";
                $text.= "Ukuran cincin pria ".$request->input('uwanita')."\n";
                $text.= "Grafir ".$request->input('gwanita')."\n\n\n";
            }

            Telegram::sendMessage([
                'chat_id' => -1001386921740, // zavira virtual office
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
            

        /*if (!empty($request->input('email'))){
            //-- kirim email

            \Mail::send('emails.welcome', ['pesanan'=>$data_pesanan], function ($message) use ($data_pesanan){
               
                $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->to($data_pesanan['email'],$data_pesanan['nama'])->subject('Terimakasih atas kepercayaan Anda by Zavira Jewelry');
            });
            
        }
            */
            if ($request->add_invoice == 'on'){
                //-- buat catatan invoice
                $client = new \GuzzleHttp\Client();
                $url = 'http://akuntansi.zavirajewelry.com/api/invoice';
                $request = $client->post($url,['form_params'=> [
                        'nama' => $request->input('nama'),
                        'nohp' => number_international($request->input('nohp')),
                        'alamat' => $request->input('alamat'),
                        'harga' => raw($request->input('hargabarang')),
                        'pesanan_id' => $id,
                        'title' => 'Pesanan no order '.$id,
                        'deskripsi' => 'Cincin pria '.$bpria_history.' cincin wanita '.$bwanita_history,
                        'harga' => raw($request->input('hargabarang')),
                        'dp' => raw($request->input('dp')),
                        'account_id' => $request->input('account_id'),

                    ]
                ]);
            }
            

            return redirect()->route('edit',['id'=>$id])->with('status','Data pesanan berhasil disimpan');		
        }
       

    }

    function edit($id){
        $pengrajin = DB::table('pengrajin')->pluck('id','nama');
        $namalogam = DB::table('namalogam')->whereNotNull('active')->orderBy('jenis','asc')->pluck('id','title');
        $asal = DB::table('asal')->pluck('id','title');
        $kurir = DB::table('kurir')->pluck('id','title');
        $plated = DB::table('plated')->pluck('id','title');
        $account = DB::table('account')->pluck('id','title');
        $promo = DB::table('promo')->where('aktif',1)->pluck('id','title');
        
        $data = \App\Pesanan::where('id',$id)->with('user','pengrajin')->first();
        return view('edit',compact('pengrajin','namalogam','data','asal','kurir','promo','plated','account'));
    }

    function editing(Request $request){

        $score_pria = 0;
        $score_wanita = 0;
        $pria_premium = null;
        $wanita_premium = null;
        $komisi_pria = 0;
        $komisi_wanita = 0;
        
        $id = $request->input('id');
        $pesanan = \App\Pesanan::find($id);
        
        

        if (!empty($request->input('upria')) && !empty($request->input('uwanita'))){
            $pesanan->couple = 1;
        }elseif (!empty($request->input('upria')) || !empty($request->input('uwanita'))){
            $pesanan->couple = 0;
        }else{
            $pesanan->couple = 3;
        }

       


        if (!empty($request->file('gambar'))){
        
           /* $this->validate($request,[
                'gambar'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
            ]);
            */
     
            $image_name = $request->file('gambar')->getRealPath();
     
            $pesanan->gambar = upload_gambar($image_name);

        }

        if (!empty($request->file('gambar_cincin_pria'))){
      
             $image_name = $request->file('gambar_cincin_pria')->getRealPath();
      
             
             $pesanan->gambar_cincin_pria = upload_gambar($image_name);
 
         }

         if (!empty($request->file('gambar_cincin_wanita'))){
      
            $image_name = $request->file('gambar_cincin_wanita')->getRealPath();
            
            $pesanan->gambar_cincin_wanita = upload_gambar($image_name);

        }

        if ($request->input('gambargambar') != $request->input('gambargambarhidden')){
            //-- di edit

            $gambar = [];
            $images = explode(',',$request->input('gambargambar'));
            foreach ($images as $image){
                array_push($gambar,upload_gambar($image));
            }
            
            $pesanan->gambargambar = implode(',',$gambar);
        }


        /*if ($request->input('pengrajin_id') == 2){ // jika pengrajinnya mas yanto, otomatis lapisnya di tempat mas gunawan
           $modal_lapis = $request->input('biaya_lapis_perak_pria') + $request->input('biaya_lapis_perak_wanita');
           $pesanan->nama = $modal_lapis;
        }
        */

        
        $pesanan->nama=$request->input('nama');
        $pesanan->nohp=number_international($request->input('nohp'));
        $pesanan->email=$request->input('email');
        $pesanan->alamat=$request->input('alamat');

        $pesanan->kecamatan=$request->input('kecamatan');
        $pesanan->jenis_kelamin=$request->input('jenis_kelamin');
        $pesanan->social_media=$request->input('social_media');
        $pesanan->tgl_lahir=$request->input('tgl_lahir');
        $pesanan->tahu_dari=$request->input('tahu_dari');

        $pesanan->kodecincin=$request->input('kodecincin');
        $pesanan->ukuranpria=$request->input('upria');
        $pesanan->grafirpria=$request->input('gpria');
        
        $pesanan->ukuranwanita=$request->input('uwanita');
        $pesanan->grafirwanita=$request->input('gwanita');
        
        $pesanan->keterangan=$request->input('keterangan');
        $pesanan->tglmasuk=$request->input('tmasuk');
        $pesanan->tglselesai=$request->input('tselesai');
        $pesanan->deadline=$request->input('tdeadline');
        //$pesanan->rekening=$request->input('rekening');
        $pesanan->hargabarang=raw($request->input('hargabarang'));
        $pesanan->dp=raw($request->input('dp'));
        $pesanan->ongkir=raw($request->input('ongkir'));
        $pesanan->asal_id=$request->input('asal');
        $pesanan->pengrajin_id=$request->input('pengrajin_id');
        $pesanan->kurir_id=$request->input('kurir_id');
        $pesanan->plated_id = $request->input('plated_id');
        //$pesanan->gambargambar=$request->input('gambargambar');
        $pesanan->last_edited_by=Auth::user()->name;
        $pesanan->urgent=$request->input('urgent');
        $pesanan->produksi_beratpria = $request->input('produksi_beratpria');
        $pesanan->produksi_beratwanita = $request->input('produksi_beratwanita');
        
        $pesanan->siap_cetak = $request->input('siap_cetak');
        $pesanan->free_woodbox = $request->input('kotakcincinkayu');
        $pesanan->promo_id = $request->input('promo_id');
        $pesanan->finising_pria = $request->input('finising_pria');
        $pesanan->finising_wanita = $request->input('finising_wanita');
        $pesanan->promo_id = $request->input('promo_id');
        $pesanan->is_lunas = $request->input('is_lunas');
        $pesanan->grafir = $request->input('grafir');
        $pesanan->account_id = $request->input('account_id');
        $pesanan->save();


         
        
        
        
        /*
        update table DP
        */
        \App\Dp::where('pesanan_id',$id)->update(['nominal'=>raw($request->input('dp'))]);
        
        // update 
        \App\Neraca::where('pesanan_id',$id)->where('identitas','DP')->update(['nominal'=>$request->input('dp')+$request->input('ongkir')]);
        

        return redirect()->route('edit',['id'=>$id])->with('status','Data berhasil di ubah');

                
    }

    function pesanan(){
        
        /*$pengrajin = DB::table('pengrajin')->pluck('id','nama');
        $asal = DB::table('asal')->pluck('id','title');
        $user = DB::table('users')->pluck('id','name');
        */

        $data = \App\Pesanan::orderBy('id','desc')->where('arsipkan',0)->whereNull('jenis_perhiasan')->simplePaginate(15);

        $user_id = Auth::id();
        $selesai = \App\Pesanan::where('user_id',$user_id)->where('finising',3)->whereNotNull('resi')->count();
        //$belum = \App\Pesanan::where('user_id',$user_id)->where('finising',3)->whereNotNull('resi')->count();

            
            /*$masalah_krusial = \App\Krusial::where('is_done',0)->orWhere('is_proses',0)->get();
            if (!empty($masalah_krusial)){
                return view('pesanan',compact('data','masalah_krusial'));
            }else{
                return view('pesanan',compact('data'));
            }
            */
            return view('pesanan',compact('data','selesai'));
    }

    function search(Request $request){
        $q = $request->input('q');

        $data = \App\Pesanan::where('nama','like','%'.$q.'%')
            ->orWhere('alamat','like','%'.$q.'%')
            ->orWhere('nohp','like','%'.$q.'%')
            ->orWhere('grafirwanita','like','%'.$q.'%')
            ->orWhere('grafirpria','like','%'.$q.'%')
            ->orWhere('keterangan','like','%'.$q.'%')
            ->orWhere('undian','like','%'.$q.'%')
            ->orWhere('free_woodbox','like','%'.$q.'%')
            ->orWhere('id','=',$q)
            ->orderBy('id','desc')->with('user','pengrajin','asal')->paginate(15);
        
        /*$data = DB::table('pesanan')->where('nama','like','%'.$q.'%')
            ->orWhere('alamat','like','%'.$q.'%')
            ->orWhere('nohp','like','%'.$q.'%')
            ->orWhere('grafirwanita','like','%'.$q.'%')
            ->orWhere('grafirpria','like','%'.$q.'%')
            ->orWhere('keterangan','like','%'.$q.'%')
            ->orWhere('undian','like','%'.$q.'%')
            ->orWhere('namalogam.title','like','%'.$q.'%')
            ->orWhere('id','=',$q)
            ->join('user','pesanan.user_id','=','user.id')
            ->join('pengrajin','pesanan.pengrajin_id','=','pengrajin.id')
            ->join('asal','pesanan.asal_id','=','asal.id')
            ->join('namalogam','pesanan.asal_id','=','asal.id')
            */



        return view('pesanan',compact('data'));
    }

    

    function loadpesanan(Request $request){
        
        $term = $request->get('name');

        $data = \App\Pesanan::select('id','nama')
                ->where("nama","LIKE","%".$term."%")
                ->orderby('id','desc')
                ->get();
        foreach ($data as $user) {
            $user->label   = $user->nama;
            $user->id = $user->id;
        }

       
        
 
   
        return response()->json($data);
        
    }


    function simplefilter(Request $request){
        $awal = $request->input('tanggal_awal');
        $akhir = $request->input('tanggal_akhir');
        $finising_type = $request->input('finising_type');

        if ($finising_type > 0){
            $data = \App\Pesanan::where('finising',$finising_type)->whereBetween('tglmasuk',[$awal,$akhir])->where('arsipkan',0)->simplePaginate(10);
        }elseif ($finising_type == 0){
            $data = \App\Pesanan::whereBetween('tglmasuk',[$awal,$akhir])->where('arsipkan',0)->simplePaginate(10);
        }
        
        
        return view('pesanan',compact('data'));
    }

    

    

    


    function take($id,$template){
        //$data = \App\Pesanan::orderBy('id','desc')->where('id',$id)->with('pengrajin','asal')->get();
        $data = \App\Pesanan::find($id);
        if ($template == 'print'){
            //echo $data[0]->kirim_ke_pengrajin;
            //$item->siap_cetak == 0 && $item->finising == null && $item->kirim_ke_pengrajin == 0
            if ($data->siap_cetak != null){
                if ($data->printed == null){
                    $waktu = date('d M Y G:i', strtotime(\Carbon\Carbon::now()));
                    \App\Pesanan::where('id',$id)->update(['printed' => Auth::user()->name.'<br />'.$waktu]);
                }
                return view('take',compact('data'));
                //return view('pesanan.cetak',compact('data'));
            }else{
               return view('notfound')->with('status','Orderan ini belum siap untuk dicetak.');
            }
            
        }elseif($template=='ambil'){
            //$x = ['tes'=>'siap'];
            Mail::send('emails.buktidp', [$x = $data], function ($message) use($data) {
                
                
                //$pdf = PDF::loadView('ambil', ['data'=>$data]);
                
                $message->from('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->replyTo('zavirajewelry@gmail.com', 'Zavira Jewelry');
                $message->to($data->email,'Konsumen')->subject('Bukti Pembayaran DP dari Zavira Jewelry');
                //$message->attachData($pdf->output(), 'filename.pdf');
            });

            return $pdf->download('invoice.pdf');
            
        }elseif ($template == 'ringkasan'){
            return view ('pesanan.ringkasan', compact('data'));
        }
        
    }

    function proseshitung(Request $request){
        
        $harga = \App\Setting::whereIn('kunci',['harga_harian_emas','harga_harian_palladium','harga_harian_platinum'])->orderBy('kunci','asc')->get();
        $emas_pergram = $harga[0]->isi;
        $palladium_pergram = $harga[1]->isi;
        $platinum_pergam = $harga[2]->isi;

        //dd($harga);

        $ids = $request->input('ids');
        if (!is_array($ids)){
            $id = explode('*',$ids);
        }else{
             //-- sudah berupa array
            $id = $ids;

            //-- update bahwa sudah dibayar
            \App\Pesanan::whereIn('id',$ids)->update(['logam_sesuai'=>2]);


            //--- delete record pada table DP 

            \App\Dp::whereIn('pesanan_id',$id)->delete();

        }
        
        

        $idx = [];
        foreach ($id as $item){
            $data_pesanan = \App\Pesanan::find($item);

            if (!empty($data_pesanan->produksi_beratpria)){
                if ($data_pesanan->bahanpria()->first()['jenis'] =='emas'){
                    
                    $harga_pergram = $harga[0]->isi;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }

                if ($data_pesanan->bahanpria()->first()['jenis'] =='palladium'){
                    
                    $harga_pergram = $harga[1]->isi;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }

                if ($data_pesanan->bahanpria()->first()['jenis'] =='platinum'){
                    $harga_pergram = $harga[2]->isi;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }  

                if ($data_pesanan->bahanpria()->first()['jenis'] =='platidium'){
                    $platinum = $harga[2]->isi; // platinum
                    $palladium = $harga[1]->isi; // palladium
                    $harga_pergram = ($palladium + $platinum) / 2;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }

                if ($data_pesanan->bahanpria()->first()['jenis'] =='ep'){
                    //-- emas putih
                    
                    if ($data_pesanan->bahanpria()->first()['kadar'] > 50){
                        // -- kadar 75%
                        $kadar = $data_pesanan->bahanpria()->first()['kadar'] / 100;
                        $berat_murni = ($kadar * $data_pesanan->produksi_beratpria);


                        $tambahan_palladium = 0.5;
                        $berat_total = $berat_murni + $tambahan_palladium ;

                        $tambahan_platinum = $data_pesanan->produksi_beratpria - $berat_total;

                        $tambahan_berat = $tambahan_palladium; // platinum
                        $harga_tambahan_berat = $palladium_pergram;

                        $tambahan_berat_2 = $tambahan_platinum; // palladium
                        $harga_tambahan_berat_2 = $platinum_pergam;
                    }else{
                        $tambahan_berat = 0.5;
                        $harga_tambahan_berat = $palladium_pergram;
                        $tambahan_berat_2 = 0;
                        $harga_tambahan_berat_2 = 0;
                    }

                    $harga_pergram = $harga[0]->isi;
                }
                
                $kadar = $data_pesanan->bahanpria()->first()['kadar'] / 100;
                $id = DB::table('biaya_produksi')->insertGetId([
                    'pesanan_id' => $item,
                    'berat'=>($kadar * $data_pesanan->produksi_beratpria),
                    'harga_per_gram'=>$harga_pergram,
                    'tambahan_berat'=>$tambahan_berat,
                    'tambahan_berat_2'=>$tambahan_berat_2,
                    'harga_tambahan_berat'=>$harga_tambahan_berat,
                    'harga_tambahan_berat_2'=>$harga_tambahan_berat_2,
                    'jenis'=>strtoupper($data_pesanan->bahanpria()->first()['jenis']),
                    'identitas'=>$request->input('identitas'),
                    'pw'=>'L',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                array_push($idx,$id);
            }

                // - blok wanita
            if (!empty($data_pesanan->produksi_beratwanita)){
                if ($data_pesanan->bahanwanita()->first()['jenis'] =='emas'){
                    
                    $harga_pergram = $harga[0]->isi;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }

                if ($data_pesanan->bahanwanita()->first()['jenis'] =='palladium'){
                    
                    $harga_pergram = $harga[1]->isi;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }

                if ($data_pesanan->bahanwanita()->first()['jenis'] =='platinum'){
                    $harga_pergram = $harga[2]->isi;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }  

                if ($data_pesanan->bahanwanita()->first()['jenis'] =='platidium'){
                    $platinum = $harga[2]->isi; // platinum
                    $palladium = $harga[1]->isi; // palladium
                    $harga_pergram = ($palladium + $platinum) / 2;
                    $tambahan_berat = 0;
                    $harga_tambahan_berat = 0;
                    $tambahan_berat_2 = 0;
                    $harga_tambahan_berat_2 = 0;
                }

                if ($data_pesanan->bahanwanita()->first()['jenis'] =='ep'){
                    
                    
                    if ($data_pesanan->bahanwanita()->first()['kadar'] > 50){

                        $kadar = $data_pesanan->bahanwanita()->first()['kadar'] / 100;
                        $berat_murni = ($kadar * $data_pesanan->produksi_beratwanita);


                        $tambahan_palladium = 0.5;
                        $berat_total = $berat_murni + $tambahan_palladium ;

                        $tambahan_platinum = $data_pesanan->produksi_beratwanita - $berat_total;

                        $tambahan_berat = $tambahan_palladium; // platinum
                        $harga_tambahan_berat = $palladium_pergram;

                        $tambahan_berat_2 = $tambahan_platinum; // palladium
                        $harga_tambahan_berat_2 = $platinum_pergam;

                        
                    }else{
                        $tambahan_berat = 0.5;
                        $harga_tambahan_berat = $harga[1]->isi;
                        $tambahan_berat_2 = 0;
                        $harga_tambahan_berat_2 = 0;
                    }

                    $harga_pergram = $harga[0]->isi;
                }
                
                $kadar = $data_pesanan->bahanwanita()->first()['kadar'] / 100;
                $id = DB::table('biaya_produksi')->insertGetId([
                    'pesanan_id' => $item,
                    'berat'=>($kadar * $data_pesanan->produksi_beratwanita),
                    'harga_per_gram'=>$harga_pergram,
                    'tambahan_berat'=>$tambahan_berat,
                    'tambahan_berat_2'=>$tambahan_berat_2,
                    'harga_tambahan_berat'=>$harga_tambahan_berat,
                    'harga_tambahan_berat_2'=>$harga_tambahan_berat_2,
                    'jenis'=>strtoupper($data_pesanan->bahanwanita()->first()['jenis']),
                    'identitas'=>$request->input('identitas'),
                    'pw'=>'P',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                array_push($idx,$id);
            }
           
        }

        $data = \App\Biayaproduksi::find($idx);

        return view('pesanan.biayaproduksi',compact('data','harga'));
    }

    

    //-- reparasi --//

}


//--- kalkulator 

function kalkulatorlogam(){
    $namalogam = \App\Namalogam::orderBy('title','asc')->get();
    $hargalogam = \App\Setting::whereIn('kunci',['harga_pokok_emas','harga_pokok_palladium','ongkos_bikin','harga_pokok_silver','harga_pokok_platinum'])->get();

    return view('kalkulator.index',compact('namalogam','hargalogam'));
}

