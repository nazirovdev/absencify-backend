@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Presensi Siswa</div>
        </div>
    </div>

    <div class="col-12">
        @if (Session::get('message'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif
        <div class="row">
            <table class="table table-striped table-md">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                    </tr>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attendance->student->nama }}</td>
                            <td>{{ $attendance->student->classroom->nama }}</td>
                            <td>{{ \Carbon\Carbon::create($attendance->tanggal_presensi)->format('d M Y') }}</td>
                            <td>{{ $attendance->jam_masuk == null ? '-' : $attendance->jam_masuk }}</td>
                            <td>{{ $attendance->jam_pulang == null ? '-' : $attendance->jam_pulang }}</td>
                            {{-- <td>{{ $attendance->status }}</td> --}}
                            <td>
                                @if ($attendance->status == 'h')
                                    <span class="badge badge-success">Hadir</span>
                                @endif
                                @if ($attendance->status == 't')
                                    <span class="badge badge-danger">Terlambat</span>
                                @endif
                                @if ($attendance->status == 's')
                                    <span class="badge badge-danger">Sakit</span>
                                @endif
                                @if ($attendance->status == 'i')
                                    <span class="badge badge-danger">izin</span>
                                @endif
                                @if ($attendance->status == 'a')
                                    <span class="badge badge-danger">Alpa</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center">Data Masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const btnDeleteData = document.querySelectorAll('.btn-delete-data')
        btnDeleteData.forEach(btnDelete => {
            btnDelete.addEventListener('click', function(e) {
                swal({
                        title: 'Anda yakin ingin menghapus ?',
                        text: 'Data yang dihapus tidak bisa direover kembali!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            fetch(`${window.location.origin}/presensi/delete/${this.getAttribute('data-id')}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            }).then(e => {
                                return e.json()
                            }).then(e => {
                                console.log(e)
                            })

                            swal('Data berhasil dihapus!', {
                                icon: 'success',
                            }).then(() => {
                                window.location.href = `${window.location.origin}/siswa`
                            });

                        } else {
                            swal('Data anda terselamatkan!');
                        }
                    });
                // alert('cok')
            })
        });
    </script>
@endsection
