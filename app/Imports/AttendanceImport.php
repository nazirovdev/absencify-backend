<?php

namespace App\Imports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Attendance([
            'student_id' => $row['student_id'],
            'tanggal_presensi' => $this->transformDate($row['tanggal_presensi']),
            'jam_masuk' => $row['jam_masuk'],
            'jam_pulang' => $row['jam_pulang'],
            'status' => $row['status']
        ]);
    }

    public function map(array $row): array
    {
        return [
            'tanggal_presensi' => 'B1', // Adjust this based on the actual column for tanggal_presensi
        ];
    }

    public function transformDate(string $value): \Carbon\Carbon
    {
        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    }
}
