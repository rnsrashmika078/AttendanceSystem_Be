<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

// front end test -> react Vite
Route::get('/{any}', [ViewController::class, 'index'])->where('any', '.*');
