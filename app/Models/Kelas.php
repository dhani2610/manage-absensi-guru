<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }

    public function mataPelajarans()
    {
        return $this->hasMany(MataPelajaran::class, 'id_kelas');
    }
}
