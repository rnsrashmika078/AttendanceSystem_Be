<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        $request->validate([
            'attendance' => 'required',
            'subject_code' => 'required',
            'student_reg_no' => 'required',
            'student_name' => 'required',
        ]);

        $record = Attendance::create([
            'attendance' => $request->attendance,
            'subject_code' => $request->subject_code,
            'student_reg_no' => $request->student_reg_no,
            'student_name' => $request->student_name,
        ]);

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => "Your attendance has been recorded successfully!",
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => "Your attendance has been recorded successfully!",
            'record' => $record,
        ]);
    }
    public function getAttendanceResult($date, $subject_code)
    {
        $selectedDate = Carbon::parse($date);
        $subject = Attendance::where('subject_code', $subject_code)->first();

        if (!$subject) {
            return response()->json(['message' => 'No record of this subject being conducted on the specified date.'], 404);
        }

        if (!$selectedDate) {
            return response()->json(['message' => 'The subject was not conducted on the specified date.'], 404);
        }

        $attendace = Attendance::where('subject_code', $subject_code)
            ->whereDate('created_at', $selectedDate)
            ->get();


        if (!$attendace) {
            return response()->json([
                'status' => false,
                'message' => "Failed While Attendace Marking!"
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => "Retrive Attendace of $subject_code on $date",
            'data' => $attendace,
        ]);
    }
}
