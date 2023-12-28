@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="/pengumuman">Pengumuman</a>
            </div>
            <div class="breadcrumb-item">Tambah Pengumuman</div>
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
                <form class="card-body" action="/pengumuman/tambah" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Judul Pengumuman</label>
                                <input class="form-control" placeholder="Masukkan Judul Pengumuman" name="judul"
                                    value="{{ old('judul') }}" type="text">
                                @error('judul')
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
                                <label class="col-form-label" style="font-size: 16px;">Tanggal Publikasi</label>
                                <input class="form-control" placeholder="Masukkan Tanggal Publikasi" name="tanggal_publikasi"
                                    value="{{ old('tanggal_publikasi') }}" type="date">
                                @error('tanggal_publikasi')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Status Pengumuman</label>
                                <div class="col-12 p-0">
                                    <select class="form-control selectric" name="status">
                                        <option value="exist">Tersedia</option>
                                        <option value="expired">Kadaluarsa</option>
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
                            <label class="col-form-label" style="font-size: 16px;">Lampiran</label>
                            <div class="col-sm-12 p-0">
                                <label
                                    style="width: 200px; height: 230px;border-width: 2px; border-color: gray; border-style: dashed; padding: 3px"
                                    for="lampiran">
                                    <img style="display: block; width: 100%; height: 100%;object-fit: cover"
                                        src="{{ asset('assets/img/default.jpg') }}" class="img-lampiran" />
                                    <input type="file" name="lampiran" id="lampiran" style="display: none"
                                        class="input-upld">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label" style="font-size: 16px;">Isi Pengumuman</label>
                        <div class="col-12 p-0">
                          <textarea class="summernote-simple" style="display: none;" name="isi_pengumuman"></textarea>
                        </div>
                        @error('isi_pengumuman')
                                <span style="font-style: italic; color: red; font-weight: bold;">
                                    {{ $message }}
                                </span>
                            @enderror
                      </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label"></label>
                        <div class="col-sm-12 p-0">
                            <button type="submit" class="btn btn-success">Tambah Pengumuman</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const inputUpld = document.querySelector('.input-upld')
        const imgLampiran = document.querySelector('.img-lampiran')
        inputUpld.addEventListener('change', function(e) {
            const file = inputUpld.files[0]
            const reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = function() {
                imgLampiran.src = reader.result
            }
        })
    </script>
@endsection
