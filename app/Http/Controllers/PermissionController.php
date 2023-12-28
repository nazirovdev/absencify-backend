<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PermissionController extends Controller
{
    public function index()
    {
        if (Auth::guard('teacher')->user() != null) {
            $permissions = Permission::withWhereHas('student', fn ($query) => $query->withWhereHas('classroom', fn ($query) => $query->where('id', Auth::guard('teacher')->user()->classroom_id)))->get();
        } else {
            $permissions = Permission::with('student.classroom:id,nama')->get();
        }

        return view('permission.index', [
            'title' => 'Izin Siswa',
            'permissions' => $permissions,
        ]);
    }

    public function actionPermission(Request $request, Permission $permission)
    {
        DB::beginTransaction();
        try {
            $tanggalMulai = Carbon::create($permission->tanggal_mulai)->day;
            $tanggalAkhir = Carbon::create($permission->tanggal_akhir)->day;

            $startDate = Carbon::create($permission->tanggal_mulai);

            $token = $permission->load('student')->student->token;

            $this->sendNotif($token, $request->status);

            $permission->update([
                'status' => $request->status
            ]);

            if ($request->status == 'terima') {
                for ($x = $tanggalMulai; $x <= $tanggalAkhir; $x++) {
                    if (Agenda::where('tanggal_agenda', Carbon::create($startDate->toDateString()))->where('status', 'l')->count() == 0) {
                        if (!Carbon::create($startDate->toDateString())->isWeekend() ) {
                            Attendance::create([
                                'student_id' => $permission->student_id,
                                'tanggal_presensi' => $startDate->toDateString(),
                                'jam_masuk' => null,
                                'status' => $permission->tipe
                            ]);
                        }
                    }
    
    
                    $startDate->addDay();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return back();
    }

    public function sendNotif($token, $status)
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
                    'body' => "Izin anda telah di".$status
                ],
                'notification' => [
                    'title' => 'Izin Siswa',
                    'body' => "Izin anda telah di".$status
                ]
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Device token saved and notification sent']);
            } else {
                return response()->json(['message' => 'Error sending notification'], 500);
            }
        }
    }

    // API
    public function studentPermission(Request $request)
    {
        $studentIdAuth = Auth::guard('student')->id();
        $studentNis = Auth::guard('student')->user()->nis;

        $tanggalSekarang = Carbon::now()->toDateString();
        $permissionTerakhir = Permission::latest()->first()->tanggal_mulai ?? null;
        $permissionStatusTerakhir = Permission::latest()->first()->status ?? null;

        $tanggalMulai = Carbon::create($request->tanggal_mulai)->toDateString();
        $tanggalAkhir = Carbon::create($request->tanggal_akhir)->toDateString();
        $keterangan = $request->keterangan;
        $tipe = $request->tipe;
        $reqFile = $request->file('file');
        $file = null;

        $validator = Validator::make($request->all(),[
            'keterangan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'tipe' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => $validator->messages()->first()
                ]
            ]);
        }

        if (Permission::where('tanggal_mulai', $tanggalMulai)->where('tanggal_akhir', $tanggalAkhir)->where('status', 'menunggu')->count() > 0) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Sedang menunggu proses izin'
                ]
            ]);
        }

        if (Permission::where('tanggal_mulai', $tanggalMulai)->where('tanggal_akhir', $tanggalAkhir)->where('status', 'terima')->count() > 0) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Anda sudah melakukan izin'
                ]
            ]);
        }

        if (Carbon::create($tanggalMulai)->isWeekend()) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Izin tidak berlaku di akhir pekan.'
                ]
            ]);
        }

        if ($tanggalMulai < $tanggalSekarang) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Tanggal mulai tidak boleh melewati tanggal sekarang'
                ]
            ]);
        }

        if ($tanggalMulai > $tanggalAkhir) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Tanggal mulai tidak boleh melewati tanggal akhir'
                ]
            ]);
        }

        if ($reqFile == null && Carbon::create($tanggalMulai)->diffInDays(Carbon::create($tanggalAkhir)) + 1 > 3) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => 'Jika lebih dari 3 hari, mohon sertakan surat'
                ]
            ]);
        }

        if ($reqFile != null) {
            $file = $studentNis . '-' . Carbon::now()->microsecond . '-' . 'izin' . '.' . $reqFile->getClientOriginalExtension();
            $reqFile->storeAs('permission', $file);
        }

        Permission::create([
            'student_id' => $studentIdAuth,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
            'keterangan' => $keterangan,
            'tipe' => $tipe,
            'file' => $file
        ]);

        return response()->json([
            'data' => [
                'isError' => false,
                'message' => 'Siswa berhasil mengajukan izin siswa'
            ],
        ]);
    }

    public function getPermissionStudent()
    {
        $studentIdAuth = Auth::guard('student')->id();
        $studentPermission = Permission::with('student:id,nama')->where('student_id', $studentIdAuth)->orderByDesc('tanggal_mulai')->get(['id', 'student_id', 'tipe', 'tanggal_mulai', 'tanggal_akhir', 'keterangan', 'file', 'status']);

        return response()->json([
            'data' => $studentPermission->map(function ($permission) {
                return [
                    'nama' => $permission->student->nama,
                    'tanggal_mulai' => $permission->tanggal_mulai,
                    'tanggal_akhir' => $permission->tanggal_akhir,
                    'tipe' => $permission->tipe,
                    'keterangan' => $permission->keterangan,
                    'status' => $permission->status,
                    'file' => ($permission->file === null) ? null : secure_asset('storage/permission/' . $permission->file),
                    'total_hari' => Carbon::create($permission->tanggal_mulai)
                        ->diffInDays(Carbon::create($permission->tanggal_akhir ?? $permission->tanggal_awal)) + 1
                ];
            })
        ]);
    }

    public function getPermissionGuardian(Request $request)
    {
        $guardianIdAuth = Auth::guard('guardian')->id();

        $studentPermission = collect(Permission::withWhereHas('student', fn($query)=>$query->withWhereHas('guardian', fn($query)=>$query->where('id', $guardianIdAuth)))->get());

        return response()->json([
            'data' => $studentPermission->map(function($permission){
                return [
                    'nama' => $permission->student->nama,
                    'tanggal_mulai' => $permission->tanggal_mulai,
                    'tanggal_akhir' => $permission->tanggal_akhir,
                    'tipe' => $permission->tipe,
                    'keterangan' => $permission->keterangan,
                    'status' => $permission->status,
                    'file' => ($permission->file === null) ? null : secure_asset('storage/files/' . $permission->file),
                    'total_hari' => Carbon::create($permission->tanggal_mulai)
                        ->diffInDays(Carbon::create($permission->tanggal_akhir ?? $permission->tanggal_awal)) + 1
                ];
            })
        ]);
    }
}
