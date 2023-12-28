@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Izin Siswa</div>
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
                        <th>Tanggal mulai</th>
                        <th>Tanggal akhir</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->student->nama }}</td>
                            <td>{{ $permission->student->classroom->nama }}</td>
                            <td>{{ \Carbon\Carbon::create($permission->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::create($permission->tanggal_akhir)->format('d M Y') }}</td>
                            <td>{{ $permission->tipe }}</td>
                            <td>
                                @if ($permission->status == 'menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @endif
                                @if ($permission->status == 'tolak')
                                    <span class="badge badge-danger">Tolak</span>
                                @endif
                                @if ($permission->status == 'terima')
                                    <span class="badge badge-success">Terima</span>
                                @endif
                            </td>
                            <td>
                                @if ($permission->status != 'terima')
                                    <a href="/izin-siswa/action/{{ $permission->id }}?status=tolak"
                                        class="btn btn-sm btn-danger">Tolak</a>
                                    <a href="/izin-siswa/action/{{ $permission->id }}?status=terima"
                                        class="btn btn-sm btn-success">Terima</a>
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
                            fetch(`${window.location.origin}/izin/delete/${this.getAttribute('data-id')}`, {
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
                                window.location.href = `${window.location.origin}/izin`
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
