<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'province',
        'admin_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Admins who manage this city (many-to-many)
    public function admins()
    {
        return $this->belongsToMany(User::class, 'admin_city', 'city_id', 'user_id')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function helps()
    {
        return $this->hasMany(Help::class);
    }
}
