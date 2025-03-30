<?php

namespace App\Http\Controllers;
use App\Models\TimeRange;
use Illuminate\Http\Request;

class TimeRangeController extends Controller
{

    public function getAll(Request $request){
        $timeSlot = TimeRange::all();
        return response()->json([
            "message" => "All Data receive Successfully!",
            "timeslots" => $timeSlot
        ]);
    }
    public function addTimeSlot(Request $request)
    {
        $request->validate([
            'table_id' => 'nullable|integer',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string'
        ]);
        $user = TimeRange::create([
             'table_id' => $request->table_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        return response()->json([
            'success' =>true,
            'message' => 'Time Slot Added Successfully!',
        ]);
    }
    public function deleteTimeSlot($id)
    {
        $timeSlot = TimeRange::find($id);
        if ($timeSlot) {
            $timeSlot->delete();
            return response()->json([
                'success'=>true,
                'message' => 'Time Slot Deleted Successfully!']);
        }

        return response()->json([
            'success' =>false,
            'message' => 'Time Slot Not Found!'
        ], 404);

    }
    public function editTimeSlot(Request $request,$id)
    {
        $request->validate([
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
        ]);

        $timeSlot = TimeRange::find($request->id);
        if ($timeSlot) {
            $timeSlot->update([
                'start_time' => $request->start_time ?? $timeSlot->start_time,
                'end_time' => $request->end_time ?? $timeSlot->end_time,
            ]);
            return response()->json([
            'success' =>true,
                'message' => 'Time Slot Updated Successfully!',
            ]);
        }

        return response()->json([
            'success' =>false,
            'message' => 'Time Slot Not Found!',
        ], 404);
    }

}
