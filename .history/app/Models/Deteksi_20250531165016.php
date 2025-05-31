<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deteksi extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'hasil_deteksi';
    
    protected $fillable = [
        'user_id',
        'sex',
        'age',
        'hypertension',
        'heart_disease',
        'ever_married',
        'work_type',
        'Residence_type',
        'avg_glucose_level',
        'bmi',
        'smoking_status',
        'prediction',
        'created_at'
    ];

    // Nonaktifkan casting untuk debugging
    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d\TH:i:s.u', // Komentari ini
    // ];

    // Tambahkan akses langsung ke created_at sebagai string
    protected $dates = [];
}