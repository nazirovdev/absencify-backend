<?php

namespace App\Exports;

use App\Models\Classroom;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ClassroomExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Classroom::query();
    }

    public function map($classroom): array
    {
        return [
            $classroom->id,
            $classroom->nama,
            Carbon::create($classroom->created_at)->toDateString(),
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'nama',
            'tanggal',
        ];
    }
}
