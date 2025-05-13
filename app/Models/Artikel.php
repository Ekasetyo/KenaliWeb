<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'artikels';

    protected $fillable = [
        'judul',
        'deskripsi', 
        'penulis',
        'sumber'
    ];

    // Tambahkan jika perlu
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}