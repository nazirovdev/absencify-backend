@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Presensi Siswa</div>
        </div>
    </div>
    @if (Session::get('message'))
        <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                {{ Session::get('message') }}
            </div>
        </div>
    @endif
    <div class="card">
        <form class="card-body" action="/presensi-siswa/import/data" method="POST" enctype="multipart/form-data">
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
                        <a href="/presensi-siswa/export">Unduh Template untuk data Presensi Siswa</a>
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
@endsection

