<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentGuardianImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Transaction
        DB::beginTransaction();

        try {
            $studentId = DB::table('guardians')->insertGetId([
                'nama' => $row['nama_wali_siswa'],
                'username' => $row['username_wali_siswa'],
                'alamat' => $row['alamat_wali_siswa'],
                'telepon' => $row['telepon_wali_siswa'],
                'password' => Hash::make('123'),
            ]);
            DB::table('students')->insert([
                'nis' => $row['nis_siswa'],
                'password' => Hash::make('123'),
                'nama' => $row['nama_siswa'],
                'alamat' => $row['alamat_siswa'],
                'telepon' => $row['telepon_siswa'],
                'jenis_kelamin' => $row['jenis_kelamin_siswa'],
                'guardian_id' => $studentId,
                'classroom_id' => $row['classroom_id']
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        // End Transaction
    }
}
