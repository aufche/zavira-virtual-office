<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('saldo:jumlahkan')
                ->timezone('Asia/Jakarta')
                ->daily();
         
        
        $schedule->call(function(){
            $skg = date('Y-m-d');
            $pesanan_terlambat = \App\Pesanan::where('kirim_ke_pengrajin',1)
                ->where('finising',null)
                ->whereDate('deadline','<=',$skg)->get();

            foreach ($pesanan_terlambat as $pesanan){
               
                if (!empty($pesanan->gambar)){
                    Telegram::setAccessToken('736352938:AAHHr5smFm3pau3uzuep44FidcqXnNLWYnY'); //-- ID bot, diganti dengan bot zavira
                    Telegram::sendPhoto([
                             'chat_id' => $pesanan->pengrajin->chat_id_personal, // chat id, minta ke pengrajin
                             'parse_mode' => 'HTML',
                             'photo'=>InputFile::create($pesanan->gambar, "photo.jpg"),
                              'caption' => "Pak yang ini terlambat, seharusnya dikirim tanggal ".$pesanan->deadline."\n No order ".$pesanan->id
                         ]); 
                 }

            }
        })->everyMinute();

        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
