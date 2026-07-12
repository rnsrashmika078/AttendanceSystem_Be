<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'is_used'
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];
}
