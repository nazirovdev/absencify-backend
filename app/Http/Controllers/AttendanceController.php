<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Imports\AttendanceImport;
use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Guardian;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index()
    {
        if (Auth::guard('teacher')->user() != null) {
            $attendances = Attendance::withWhereHas('student', fn ($query) => $query
                ->withWhereHas('classroom', fn ($query) => $query
                    ->where('id', Auth::guard('teacher')->user()->classroom_id)))
                ->where('tanggal_presensi', Carbon::now()->toDateString())
                ->get();
        } else {
            $attendances = Attendance::with(['student.classroom:id,nama'])->where('tanggal_presensi', Carbon::now()->toDateString())->get();
        }

        return view('attendance.index', [
            'title' => 'Presensi Siswa',
            'attendances' => $attendances
        ]);
    }

    public function recapMonthAttendance(Request $request)
    {
        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;
        $class = $request->class ?? null;

        if (Auth::guard('teacher')->user() != null) {
            $teacher = Student::withWhereHas('classroom', fn ($query) => $query->where('id', Auth::guard('teacher')->user()->classroom_id))->get();
        } else {
            $teacher = Student::withWhereHas('classroom', fn ($query) => $query->where('nama', 'like', '%' . $class . '%'))->get();
        }

        return view('attendance.recap-month', [
            'title' => 'Rekap Presensi - Bulan',
            'students' => $teacher,
            'attendances' => Attendance::whereMonth('tanggal_presensi', $month)->whereYear('tanggal_presensi', $year)->get(),
            'month' => $month,
            'year' => $year,
            'monts' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ],
            'years' => [
                '2023',
                '2024',
                '2025',
                '2026',
                '2027',
                '2028',
                '2029',
                '2030',
            ],
            'classrooms' => Classroom::get(),
            'class' => $class,
            'agendas' => Agenda::get()
        ]);
    }

    public function recapAttendanceSmtGasalTengah(Request $request)
    {
        $totalHari = 0;
        $parseStartDate = Carbon::create(Setting::first()->smt_gasal_awal);
        $parseEndDate = Carbon::create(Setting::first()->smt_gasal_tengah);

        while ($parseStartDate->lte($parseEndDate)) {
            if (!$parseStartDate->isWeekend()) {
                $totalHari += 1;
            }

            $parseStartDate->addDay();
        }

        return view('attendance.recap-gasal-tengah', [
            'title' => 'Data Rekap Presensi Tengah Semester Gasal',
            'students' => Student::get(),
            'attendances' => Attendance::whereBetween('tanggal_presensi', [Carbon::create(Setting::first()->smt_gasal_awal), Carbon::create(Setting::first()->smt_gasal_tengah)])->get(),
            'total_hari' => $totalHari
        ]);
    }

    public function recapAttendanceSmtGasalAkhir(Request $request)
    {
        $totalHari = 0;
        $parseStartDate = Carbon::create(Setting::first()->smt_gasal_awal);
        $parseEndDate = Carbon::create(Setting::first()->smt_gasal_akhir);

        while ($parseStartDate->lte($parseEndDate)) {
            if (!$parseStartDate->isWeekend()) {
                $totalHari += 1;
            }

            $parseStartDate->addDay();
        }

        return view('attendance.recap-gasal-akhir', [
            'title' => 'Data Rekap Presensi Akhir Semester Gasal',
            'students' => Student::get(),
            'attendances' => Attendance::whereBetween('tanggal_presensi', [Carbon::create(Setting::first()->smt_gasal_awal), Carbon::create(Setting::first()->smt_gasal_akhir)])->get(),
            'total_hari' => $totalHari
        ]);
    }

    public function recapAttendanceSmtGenapTengah(Request $request)
    {
        $totalHari = 0;
        $parseStartDate = Carbon::create(Setting::first()->smt_genap_awal);
        $parseEndDate = Carbon::create(Setting::first()->smt_genap_tengah);

        while ($parseStartDate->lte($parseEndDate)) {
            if (!$parseStartDate->isWeekend()) {
                $totalHari += 1;
            }

            $parseStartDate->addDay();
        }

        return view('attendance.recap-genap-tengah', [
            'title' => 'Data Rekap Presensi Tengah Semester Genap',
            'students' => Student::get(),
            'attendances' => Attendance::whereBetween('tanggal_presensi', [Carbon::create(Setting::first()->smt_genap_awal), Carbon::create(Setting::first()->smt_genap_tengah)])->get(),
            'total_hari' => $totalHari
        ]);
    }

    public function recapAttendanceSmtGenapAkhir(Request $request)
    {
        $totalHari = 0;
        $parseStartDate = Carbon::create(Setting::first()->smt_genap_awal);
        $parseEndDate = Carbon::create(Setting::first()->smt_genap_akhir);

        while ($parseStartDate->lte($parseEndDate)) {
            if (!$parseStartDate->isWeekend()) {
                $totalHari += 1;
            }

            $parseStartDate->addDay();
        }

        return view('attendance.recap-genap-tengah', [
            'title' => 'Data Rekap Presensi Tengah Semester Genap',
            'students' => Student::get(),
            'attendances' => Attendance::whereBetween('tanggal_presensi', [Carbon::create(Setting::first()->smt_genap_awal), Carbon::create(Setting::first()->smt_genap_akhir)])->get(),
            'total_hari' => $totalHari
        ]);
    }

    public function sendNotif($token, $message)
    {
        $deviceToken = $token;
        $serverKey = 'AAAAyrsmNy8:APA91bG69J698mETk1MeINmwFL6FkG1nXW8h85YgJ6R6tMOTW0_37lrkkLdMxYvOQXU_jk20411ik3ffYJqCVy_pvX85GTLDBoPnTgHyAXcsL7opawW-2IEBvxrqICeQtGZK35xbQNk4';

        if ($deviceToken !== null) {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $deviceToken,
                'data' => [
                    'title' => 'Izin Siswa',
                    'body' => $message
                ],
                'notification' => [
                    'title' => 'Izin Siswa',
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Device token saved and notification sent']);
            } else {
                return response()->json(['message' => 'Error sending notification'], 500);
            }
        }
    }

    public function importDataPresensi(Request $request)
    {
        return view('attendance.import-data-presensi', [
            'title' => 'Import Data Presensi Siswa'
        ]);
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['message' => 'Data gagal diimport', 'error' => true]);
        }

        $reqFile = $request->file('file');

        Excel::import(new AttendanceImport, $reqFile);

        return redirect()->back()->with(['message' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportTemplate()
    {
        return (new AttendanceExport)->download('attendance_template_' . Carbon::now()->microsecond . '.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        $pdf = Pdf::loadView('attendance.pdf', [
            'title' => 'Data Presensi Siswa',
            'agendas' => Agenda::get(),
            'students' => Student::get(),
            'attendances' => Attendance::get(),
            'year' => $year,
            'month' => $month
        ])->setPaper('a4', 'landscape');

        // return $pdf->download('document-'.Carbon::now()->microsecond.'.pdf');
        return $pdf->stream();
    }

    // API
    public function formulaHavershine($latDst, $lngDst)
    {
        $location = explode(',', Setting::first()->titik_lokasi);
        $settingRadius = Setting::first()->radius;

        $radius = 6371000; // Radius Bumi dalam meter

        $lat1 = deg2rad($latDst);
        $lon1 = deg2rad($lngDst);
        $lat2 = deg2rad($location[0]);
        $lon2 = deg2rad($location[1]);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c;

        return round($distance) > $settingRadius;
    }

    public function attendanceStudent(Request $request)
    {
        $studentIdAuth = Auth::guard('student')->id();
        $studentName = Auth::guard('student')->user()->nama;
        $studentNis = Auth::guard('student')->user()->nis;

        $tokenGuardian = Guardian::where('id', Auth::guard('student')->user()->guardian_id)->first()->token;

        $attendance = Attendance::where('student_id', $studentIdAuth)->orderByDesc('tanggal_presensi')->first();
        $scheduleAttendance = Schedule::where('hari', Carbon::now()->dayName)->first();

        $jamSekarang = Carbon::now()->toTimeString();
        $tanggalSekarang = Carbon::now()->toDateString();
        $hariSekarang = Carbon::now()->dayName;

        $requestImage = $request->file('image');
        $imageFileName = $requestImage == null ? null : $studentNis . '-' . $jamSekarang . '.' . $requestImage->getClientOriginalExtension();

        if ($this->formulaHavershine($request->lat, $request->lng)) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Anda berada diluar jangkauan'
                ]
            ]);
        }

        if ($attendance != null && $attendance->tanggal_presensi == $tanggalSekarang) {
            if ($attendance->jam_masuk != null && $attendance->jam_pulang != null) {
                return response()->json([
                    'data' => [
                        'isError' => true,
                        'message' => 'Anda sudah melakukan presensi'
                    ]
                ]);
            }

            if ($attendance->jam_masuk != null && $hariSekarang == $scheduleAttendance->hari && $jamSekarang <= $scheduleAttendance->jam_pulang) {
                return response()->json([
                    'data' => [
                        'isError' => true,
                        'message' => 'Presensi pulang belum tersedia'
                    ]
                ]);
            }

            if ($attendance->jam_masuk != null && $hariSekarang == $scheduleAttendance->hari && $jamSekarang > $scheduleAttendance->jam_pulang) {
                if ($requestImage != null) {
                    $requestImage->storeAs('attendance', $imageFileName);
                }

                $attendance->update([
                    'jam_pulang' => $jamSekarang,
                    'image_pulang' => $imageFileName
                ]);

                if ($tokenGuardian != null) {
                    $this->sendNotif($tokenGuardian, "$studentName berhasil absen pulang");
                }

                return response()->json([
                    'data' => [
                        'isError' => false,
                        'message' => 'Presensi pulang berhasil',
                        'attendance' => collect($attendance->load(['student:id,nama,classroom_id', 'student.classroom:id,nama']))->map(function ($data, $key) {
                            return $data;
                        })->except('student_id', 'created_at', 'updated_at', 'student.id', 'student.classroom_id', 'student.classroom.id')
                    ]
                ]);
            }

            if ($attendance->status == 's') {
                return response()->json([
                    'data' => [
                        'isError' => true,
                        'message' => 'Anda hari ini sakit'
                    ]
                ]);
            }

            if ($attendance->status == 'i') {
                return response()->json([
                    'data' => [
                        'isError' => true,
                        'message' => 'Anda hari ini izin'
                    ]
                ]);
            }

            if ($attendance->status == 'a') {
                return response()->json([
                    'data' => [
                        'isError' => true,
                        'message' => 'Anda hari ini alpa'
                    ]
                ]);
            }
        }

        if ($scheduleAttendance == null) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Presensi tidak tersedia',
                ]
            ]);
        }

        if ($jamSekarang >= $scheduleAttendance->jam_pulang) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Presensi Masuk telah lewat dari KBM',
                ]
            ]);
        }

        if ($jamSekarang > $scheduleAttendance->jam_masuk) {
            if ($requestImage != null) {
                $requestImage->storeAs('attendance', $imageFileName);
            }

            $attendance = Attendance::create([
                'student_id' => $studentIdAuth,
                'tanggal_presensi' => $tanggalSekarang,
                'jam_masuk' => $jamSekarang,
                'image_masuk' => $imageFileName,
                'status' => 't'
            ]);

            if ($tokenGuardian != null) {
                $this->sendNotif($tokenGuardian, "$studentName berhasil absen, namun terlambat");
            }

            return response()->json([
                'data' => [
                    'isError' => false,
                    'message' => 'Presensi Masuk berhasil, namun terlambat',
                    'attendance' => collect($attendance->load(['student:id,nama,classroom_id', 'student.classroom:id,nama']))->map(function ($data, $key) {
                        return $data;
                    })->except('student_id', 'created_at', 'updated_at', 'student.id', 'student.classroom_id', 'student.classroom.id')
                ]
            ]);
        }

        if ($requestImage != null) {
            $requestImage->storeAs('attendance', $imageFileName);
        }

        $attendance = Attendance::create([
            'student_id' => $studentIdAuth,
            'tanggal_presensi' => $tanggalSekarang,
            'jam_masuk' => $jamSekarang,
            'image_masuk' => $imageFileName,
            'status' => 'h'
        ]);

        if ($tokenGuardian != null) {
            $this->sendNotif($tokenGuardian, "$studentName berhasil absen tepat waktu");
        }

        return response()->json([
            'data' => [
                'isError' => false,
                'message' => 'Presensi Masuk berhasil',
                'attendance' => collect($attendance->load(['student:id,nama,classroom_id', 'student.classroom:id,nama']))->map(function ($data, $key) {
                    return $data;
                })->except('student_id', 'created_at', 'updated_at', 'student.id', 'student.classroom_id', 'student.classroom.id')
            ]
        ]);
    }

    public function attendanceStudentHistory(Request $request)
    {
        $studentIdAuth = Auth::guard('student')->id();
        $attendances = Attendance::withWhereHas('student', fn ($query) => $query->where('id', $studentIdAuth)->withWhereHas('classroom', fn ($query) => $query))->orderByDesc('tanggal_presensi')->get();

        return response()->json([
            'data' => [
                'attendance' => collect($attendances)->map(function ($attendance) {
                    return [
                        'id' => $attendance->id,
                        'student' => [
                            'nama' => $attendance->student->nama,
                            'classroom' => [
                                'nama' => $attendance->student->classroom->nama
                            ]
                        ],
                        'tanggal_presensi' => $attendance->tanggal_presensi,
                        'jam_masuk' => $attendance->jam_masuk,
                        'image_masuk' => $attendance->image_masuk == null ? null : secure_asset('storage/attendance/' . $attendance->image_masuk),
                        'jam_pulang' => $attendance->jam_pulang,
                        'image_pulang' => $attendance->image_pulang == null ? null : secure_asset('storage/attendance/' . $attendance->image_pulang),
                        'status' => $attendance->status,
                    ];
                }),
            ]
        ]);
    }

    public function getAttendanceLeaderboard()
    {
        $studentClassroom = Auth::guard('student')->user()->classroom_id;

        return response()->json([
            'data' => [
                'isError' => false,
                'leaderboards' => collect(Attendance::withWhereHas('student', fn ($query)
                => $query->withWhereHas('classroom', fn ($query)
                => $query->where('id', $studentClassroom)))->where('tanggal_presensi', Carbon::now()->toDateString())->orderBy('jam_masuk', 'asc')->get())->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'tanggal_presensi' => $data->tanggal_presensi,
                        'jam_masuk' => $data->jam_masuk,
                        'image_masuk' => $data->image_masuk == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/attendance/' . $data->image_masuk),
                        'jam_pulang' => $data->jam_pulang,
                        'image_pulang' => $data->image_pulang == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/attendance/' . $data->image_pulang),
                        'student' => [
                            'nama' => $data->student->nama
                        ],
                        'classroom' => [
                            'nama' => $data->student->classroom->nama
                        ],
                        'status' => $data->status,
                    ];
                })
            ]
        ]);
    }

    public function getAttendanceRecapMonth()
    {
        $studentIdAuth = Auth::guard('student')->id();

        $startMonth = Carbon::now()->startOfMonth()->toDateString();
        $endMonth = Carbon::now()->endOfMonth()->toDateString();

        $hadir = Attendance::whereBetween('tanggal_presensi', [$startMonth, $endMonth])
            ->where('student_id', $studentIdAuth)->where('status', 'h')->count();

        $terlambat = Attendance::whereBetween('tanggal_presensi', [$startMonth, $endMonth])
            ->where('student_id', $studentIdAuth)->where('status', 't')->count();

        $izin = Attendance::whereBetween('tanggal_presensi', [$startMonth, $endMonth])
            ->where('student_id', $studentIdAuth)->where('status', 'i')->count();

        $sakit = Attendance::whereBetween('tanggal_presensi', [$startMonth, $endMonth])
            ->where('student_id', $studentIdAuth)->where('status', 's')->count();

        $alpa = Attendance::whereBetween('tanggal_presensi', [$startMonth, $endMonth])
            ->where('student_id', $studentIdAuth)->where('status', 'a')->count();

        return response()->json([
            'data' => [
                'recap' => [
                    'h' => $hadir,
                    't' => $terlambat,
                    'i' => $izin,
                    's' => $sakit,
                    'a' => $alpa
                ]
            ]
        ]);
    }

    // Guardian
    public function getAttendanceStudent()
    {
        $guardianIdAuth = Auth::guard('guardian')->id();
        $attendances = Attendance::withWhereHas('student', fn ($query) => $query->withWhereHas('guardian', fn ($query) => $query->where('id', $guardianIdAuth)))->orderByDesc('tanggal_presensi')->get();

        return response()->json([
            'data' => [
                'attendances' => collect($attendances)->map(function ($attendance) {
                    return [
                        'id' => $attendance->id,
                        'student' => [
                            'nama' => $attendance->student->nama,
                            'classroom' => [
                                'nama' => $attendance->student->classroom->nama
                            ]
                        ],
                        'tanggal_presensi' => $attendance->tanggal_presensi,
                        'jam_masuk' => $attendance->jam_masuk,
                        'image_masuk' => $attendance->image_masuk == null ? null : secure_asset('storage/attendance/' . $attendance->image_masuk),
                        'jam_pulang' => $attendance->jam_pulang,
                        'image_pulang' => $attendance->image_pulang == null ? null : secure_asset('storage/attendance/' . $attendance->image_pulang),
                        'status' => $attendance->status,
                    ];
                })
            ]
        ]);
    }
}
