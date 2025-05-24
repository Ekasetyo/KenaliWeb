<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artikel::create([
            'judul' => 'Bebas dari stroke',
            'deskripsi' => 'Stroke adalah kondisi medis yang serius yang terjadi ketika aliran darah ke otak terganggu, menyebabkan kerusakan pada jaringan otak. Ini bisa disebabkan oleh penyumbatan pembuluh darah (stroke iskemik) atau pecahnya pembuluh darah (stroke hemoragik).',
            'penulis' => 'Dr. John Doe',
            'sumber' => 'https://www.example.com/bebas-dari-stroke',
        ]);
    }
}
