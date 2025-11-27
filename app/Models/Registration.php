<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'uuid',
        'role',
        'nik',
        'full_name',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'address',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'city',
        'city_id',
        'province',
        'religion',
        'marital_status',
        'occupation',
        'ktp_photo_path',
        'selfie_photo_path',
        'email',
        'password',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
