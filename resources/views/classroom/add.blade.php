@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="/kelas">Kelas</a>
            </div>
            <div class="breadcrumb-item">Tambah Kelas</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="card-body" action="/kelas/tambah" method="POST">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col-6">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Nama Kelas</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Kelas" name="nama"
                                    value="{{ old('nama') }}">
                                @error('nama')
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
                            <button type="submit" class="btn btn-success">Tambah Kelas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
