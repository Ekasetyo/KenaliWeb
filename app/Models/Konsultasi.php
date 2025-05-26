<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'topic', 'status'];

    public function Pesan()
    {
        return $this->hasMany(PesanKonsultasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
