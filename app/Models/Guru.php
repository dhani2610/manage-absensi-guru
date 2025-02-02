<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(Admin::class, 'id_user');
    }

    public function mataPelajarans()
    {
        return $this->hasMany(MataPelajaran::class, 'id_guru');
    }
}
