<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'city_id',
        'ktp_path',
        'verified',
        'status',
        'phone',
        'address',
        // KTP Fields
        'nik',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'city',
        'province',
        'religion',
        'marital_status',
        'occupation',
        'ktp_photo',
        'selfie_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified' => 'boolean',
            'date_of_birth' => 'date',
        ];
    }

    // Relationships
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function helps()
    {
        return $this->hasMany(Help::class);
    }

    public function takenHelps()
    {
        return $this->hasMany(Help::class, 'mitra_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'mitra_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'mitra_id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function balance()
    {
        return $this->hasOne(UserBalance::class);
    }

    public function transactions()
    {
        return $this->hasMany(BalanceTransaction::class);
    }

    // Helper methods
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKustomer()
    {
        return $this->isCustomer();
    }

    public function isMitra()
    {
        return $this->role === 'mitra';
    }

    public function isCustomer()
    {
        // Accept both 'customer' (new) and 'kustomer' (legacy) values
        return in_array($this->role, ['customer', 'kustomer']);
    }

    public function isVerified()
    {
        return $this->verified;
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
