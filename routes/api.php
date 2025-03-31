<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\QrRecordHistoryController;
use App\Http\Controllers\TimeRangeController;
use App\Http\Controllers\TimeTableController;
use App\Models\QrRecordHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;


//Student API Routes
Route::post('/student_login', [StudentController::class, 'login']);
Route::middleware('auth:sanctum')->post('/student_logout', [StudentController::class, 'logout']);
Route::post('/student_register', [StudentController::class, 'register']);
Route::post('/student_password_recovery', [StudentController::class, 'recover_password']);
Route::get('/student_show', [StudentController::class, 'showAll']);

//Lecturer API Routes
Route::post('/lecturer_login', [LecturerController::class, 'login']);
Route::middleware('auth:sanctum')->post('/lecturer_logout', [LecturerController::class, 'logout']);
Route::post('/lecturer_register', [LecturerController::class, 'register']);
Route::get('/lecturer_show', [LecturerController::class, 'showAll']);
Route::post('/lecturer_password_recovery', [StudentController::class, 'recover_password']);

// Route::get('/user/{id}', [SocialController::class, 'getUserById']);
// Route::middleware('auth:sanctum')->get('/user', [SocialController::class, 'user']);

// Lecture API Routes
Route::post('/lecture_event_create', [LectureController::class, 'addLectureSlot']);
Route::put('/lecture_event_update/{id}', [LectureController::class, 'editLectureSlot']);
Route::delete('/lecture_event_delete/{id}', [LectureController::class, 'deleteLectureSlot']);
Route::get('/lecture_get_all', [LectureController::class, 'getAll']);

// Time Slot API Routes
Route::post('/timeslot_event_create', [TimeRangeController::class, 'addTimeSlot']);
Route::put('/timeslot_event_update/{id}', [TimeRangeController::class, 'editTimeSlot']);
Route::delete('/timeslot_event_delete/{id}', [TimeRangeController::class, 'deleteTimeSlot']);
Route::get('/timeslot_get_all', [TimeRangeController::class, 'getAll']);

//Time Table API Routes
Route::get('/get', [TimeTableController::class, 'getAll']);
Route::get('/getRowData/{id}', [TimeTableController::class, 'getRowData']);
Route::post('/create', [TimeTableController::class, 'addTimeSlot']);
Route::put('/update/{id}', [TimeTableController::class, 'editSlot']);
Route::delete('/delete/{id}', [TimeTableController::class, 'deleteTimeSlot']);


// QR Code API Routes
Route::put('/qr_update/{id}', [QrCodeController::class, 'updateQRCode']);
Route::get('/qr_get/{id}', [QrCodeController::class, 'getQRCode']);
Route::post('/qr_create', [QrCodeController::class, 'createQR_ID']);
Route::delete('/qr_delete/{id}', [QrCodeController::class, 'deleteQRRecord']);




// Mark Attendance API Routes
Route::get('/get_attendance_result/{date}/{subject_Code}', action: [AttendanceController::class, 'getAttendanceResult']);
Route::post('/mark_attendance', [AttendanceController::class, 'markAttendance']);

// QR Record History
Route::post('/create_qr_record', [QrRecordHistoryController::class, 'createQR_ID']);
Route::get('/get_record_history/{date}/{subject_Code}', action: [QrRecordHistoryController::class, 'getRecordHistory']);
