<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ViewController extends Controller
{
    public function index()
    {

        // Cache::put('message', 'hi there');
        // Cache::delete('message')

        // Cache::put('cachekey', ' this is a test', now()->addMinutes(1));
        Cache::flush();
        dd(Cache::get('cachekey'));

        return view('index');
    }
}
