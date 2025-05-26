<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;

class RiwayatDeteksiController extends Controller
{
    public function getRiwayat(Request $request)
    {
        try {
            $request->validate(['user_id' => 'required|string']);

            $mongoClient = new MongoClient(env('MONGODB_URI'));
            $collection = $mongoClient->kenali->hasil_deteksi;

            $riwayat = $collection->find([
                'user_id' => $request->user_id
            ], [
                'sort' => ['created_at' => -1]
            ])->toArray();

            // Format data sebelum dikembalikan
            $formattedData = array_map(function ($item) {
                return [
                    '_id' => (string)$item['_id'],
                    'user_id' => $item['user_id'],
                    'age' => $item['age'],
                    'hypertension' => $item['hypertension'],
                    'heart_disease' => $item['heart_disease'],
                    'avg_glucose_level' => $item['avg_glucose_level'],
                    'bmi' => $item['bmi'],
                    'sex' => $item['sex'] ?? '',
                    'ever_married' => $item['ever_married'] ?? '',
                    'work_type' => $item['work_type'] ?? '',
                    'Residence_type' => $item['Residence_type'] ?? '',
                    'smoking_status' => $item['smoking_status'] ?? '',

                    'prediction' => $item['prediction'],
                    'created_at' => $item['created_at'],

                ];
            }, $riwayat);

            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'total' => count($formattedData)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $mongoClient = new MongoClient(env('MONGODB_URI'));
            $collection = $mongoClient->kenali->hasil_deteksi;

            $result = $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            if ($result->getDeletedCount() == 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Riwayat berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Riwayat tidak ditemukan',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
