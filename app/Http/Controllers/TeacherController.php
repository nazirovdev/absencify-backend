<?php

namespace App\Http\Controllers;

use App\Exports\TeacherExport;
use App\Exports\TeacherExportTemplate;
use App\Imports\TeacherImport;
use App\Models\Classroom;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.index', [
            'title' => 'Wali Kelas',
            'teachers' => Teacher::with('classroom')->paginate(25)->withQueryString(),
        ]);
    }

    public function add()
    {
        return view('teacher.add', [
            'title' => 'Tambah Wali Kelas',
            'classrooms' => Classroom::all(),
        ]);
    }

    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', [
            'title' => 'Edit Wali Kelas',
            'teacher' => $teacher,
            'classrooms' => Classroom::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:teachers,nip',
            'classroom_id' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'image' => 'image|max:2048',
        ]);

        if ($this->isTeacherGetClass($request->classroom_id)) {
            return back()->with([
                'message' => 'Kelas sudah ada pengampu'
            ]);
        }

        $reqFile = $request->file('image');
        $newFotoName = null;

        if ($reqFile != null) {
            $newFotoName = ($request->nip . '-' . Carbon::now()->microsecond . '.' . $reqFile->getClientOriginalExtension());
            $reqFile->storeAs('teacher', $newFotoName);
        }

        Teacher::create([
            'nip' => $request->nip,
            'classroom_id' => $request->classroom_id,
            'nama' => $request->nama,
            'password' => Hash::make('123'),
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'image' => $newFotoName
        ]);

        return redirect('/wali-kelas')->with(['message' => 'Data berhasil ditambah']);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nip' => 'required|unique:teachers,nip,' . $teacher->id,
            'nama' => 'required',
            'classroom_id' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'image' => 'image|max:2048',
        ]);

        $reqFile = $request->file('image');
        $newFotoName = $teacher->image;

        if ($request->classroom_id != $teacher->classroom_id) {
            return back()->with([
                'message' => 'Kelas sudah ada pengampu'
            ]);
        }

        if ($reqFile != null) {
            if (File::exists('storage/teacher/' . $teacher->image)) {
                File::delete('storage/teacher/' . $teacher->image);
            }

            $newFotoName = ($request->nip . '-' . Carbon::now()->microsecond . '.' . $reqFile->getClientOriginalExtension());
            $reqFile->storeAs('teacher', $newFotoName);
        }

        $teacher->update([
            'nip' => $request->nip,
            'classroom_id' => $request->classroom_id,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'image' => $newFotoName,
        ]);

        return redirect('wali-kelas')->with(['message' => 'Data berhasil diupdate']);
    }

    public function delete(Teacher $teacher)
    {
        if (File::exists('storage/teacher/' . $teacher->image)) {
            File::delete('storage/teacher/' . $teacher->image);
        }

        $teacher->delete();
    }

    public function export()
    {
        return (new TeacherExport)->download('teacher.xlsx');
    }

    public function exportTemplate()
    {
        return (new TeacherExportTemplate)->download('teacher_template_'.Carbon::now()->microsecond.'.xlsx');
    }

    public function import(Request $request)
    {
        $reqFile = $request->file('file');
        Excel::import(new TeacherImport, $reqFile);

        return redirect()->back();
    }

    // Helper
    public function isTeacherGetClass($teacherId)
    {
        return Teacher::where('classroom_id', $teacherId)->first() != null;
    }

    public function exportPDF(Request $request)
    {
        $pdf = Pdf::loadView('teacher.pdf', [
            'teachers' => Teacher::get()
        ]);

        // return $pdf->download('document-'.Carbon::now()->microsecond.'.pdf');
        return $pdf->stream();
    }
}
