@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="/jadwal">Jadwal Presensi</a>
            </div>
            <div class="breadcrumb-item">Tambah Jadwal Presensi</div>
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
                <form class="card-body" action="/jadwal/tambah" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Hari</label>
                                <div class="col-12 p-0">
                                    <select class="form-control selectric" name="hari">
                                        @foreach ($days as $key => $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('hari')
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
                                <label class="col-form-label" style="font-size: 16px;">Jam Masuk</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" placeholder="Masukkan Tanggal Agenda" name="jam_masuk" type="time">
                                </div>
                                @error('jam_masuk')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Jam Pulang</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" placeholder="Masukkan Tanggal Agenda" name="jam_pulang" type="time">
                                </div>
                                @error('jam_pulang')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-success">Tambah jadwal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
