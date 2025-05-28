<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $this->ensureIsNotRateLimited($request);

        try {
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            $user = $collection->findOne(['email' => $request->email]);

            if (!$user || !password_verify($request->password, $user->password)) {
                RateLimiter::hit($this->throttleKey($request));
                
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah',
                    'errors' => [
                        'email' => ['Email atau password salah']
                    ]
                ], 401);
            }

            // Generate token (gunakan Sanctum atau JWT)
            $token = $this->generateToken($user);

            RateLimiter::clear($this->throttleKey($request));

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => [
                    'id' => (string)$user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    protected function generateToken($user)
    {
        // Contoh sederhana (gunakan Sanctum/JWT untuk produksi)
        return base64_encode(json_encode([
            'user_id' => (string)$user->_id,
            'expires_at' => now()->addDays(7)->timestamp
        ]));
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->email).'|'.$request->ip());
    }
}