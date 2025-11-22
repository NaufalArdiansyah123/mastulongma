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
    'order_id',
    'status',
    'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'processed_at' => 'datetime', // <— WAJIB
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

    protected static function booted()
    {
        static::creating(function ($model) {
            // Ensure topup transactions always have an order_id
            if (($model->type ?? null) === 'topup') {
                if (empty($model->order_id)) {
                    $userPart = $model->user_id ?? (auth()->id() ?? '0');
                    $ts = time();
                    // Add a short unique suffix to reduce collision risk
                    $suffix = substr(uniqid('', true), -6);
                    $model->order_id = sprintf('TOPUP-%s-%s-%s', $userPart, $ts, $suffix);
                }
            }
        });

        // Normalize status values on save to avoid storing typos like 'panding'
        static::saving(function ($model) {
            if (property_exists($model, 'status') || array_key_exists('status', $model->getAttributes())) {
                $s = strtolower(trim((string) ($model->status ?? '')));

                $map = [
                    // common misspellings -> canonical
                    'panding' => 'pending',
                    'pendding' => 'pending',
                    'pendng' => 'pending',
                    'pending' => 'pending',

                    'complate' => 'completed',
                    'compleatd' => 'completed',
                    'complted' => 'completed',
                    'completed' => 'completed',

                    'failed' => 'failed',
                ];

                if ($s === '') {
                    // leave empty as-is
                } elseif (isset($map[$s])) {
                    $model->status = $map[$s];
                } else {
                    // if unknown, keep original trimmed lowercased value
                    $model->status = $s;
                }
            }
        });
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
