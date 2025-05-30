<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_acara',
        'tanggal_acara',
        'batas_pendaftaran',
        'maksimal_peserta',
        'deskripsi_acara',
    ];

    protected $casts = [
        'tanggal_acara' => 'datetime',
        'batas_pendaftaran' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranAcara::class);
    }

    public function peserta()
    {
        return $this->belongsToMany(User::class, 'pendaftaran_acaras')
                    ->withPivot('status', 'catatan')
                    ->withTimestamps();
    }
}