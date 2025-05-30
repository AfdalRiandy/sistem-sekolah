<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftaran_acara_id',
        'nilai',
        'catatan',
        'is_published',
    ];

    public function pendaftaranAcara()
    {
        return $this->belongsTo(PendaftaranAcara::class);
    }
}