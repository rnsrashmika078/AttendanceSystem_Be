<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // ✅ Add this
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AppUser extends Model
{
    use HasApiTokens,HasFactory;
    protected $fillable = [
        'dp',
        'firstname',
        'lastname',
        'username',
        'email',
        'password',
        'address',
        'profession',
        'city',
        'country',
        'university',
        'phone',
        'mobile',
        'website',
        'github',
        'twitter',
        'instagram',
        'facebook',
       
    ];
}
