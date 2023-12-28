<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Agenda;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Guardian;
use App\Models\Permission;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('123')
        ]);

        // Classroom::create([
        //     'nama' => 'X-TKJ-1'
        // ]);

        // Classroom::create([
        //     'nama' => 'X-TKJ-2'
        // ]);

        // Teacher::create([
        //     'nip' => 121,
        //     'classroom_id' => 1,
        //     'nama' => 'Galuh Utami',
        //     'password' => Hash::make('123'),
        //     'jenis_kelamin' => 'p',
        //     'alamat' => 'JL. Kalipancur',
        //     'image' => null
        // ]);

        // Teacher::create([
        //     'nip' => 131,
        //     'classroom_id' => 2,
        //     'nama' => 'Eka Listiyowati',
        //     'password' => Hash::make('123'),
        //     'jenis_kelamin' => 'p',
        //     'alamat' => 'JL. Pasadena',
        //     'image' => null
        // ]);

        // Agenda::create([
        //     'tanggal_agenda' => '2023-11-23',
        //     'status' => 'l',
        //     'keterangan' => 'Libur Semesteran'
        // ]);
        // Agenda::create([
        //     'tanggal_agenda' => '2023-11-24',
        //     'status' => 'a',
        //     'keterangan' => 'Rapat Pleno'
        // ]);

        Schedule::create([
            'hari' => 'Senin',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '14:00:00'
        ]);

        Schedule::create([
            'hari' => 'Selasa',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '14:00:00'
        ]);

        Schedule::create([
            'hari' => 'Rabu',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '14:00:00'
        ]);

        Schedule::create([
            'hari' => 'Kamis',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '14:00:00'
        ]);

        Schedule::create([
            'hari' => 'Jumat',
            'jam_masuk' => '07:00:00',
            'jam_pulang' => '11:00:00'
        ]);

        Setting::create([
            'titik_lokasi' => '-7.00999, 110.37705',
            'radius' => 10,
            'smt_gasal_awal' => '2023-06-01',
            'smt_gasal_tengah' => '2023-08-31',
            'smt_gasal_akhir' => '2023-12-31',

            'smt_genap_awal' => '2024-01-01',
            'smt_genap_tengah' => '2024-03-31',
            'smt_genap_akhir' => '2024-06-31',
        ]);

        // for ($i=1; $i <= Carbon::create('2023-12-01')->format('t'); $i++) {
        //     if(!Carbon::create("2023-12-$i")->isWeekend() && Agenda::where('tanggal_agenda', "2023-12-$i")->where('status', 'l')->count() < 1) {
        //         if (Carbon::create("2023-12-$i")->toDateString() == '2023-12-05') {
        //             Attendance::create([
        //                 'student_id' => 1,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 's'
        //             ]);
        //         }else {
        //             Attendance::create([
        //                 'student_id' => 1,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);
        //         }
        //     }
        // }

        // Attendance::create([
        //     'student_id' => 1,
        //     'tanggal_presensi' => "2023-12-05",
        //     'jam_masuk' => '07:00:00',
        //     'jam_pulang' => null,
        //     'status' => 't'
        // ]);

        // Attendance::create([
        //     'student_id' => 1,
        //     'tanggal_presensi' => "2023-12-06",
        //     'jam_masuk' => '07:00:00',
        //     'jam_pulang' => null,
        //     'status' => 'i'
        // ]);

        // Attendance::create([
        //     'student_id' => 1,
        //     'tanggal_presensi' => "2023-12-07",
        //     'jam_masuk' => '07:00:00',
        //     'jam_pulang' => null,
        //     'status' => 's'
        // ]);

        // Attendance::create([
        //     'student_id' => 1,
        //     'tanggal_presensi' => "2023-12-08",
        //     'jam_masuk' => '07:00:00',
        //     'jam_pulang' => null,
        //     'status' => 'a'
        // ]);

        // Attendance::create([
        //     'student_id' => 2,
        //     'tanggal_presensi' => "2023-11-29",
        //     'jam_masuk' => '07:00:00',
        //     'jam_pulang' => null,
        //     'status' => 's'
        // ]);

        // Permission::create([
        //     'student_id' => 1,
        //     'tanggal_mulai' => '2023-12-01',
        //     'tanggal_akhir' => '2023-12-01',
        //     'keterangan' => 'Sakit Perut',
        //     'tipe' => 's',
        //     'file' => null
        // ]);

        // Permission::create([
        //     'student_id' => 2,
        //     'tanggal_mulai' => '2023-11-23',
        //     'tanggal_akhir' => '2023-11-23',
        //     'keterangan' => 'Berlibur ke Bali',
        //     'tipe' => 'i',
        //     'file' => null
        // ]);

        // Guardian::create([
        //     'nama' => 'Budiyono Sugeng Riyadi',
        //     'username' => 'budiyono@1662128001',
        //     'alamat' => 'JL. Borobudur Timur XI',
        //     'telepon' => '018212812',
        //     'password' => Hash::make('123'),
        // ]);

        // Guardian::create([
        //     'nama' => 'Zaenuri',
        //     'username' => 'zaenuri@1662128002',
        //     'alamat' => 'JL. Borobudur Timur XI',
        //     'telepon' => '018212812',
        //     'password' => Hash::make('123'),
        // ]);

        // Guardian::create([
        //     'nama' => 'Maryadi',
        //     'username' => 'maryadi@1662128003',
        //     'alamat' => 'JL. Borobudur Timur XI',
        //     'telepon' => '018212812',
        //     'password' => Hash::make('123'),
        // ]);

        // Guardian::create([
        //     'nama' => 'Sukiran',
        //     'username' => 'sukiran@1662128004',
        //     'alamat' => 'JL. Borobudur Timur XI',
        //     'telepon' => '018212812',
        //     'password' => Hash::make('123'),
        // ]);

        // Guardian::create([
        //     'nama' => 'Hartono',
        //     'username' => 'hartono@1662128005',
        //     'alamat' => 'JL. Borobudur Timur XI',
        //     'telepon' => '018212812',
        //     'password' => Hash::make('123'),
        // ]);

        // Guardian::create([
        //     'nama' => 'Parlan',
        //     'username' => 'parlan@1662128006',
        //     'alamat' => 'JL. Borobudur Timur XI',
        //     'telepon' => '018212812',
        //     'password' => Hash::make('123'),
        // ]);

        // Student::create([
        //     'nis' => '1662128001',
        //     'password' => Hash::make('123'),
        //     'nama' => 'Muhammad Nazir Azhari',
        //     'alamat' => 'JL. Borobudur Timur XIII',
        //     'telepon' => '0128182', 
        //     'jenis_kelamin' => 'l',
        //     'image' => null,
        //     'guardian_id' => 1,
        //     'classroom_id' => 1
        // ]);

        // Student::create([
        //     'nis' => '1662128002',
        //     'password' => Hash::make('123'),
        //     'nama' => 'Muhammad Nabil Fikri',
        //     'alamat' => 'JL. Borobudur Timur XIII',
        //     'telepon' => '0128182', 
        //     'jenis_kelamin' => 'l',
        //     'image' => null,
        //     'guardian_id' => 2,
        //     'classroom_id' => 1
        // ]);

        // Student::create([
        //     'nis' => '1662128003',
        //     'password' => Hash::make('123'),
        //     'nama' => 'Vijay Putra Pratama',
        //     'alamat' => 'JL. Borobudur Timur XIII',
        //     'telepon' => '0128182', 
        //     'jenis_kelamin' => 'l',
        //     'image' => null,
        //     'guardian_id' => 3,
        //     'classroom_id' => 1
        // ]);

        // Student::create([
        //     'nis' => '1662128004',
        //     'password' => Hash::make('123'),
        //     'nama' => 'Ardan Ryan',
        //     'alamat' => 'JL. Borobudur Timur XIII',
        //     'telepon' => '0128182', 
        //     'jenis_kelamin' => 'l',
        //     'image' => null,
        //     'guardian_id' => 4,
        //     'classroom_id' => 1
        // ]);

        // Student::create([
        //     'nis' => '1662128005',
        //     'password' => Hash::make('123'),
        //     'nama' => 'Muhammad Kharit Rahmadani',
        //     'alamat' => 'JL. Borobudur Timur XIII',
        //     'telepon' => '0128182', 
        //     'jenis_kelamin' => 'l',
        //     'image' => null,
        //     'guardian_id' => 5,
        //     'classroom_id' => 1
        // ]);

        // Student::create([
        //     'nis' => '1662128006',
        //     'password' => Hash::make('123'),
        //     'nama' => 'Adam Wahyudi',
        //     'alamat' => 'JL. Borobudur Timur XIII',
        //     'telepon' => '0128182', 
        //     'jenis_kelamin' => 'l',
        //     'image' => null,
        //     'guardian_id' => 6,
        //     'classroom_id' => 2
        // ]);

        // for ($i=1; $i <= Carbon::create('2023-10-01')->format('t'); $i++) {
        //     if(!Carbon::create("2023-10-$i")->isWeekend() && Agenda::where('tanggal_agenda', "2023-10-$i")->where('status', 'l')->count() < 1) {
        //             Attendance::create([
        //                 'student_id' => 1,
        //                 'tanggal_presensi' => "2023-10-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 2,
        //                 'tanggal_presensi' => "2023-10-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 3,
        //                 'tanggal_presensi' => "2023-10-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 4,
        //                 'tanggal_presensi' => "2023-10-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 5,
        //                 'tanggal_presensi' => "2023-10-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 6,
        //                 'tanggal_presensi' => "2023-10-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);
        //     }
        // }

        // for ($i=1; $i <= Carbon::create('2023-11-01')->format('t'); $i++) {
        //     if(!Carbon::create("2023-11-$i")->isWeekend() && Agenda::where('tanggal_agenda', "2023-11-$i")->where('status', 'l')->count() < 1) {
        //             Attendance::create([
        //                 'student_id' => 1,
        //                 'tanggal_presensi' => "2023-11-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 2,
        //                 'tanggal_presensi' => "2023-11-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 3,
        //                 'tanggal_presensi' => "2023-11-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 4,
        //                 'tanggal_presensi' => "2023-11-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 5,
        //                 'tanggal_presensi' => "2023-11-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 6,
        //                 'tanggal_presensi' => "2023-11-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);
        //     }
        // }

        // for ($i=1; $i <= Carbon::create('2023-12-01')->format('t'); $i++) {
        //     if(!Carbon::create("2023-12-$i")->isWeekend() && Agenda::where('tanggal_agenda', "2023-12-$i")->where('status', 'l')->count() < 1) {
        //             Attendance::create([
        //                 'student_id' => 1,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 2,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 3,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 4,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 5,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);

        //             Attendance::create([
        //                 'student_id' => 6,
        //                 'tanggal_presensi' => "2023-12-$i",
        //                 'jam_masuk' => '07:00:00',
        //                 'jam_pulang' => null,
        //                 'status' => 'h'
        //             ]);
        //     }
        // }
    }
}
