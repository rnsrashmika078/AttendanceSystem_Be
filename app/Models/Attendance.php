<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'course_id',
        'reg_number',
        'name',
        'email',
    ];
}
