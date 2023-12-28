<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Presensi Siswa</title>
    <style>
        
    </style>
</head>
<body>
    <table align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img style="display: block; margin: 0px auto" src="{{ public_path() . '/assets/img/logo.png' }}" />
            </td>
            <td style="width: 500px; text-align: center">
                <h2 style="text-align: center">SMK Islamic Center Baiturrahman Semarang</h2>
                <h3 style="text-align: center">{{ $title }}</h3>
            </td>
        </tr>
        <tr>
            <td colspan="2">
               <div style="width: 100%; height: 3px; background-color: black;"></div>
            </td>
        </tr>
    </table>
    <br>
    <table border="1" align="center" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <th style="padding: 3px">No</th>
                <th style="padding: 3px">Nama</th>
                @for ($i = 1; $i <= \Carbon\Carbon::createFromDate($year, $month)->format('t'); $i++)
                    <?php $datex = \Carbon\Carbon::createFromDate($year, $month)->setDay($i) ?>
                    <?php $foundAgenda = false ?>
                    @foreach ($agendas as $agenda)
                        @if ($datex->toDateString() == $agenda->tanggal_agenda && $agenda->status == 'l')
                            <th>{{ $i }}</th>
                            <?php $foundAgenda = true ?>
                            @break;
                        @endif

                        @if ($datex->toDateString() == $agenda->tanggal_agenda && $agenda->status == 'a')
                            <th>{{ $i }}</th>
                            <?php $foundAgenda = true ?>
                            @break;
                        @endif
                    @endforeach

                    @if ($datex->isWeekend())
                        <th style="background-color: red; color: white; width: 20px">{{ $i }}</th>
                        <?php $foundAgenda = true ?>
                    @endif

                    @if (!$foundAgenda)
                        <th style="width: 20px; width: 20px">{{ $i }}</th>
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
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td>{{ $student->nama }}</td>
                    @for ($x = 1; $x <= \Carbon\Carbon::createFromDate($year, $month)->format('t') ; $x++)
                        <?php $founded = false ?>
                        @foreach ($attendances as $attendance)
                            @if ($student->id == $attendance->student_id && $x == \Carbon\Carbon::create($attendance->tanggal_presensi)->day)
                                @if($attendance->status == 'h' || $attendance->status == 't')
                                    <td style="text-align: center">H</td>
                                    @php $hadir += 1 @endphp
                                @endif
                                @if($attendance->status == 's')
                                    <td style="text-align: center">S</td>
                                    @php $sakit += 1 @endphp
                                @endif
                                @if($attendance->status == 'i')
                                    <td style="text-align: center">I</td>
                                    @php $izin += 1 @endphp
                                @endif
                                @if($attendance->status == 'a')
                                    <td style="text-align: center">A</td>
                                    @php $alpa += 1 @endphp
                                @endif
                                <?php $founded = true ?>
                                @break
                            @endif
                        @endforeach
                        @if (!$founded)
                            <td style="text-align: center">-</td>
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
</body>
</html>