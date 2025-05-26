<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelMobileController extends Controller
{
    /**
     * Get all articles for mobile app
     */
    public function getartikel()
    {
        try {
            $articles = Artikel::orderBy('created_at', 'desc')
                ->select(['_id', 'judul', 'deskripsi', 'penulis', 'sumber', 'created_at'])
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data artikel berhasil diambil',
                'data' => $articles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data artikel',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get article detail by ID
     */
    public function show($id)
    {
        try {
            $article = Artikel::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail artikel berhasil diambil',
                'data' => $article
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}