<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectsRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        if ($search !== null && trim($search) !== '' && $search !== 'undefined') {
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
