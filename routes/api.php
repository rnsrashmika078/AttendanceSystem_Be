<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsocketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;


// refine ( AUTH )
// Route::prefix('v1/auth')->group(function () {
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/generate-otp', [AuthController::class, 'generateOTP'])->middleware('throttle:otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);



// refine ( WEBSOCKET -> REVERB )
Route::post('/realtime/private', [WebsocketController::class, 'sendMessage'])->middleware('auth:sanctum');
Route::post('/realtime/presence', [WebsocketController::class, 'session'])->middleware('auth:sanctum');


// refine ( Subjects )
Route::prefix('v1/subjects')->group(function () {
    Route::post('/', [SubjectController::class, "addSubject"]);
    Route::get('/', [SubjectController::class, "getAllSubjects"]);
    Route::delete('/', [SubjectController::class, "removeSubject"]);
    Route::get('/id',  [SubjectController::class, "getSubject"]);
});

// refine ( users )
Route::prefix('v1/users')->group(function () {
    Route::get('/', [UserController::class, "getLecturers"]);
});
// refine ( sessions ) 
Route::prefix('v1/session')->group(function () {
    Route::post('/', [SessionController::class, "createSession"]);
    Route::get('/', [SessionController::class, "getSessionInfo"]);
    Route::get('/id', [SessionController::class, "getSessionById"]);
    Route::get('/all', [SessionController::class, "getAllSessions"]);
    Route::put('/', [SessionController::class, "updateSessionStatus"]);
});


// refine ( QR CODE )
Route::prefix('v1/qr')->group(function () {
    Route::post('/validate', [QrCodeController::class, "validate"]);
    Route::post('/update', [QrCodeController::class, "createORUpdate"]);
    Route::get('/check', [QrCodeController::class, "checkValidation"]);
});

// refine ( Attendance )
Route::prefix('v1/attendance')->group(function () {
    Route::get('/', [AttendanceController::class, "getAttendanceResult"]);
});
