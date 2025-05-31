<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Deteksi extends Model
{
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

    protected $casts = [
        'created_at' => 'datetime:Y-m-d\TH:i:s.u', // Sesuai format "2025-05-26T10:05:31.956349"
    ];

}