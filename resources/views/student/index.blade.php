@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-button">
            <a href="/siswa/tambah" class="btn btn-primary">Tambah Baru</a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Import Data
            </button>
            <a href="/siswa/export-pdf" class="btn btn-primary">Export PDF</a>
        </div>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Siswa</div>
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
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration + $students->firstItem() - 1 }}</td>
                            <td>{{ $student->nis }}</td>
                            <td>{{ $student->nama }}</td>
                            <td>{{ $student->classroom->nama }}</td>
                            <td>
                                <a href="/siswa/edit/{{ $student->id }}" class="btn btn-warning">Update</a>
                                {{-- <a href="#" class="btn btn-primary">Detail</a> --}}
                                <button class="btn btn-danger btn-delete-data" data-id="{{ $student->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center">Data Masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="width: 100%; display: flex; justify-content: flex-end;">
                {{ $students->links() }}
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
                            fetch(`${window.location.origin}/siswa/delete/${this.getAttribute('data-id')}`, {
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


<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Siswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="section-header">
                <form class="card-body" action="/siswa/import" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col-12">
                            <div class="form-group row mb-4">
                                <label
                                style="width: 100%; padding: 0 10px;height:40px; border-width: 2px; border-color: gray; border-style: dashed;"
                                for="upld">
                                    <p style="line-height: 40px" class="text-upld-classroom">Upload</p>
                                    <input type="file" name="file" id="upld" style="display: none"
                                        class="input-upld-classroom">
                                </label>
                                <a href="/siswa/export/template">Unduh Template untuk data Siswa</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
    <script>
        const inputUpldClassroom = document.querySelector('.input-upld-classroom')
        const textUpldClassroom = document.querySelector('.text-upld-classroom')
        inputUpldClassroom.addEventListener('change', function(e) {
            const file = inputUpldClassroom.files[0]
            const reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = function() {
                textUpldClassroom.textContent = file.name
            }

        })
    </script>
</div>