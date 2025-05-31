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

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'user_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}