<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;

class AllController extends Controller
{
    public function getAll()
    {
        $students = Student::all();
        $lecturers = Lecturer::all();

        $data = [
            'students' => $students,
            'lecturers' => $lecturers,
        ];


        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }
}
