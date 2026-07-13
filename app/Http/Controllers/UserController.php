<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function getLecturers(Request $request)
    {
        $cache = Cache::get('lecturers');
        if ($cache) {
            $result = [
                'success' => true,
                'message' => "all lecturers from cache",
                'lecturers' => $cache
            ];
            return response()->json($result);
        }
        $lectures = User::where('role', 'lecturer')->get();
        $result = [
            'success' => true,
            'message' => "all lecturers from database",
            'lecturers' => $lectures
        ];

        Cache::put('lecturers', $lectures , now()->addMinute());

        return response()->json($result);
    }
}
