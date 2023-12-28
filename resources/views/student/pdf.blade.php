<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>
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
        <tr>
            <td style="padding: 5px; text-align: center; padding: 5px; font-weight: bold">No</td>
            <td style="padding: 5px; text-align: center; font-weight: bold">NIS</td>
            <td style="padding: 5px; text-align: center; font-weight: bold">Nama</td>
            <td style="padding: 5px; text-align: center; font-weight: bold">Username Wali</td>
            <td style="padding: 5px; text-align: center; font-weight: bold">Password Wali / Siswa</td>
        </tr>
        @foreach ($students as $student)
            <tr>
                <td style="padding: 5px; text-align: center; font-weight: bold">{{ $loop->iteration }}</td>
                <td style="padding: 5px; text-align: center; font-weight: bold">{{ $student->nis }}</td>
                <td style="padding: 5px; font-weight: bold">{{ $student->nama }}</td>
                <td style="padding: 5px; font-weight: bold">{{ $student->guardian->username }}</td>
                <td style="padding: 5px; font-weight: bold">123</td>
            </tr>
        @endforeach
    </table>
</body>
</html>