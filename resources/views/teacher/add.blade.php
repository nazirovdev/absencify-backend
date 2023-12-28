@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="/wali-kelas">Wali Kelas</a>
            </div>
            <div class="breadcrumb-item">Tambah Wali Kelas</div>
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
            <div class="card">
                <form class="card-body" action="/wali-kelas/tambah" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">NIP Wali Kelas</label>
                                <input class="form-control" placeholder="Masukkan NIP Wali Kelas" name="nip"
                                    value="{{ old('nip') }}" type="number">
                                @error('nip')
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
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Nama Wali Kelas</label>
                                <input class="form-control" placeholder="Masukkan Nama Wali Kelas" name="nama"
                                    value="{{ old('nama') }}" type="text">
                                @error('nama')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
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
                    </div>
                    <div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;">Alamat Wali Kelas</label>
                            <input class="form-control" placeholder="Masukkan Alamat Wali Kelas" name="alamat"
                                value="{{ old('alamat') }}" type="text">
                            @error('alamat')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label" style="font-size: 16px;">Foto</label>
                        <div class="col-sm-12 p-0">
                            <label
                                style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px"
                                for="upld">
                                <img style="display: block; width: 100%; height: 100%;object-fit: cover"
                                    src="{{ asset('assets/img/default.jpg') }}" class="img-upld" />
                                <input type="file" name="image" id="upld" style="display: none"
                                    class="input-upld">
                            </label>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-success">Tambah Wali Kelas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
