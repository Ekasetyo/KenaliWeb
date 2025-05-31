<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Konsultasi extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'konsultasis';

    protected $fillable = [
        'id_pengguna', 'identitas', 'keluhan', 'jawaban', 'nama_pemberi_jawaban'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'id_pengguna' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', '_id');
    }
}