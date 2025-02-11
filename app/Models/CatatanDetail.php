<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanDetail extends Model
{
    use HasFactory;

    public function catatan()
    {
        return $this->hasMany(CatatanDetail::class, 'id_catatan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
