<?php

namespace App\Exports;

use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class AttendanceExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Attendance::query();
    }

    public function map($classroom): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'student_id',
            'tanggal_presensi',
            'jam_masuk',
            'jam_pulang',
            'status',
        ];
    }
}
