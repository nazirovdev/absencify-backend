<?php

namespace App\Http\Controllers;

use App\Exports\ClassroomExport;
use App\Exports\ClassroomExportExample;
use App\Imports\ClassroomImport;
use App\Models\Classroom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ClassroomController extends Controller
{
    public function index()
    {
        return view('classroom.index', [
            'title' => 'Kelas',
            'classrooms' => Classroom::paginate(25)->withQueryString()
        ]);
    }

    public function add()
    {
        return view('classroom.add', [
            'title' => 'Tambah Kelas'
        ]);
    }

    public function edit(Classroom $classroom)
    {
        return view('classroom.edit', [
            'title' => 'Edit Kelas',
            'classroom' => $classroom
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:classrooms,nama'
        ]);

        Classroom::create($request->only(['nama']));

        return redirect('kelas')->with(['message' => 'Data berhasil ditambah']);
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'nama' => 'required|unique:classrooms,nama,' . $classroom->id
        ]);

        $classroom->update($request->only(['nama']));

        return redirect('kelas')->with(['message' => 'Data berhasil diupdate']);
    }

    public function delete(Classroom $classroom)
    {
        $classroom->delete();
    }

    public function export()
    {
        return (new ClassroomExport)->download('classroom.xlsx');
    }

    public function exportTemplate()
    {
        return (new ClassroomExportExample)->download('classroom_template_'.Carbon::now()->microsecond.'.xlsx');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['message' => 'Data gagal diimport', 'error' => true]);
        }

        $reqFile = $request->file('file');

        Excel::import(new ClassroomImport, $reqFile);

        return redirect()->back()->with(['message' => 'Data sukses diimport', 'error' => false]);
    }

    public function exportPDF(Request $request)
    {
        $pdf = Pdf::loadView('classroom.pdf', [
            'classrooms' => Classroom::get()
        ]);

        // return $pdf->download('document-'.Carbon::now()->microsecond.'.pdf');
        return $pdf->stream();
    }
}
