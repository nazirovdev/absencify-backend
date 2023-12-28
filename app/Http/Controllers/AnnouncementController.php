<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Guardian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('announcement.index', [
            'title' => 'Pengumuman',
            'announcements' => Announcement::latest()->paginate(25)
        ]);
    }

    public function add()
    {
        return view('announcement.add', [
            'title' => 'Tambah Pengumuman',
        ]);
    }

    public function store(Request $request)
    {
        $guardianTokens = Guardian::pluck('token');
        $reqLampiran = $request->file('lampiran');

        $lampiran = null;

        $request->validate([
            'judul' => 'required',
            'tanggal_publikasi' => 'required',
            'isi_pengumuman' => 'required',
            'lampiran' => 'image'
        ]);

        if ($reqLampiran != null) {
            $lampiran = 'lampiran-'. Carbon::now()->microsecond .'.'.$reqLampiran->getClientOriginalExtension();
            $reqLampiran->storeAs('lampiran', $lampiran);
        }

        Announcement::create([
            'judul' => $request->judul,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'isi_pengumuman' => $request->isi_pengumuman,
            'status' => $request->status,
            'lampiran' => $lampiran
        ]);

        $this->sendNotif($guardianTokens->toArray(), 'Pengumuman Sekolah');

        return redirect('/pengumuman')->with([
            'message' => 'Data berhasil ditambah'
        ]);
    }

    public function edit(Announcement $announcement)
    {
        return view('announcement.edit', [
            'title' => 'Edit Pengumuman',
            'announcement' => $announcement
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $reqLampiran = $request->file('lampiran');
        $lampiran = null;

        $request->validate([
            'judul' => 'required',
            'tanggal_publikasi' => 'required',
            'isi_pengumuman' => 'required',
            'lampiran' => 'image'
        ]);

        if ($reqLampiran != null) {
            $lampiran = 'lampiran-'. Carbon::now()->microsecond .'.'.$reqLampiran->getClientOriginalExtension();
            $reqLampiran->storeAs('lampiran', $lampiran);
        }

        $announcement->update([
            'judul' => $request->judul,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'isi_pengumuman' => $request->isi_pengumuman,
            'status' => $request->status,
            'lampiran' => $lampiran
        ]);

        return redirect('/pengumuman')->with([
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
    }

    public function sendNotif($token, $message)
    {
        $deviceToken = $token;
        $serverKey = 'AAAAyrsmNy8:APA91bG69J698mETk1MeINmwFL6FkG1nXW8h85YgJ6R6tMOTW0_37lrkkLdMxYvOQXU_jk20411ik3ffYJqCVy_pvX85GTLDBoPnTgHyAXcsL7opawW-2IEBvxrqICeQtGZK35xbQNk4';

        if ($deviceToken !== null) {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'registration_ids' => $deviceToken,
                'data' => [
					'title' => 'Pengumuman Sekolah',
                    'body' => $message
                ],
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Device token saved and notification sent']);
            } else {
                return response()->json(['message' => 'Error sending notification'], 500);
            }
        }
    }

    // API
    public function getAnnouncement(Request $request)
    {
        return response()->json([
            'data' => [
                'announcements' => Announcement::latest()->get()
            ]
        ]);
    }
}
