<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'attendance', 
        'subject_code',
        'student_reg_no',
        'student_name',
    ];
}
