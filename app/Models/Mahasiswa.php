<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = "mhs";
    protected $primaryKey = "id";
    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'no_hp',
        'email',
        'prodi',
        'fakultas',
        'semester',
        'tahun_masuk',
        'status',
        'foto',
    ];

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'mahasiswa_id');
    }
}
