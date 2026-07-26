<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturerSessions extends Model
{
    protected $fillable = [
        'lecturer_id',
        'lecturer_name',
        'lecturer_email',
        'course_id',
        'session_id',
        'session_status',
        'expires_at',
        'started_at',
        'remain_in_sec',

    ];
}
