<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.add', [
            'title' => 'Pengaturan Umum',
            'setting' => Setting::first()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'titik_lokasi' => 'required',    
            'radius' => 'required',    
        ]);

        if (Setting::count() < 1) {
            Setting::create([
                'titik_lokasi' => $request->titik_lokasi,
                'radius' => $request->radius,
                'smt_gasal_awal' => $request->smt_gasal_awal,
                'smt_gasal_tengah' => $request->smt_gasal_tengah,
                'smt_gasal_akhir' => $request->smt_gasal_akhir,
            ]);

            return back()->with([
                'message' => 'Pengaturan berhasil diupdate'
            ]);
        }else {
            Setting::where('id', 1)->update([
                'titik_lokasi' => $request->titik_lokasi,
                'radius' => $request->radius,
                'smt_gasal_awal' => $request->smt_gasal_awal,
                'smt_gasal_tengah' => $request->smt_gasal_tengah,
            ]);

            return back()->with([
                'message' => 'Pengaturan berhasil diupdate'
            ]);
        }
    }

    // API
    public function getLokasi()
    {
        return response()->json([
            'data' => [
                'titik_lokasi' => [
                    'lat' => explode(',', Setting::first()->titik_lokasi)[0],
                    'lng' => explode(',', Setting::first()->titik_lokasi)[1],
                ],
                'radius' => Setting::first()->radius
            ]
        ]);
    }
}
