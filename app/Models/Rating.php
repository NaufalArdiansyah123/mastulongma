<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'help_id',
        'user_id',
        'mitra_id',
        'rating',
        'review',
    ];

    public function help()
    {
        return $this->belongsTo(Help::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }
}
