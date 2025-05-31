<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LoginSessionMiddleware
{
    public function handle($request, Closure $next)
    {
     
    //dd(Session::all());
    \Log::info('LoginSessionMiddleware session check:', [Session::all()]);

    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
    }
    return $next($request);
    } 
}