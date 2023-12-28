@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="/siswa">Siswa</a>
            </div>
            <div class="breadcrumb-item">Tambah Siswa</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if (Session::get('message'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif
            <form class="card" action="/siswa/tambah" method="POST" enctype="multipart/form-data">
                @csrf()
                <div class="card-body">
                    <h2 class="section-title" style="margin-left: -15px">Form Data Siswa</h2>
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">NIS Siswa</label>
                                <input class="form-control input-nis-siswa" placeholder="Masukkan NIS Siswa"
                                    name="nis_siswa" value="{{ old('nis_siswa') }}" type="number">
                                @error('nis_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Nama Siswa</label>
                                <input class="form-control" placeholder="Masukkan Nama Siswa" name="nama_siswa"
                                    value="{{ old('nama_siswa') }}" type="text">
                                @error('nama_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Alamat</label>
                                <input class="form-control" placeholder="Masukkan Alamat" name="alamat_siswa"
                                    value="{{ old('alamat_siswa') }}" type="text">
                                @error('alamat_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Telepon</label>
                                <input class="form-control" placeholder="Masukkan Alamat" name="telepon_siswa"
                                    value="{{ old('telepon_siswa') }}" type="text">
                                @error('telepon_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Jenis Kelamin</label>
                                <div class="col-12 p-0">
                                    <select class="form-control selectric" name="jenis_kelamin">
                                        <option value="l">Laki-laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                                @error('jenis_kelamin')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Kelas</label>
                                <div class="col-12 p-0">
                                    <select class="form-control selectric" name="classroom_id">
                                        @foreach ($classrooms as $classroom)
                                            <option value="{{ $classroom->id }}">{{ $classroom->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('classroom_id')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label" style="font-size: 16px;">Foto Siswa</label>
                        <div class="col-sm-12 p-0">
                            <label
                                style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px"
                                for="upld">
                                <img style="display: block; width: 100%; height: 100%;object-fit: cover"
                                    src="{{ asset('assets/img/default.jpg') }}" class="img-upld" />
                                <input type="file" name="image_siswa" id="upld" style="display: none"
                                    class="input-upld">
                            </label>
                        </div>
                        @error('image_siswa')
                            <span style="font-style: italic; color: red; font-weight: bold;">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="section-title" style="margin-left: -15px">Form Data Wali Siswa</h2>
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Nama Wali Siswa</label>
                                <input class="form-control input-nama-wali-siswa" placeholder="Masukkan Nama Wali Siswa"
                                    name="nama_wali_siswa" value="{{ old('nama_wali_siswa') }}" type="text">
                                @error('nama_wali_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Username Wali Siswa</label>
                                <input class="form-control input-username-wali-siswa"
                                    placeholder="Masukkan Username Wali Siswa" name="username_wali_siswa"
                                    value="{{ old('username_wali_siswa') }}" type="text">
                                @error('username_wali_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Alamat Wali Siswa</label>
                                <input class="form-control input-nama-wali-siswa" placeholder="Masukkan Alamat Wali Siswa"
                                    name="alamat_wali_siswa" value="{{ old('alamat_wali_siswa') }}" type="text">
                                @error('alamat_wali_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Telepon Wali Siswa</label>
                                <input class="form-control input-username-wali-siswa"
                                    placeholder="Masukkan Telepon Wali Siswa" name="telepon_wali_siswa"
                                    value="{{ old('telepon_wali_siswa') }}" type="text">
                                @error('telepon_wali_siswa')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label" style="font-size: 16px;">Foto Wali Siswa</label>
                        <div class="col-sm-12 p-0">
                            <label
                                style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px"
                                for="upld">
                                <img style="display: block; width: 100%; height: 100%;object-fit: cover"
                                    src="{{ asset('assets/img/default.jpg') }}" class="img-upld" />
                                <input type="file" name="image_wali_siswa" id="upld" style="display: none"
                                    class="input-upld">
                            </label>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-success">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        const inputNisSiswa = document.querySelector('.input-nis-siswa')
        const inputUsernameWaliSiswa = document.querySelector('.input-username-wali-siswa')
        const inputNamaWaliSiswa = document.querySelector('.input-nama-wali-siswa')

        inputNamaWaliSiswa.addEventListener('keyup', function(e) {
            const str = e.target.value
            inputUsernameWaliSiswa.value = `${str.split(' ')[0].toLowerCase()}@${inputNisSiswa.value}`

            if (str.length < 1) {
                inputUsernameWaliSiswa.value = ''
            }
        })
    </script>
@endsection
