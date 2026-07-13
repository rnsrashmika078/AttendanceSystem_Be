<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectsRequest;
use App\Http\Resources\SubjectsResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    public function getAllSubjects()
    {
        $allSubjects = Subject::with('users')->get();
        return response()->json([
            "success" => true,
            "message" => "retrived all subjects",
            "all_subjects" => $allSubjects
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
            ]);
        }
        $newSubject = Subject::create($validate);
        Log::info("validated user", [
            'user' => Auth::user()
        ]);

        $newSubject->users()->attach(1);
        return response()->json([
            "success" => true,
            "message" => "Successfully Added the subject",
            "new_subject" => $newSubject
            // "new_subject" =>  new SubjectsResource($newSubject)
        ]);
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
