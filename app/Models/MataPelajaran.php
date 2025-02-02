<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    /**
     * Relasi ke model Kelas.
     * MataPelajaran belongsTo Kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Relasi ke model Guru.
     * MataPelajaran belongsTo Guru.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_mapel');
    }
}
