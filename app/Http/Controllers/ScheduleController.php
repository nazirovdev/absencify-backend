<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('schedule.index', [
            'title' => 'Jadwal Presensi',
            'schedules' => Schedule::paginate(10),
        ]);
    }

    public function add()
    {
        return view('schedule.add', [
            'title' => 'Tambah Jadwal Presensi',
            'days' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        ]);
    }

    public function edit(Schedule $schedule)
    {
        return view('schedule.edit', [
            'title' => 'Edit Jadwal Presensi',
            'days' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'schedule' => $schedule
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        Schedule::create([
            'hari' => $request->hari,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return redirect('/jadwal')->with([
            'message' => 'Data Berhasil Ditambah',
            'status' => true
        ]);
    }

    public function update(Schedule $schedule, Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        $schedule->update([
            'hari' => $request->hari,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return redirect('/jadwal')->with([
            'message' => 'Data Berhasil Diupdate',
            'status' => true
        ]);
    }

    public function delete(Schedule $schedule)
    {
        $schedule->delete();
    }
}
