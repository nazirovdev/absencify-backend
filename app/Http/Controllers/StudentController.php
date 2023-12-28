<?php

namespace App\Http\Controllers;

use App\Exports\StudentGuardianExport;
use App\Imports\StudentGuardianImport;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index', [
            'title' => 'Siswa',
            'students' => Auth::guard('web')->user()
                ? Student::with('classroom')->paginate(25)->withQueryString()
                : Student::withWhereHas('classroom', fn ($query) =>
                $query->where('id', Auth::guard('teacher')->user()->classroom_id))->paginate(5)->withQueryString(),
        ]);
    }

    public function add()
    {
        return view('student.add', [
            'title' => 'Tambah Siswa',
            'classrooms' => Classroom::all()
        ]);
    }

    public function edit(Student $student)
    {
        return view('student.edit', [
            'title' => 'Edit Siswa',
            'student' => $student->load('guardian'),
            'classrooms' => Classroom::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis_siswa' => 'required|unique:students,nis',
            'nama_siswa' => 'required',
            'alamat_siswa' => 'required',
            'telepon_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'classroom_id' => 'required',
            'nama_wali_siswa' => 'required',
            'alamat_wali_siswa' => 'required',
            'telepon_wali_siswa' => 'required',
            'username_wali_siswa' => 'required',
            'image_siswa' => 'image|max:2048',
        ]);

        $newFotoStudentName = null;

        $reqFileStudent = $request->file('image_siswa');
        $reqFileGuardian = $request->file('image_wali_siswa');

        // Transaction
        DB::beginTransaction();

        try {
            if ($reqFileStudent != null) {
                $newFotoStudentName = ($request->nis_siswa . '-' . Carbon::now()->microsecond . '.' . $reqFileStudent->getClientOriginalExtension());
                $reqFileStudent->storeAs('student', $newFotoStudentName);
            }

            // if ($reqFileGuardian != null) {
            //     $newFotoStudentName = ($request->username_wali_siswa . '-' . Carbon::now()->microsecond . '.' . $reqFileGuardian->getClientOriginalExtension());
            //     $reqFileGuardian->storeAs('guardian', $newFotoStudentName);
            // }

            $studentId = DB::table('guardians')->insertGetId([
                'nama' => $request->nama_wali_siswa,
                'username' => $request->username_wali_siswa,
                'alamat' => $request->alamat_wali_siswa,
                'telepon' => $request->telepon_wali_siswa,
                'password' => Hash::make('123'),
            ]);
            DB::table('students')->insert([
                'nis' => $request->nis_siswa,
                'password' => Hash::make('123'),
                'nama' => $request->nama_siswa,
                'alamat' => $request->alamat_siswa,
                'telepon' => $request->telepon_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'image' => $newFotoStudentName,
                'guardian_id' => $studentId,
                'classroom_id' => $request->classroom_id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        // End Transaction

        return redirect('/siswa')->with(['message' => 'Data berhasil ditambah']);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis_siswa' => 'required|unique:students,nis,' . $student->id,
            'nama_siswa' => 'required',
            'alamat_siswa' => 'required',
            'telepon_siswa' => 'required',
            'alamat_wali_siswa' => 'required',
            'telepon_wali_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'classroom_id' => 'required',
            'nama_wali_siswa' => 'required',
            'username_wali_siswa' => 'required',
            'image' => 'image|max:2048',
        ]);

        $reqFileStudent = $request->file('image_siswa');
        $newFotoStudentName = null;

        // Transaction
        DB::beginTransaction();

        try {
            if ($reqFileStudent != null) {
                if (File::exists('storage/student/' . $student->image)) {
                    File::delete('storage/student/' . $student->image);
                }

                $newFotoStudentName = ($request->nis_siswa . '-' . Carbon::now()->microsecond . '.' . $reqFileStudent->getClientOriginalExtension());
                $reqFileStudent->storeAs('student', $newFotoStudentName);
            }

            DB::table('guardians')->where('id', $student->guardian->id)->update([
                'nama' => $request->nama_wali_siswa,
                'alamat' => $request->alamat_wali_siswa,
                'telepon' => $request->telepon_wali_siswa,
                'username' => $request->username_wali_siswa,
            ]);
            DB::table('students')->where('id', $student->id)->update([
                'nis' => $request->nis_siswa,
                'nama' => $request->nama_siswa,
                'alamat' => $request->alamat_siswa,
                'telepon' => $request->telepon_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'image' => $newFotoStudentName,
                'classroom_id' => $request->classroom_id,
                'guardian_id' => $student->guardian->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return redirect('siswa')->with(['message' => 'Data berhasil diupdate']);
    }

    public function delete(Student $student)
    {
        if (File::exists('storage/student/' . $student->image)) {
            File::delete('storage/student/' . $student->image);
        }

        // Transaction
        DB::beginTransaction();

        try {
            DB::table('guardians')->where('id', $student->guardian->id)->delete();
            DB::table('students')->where('id', $student->id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        $student->delete();
    }

    public function import(Request $request)
    {
        $reqFile = $request->file('file');
        Excel::import(new StudentGuardianImport, $reqFile);

        return redirect()->back();
    }

    public function exportTemplate()
    {
        return (new StudentGuardianExport)->download('student_guardian_template_'.Carbon::now()->microsecond.'.xlsx');
    }

    public function exportPDF(Request $request)
    {
        if (Auth::guard('teacher')->user() != null) {
            $student = Student::where('classroom_id', Auth::guard('teacher')->user()->classroom_id)->get();
        }else {
            $student = Student::get();
        }

        $pdf = Pdf::loadView('student.pdf', [
            'students' => $student,
            'title' => 'Data Siswa'
        ]);

        // return $pdf->download('document-'.Carbon::now()->microsecond.'.pdf');
        return $pdf->stream();
    }

    // API
    public function authStudent(Request $request)
    {
        $nis = $request->nis;
        $password = $request->password;

        $student = Student::where('nis', $nis)->first();

        if ($student == null || !Hash::check($password, $student->password)) {
            return response()->json([
                'message' => 'NIS atau Password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Berhasil Login',
            'data' => $student->createToken('student-login')->plainTextToken
        ], 200);
    }

    public function studentMe()
    {
        $studentIdAuth = Auth::guard('student')->id();
        $student = Student::with('guardian:id,nama', 'classroom:id,nama', 'classroom.teacher:nama,classroom_id')->find($studentIdAuth);

        return response()->json([
            'data' => [
                'id' => $student->id,
                'nama' => $student->nama,
                'nis' => $student->nis,
                'alamat' => $student->alamat,
                'telepon' => $student->telepon,
                'image' => $student->image == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/student/' . $student->image),
                'jenis_kelamin' => $student->jenis_kelamin,
                'guardian' => $student->guardian->nama,
                'classroom' => $student->classroom->nama,
                'teacher' => $student->classroom->teacher->nama,
                'isStudent' => true
            ]
        ]);
    }

    public function studentLogout()
    {
        $studentIdAuth = Auth::guard('student')->id();

        PersonalAccessToken::where('tokenable_id', $studentIdAuth)->where('name', 'student-login')->delete();

        return response()->json([
            'data' => 'Student Logout'
        ]);
    }

    public function studentProfilUpdate(Request $request)
    {
        $studentIdAuth = Auth::guard('student')->id();
        $studentNis = Auth::guard('student')->user()->nis;
        $student = Student::find($studentIdAuth);

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'image' => 'image|max:2048',
            'jenis_kelamin' => 'required',
            'telepon' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => $validator->errors()->first(),
                ]
            ], 400);
        }

        $reqImage = $request->file('image');
        $newImageStudentName = null;

        if ($reqImage != null) {
            if (File::exists('storage/student/' . $student->image)) {
                File::delete('storage/student/' . $student->image);
            }

            $newImageStudentName = $studentNis . '-' . Carbon::now()->microsecond . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('student', $newImageStudentName);

            $student->update([
                'image' => $newImageStudentName,
            ]);
        }

        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
        ]);

        return response()->json([
            'data' => [
                'isError' => false,
                'message' => 'Data berhasil diupdate',
                'student' => [
                    'id' => $student->id,
                    'nis' => $student->nis,
                    'nama' => $student->nama,
                    'alamat' => $student->alamat,
                    'image' => $student->image == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/student/' . $student->image),
                    'jenis_kelamin' => $student->jenis_kelamin,
                    'telepon' => $student->telepon,
                ]
            ]
        ]);
    }

    public function studentUpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'isError' => true,
                    'message' => $validator->errors()->first()
                ]
            ]);
        }

        $studentIdAuth = Auth::guard('student')->id();
        $student = Student::where('id', $studentIdAuth)->first();

        if (Hash::check($request->old_password, $student->password)) {
            $student->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'data' => [
                    'isError' => false,
                    'message' => 'Password berhasil diperbaharui'
                ]
            ]);
        }

        return response()->json([
            'data' => [
                'isError' => true,
                'message' => 'Password gagal diperbaharui'
            ]
        ]);
    }

    public function saveTokenDevice(Request $request)
    {
        $studentIdAuth = Auth::guard('student')->id();
        $tokenDevice = $request->token;

        Student::find($studentIdAuth)->update([
            'token' => $tokenDevice
        ]);

        return response()->json([
            'data' => [
                'token' => $tokenDevice
            ]
        ]);
    }

    public function removeTokenDevice(Request $request)
    {
        $studentIdAuth = Auth::guard('student')->id();
        $tokenDevice = null;

        Student::find($studentIdAuth)->update([
            'token' => $tokenDevice
        ]);

        return response()->json([
            'data' => [
                'message' => 'Token berhasil dihapus'
            ]
        ]);
    }
}
