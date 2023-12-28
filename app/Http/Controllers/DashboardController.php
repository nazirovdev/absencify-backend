<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('teacher')->user() != null) {
            $hadir = Attendance::withWhereHas('student', fn ($query) => $query
                ->withWhereHas('classroom', fn ($query) => $query
                    ->where('id', Auth::guard('teacher')->user()->classroom_id)))
                ->where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 'h')
                ->distinct()
                ->count('student_id');

            $terlambat = Attendance::withWhereHas('student', fn ($query) => $query
                ->withWhereHas('classroom', fn ($query) => $query
                    ->where('id', Auth::guard('teacher')->user()->classroom_id)))
                ->where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 't')
                ->distinct()
                ->count('student_id');

            $izin = Attendance::withWhereHas('student', fn ($query) => $query
                ->withWhereHas('classroom', fn ($query) => $query
                    ->where('id', Auth::guard('teacher')->user()->classroom_id)))
                ->where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 'i')
                ->distinct()
                ->count('student_id');

            $sakit = Attendance::withWhereHas('student', fn ($query) => $query
                ->withWhereHas('classroom', fn ($query) => $query
                    ->where('id', Auth::guard('teacher')->user()->classroom_id)))
                ->where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 's')
                ->distinct()
                ->count('student_id');

            $alpa = Attendance::withWhereHas('student', fn ($query) => $query
                ->withWhereHas('classroom', fn ($query) => $query
                    ->where('id', Auth::guard('teacher')->user()->classroom_id)))
                ->where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 'a')
                ->distinct()
                ->count('student_id');
        } else {
            $hadir = Attendance::where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 'h')->distinct()->count('student_id');
            $terlambat = Attendance::where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 't')->distinct()->count('student_id');
            $izin = Attendance::where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 'i')->distinct()->count('student_id');
            $sakit = Attendance::where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 's')->distinct()->count('student_id');
            $alpa = Attendance::where('tanggal_presensi', Carbon::now()->toDateString())
                ->where('status', 'a')->distinct()->count('student_id');
        }

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'data' => [
                'hadir' => $hadir,
                'terlambat' => $terlambat,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
            ]
        ]);
    }
}
