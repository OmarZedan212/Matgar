<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'dob',
        'gender',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];
    /**
     * Auto-hash when setting password (and avoid double-hashing).
     */
    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }

        // If it's already a bcrypt hash, needsRehash() will be false.
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }
}
