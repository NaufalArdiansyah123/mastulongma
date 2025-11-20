<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\BalanceTransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'description',
        'reference_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeTopup($query)
    {
        return $query->where('type', 'topup');
    }

    public function scopeDeduction($query)
    {
        return $query->where('type', 'deduction');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
