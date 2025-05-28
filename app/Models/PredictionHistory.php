<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PredictionHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'hasil_deteksi'; // Sesuaikan dengan nama collection di MongoDB
    
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
}