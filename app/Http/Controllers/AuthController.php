<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginUser()
    {
        return view('auth.user', [
            'title' => 'Login - User'
        ]);
    }

    public function authUser(Request $request)
    {
        $request->validate([
            'username' => 'required'
        ]);

        if (!Auth::guard('web')->attempt($request->only(['username', 'password']))) {
            return back()->with([
                'message' => 'Username atau Password Salah'
            ]);
        }

        $request->session()->regenerate();
        return redirect('/');
    }

    public function authUserMe()
    {
        return view('auth.user-me', [
            'title' => 'Profile'
        ]);
    }

    public function updateAuthUser(Request $request)
    {
        $request->validate([
            'username' => 'unique:users,username,' . Auth::guard('web')->user()->id,
            'password_lama' => 'nullable|min:3',
            'password_baru' => 'nullable|min:3'
        ]);

        $userAuthId = Auth::guard('web')->user()->id;
        $newPassword = Auth::guard('web')->user()->password;
        $newImage = Auth::guard('web')->user()->image;

        $reqImage = $request->file('image');

        if ($request->password_lama != null || $request->password_baru != null) {
            if (Hash::check($request->password_lama, Auth::guard('web')->user()->password)) {
                $newPassword = Hash::make($request->password_baru);
            } else {
                return back()->with([
                    'message' => 'Password yang anda masukkan tidak sesuai',
                    'status' => false
                ]);
            }
        }

        if ($reqImage != null) {
            if (File::exists('storage/user/' . Auth::guard('web')->user()->image)) {
                File::delete('storage/user/' . Auth::guard('web')->user()->image);
            }

            $newImage = $request->username . '-' . Carbon::now()->microsecond . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('user', $newImage);
        }

        User::where('id', $userAuthId)->update([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $newPassword,
            'image' => $newImage
        ]);

        return back()->with([
            'message' => 'Profil berhasil diperbarui',
            'status' => true
        ]);
    }

    public function loginTeacher()
    {
        return view('auth.teacher', [
            'title' => 'Login - Guru'
        ]);
    }

    public function authTeacher(Request $request)
    {
        $request->validate([
            'nip' => 'required'
        ]);

        if (!Auth::guard('teacher')->attempt($request->only(['nip', 'password']))) {
            return back()->with([
                'message' => 'NIP atau Password Salah'
            ]);
        }

        $request->session()->regenerate();
        return redirect('/');
    }

    public function authTeacherMe()
    {
        return view('auth.teacher-me', [
            'title' => 'Profile - Guru'
        ]);
    }

    public function updateAuthTeacher(Request $request)
    {
        $request->validate([
            'nip' => 'unique:teachers,nip,' . Auth::guard('teacher')->user()->id,
            'password_lama' => 'nullable|min:3',
            'password_baru' => 'nullable|min:3'
        ]);

        $userAuthId = Auth::guard('teacher')->user()->id;
        $newPassword = Auth::guard('teacher')->user()->password;
        $newImage = Auth::guard('teacher')->user()->image;

        $reqImage = $request->file('image');

        if ($request->password_lama != null || $request->password_baru != null) {
            if (Hash::check($request->password_lama, Auth::guard('teacher')->user()->password)) {
                $newPassword = Hash::make($request->password_baru);
            } else {
                return back()->with([
                    'message' => 'Password yang anda masukkan tidak sesuai',
                    'status' => false
                ]);
            }
        }

        if ($reqImage != null) {
            if (File::exists('storage/teacher/' . Auth::guard('teacher')->user()->image)) {
                File::delete('storage/teacher/' . Auth::guard('teacher')->user()->image);
            }

            $newImage = $request->nip . '-' . Carbon::now()->microsecond . '.' . $reqImage->getClientOriginalExtension();
            $reqImage->storeAs('teacher', $newImage);
        }

        Teacher::where('id', $userAuthId)->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'password' => $newPassword,
            'image' => $newImage
        ]);

        return back()->with([
            'message' => 'Profil berhasil diperbarui',
            'status' => true
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth');
    }
}
