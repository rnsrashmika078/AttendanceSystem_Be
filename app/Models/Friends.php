<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Friends extends Model
{
    use HasFactory;

    protected $fillable = ['userEmail', 'username','recieverEmail'];
}
