<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class LoginSessionMiddleware
{
    public function handle($request, Closure $next)
    {
     
    dd(Session::all());

    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
    }
    return $next($request);
    } 
}