<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

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
    //     'created_at' => 'datetime:Y-m-d\TH:i:s.u',
    // ];

    protected $dates = [];

    public static function boot()
    {
        parent::boot();
        static::retrieved(function ($model) {
            Log::info('Deteksi Model Retrieved:', ['collection' => $model->getCollection(), 'data' => $model->toArray()]);
        });
    }
}