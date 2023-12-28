<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class StudentGuardianExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Student::query();
    }

    public function map($classroom): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'nis_siswa',
            'nama_siswa',
            'alamat_siswa',
            'telepon_siswa',
            'jenis_kelamin_siswa',
            'classroom_id',
            'nama_wali_siswa',
            'username_wali_siswa',
            'alamat_wali_siswa',
            'telepon_wali_siswa',
        ];
    }
}
