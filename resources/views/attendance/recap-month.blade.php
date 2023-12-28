@extends('layout.index')

@section('content')
    <div class="section-header">
        <h1>{{ $title }} {{ $monts[$month - 1] }}</h1>
    </div>
    <div class="col-12">
        <form class="form-group row mb-4" action="/presensi-siswa/rekap/bulanan">
            <div class="col-6">
                <label class="col-form-label" style="font-size: 16px;">Bulan</label>
                <div class="col p-0">
                    <select class="form-control selectric" name="month">
                        @foreach ($monts as $key => $item)
                            @if (($key + 1) == $month)
                                <option value="{{ $key + 1 }}" selected>{{ $item }}</option>
                            @else
                                <option value="{{ $key + 1 }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <label class="col-form-label" style="font-size: 16px;">Tahun</label>
                <div class="col p-0">
                    <select class="form-control selectric" name="year">
                        @foreach ($years as $key => $item)
                            @if (($key + 1) == $year)
                                <option value="{{ $item }}" selected>{{ $item }}</option>
                            @else
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                @if (Auth::guard('web')->user() != null)
                    <label class="col-form-label" style="font-size: 16px;">Kelas</label>
                    <div class="col p-0">
                        <select class="form-control selectric" name="class">
                            <option value="" selected>Seluruh Kelas</option>
                            @foreach ($classrooms as $key => $classroom)
                                @if ($classroom->nama == $class)
                                    <option value="{{ $classroom->nama }}" selected>{{ $classroom->nama }}</option>
                                @else
                                    <option value="{{ $classroom->nama }}">{{ $classroom->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-12 p-0">
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                    <a href="/presensi-siswa/rekap/bulanan" class="btn btn-warning mt-4">Reset</a>
                    <a href="/presensi-siswa/export-pdf?month={{ $month ?? '' }}&year={{ $year ?? '' }}" class="btn btn-primary mt-4">Export PDF</a>
                </div>
            </div>
        </form>
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
                            <th>Name</th>
                            @for ($i = 1; $i <= \Carbon\Carbon::createFromDate($year, $month)->format('t'); $i++)
                                <?php $datex = \Carbon\Carbon::createFromDate($year, $month)->setDay($i) ?>
                                <?php $foundAgenda = false ?>
                                @foreach ($agendas as $agenda)
                                    @if ($datex->toDateString() == $agenda->tanggal_agenda && $agenda->status == 'l')
                                        <th class="bg-warning text-dark">{{ $i }}</th>
                                        <?php $foundAgenda = true ?>
                                        @break;
                                    @endif

                                    @if ($datex->toDateString() == $agenda->tanggal_agenda && $agenda->status == 'a')
                                        <th class="bg-success text-dark">{{ $i }}</th>
                                        <?php $foundAgenda = true ?>
                                        @break;
                                    @endif
                                @endforeach

                                @if ($datex->isWeekend())
                                    <th class="text-light bg-danger">{{ $i }}</th>
                                    <?php $foundAgenda = true ?>
                                @endif

                                @if (!$foundAgenda)
                                    <th>{{ $i }}</th>
                                @endif
                            @endfor
                            <th>Hadir</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Alpa</th>
                        </tr>
                        @foreach ($students as $student)
                            @php $hadir = 0 @endphp
                            @php $sakit = 0 @endphp
                            @php $izin = 0 @endphp
                            @php $alpa = 0 @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->nama }}</td>
                                @for ($x = 1; $x <= \Carbon\Carbon::createFromDate($year, $month)->format('t') ; $x++)
                                    <?php $founded = false ?>
                                    @foreach ($attendances as $attendance)
                                        @if ($student->id == $attendance->student_id && $x == \Carbon\Carbon::create($attendance->tanggal_presensi)->day)
                                            @if($attendance->status == 'h' || $attendance->status == 't')
                                                <td>H</td>
                                                @php $hadir += 1 @endphp
                                            @endif
                                            @if($attendance->status == 's')
                                                <td>S</td>
                                                @php $sakit += 1 @endphp
                                            @endif
                                            @if($attendance->status == 'i')
                                                <td>I</td>
                                                @php $izin += 1 @endphp
                                            @endif
                                            @if($attendance->status == 'a')
                                                <td>A</td>
                                                @php $alpa += 1 @endphp
                                            @endif
                                            <?php $founded = true ?>
                                            @break
                                        @endif
                                    @endforeach
                                    @if (!$founded)
                                        <td>-</td>
                                    @endif
                                @endfor
                                <th>{{ $hadir }}</th>
                                <th>{{ $sakit }}</th>
                                <th>{{ $izin }}</th>
                                <th>{{ $alpa }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
