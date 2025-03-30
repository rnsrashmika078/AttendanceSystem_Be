<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
     protected $fillable = [
        'start_time',
        'end_time',
        // first year
        'year_1_lecturer',
        'year_1_lecture',
        'year_1_lecture_hall',
        // second year
        'year_2_lecturer',
        'year_2_lecture',
        'year_2_lecture_hall',
        // third year
        'year_3_lecturer',
        'year_3_lecture',
        'year_3_lecture_hall',
        // forth year
        'year_4_lecturer',
        'year_4_lecture',
        'year_4_lecture_hall',
    ];
}
