<?php

namespace App\Http\Controllers;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    public function getAll(Request $request)
    {
        $data = TimeTable::all();
        return response()->json([
            "message" => "All Data receive Successfully!",
            "data" => $data
        ]);
    }
    public function addTimeSlot(Request $request)
    {
        $request->validate([


            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            // first year
            'year_1_lecturer' => 'nullable|string',
            'year_1_lecture' => 'nullable|string',
            'year_1_lecture_hall' => 'nullable|string',
            // second year
            'year_2_lecturer' => 'nullable|string',
            'year_2_lecture' => 'nullable|string',
            'year_2_lecture_hall' => 'nullable|string',
            // third year
            'year_3_lecturer' => 'nullable|string',
            'year_3_lecture' => 'nullable|string',
            'year_3_lecture_hall' => 'nullable|string',
            // forth year
            'year_4_lecturer' => 'nullable|string',
            'year_4_lecture' => 'nullable|string',
            'year_4_lecture_hall' => 'nullable|string',


        ]);
        $user = TimeTable::create([

            'start_time'  => $request->start_time,
            'end_time' => $request->end_time,
            // first year
            'year_1_lecturer' => $request->year_1_sem_1,
            'year_1_lecture'=> $request->year_1_lecture,
            'year_1_lecture_hall' => $request->year_1_lecture_hall,
            // second year
            'year_2_lecturer' => $request->year_2_lecturer,
            'year_2_lecture' => $request->year_2_lecture,
            'year_2_lecture_hall' => $request->year_2_lecture_hall,
            // third year
            'year_3_lecturer'=> $request->year_3_lecturer,
            'year_3_lecture' => $request->year_3_lecture,
            'year_3_lecture_hall' => $request->year_3_lecture_hall,
            // forth year
            'year_4_lecturer'=> $request->year_4_lecturer,
            'year_4_lecture'=> $request->year_4_lecture,
            'year_4_lecture_hall' => $request->year_4_lecture_hall,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Time Slot Added Successfully!',
        ]);
    }
    public function deleteTimeSlot($id)
    {
        $timeSlot = TimeTable::find($id);
        if ($timeSlot) {
            $timeSlot->delete();
            return response()->json([
                'success' => true,
                'message' => 'Time Slot Deleted Successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Time Slot Not Found!'
        ], 404);

    }
    public function editSlot(Request $request, $id)
    {


        $request->validate([
            'day' => 'nullable|string',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',

            //first year
            'year_1_lecturer' => 'nullable|string',
            'year_1_lecture' => 'nullable|string',
            'year_1_lecture_hall' => 'nullable|string',

            //second Year
            'year_2_lecturer' => 'nullable|string',
            'year_2_lecture' => 'nullable|string',
            'year_2_lecture_hall' => 'nullable|string',

            //third Year
            'year_3_lecturer' => 'nullable|string',
            'year_3_lecture' => 'nullable|string',
            'year_3_lecture_hall' => 'nullable|string',

            //forth Year
            'year_4_lecturer' => 'nullable|string',
            'year_4_lecture' => 'nullable|string',
            'year_4_lecture_hall' => 'nullable|string'
        ]);
        $editSlot = TimeTable::find($id);
        if ($editSlot) {
            $editSlot->update([
                'start_time' => $request->start_time ?? $editSlot->start_time,
                'end_time' => $request->end_time ?? $editSlot->end_time,

                // first year
                'year_1_lecturer' => $request->year_1_lecturer ?? $editSlot->year_1_lecturer,
                'year_1_lecture' => $request->year_1_lecture ?? $editSlot->year_1_lecture,
                'year_1_lecture_hall' => $request->year_1_lecture_hall ?? $editSlot->year_1_lecture_hall,

                // first year
                'year_2_lecturer' => $request->year_2_lecturer ?? $editSlot->year_2_lecturer,
                'year_2_lecture' => $request->year_2_lecture ?? $editSlot->year_2_lecture,
                'year_2_lecture_hall' => $request->year_2_lecture_hall ?? $editSlot->year_2_lecture_hall,


                // first year
                'year_3_lecturer' => $request->year_3_lecturer ?? $editSlot->year_3_lecturer,
                'year_3_lecture' => $request->year_3_lecture ?? $editSlot->year_3_lecture,
                'year_3_lecture_hall' => $request->year_3_lecture_hall ?? $editSlot->year_3_lecture_hall,


                // first year
                'year_4_lecturer' => $request->year_4_lecturer ?? $editSlot->year_4_lecturer,
                'year_4_lecture' => $request->year_4_lecture ?? $editSlot->year_4_lecture,
                'year_4_lecture_hall' => $request->year_4_lecture_hall ?? $editSlot->year_4_lecture_hall


            ]);
            return response()->json([
                'success' => true,
                'message' => 'Time Slot Updated Successfully!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Time Slot Not Found!',
        ], 404);
    }

    public function getRowData(Request $request, $id)
    {

        $request->validate([
            'time' => 'nullable|string',
            'year_1_sem_1' => 'nullable|string',
            'year_2_sem_1' => 'nullable|string',
            'year_3_sem_1' => 'nullable|string',
            'year_4_sem_1' => 'nullable|string',
        ]);
        $rowData = TimeTable::find($id);
        if ($rowData) {
            $rowData->update([
                'time' => $request->time ?? $rowData->time,
                'year_1_sem_1' => $request->year_1_sem_1 ?? $rowData->year_1_sem_1,
                'year_2_sem_1' => $request->year_2_sem_1 ?? $rowData->year_2_sem_1,
                'year_3_sem_1' => $request->year_3_sem_1 ?? $rowData->year_3_sem_1,
                'year_4_sem_1' => $request->year_4_sem_1 ?? $rowData->year_4_sem_1,
            ]);
            return response()->json([
                'success' => true,
                "rowData" => $rowData,
                'message' => 'Return data from specific row!',
            ]);
        }
        return response()->json([
            'success' => $id,
            'message' => 'Time Slot Not Found!',
        ], 404);
    }
}
