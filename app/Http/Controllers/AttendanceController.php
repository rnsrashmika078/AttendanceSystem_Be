<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{

    public function getAttendanceResult(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|string'
            ]);
            $subject = Attendance::where('course_id', $validated['course_id'])->get();
            if ($subject->isEmpty()) {
                return response()->json([
                    'message' => "No result found!",
                    'success' => false,
                    'result' => [],
                    'error' => null
                ], 200);
            }
            return response()->json([
                'message' => "Attendance result",
                'success' => true,
                'result' =>  $subject,
                'error' => null
            ], 200);
        } catch (ValidationException $e) {
            Log::info("EXCEPTION", [
                'validation error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Validation Error',
                'success' => false,
                'result' => [],
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            Log::info("EXCEPTION", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'something went wrong. please try again',
                'success' => false,
                'result' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
}
