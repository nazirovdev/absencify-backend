@extends('layout.index')

@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Presensi Siswa</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Hadir</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpa</th>
                            <th>Total Hari</th>
                        </tr>
                        @foreach ($students as $student)
                            @php
                                $hadir = 0;
                                $sakit = 0;
                                $izin = 0;
                                $alpa = 0;
                            @endphp

                            @foreach ($attendances as $attendance)
                                @if ($attendance->student_id == $student->id)
                                    @if ($attendance->status == 'h')
                                        @php
                                            $hadir += 1
                                        @endphp
                                    @endif
                                    @if ($attendance->status == 's')
                                        @php
                                            $sakit += 1
                                        @endphp
                                    @endif
                                    @if ($attendance->status == '1')
                                        @php
                                            $izin += 1
                                        @endphp
                                    @endif
                                    @if ($attendance->status == 'a')
                                        @php
                                            $alpa += 1
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->nama }}</td>
                                <td>{{ $student->classroom->nama }}</td>
                                <td>{{ $hadir }}</td>
                                <td>{{ $sakit }}</td>
                                <td>{{ $izin }}</td>
                                <td>{{ $alpa }}</td>
                                <td>{{ $total_hari }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
