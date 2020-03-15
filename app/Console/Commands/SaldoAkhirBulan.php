<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class SaldoAkhirBulan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saldo:jumlahkan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk menjumlahkan saldo setiap akhir bulan atau bisa awal bulan tgl 1 pukul 00:00';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $buku = \App\Buku::all();
        $bulan = date('F Y');
        foreach ($buku as $item){
            $pemasukan = \App\Pembukuan::where('bulantahun','!=',$bulan)->where('buku_id','=',$item->id)->sum('masuk');
            $pengeluaran = \App\Pembukuan::where('bulantahun','!=',$bulan)->where('buku_id','=',$item->id)->sum('keluar');
            $saldo = $pemasukan - $pengeluaran;
            DB::table('buku')->where('id',$item->id)->update(['saldo'=>$saldo,'bulantahun'=>$bulan]);
        }
    }
}
