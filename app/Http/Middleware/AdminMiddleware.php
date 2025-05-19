<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = session('user');
        if ($user && $user['status'] === 'admin') {
            return $next($request);
        }
        return redirect('/login')->with('error', 'Akses hanya untuk admin!');
    }
}