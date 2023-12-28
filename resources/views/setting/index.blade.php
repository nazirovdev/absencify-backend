@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-button">
            <a href="/jadwal/tambah" class="btn btn-primary">Tambah Baru</a>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Jadwal Presensi</div>
        </div>
    </div>

    <div class="col-12">
        @if (Session::get('message') && Session::get('status') == true)
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif
        @if (Session::get('message') && Session::get('status') == false)
            <div class="alert alert-danger alert-dismissible show fade">
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
                        <th>Kelas</th>
                        <th>hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule->classroom->nama }}</td>
                            <td>{{ $schedule->hari }}</td>
                            <td>{{ \Carbon\Carbon::create($schedule->jam_masuk)->toTimeString() }}</td>
                            <td>{{ \Carbon\Carbon::create($schedule->jam_pulang)->toTimeString() }}</td>
                            <td>
                                <a href="/jadwal/edit/{{ $schedule->id }}" class="btn btn-warning">Update</a>
                                <a href="#" class="btn btn-primary">Detail</a>
                                <button class="btn btn-danger btn-delete-data" data-id="{{ $schedule->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center">Data Masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="width: 100%; display: flex; justify-content: flex-end;">
                {{ $schedules->links() }}
            </div>
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
                            fetch(`${window.location.origin}/jadwal/delete/${this.getAttribute('data-id')}`, {
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
                                window.location.href = `${window.location.origin}/jadwal`
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
