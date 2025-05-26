<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanKonsultasi extends Model
{
    use HasFactory;

    protected $fillable = ['konsultasi_id', 'sender', 'message'];

    public function Konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }
}
