@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if (Session::get('message'))
                <div
                    class="{{ Session::get('status') == true ? 'alert alert-success' : 'alert alert-danger' }} alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif
            <form class="card p-2" action="/auth/wali-kelas/me" method="post" class="needs-validation"
                enctype="multipart/form-data">
                @csrf()
                @method('PUT')
                <div class="">
                    <h2 class="section-title">Hi, {{ Auth::guard('teacher')->user()->nama }}</h2>
                    <p class="section-lead">
                        Informasi tentang profil akun ini
                    </p>
                    <div class="row">
                        <div class="form-group col">
                            <label class="col-form-label" style="font-size: 16px;color: black">NIP</label>
                            <input type="number" class="form-control" value="{{ Auth::guard('teacher')->user()->nip }}"
                                required="" name="nip">
                        </div>
                        <div class="form-group col">
                            <label class="col-form-label" style="font-size: 16px;color: black">Nama</label>
                            <input type="text" class="form-control" value="{{ Auth::guard('teacher')->user()->nama }}"
                                required="" name="nama">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label class="col-form-label" style="font-size: 16px;color: black">Password Lama</label>
                            <input type="password" class="form-control" name="password_lama"
                                value="{{ old('password_lama') }}">
                            @error('password_lama')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col">
                            <label class="col-form-label" style="font-size: 16px;color: black">Password Baru</label>
                            <input type="password" class="form-control" name="password_baru"
                                value="{{ old('password_baru') }}">
                            @error('password_baru')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col" style="padding: 0px">
                        <div>
                            <label class="col-form-label" style="font-size: 16px;color: black">Foto Siswa</label>
                            <div class="">
                                <label
                                    style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px"
                                    for="upld">
                                    <img style="display: block; width: 100%; height: 100%;object-fit: cover"
                                        src="{{ Auth::guard('teacher')->user()->image == null ? asset('assets/img/default.jpg') : asset('storage/teacher/' . Auth::guard('teacher')->user()->image) }}"
                                        class="img-upld" />
                                    <input type="file" name="image" id="upld" style="display: none"
                                        class="input-upld">
                                </label>
                            </div>
                            @error('image')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
@endsection
