<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class SocialController extends Controller
{
    public function showAll(){
        $users = AppUser::all();
        return response()->json([
            'users' => $users
        ]);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function getUserById($id)
    {
        $user = AppUser::find($id);

        if (!$user) {
           return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

    // User Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $user = AppUser::where('email', $request->email)->first();
        $id = $user->id;
        $username = $user->username;

       
        if (!$user || !Hash::check($request->password, $user->password)) {
            // throw ValidationException::withMessages([
            //     'email' => ['Invalid credentials.'],
            // ]);
            return response()->json([
                 'status' => false,
                 'message' => "Email or Password is wrong"
                ]);
        }
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
            'userid' => $id,
            'username'=>$username,
            'status' => true,
            'message' => "Successfully Log In"
            ]);
    }
    //Log out
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        $user = $request->user();
    
        if ($user) {
            // Revoke the user's current token
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
                'message' => 'Unauthorized'], 401); // Return unauthorized if user is not authenticated
    }
    // User Registration
    public function register(Request $request)
    {
        $request->validate([
            'dp' => 'string',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'address'=> 'required|string|max:255',
            'profession' => 'string',
            'city' => 'string',
            'country' => 'string',
            'university' => 'string',
            'phone' =>'string',
            'mobile'=> 'string',
            'website'=>'string',
            'github'=>'string',
            'twitter'=> 'string',
            'instagram'=>'string',
            'facebook'=>'string',
        ]);
        $user = AppUser::create([
            'dp' => $request->dp,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address'=> $request->address,
            'profession' => $request->profession,
            'city' => $request->city,
            'country' => $request->country,
            'university' => $request->university,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'website' => $request->website,
            'github' => $request->github,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,

        ]);
        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken
        ]);
    }
}
