<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecture;
class LectureController extends Controller
{

    public function getAll(Request $request)
    {
        $lectureSlot = Lecture::all();
        return response()->json([
            "message" => "All Data receive Successfully!",
            "lectureSlot" => $lectureSlot
        ]);
    }
    public function AddLectureSlot(Request $request)
    {
        $request->validate([
            'lecturer' => 'nullable|string',
            'lecture' => 'nullable|string',
            'lecture_hall' => 'nullable|string'
        ]);
        $user = Lecture::create([
            'lecturer' => $request->lecturer,
            'lecture' => $request->lecture,
            'lecture_hall' => $request->lecture_hall,
        ]);
        return response()->json([
            'sucess' => true,
            'message' => 'Lecture Added Successfully!',
        ]);
    }
    public function deleteLectureSlot($id)
    {
        $lecture = Lecture::find($id);
        if ($lecture) {
            $lecture->delete();
            return response()->json([
                'sucess' => true,

                'message' => 'Lecture Deleted Successfully!'
            ]);
        }

        return response()->json([
            'sucess' => false,

            'message' => 'Lecture Not Found!'
        ], 404);
    }
    public function editLectureSlot(Request $request, $id)
    {
        $request->validate([
            'lecturer' => 'nullable|string',
            'lecture' => 'nullable|string',
            'lecture_hall' => 'nullable|string',
        ]);

        $lecture = Lecture::find($id);
        if ($lecture) {
            $lecture->update([
                'lecturer' => $request->lecturer ?? $lecture->lecturer,
                'lecture' => $request->lecture ?? $lecture->lecture,
                'lecture_hall' => $request->lecture_hall ?? $lecture->lecture_hall,
            ]);
            return response()->json([
                'sucess' => true,
                'message' => 'Lecture Updated Successfully!',
            ]);
        }

        return response()->json([
            'succes' => false,
            'message' => 'Lecture Not Found!',
        ], 404);
    }
}
