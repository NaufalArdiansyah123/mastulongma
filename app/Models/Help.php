<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'city_id',
        'title',
        'description',
        'photo',
        'location',
        'status',
        'mitra_id',
        'taken_at',
        'completed_at',
        'admin_notes',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'approved')->whereNull('mitra_id');
    }

    public function scopeTaken($query)
    {
        return $query->whereIn('status', ['taken', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
