<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QrRecordHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_code',
        'status',
    ];
}
