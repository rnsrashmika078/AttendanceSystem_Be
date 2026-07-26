<?php

namespace App\Http\Controllers;

use App\Events\PrivateChannelEvent;
use App\Models\Attendance;
use App\Models\QrCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QrCodeController extends Controller
{
    public function validate(Request $request)
    {
        try {
            $validated = $request->validate([
                'qr_code' => 'required|string',
                'id' => 'required|integer', // lecturer , receiver id
                'course_id' => 'required|string'
            ]);
            $qr = QrCode::where('course_id', $validated['course_id'])->first();
            $user = Auth::user();
            $data = [
                'user_id' => $user->id,
                'status' => true,
                'course_id' => $validated['course_id'],
                'reg_number' => $user->reg_number,
                'name' => $user->name,
                'email' => $user->email,
            ];
            Log::info("QR VALIDATION ON SUCCESS : CHECK QR CODE EXISTATANT", [
                'QR_CODE' => $validated['qr_code']
            ]);
            if ($qr->qr_code === $validated['qr_code']) {
                event(new PrivateChannelEvent($data, $validated['id'], $user));
                Log::info("QR VALIDATION ON SUCCESS", [
                    'success' => $qr->qr_code === $validated['qr_code'],
                    'qr' => $qr->qr_code,
                    'id' => $validated['id'],
                    'request' => $validated['qr_code']
                ]);
                $attendance = Attendance::create($data);
                return response()->json([
                    'message' => 'Your attendance marked successfully!',
                    'success' => true,
                    'result' => $attendance,
                    'error' => null
                ]);
            }
            Log::info("QR VALIDATION ON ERROR", [
                'success' => $qr->qr_code === $validated['qr_code'],
                'qr' => $qr->qr_code,
                'request' => $validated['qr_code'],
                'id' => $validated['id'],
            ]);

            return response()->json([
                'message' => 'In valid QR code. Please try again',
                'success' => false,
                'result' => null,
                'error' => null
            ]);
        } catch (ValidationException $e) {
            Log::info("function: validate", [
                'validation error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Validation error',
                'success' => false,
                'result' => null,
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            Log::info("function: validate", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'something wrong.. please try again',
                'success' => false,
                'result' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function createORupdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'qr_code' => 'required|string',
                'course_id' => 'required|string',
                'id' => 'required', // this should be course id
            ]);

            $qr = QrCode::updateOrCreate([
                'id' => $validated['id']
            ], ['qr_code'  => $validated['qr_code'], 'course_id' => $validated['course_id']]);

            return response()->json([
                'message' => 'Qr code updated!',
                'success' => true,
                'result' => $qr,
                'error' => null,
            ]);
        } catch (ValidationException $e) {
            Log::info("function: create or update", [
                'validation error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Validation error',
                'success' => false,
                'result' => null,
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            Log::info("function: create or update", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'something wrong.. please try again',
                'success' => false,
                'result' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function checkValidation(Request $request)
    {
        try {
            $validated =  $request->validate([
                'user_id' => 'required|integer',
                'course_id' => 'required|string',
            ]);
            $record = Attendance::where('course_id', $validated['course_id'])->where('user_id', $validated['user_id'])->first();
            if (!is_null($record)) {
                return response()->json([
                    'message' => 'Your attendance already marked for course ' . $validated['course_id'],
                    'success' => true,
                    'result' => $record,
                    'error' => null
                ]);
            }
            return response()->json([
                'message' => 'Your attendance required',
                'success' => false,
                'result' => null,
                'error' => null
            ]);
        } catch (ValidationException $e) {
            Log::info("function: checkValidation", [
                'validation error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Validation error',
                'success' => false,
                'result' => null,
                'error' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            Log::info("function: checkValidation", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'something wrong.. please try again',
                'success' => false,
                'result' => null,
                'error' => $e->getMessage()
            ]);
        }
    }
}
