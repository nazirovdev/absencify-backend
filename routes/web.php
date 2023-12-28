<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/create', function () {
    return view('create');
});

Route::middleware('guest:web,teacher')->group(function () {
    Route::get('/auth', [AuthController::class, 'loginUser'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'authUser']);

    Route::get('/auth/wali-kelas', [AuthController::class, 'loginTeacher']);
    Route::post('/auth/wali-kelas/login', [AuthController::class, 'authTeacher']);
});

Route::middleware('auth:web,teacher')->group(function () {
    // Auth User
    Route::get('/auth/me', [AuthController::class, 'authUserMe']);
    Route::put('/auth/me', [AuthController::class, 'updateAuthUser']);

    // Auth Teacher
    Route::get('/auth/wali-kelas/me', [AuthController::class, 'authTeacherMe']);
    Route::put('/auth/wali-kelas/me', [AuthController::class, 'updateAuthTeacher']);

    Route::get('/auth/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);

    // Classroom
    Route::get('/kelas', [ClassroomController::class, 'index']);
    Route::get('/kelas/tambah', [ClassroomController::class, 'add']);
    Route::get('/kelas/edit/{classroom:id}', [ClassroomController::class, 'edit']);
    Route::post('/kelas/tambah', [ClassroomController::class, 'store']);
    Route::put('/kelas/edit/{classroom:id}', [ClassroomController::class, 'update']);
    Route::delete('/kelas/delete/{classroom:id}', [ClassroomController::class, 'delete']);
    Route::get('/kelas/export', [ClassroomController::class, 'export']);
    Route::get('/kelas/export/template', [ClassroomController::class, 'exportTemplate']);
    Route::post('/kelas/import', [ClassroomController::class, 'import']);
    Route::get('/kelas/export-pdf', [ClassroomController::class, 'exportPDF']);

    // Teacher
    Route::get('/wali-kelas', [TeacherController::class, 'index']);
    Route::get('/wali-kelas/tambah', [TeacherController::class, 'add']);
    Route::get('/wali-kelas/edit/{teacher:id}', [TeacherController::class, 'edit']);
    Route::post('/wali-kelas/tambah', [TeacherController::class, 'store']);
    Route::put('/wali-kelas/edit/{teacher:id}', [TeacherController::class, 'update']);
    Route::delete('/wali-kelas/delete/{teacher:id}', [TeacherController::class, 'delete']);
    Route::get('/wali-kelas/export', [TeacherController::class, 'export']);
    Route::get('/wali-kelas/export/template', [TeacherController::class, 'exportTemplate']);
    Route::post('/wali-kelas/import', [TeacherController::class, 'import']);
    Route::get('/wali-kelas/export-pdf', [TeacherController::class, 'exportPDF']);

    // Student
    Route::get('/siswa', [StudentController::class, 'index']);
    Route::get('/siswa/tambah', [StudentController::class, 'add']);
    Route::get('/siswa/edit/{student:id}', [StudentController::class, 'edit']);
    Route::post('/siswa/tambah', [StudentController::class, 'store']);
    Route::put('/siswa/edit/{student:id}', [StudentController::class, 'update']);
    Route::delete('/siswa/delete/{student:id}', [StudentController::class, 'delete']);
    Route::post('/siswa/import', [StudentController::class, 'import']);
    Route::get('/siswa/export/template', [StudentController::class, 'exportTemplate']);
    Route::get('/siswa/export-pdf', [StudentController::class, 'exportPDF']);

    // Attendance
    Route::get('/presensi-siswa', [AttendanceController::class, 'index']);
    Route::get('/presensi-siswa/rekap/bulanan', [AttendanceController::class, 'recapMonthAttendance']);
    Route::get('/presensi-siswa/rekap/smt-gasal-tengah', [AttendanceController::class, 'recapAttendanceSmtGasalTengah']);
    Route::get('/presensi-siswa/rekap/smt-gasal-akhir', [AttendanceController::class, 'recapAttendanceSmtGasalAkhir']);
    Route::get('/presensi-siswa/rekap/smt-genap-tengah', [AttendanceController::class, 'recapAttendanceSmtGenapTengah']);
    Route::get('/presensi-siswa/rekap/smt-genap-akhir', [AttendanceController::class, 'recapAttendanceSmtGenapAkhir']);
    Route::get('/presensi-siswa/import', [AttendanceController::class, 'importDataPresensi']);
    Route::post('/presensi-siswa/import/data', [AttendanceController::class, 'importData']);
    Route::get('/presensi-siswa/export', [AttendanceController::class, 'exportTemplate']);
    Route::get('/presensi-siswa/export-pdf', [AttendanceController::class, 'exportPDF']);

    // Izin
    Route::get('/izin-siswa', [PermissionController::class, 'index']);
    Route::get('/izin-siswa/action/{permission:id}', [PermissionController::class, 'actionPermission']);

    // Agenda
    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::get('/agenda/tambah', [AgendaController::class, 'add']);
    Route::get('/agenda/edit/{agenda:id}', [AgendaController::class, 'edit']);
    Route::post('/agenda/tambah', [AgendaController::class, 'store']);
    Route::put('/agenda/edit/{agenda:id}', [AgendaController::class, 'update']);
    Route::delete('/agenda/delete/{agenda:id}', [AgendaController::class, 'delete']);

    // Jadwal
    Route::get('/jadwal', [ScheduleController::class, 'index']);
    Route::get('/jadwal/tambah', [ScheduleController::class, 'add']);
    Route::get('/jadwal/edit/{schedule:id}', [ScheduleController::class, 'edit']);
    Route::post('/jadwal/tambah', [ScheduleController::class, 'store']);
    Route::put('/jadwal/edit/{schedule:id}', [ScheduleController::class, 'update']);
    Route::delete('/jadwal/delete/{schedule:id}', [ScheduleController::class, 'delete']);

    // Pengaturan
    Route::get('/pengaturan', [SettingController::class, 'index']);
    Route::put('/pengaturan', [SettingController::class, 'update']);

    // Announcement
    Route::get('/pengumuman', [AnnouncementController::class, 'index']);
    Route::get('/pengumuman/tambah', [AnnouncementController::class, 'add']);
    Route::post('/pengumuman/tambah', [AnnouncementController::class, 'store']);
    Route::get('/pengumuman/edit/{announcement:id}', [AnnouncementController::class, 'edit']);
    Route::put('/pengumuman/edit/{announcement:id}', [AnnouncementController::class, 'update']);
    Route::delete('/pengumuman/delete/{announcement:id}', [AnnouncementController::class, 'destroy']);
});
