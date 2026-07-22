<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectsRequest;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    public function getAllSubjects(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('limit', 5);
        $search = $request->query('search', null);
        $query = Subject::with('users');

        Log::info("Query search", [
            'serach' => $search
        ]);
//  && trim($search) !== '' && $search !== 'undefined'
        if ($search !== null) {
            $query->where('subject', 'LIKE', "%{$search}%");
        }
        $allSubjects = $query->paginate($perPage, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "retrived all subjects",
            "all_subjects" => $allSubjects->items(),
            'hasMore' => $allSubjects->hasMorePages(),
            'currentPage' => $allSubjects->currentPage()
        ]);
    }
    public function getSubject(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|integer'
            ]);

            $subject = Subject::with('users')->where('id', $validated['id'])->first();

            Log::info('subject', [
                'subject' => $subject
            ]);

            return response()->json([
                "success" => true,
                "message" => "retrived all subjects",
                "result" => $subject,
                'errors' => null,
            ]);
        } catch (ValidationException $e) {
            Log::info('validated data on AUTH USER', [
                'data' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'result' => null,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::info('validated data on AUTHUSER', [
                'data' => $e->getMessage()
            ]);
            Log::error('getUserProfile failed', ['err' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'result' => null,
                'errors' => null,
            ], 500);
        }
    }
    public function addSubject(SubjectsRequest $request)
    {
        $validate = $request->validated();

        $subjectExist = Subject::where('subject_code', $validate['subject_code'])->first();

        if ($subjectExist) {
            return response()->json([
                "success" => true,
                "message" => "Subject already exists!",
            ], 409);
        }
        $newSubject = Subject::create($validate);

        $newSubject->users()->attach(1);
        return response()->json([
            "success" => true,
            "message" => "Successfully Added the subject",
            "new_subject" => $newSubject
            // "new_subject" =>  new SubjectsResource($newSubject)
        ], 201);
    }
    public function removeSubject()
    {
        Subject::query()->delete();

        return response()->json([
            'message' => 'All subjects deleted successfully.'
        ]);
    }

    public function updateSubject()
    {
        Cache::set('message', 'hi there');

        $cache = Cache::get('message');

        return $cache;
    }
    public function assignLecturer() {}
}
