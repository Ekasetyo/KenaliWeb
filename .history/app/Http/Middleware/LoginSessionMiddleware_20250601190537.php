<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class LoginSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        // Debug session
        // dd(Session::all());

       if (!$user || $user['status'] !== $role)  {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        return $next($request);
    }
}