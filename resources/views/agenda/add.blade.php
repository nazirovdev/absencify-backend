@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="/agenda">Agenda</a>
            </div>
            <div class="breadcrumb-item">Tambah Agenda</div>
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
                <form class="card-body" action="/agenda/tambah" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Tanggal Agenda</label>
                                <input class="form-control" placeholder="Masukkan Tanggal Agenda" name="tanggal_agenda"
                                    value="{{ old('tanggal_agenda') }}" type="date">
                                @error('tanggal_agenda')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Status Agenda</label>
                                <div class="col-12 p-0">
                                    <select class="form-control selectric" name="status">
                                        <option value="a">Agenda</option>
                                        <option value="l">Libur</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label" style="font-size: 16px;">Keterangan</label>
                            <input class="form-control" placeholder="Masukkan Keterangan Agenda" name="keterangan"
                                value="{{ old('keterangan') }}" type="text">
                            @error('keterangan')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-success">Tambah Agenda</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
