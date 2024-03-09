@extends('layout.index')
@section('content')
<div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            <a href="/wali-kelas">Wali Kelas</a>
        </div>
        <div class="breadcrumb-item">Edit Wali Kelas</div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        @if (Session::get('message'))
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
        @endif
        <div class="card">
            <form class="card-body" action="/wali-kelas/edit/{{ $teacher->id }}" method="POST" enctype="multipart/form-data">
                @csrf()
                @method('PUT')
                <div class="row gx-5" style="gap: 40px">
                    <div class="col">
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;">NIP Wali Kelas</label>
                            <input class="form-control" placeholder="Masukkan NIP Wali Kelas" name="nip" value="{{ $teacher->nip }}" type="number">
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
                                    @if ($teacher->classroom_id == $classroom->id)
                                    <option value="{{ $classroom->id }}" selected>{{ $classroom->nama }}
                                    </option>
                                    @else
                                    <option value="{{ $classroom->id }}">{{ $classroom->nama }}</option>
                                    @endif
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
                            <input class="form-control" placeholder="Masukkan Nama Wali Kelas" name="nama" value="{{ $teacher->nama }}" type="text">
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
                                    @if ($teacher->jenis_kelamin == 'l')
                                    <option value="l" selected>Laki-laki</option>
                                    <option value="p">Perempuan</option>
                                    @else
                                    <option value="l">Laki-laki</option>
                                    <option value="p" selected>Perempuan</option>
                                    @endif
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
                        <input class="form-control" placeholder="Masukkan Alamat Wali Kelas" name="alamat" value="{{ $teacher->alamat }}" type="text">
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
                        <label style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px" for="upld">
                            <img style="display: block; width: 100%; height: 100%;object-fit: cover" src="{{ $teacher->image == null ? secure_asset('assets/img/default.jpg') : secure_asset('storage/teacher/' . $teacher->image) }}" class="img-upld" />
                            <input type="file" name="image" id="upld" style="display: none" class="input-upld">
                        </label>
                    </div>
                </div>
                <div class="form-group
                                    row mb-4">
                    <label class="col-form-label"></label>
                    <div class="col-sm-12 p-0">
                        <button type="submit" class="btn btn-success">Update Wali Kelas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection