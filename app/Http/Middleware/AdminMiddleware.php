<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Session::get('user');
        
        if (!$user || $user['status'] !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}