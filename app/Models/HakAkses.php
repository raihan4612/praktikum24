<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = "hak_akses";
    protected $primaryKey = "id";
    protected $fillable = [
        'nama_role',
        'deskripsi',
        'can_create',
        'can_read',
        'can_update',
        'can_delete',
        'can_export',
        'is_active',
    ];

    protected $casts = [
        'can_create' => 'boolean',
        'can_read'   => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
        'can_export' => 'boolean',
        'is_active'  => 'boolean',
    ];
}
