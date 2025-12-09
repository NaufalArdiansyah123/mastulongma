<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
        'title',
        'amount',
        'admin_fee',
        'total_amount',
        'description',
        'equipment_provided',
        'photo',
        'location',
        'full_address',
        'latitude',
        'longitude',
        'status',
        'mitra_id',
        'taken_at',
        'completed_at',
        'admin_notes',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
        'completed_at' => 'datetime',
        'amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Alias untuk customer (sama dengan user)
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * The rating left by the owner of this help (if any).
     * This is useful to eager-load the single rating that belongs to the help's creator.
     */
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(Chat::class);
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
