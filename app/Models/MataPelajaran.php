<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_mapel');
    }

    public function nilaiSiswa()
    {
        return $this->hasMany(MataPelajaran::class, 'id_mapel');
    }
}
