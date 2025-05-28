<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Hash;

class UserMobileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        try {
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            $userId = $request->user_id;
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => new \MongoDB\BSON\UTCDateTime(strtotime($request->tanggal_lahir) * 1000),
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'updated_at' => new \MongoDB\BSON\UTCDateTime(),
            ];

            $result = $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($userId)],
                ['$set' => $updateData]
            );

            if ($result->getModifiedCount() > 0) {
                $updatedUser = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectID($userId)]);
                return response()->json([
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui',
                    'user' => [
                        'id' => (string)$updatedUser->_id,
                        'name' => $updatedUser->name,
                        'email' => $updatedUser->email,
                        'jenis_kelamin' => $updatedUser->jenis_kelamin,
                        'tanggal_lahir' => $updatedUser->tanggal_lahir->toDateTime()->format('Y-m-d'),
                        'no_telepon' => $updatedUser->no_telepon,
                        'alamat' => $updatedUser->alamat,
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada perubahan pada profil',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        try {
            $mongoClient = new MongoClient(env('DB_CONNECTION_STRING'));
            $db = $mongoClient->kenali;
            $collection = $db->users;

            $userId = $request->user_id;
            $user = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectID($userId)]);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan',
                ], 404);
            }

            // Verifikasi kata sandi lama
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi lama salah',
                ], 400);
            }

            // Update kata sandi baru
            $result = $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($userId)],
                ['$set' => [
                    'password' => Hash::make($request->new_password),
                    'updated_at' => new \MongoDB\BSON\UTCDateTime(),
                ]]
            );

            if ($result->getModifiedCount() > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kata sandi berhasil diperbarui',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui kata sandi',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
}