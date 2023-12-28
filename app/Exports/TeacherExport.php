<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class TeacherExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Teacher::query();
    }

    public function map($classroom): array
    {
        return [
            $classroom->nip,
            $classroom->nama,
            $classroom->jenis_kelamin,
            $classroom->alamat,
            $classroom->classroom_id,
        ];
    }

    public function headings(): array
    {
        return [
            'nip',
            'nama',
            'jenis_kelamin',
            'alamat',
            'classroom_id',
        ];
    }
}
