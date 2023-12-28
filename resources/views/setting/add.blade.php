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
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif
            <div class="card">
                <form class="card-body" action="/pengaturan" method="POST">
                    @csrf()
                    @method('PUT')
                    <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Titik Lokasi</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" value="{{ $setting->titik_lokasi }}" placeholder="Masukkan Tanggal Agenda" name="titik_lokasi" type="text" id="titik_lokasi">
                                    <a href="" id="link-map">Disarankan menggunakan Open Street Map</a>
                                </div>
                                @error('titik_lokasi')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Radius</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" value="{{ $setting->radius }}" placeholder="Masukkan Tanggal Agenda" name="radius" type="number" id="radius">
                                </div>
                                @error('radius')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row gx-5" style="gap: 40px">
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Semester Gasal Awal</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" value="{{ $setting->smt_gasal_awal }}" placeholder="Masukkan Tanggal Agenda" name="smt_gasal_awal" type="date">
                                </div>
                                @error('smt_gasal_awal')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Semester Gasal Awal</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" value="{{ $setting->smt_gasal_tengah }}" placeholder="Masukkan Tanggal Agenda" name="smt_gasal_tengah" type="date">
                                </div>
                                @error('smt_gasal_tengah')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row mb-4">
                                <label class="col-form-label" style="font-size: 16px;">Semester Gasal Akhir</label>
                                <div class="col-12 p-0">
                                    <input class="form-control" value="{{ $setting->smt_gasal_akhir }}" placeholder="Masukkan Tanggal Agenda" name="smt_gasal_akhir" type="date">
                                </div>
                                @error('smt_gasal_akhir')
                                    <span style="font-style: italic; color: red; font-weight: bold;">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div id="map" class="form-group row mb-4" style="width: 100%; height: 400px; background-color: lightblue; border-radius: 10px">
                            
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label"></label>
                            <div class="col-sm-12 p-0">
                                <button type="submit" class="btn btn-success">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const linkMap = document.getElementById('link-map')

        const titikLokasi = document.getElementById('titik_lokasi').value.split(',')
        const lat = Number(titikLokasi[0])
        const lng = Number(titikLokasi[1])
        const radius = Number(document.getElementById('radius').value)
        
        linkMap.addEventListener('click', function(e) {
            e.preventDefault()
            window.location.href = `https://www.openstreetmap.org/search?whereami=1&query=${lat}%2C${lng}#map=19/${lat}/${lng} `
        })

        let map = L.map('map').setView([lat, lng], 21);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map);
            L.circle([lat, lng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
    </script>
@endsection
