<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class UserRiwayatPrediksiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['login.session']);
    }

    public function dataPrediksi(Request $request)
    {
        $user = Session::get('user');
        if (!$user || $user['status'] !== 'user') {
            Log::error('Unauthorized access attempt');
            abort(403, 'Unauthorized access');
        }

        Log::info('User session:', [$user]);
        $userId = (string)$user['id'];

        $search = $request->input('search');

        $query = ['user_id' => $userId];
        $dataCursor = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('hasil_deteksi')
            ->find($query);
        $dataArray = iterator_to_array($dataCursor);

        try {
            $usersCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->find(['_id' => new ObjectId($userId)]);
        } catch (\Exception $e) {
            Log::error('Error converting user_id to ObjectId: ' . $e->getMessage());
            $usersCursor = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->find(['_id' => $userId]);
        }
        $usersArray = iterator_to_array($usersCursor);

        $usersMap = [];
        foreach ($usersArray as $userData) {
            $usersMap[(string)$userData->_id] = $userData;
        }

        foreach ($dataArray as $item) {
            $item->user = $usersMap[(string)$item->user_id] ?? null;
        }

        if ($search) {
            $dataArray = array_filter($dataArray, function ($item) use ($search) {
                return stripos($item->user->name ?? '', $search) !== false;
            });
        }

        foreach ($dataArray as $item) {
            $item->name = $item->user->name ?? '-';
            $item->age = $item->age ?? '-';

            if (isset($item->user->tanggal_lahir)) {
                try {
                    $item->age = Carbon::parse($item->user->tanggal_lahir)->age;
                } catch (\Exception $e) {
                    Log::error('Error parsing tanggal_lahir: ' . $e->getMessage());
                }
            }
        }

        $data = new \Illuminate\Pagination\LengthAwarePaginator(
            $dataArray,
            count($dataArray),
            10,
            $request->input('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('user.riwayat-deteksi.index', [
            'data' => $data,
            'usersRaw' => collect($dataArray)->mapWithKeys(function ($item) {
                return [$item->user_id => (object) [
                    'name' => $item->name,
                    'tanggal_lahir' => $item->user->tanggal_lahir ?? null
                ]];
            }),
            'layout' => 'user'
        ]);
    }

    public function showDetail($id)
    {
        
        $userId = (string)$user['id'];

        try {
            $data = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->findOne(['_id' => new ObjectId($id), 'user_id' => $userId]);
        } catch (\Exception $e) {
            Log::error('Error finding detail: ' . $e->getMessage());
            return redirect()->route('user.riwayat-deteksi')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if (!$data) {
            return redirect()->route('user.riwayat-deteksi')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        try {
            $userData = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->findOne(['_id' => new ObjectId($userId)]);
        } catch (\Exception $e) {
            $userData = null;
            Log::error('Error finding user data: ' . $e->getMessage());
        }

        $data->user = $userData;
        $data->name = $userData->name ?? '-';

        return view('user.riwayat-deteksi.detail', [
            'data' => $data,
            'layout' => 'user'
        ]);
    }

    public function delete(Request $request, $id)
    {
        $user = Session::get('user');
        if (!$user || $user['status'] !== 'user') {
            abort(403, 'Unauthorized access');
        }
        $userId = (string)$user['id'];

        try {
            $result = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('hasil_deteksi')
                ->deleteOne(['_id' => new ObjectId($id), 'user_id' => $userId]);
            
            if ($result->getDeletedCount() === 0) {
                Log::warning('No data deleted', ['id' => $id, 'user_id' => $userId]);
                return redirect()->route('user.riwayat-deteksi')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
            }

            return redirect()->route('user.riwayat-deteksi')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting data: ' . $e->getMessage());
            return redirect()->route('user.riwayat-deteksi')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}