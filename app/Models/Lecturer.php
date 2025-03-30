<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lecturer extends Model
{
    use HasApiTokens,HasFactory;
    protected $fillable = [
        'account_type',
        'dp', //optional
        'init_name',
        'email',
        'password',
        'department',
        'destrict', //optional
        'website', //optional
        'facebook', //optional
        'github', //optional
        'linkedin', //optional

    ];
    
}
