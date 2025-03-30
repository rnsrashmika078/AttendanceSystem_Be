<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
class LecturerController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'account_type' => 'required',
            // 'lecturer_code' => 'required'

        ]);
        $student_user = Student::where('email', $request->email)->first();
        if($student_user){
            return response()->json([
                'status' => false,
                'message' => 'Email Already in Use as a Student Account!'
            ]);
        }
        $user = Lecturer::where('email', $request->email)->first();
       
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Email you have entered not registered yet'
            ]);
        }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                 'status' => false,
                 'message' => "Email or Password is wrong"
                ]);
        }
        if ($request->account_type !== $user->account_type) {
            return response()->json([
                'status' => false,
                'message' => "Wrong Account Type"
               ]);
        }
       
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'status' => true,
            'message' => "Successfully Log In"
            ]);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
    
        if ($user) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });
            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ]);
        }
    
        return response()->json(
            [
                'status' => false,
                'message' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'account_type' => 'string',
            'dp' => 'nullable|string',
            'init_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'department' => 'string|required',
            'destrict'=>'nullable|string',
            'website'=>'nullable|string',
            'facebook'=>'nullable|string',
            'github'=>'nullable|string',
            'linkedin'=>'nullable|string',
        ]);
        $student_user = Student::where('email', $request->email)->first();
        if($student_user){
            return response()->json([
                'status' => false,
                'message' => 'Email Already in Use as a Student Account!'
            ]);
        }
        $user_Exist = Lecturer::where('email', $request->email)->first();
        if($user_Exist){
            return response()->json([
                'status' => false,
                'message' => 'Email Already in Use!'
            ]);
        }
        $user = Lecturer::create([
            'account_type' =>  $request->account_type,
            'dp' => $request->dp,
            'init_name' => $request->init_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department' => $request->department,
            'destrict'=> $request->destrict,
            'website' => $request->website,
            'facebook' => $request->facebook,
            'github' => $request->github,
            'linkedin' => $request->linkedin,
        ]);
        return response()->json([
            'status'=> true,
            'message' => 'User registered successfully!',
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }


    public function showAll(){
        $users = Lecturer::all();
        return response()->json([
            'users' => $users
        ]);
    }
}
