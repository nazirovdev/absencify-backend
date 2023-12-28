<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student
Route::post('/auth/student', [StudentController::class, 'authStudent']);
Route::middleware('auth:sanctum,student')->group(function () {
    // Profil
    Route::get('/student/me', [StudentController::class, 'studentMe']);
    Route::get('/student/logout', [StudentController::class, 'studentLogout']);
    Route::post('/student/update', [StudentController::class, 'studentProfilUpdate']);
    Route::post('/student/update/password', [StudentController::class, 'studentUpdatePassword']);
    Route::post('/student/token/device', [StudentController::class, 'saveTokenDevice']);
    Route::post('/student/token/device/remove', [StudentController::class, 'removeTokenDevice']);

    // Attendance
    Route::post('/student/present', [AttendanceController::class, 'attendanceStudent']);
    Route::get('/student/present', [AttendanceController::class, 'attendanceStudentHistory']);
    Route::get('/student/present/leaderboard', [AttendanceController::class, 'getAttendanceLeaderboard']);
    Route::get('/student/recap/month', [AttendanceController::class, 'getAttendanceRecapMonth']);

    // Permission
    Route::post('/student/permission', [PermissionController::class, 'studentPermission']);
    Route::get('/student/permission', [PermissionController::class, 'getPermissionStudent']);
    Route::post('/student/permission/change', [PermissionController::class, 'changeStudentPermission']);

    // Setting
    Route::get('/setting/location', [SettingController::class, 'getLokasi']);

    // Agenda
    Route::get('/agenda', [AgendaController::class, 'getAgenda']);
});

// Guardian
Route::post('/auth/guardian', [GuardianController::class, 'authGuardian']);
Route::middleware('auth:sanctum,guardian')->group(function () {
    // Profil
    Route::get('/guardian/me', [GuardianController::class, 'guardianMe']);
    Route::get('/guardian/logout', [GuardianController::class, 'guardianLogout']);
    Route::post('/guardian/update', [GuardianController::class, 'guardianProfilUpdate']);
    Route::post('/guardian/update/password', [GuardianController::class, 'guardianUpdatePassword']);
    Route::post('/guardian/token/device', [GuardianController::class, 'saveTokenDeviceGuardian']);
    Route::post('/guardian/token/device/remove', [GuardianController::class, 'removeTokenDeviceGuardian']);

    // Attendance
    Route::get('/guardian/present', [AttendanceController::class, 'getAttendanceStudent']);

    // Permission
    Route::get('/guardian/permission', [PermissionController::class, 'getPermissionGuardian']);

    // Announcement
    Route::get('/guardian/announcement', [AnnouncementController::class, 'getAnnouncement']);
});