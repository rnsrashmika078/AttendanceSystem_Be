<?php

namespace App\Http\Controllers;

use App\Http\Resources\SessionInfoResource;
use App\Models\LecturerSessions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function createSession(Request $request)
    {
        try {
            $validated = $request->validate([
                'lecturer_name' => 'required|string',
                'lecturer_email' => 'required|string',
                'lecturer_id' => 'required|integer',
                'course_id' => 'required|string|unique:lecturer_sessions,course_id',
                'session_status' => 'required|in:on-progress,finished',
            ]);
            $session = LecturerSessions::create([
                'lecturer_id' => $validated['lecturer_id'],
                'lecturer_name' => $validated['lecturer_name'],
                'lecturer_email' => $validated['lecturer_email'],
                'session_status' => $validated['session_status'],
                'course_id' => $validated['course_id'],
                'started_at' => now(),
                'expires_at' => now()->addMinutes(10)
            ]);
            Log::info("Validated Session Data", [
                'session' => $validated
            ]);
            return response()->json([
                'message' => 'Session created successfully!',
                'success' => true,
                'error' => null,
                'result' =>   new SessionInfoResource($session)
            ]);
        } catch (ValidationException $e) {
            Log::info("ValidationException errors on session data", [
                'validation error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Validation Error',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        } catch (Exception $e) {
            Log::info("Exception errors on session data", [
                'exception error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Exception ',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        }
    }
    public function getSessionInfo(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|string',
            ]);
            $sessionInfo = LecturerSessions::where('course_id', $validated['course_id'])->firstOrFail();
            Log::info("Validated Session Data", [
                'session' => $validated,
                'expires_at' => now(),
            ]);
            return response()->json([
                'message' => 'Successfully retrieved session information!',
                'success' => true,
                'error' => null,
                'result' =>  new SessionInfoResource($sessionInfo)
            ]);
        } catch (ValidationException $e) {
            Log::info("ValidationException errors on session data", [
                'validation error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Validation Error',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        } catch (Exception $e) {
            Log::info("Exception errors on session data", [
                'exception error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Exception ',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        }
    }
    public function getAllSessions(Request $request)
    {
        try {
            $allSessions = LecturerSessions::all();
            return response()->json([
                'message' => 'Successfully retrieved all sessions!',
                'success' => true,
                'error' => null,
                'result' => SessionInfoResource::collection($allSessions)
            ]);
        } catch (ValidationException $e) {
            Log::info("ValidationException errors on session data", [
                'validation error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Validation Error',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        } catch (Exception $e) {
            Log::info("Exception errors on session data", [
                'exception error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Exception ',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        }
    }
    public function getSessionById(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        try {
            $session = LecturerSessions::findOrFail($validated['id']);
            return response()->json([
                'message' => 'Successfully retrieved session by id!',
                'success' => true,
                'error' => null,
                'result' => new SessionInfoResource($session)
            ]);
        } catch (ValidationException $e) {
            Log::info("ValidationException errors on session data", [
                'validation error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Validation Error',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        } catch (Exception $e) {
            Log::info("Exception errors on session data", [
                'exception error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Exception ',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null

            ]);
        }
    }
    public function updateSessionStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|string',
            ]);
            $sessionInfo = LecturerSessions::where('course_id', $validated['course_id'])->firstOrFail();
            $sessionInfo->update([
                'session_status' => 'finished'
            ]);
            Log::info("Validated Session Data", [
                'session' => $validated
            ]);
            return response()->json([
                'message' => 'Successfully updated the session information!',
                'success' => true,
                'error' => null,
                'result' => $sessionInfo
            ]);
        } catch (ValidationException $e) {
            Log::info("ValidationException errors on session data", [
                'validation error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Validation Error',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null
            ]);
        } catch (Exception $e) {
            Log::info("Exception errors on session data", [
                'exception error' => $e->getMessage()
            ]);
            return response()->json([
                'message' => 'Exception',
                'success' => false,
                'error' => $e->getMessage(),
                'result' => null
            ]);
        }
    }
}
