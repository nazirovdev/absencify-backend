<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class GuardianController extends Controller
{
    public function index()
    {
        return view('guardian.index', [
            'title' => 'Wali Siswa',
            'guardians' => Guardian::paginate(5)->withQueryString(),
        ]);
    }

    public function add()
    {
        return view('guardian.add', [
            'title' => 'Tambah Wali Siswa'
        ]);
    }

    public function edit(Guardian $guardian)
    {
        return view('guardian.edit', [
            'title' => 'Edit Wali Siswa',
            'guardian' => $guardian,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:guardians,username',
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'image' => 'image|max:2048',
            'alamat_wali_siswa' => 'required',
            'telepon_wali_siswa' => 'required'
        ]);

        $reqFile = $request->file('image');
        $newFotoName = null;

        if ($reqFile != null) {
            $newFotoName = ($request->username . '-' . Carbon::now()->microsecond . '.' . $reqFile->getClientOriginalExtension());
            $reqFile->storeAs('guardian', $newFotoName);
        }

        Guardian::create([
            'nip' => $request->nip,
            'classroom_id' => $request->classroom_id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'image' => $newFotoName
        ]);

        return redirect('/wali-siswa')->with(['message' => 'Data berhasil ditambah']);
    }

    public function update(Request $request, Guardian $guardian)
    {
        $request->validate([
            'nip' => 'required|unique:guardians,nip,' . $guardian->id,
            'nama' => 'required',
            'classroom_id' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'image' => 'image|max:2048',
        ]);

        $reqFile = $request->file('image');
        $newFotoName = $guardian->image;

        if ($request->classroom_id != $guardian->classroom_id) {
            return back()->with([
                'message' => 'Kelas sudah ada pengampu'
            ]);
        }

        if ($reqFile != null) {
            if (File::exists('storage/guardian/' . $guardian->image)) {
                File::delete('storage/guardian/' . $guardian->image);
            }

            $newFotoName = ($request->nip . '-' . Carbon::now()->microsecond . '.' . $reqFile->getClientOriginalExtension());
            $reqFile->storeAs('guardian', $newFotoName);
        }

        $guardian->update([
            'nip' => $request->nip,
            'classroom_id' => $request->classroom_id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'image' => $newFotoName,
        ]);

        return redirect('wali-siswa')->with(['message' => 'Data berhasil diupdate']);
    }

    public function delete(Guardian $guardian)
    {
        if (File::exists('storage/guardian/' . $guardian->image)) {
            File::delete('storage/guardian/' . $guardian->image);
        }

        $guardian->delete();
    }

    // API
    public function authGuardian(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $guardian = Guardian::where('username', $username)->first();

        if ($guardian == null || !Hash::check($password, $guardian->password)) {
            return response()->json([
                'message' => 'Username atau Password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Berhasil Login',
            'data' => $guardian->createToken('guardian-login')->plainTextToken
        ], 200);
    }

    public function guardianMe()
    {
        $guardianIdAuth = Auth::guard('guardian')->id();
        $guardian = Guardian::with(['student', 'student.classroom'])->where('id', $guardianIdAuth)->first(['id', 'username', 'nama', 'alamat', 'telepon', 'image']);

        return response()->json([
            'data' => [
                'id' => $guardian->id,
                'nama' => $guardian->nama,
                'username' => $guardian->username,
                'student' => [
                    'name' => $guardian->student->nama,
                    'class' => $guardian->student->classroom->nama
                ],
                'alamat' => $guardian->alamat,
                'telepon' => $guardian->telepon,
                'image' => $guardian->image == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/guardian/' . $guardian->image),
                'isGuardian' => true
            ]
        ]);
    }

    public function guardianLogout()
    {
        $guardianIdAuth = Auth::guard('guardian')->id();

        PersonalAccessToken::where('tokenable_id', $guardianIdAuth)->where('name', 'guardian-login')->delete();

        return response()->json([
            'data' => 'Guardian Logout'
        ]);
    }

    public function guardianProfilUpdate(Request $request)
    {
        $guardianIdAuth = Auth::guard('guardian')->id();
        $guardianUsername = Auth::guard('guardian')->user()->username;
        $guardian = Guardian::find($guardianIdAuth);

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'image' => 'image|max:2048',
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
            if (File::exists('storage/guardian/' . $guardian->image)) {
                File::delete('storage/guardian/' . $guardian->image);
            }

            $newImageStudentName = $guardianUsername . '-' . Carbon::now()->microsecond . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('guardian', $newImageStudentName);

            $guardian->update([
                'image' => $newImageStudentName,
            ]);
        }

        $guardian->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return response()->json([
            'data' => [
                'isError' => false,
                'message' => 'Data berhasil diupdate',
                'guardian' => [
                    'nama' => $guardian->nama,
                    'alamat' => $guardian->alamat,
                    'telepon' => $guardian->telepon,
                    'image' => $guardian->image == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/guardian/' . $guardian->image),
                ],
            ]
        ]);
    }

    public function guardianUpdatePassword(Request $request)
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

        $guardianIdAuth = Auth::guard('guardian')->id();
        $guardian = Guardian::where('id', $guardianIdAuth)->first();

        if (Hash::check($request->old_password, $guardian->password)) {
            $guardian->update([
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

    public function saveTokenDeviceGuardian(Request $request)
    {
        $studentIdAuth = Auth::guard('guardian')->id();
        $tokenDevice = $request->token;

        Guardian::find($studentIdAuth)->update([
            'token' => $tokenDevice
        ]);

        return response()->json([
            'data' => [
                'token' => $tokenDevice
            ]
        ]);
    }

    public function removeTokenDeviceGuardian(Request $request)
    {
        $studentIdAuth = Auth::guard('guardian')->id();
        $tokenDevice = null;

        Guardian::find($studentIdAuth)->update([
            'token' => $tokenDevice
        ]);

        return response()->json([
            'data' => [
                'message' => 'Token berhasil dihapus'
            ]
        ]);
    }
}
