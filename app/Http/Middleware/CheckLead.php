<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (Auth::user()->email == 'donokasinoindro85@yahoo.com'){
            return $next($request);
        }

        $logged_id = Auth::id();
        $skg = date('Y-m-d');
        $leads = \App\Lead::where('user_id', $logged_id)->whereDate('created_at', '=', date('Y-m-d'))->count();
        if ( $leads > 0){
            return $next($request);
        }else{
            return  redirect()->route('pesanan.lead')->with('status', 'Hari ini kamu belum mengisi data chat, silahkan isi terlebih dahulu untuk menggunakan halaman admin');
        }

        
    }
}
