<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda.index', [
            'title' => 'Agenda',
            'agendas' => Agenda::paginate(10)
        ]);
    }

    public function add()
    {
        return view('agenda.add', [
            'title' => 'Tambah Agenda',
        ]);
    }

    public function edit(Agenda $agenda)
    {
        return view('agenda.edit', [
            'title' => 'Edit Agenda',
            'agenda' => $agenda
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_agenda' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]);

        Agenda::create([
            'tanggal_agenda' => $request->tanggal_agenda,
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect('/agenda');
    }

    public function update(Agenda $agenda, Request $request)
    {
        $request->validate([
            'tanggal_agenda' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]);

        $agenda->update([
            'tanggal_agenda' => $request->tanggal_agenda,
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect('/agenda');
    }

    public function delete(Agenda $agenda, Request $request)
    {
        $agenda->delete();

        return response()->json([
            'message' => 'Agenda berhasil dihapus'
        ], 200);
    }

    // API
    public function getAgenda()
    {
        $agenda = Agenda::orderBy('tanggal_agenda', 'desc')->get();

        return response()->json([
            'data' => [
                'agenda' => $agenda
            ]
        ]);
    }
}
