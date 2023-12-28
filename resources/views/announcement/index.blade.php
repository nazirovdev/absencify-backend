@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-button">
            <a href="/pengumuman/tambah" class="btn btn-primary">Tambah Baru</a>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Pengumuman</div>
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
                        <th>Tanggal</th>
                        <th>Tanggal Publikasi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($announcements as $announcement)
                        <tr>
                            <td>{{ $loop->iteration + $announcements->firstItem() - 1 }}</td>
                            <td>{{ $announcement->judul }}</td>
                            <td>{{ \Carbon\Carbon::create($announcement->tanggal_publikasi)->format('d M Y') }}</td>
                            <td>{{ $announcement->status }}</td>
                            <td>
                                <a href="/pengumuman/edit/{{ $announcement->id }}" class="btn btn-warning">Update</a>
                                <a href="#" class="btn btn-primary">Detail</a>
                                <button class="btn btn-danger btn-delete-data" data-id="{{ $announcement->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center">Data Masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="width: 100%; display: flex; justify-content: flex-end;">
                {{ $announcements->links() }}
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
                            fetch(`${window.location.origin}/pengumuman/delete/${this.getAttribute('data-id')}`, {
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
                                window.location.href = `${window.location.origin}/pengumuman`
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
