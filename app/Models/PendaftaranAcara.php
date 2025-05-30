<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranAcara extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'acara_id',
        'status',
        'catatan',
    ];

    // Relationship with User (Peserta)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Acara
    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }
}