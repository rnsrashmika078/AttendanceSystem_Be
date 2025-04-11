<?php

namespace App\Http\Controllers;

use App\Models\QrRecordHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QrRecordHistoryController extends Controller
{
    public function createRecordHistory(Request $request, $subject_code)
    {
        $exist = QrRecordHistory::where("sub_code", $subject_code)->first();
        if ($exist) {
            $exist->update([
                'sub_code' => $request->sub_code ?? $exist->sub_code,
                'status' => $request->status ?? $exist->status,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'QR History updated successfully!',
                'data' => $exist
            ]);
        } else {
            $qr = QrRecordHistory::create([
                'sub_code' => $request->sub_code,
                'status' => $request->status,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'QR History has been Updated!',
                'data' => $qr

            ]);
        }

    }

    public function getRecordHistory($date, $subject_code)
    {
        // $selectedDate = Carbon::parse($date)->timezone('Asia/Colombo');
        $selectedDate = Carbon::parse($date);

        $subject = QrRecordHistory::where('sub_code', $subject_code)->first();

        if (!$subject) {
            return response()->json(['message' => 'No record of this subject being conducted on the specified date.'], );
        }

        if (!$selectedDate) {
            return response()->json(['message' => 'The subject was not conducted on the specified date.'], );
        }

        $attendace = QrRecordHistory::where('sub_code', $subject_code)
            ->whereDate('created_at', $selectedDate)
            ->get();


        if (!$attendace) {
            return response()->json([
                'status' => false,
                'message' => "error while retriving record history!"
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => "Retrive record history  of $subject_code on $date",
            'data' => $attendace,
        ]);
    }
}
