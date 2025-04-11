<?php

use Illuminate\Support\Facades\Route;

// front end test -> react Vite
Route::get('/{any}', function () {
    return view('react');
})->where('any', '.*');
