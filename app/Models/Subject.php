<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'semester',
        'year',
        'subject_code',
        'subject',
        'user_id',

    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id')
        ->withTimestamps()
        ->using(SubjectUser::class)
        ->withPivot('role');
    }
}
