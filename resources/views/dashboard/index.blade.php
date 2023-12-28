@extends('layout.index')
<style>
    .dashboard-container {
        display: grid !important;
        grid-template-columns: 1fr 1fr 1fr 1fr !important;
        gap: 5px;
    }

    .dashboard-container .card {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-direction: row !important;
    }

    .dashboard-container .card-icon {
        width: 50px !important;
        height: 50px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    @media (min-width: 0px) {
        .dashboard-container {
            grid-template-columns: 1fr !important;
        }
    }

    @media (min-width: 576px) {
        .dashboard-container {
            grid-template-columns: 1fr 1fr !important;
        }
    }

    @media (min-width: 768px) {
        .dashboard-container {
            grid-template-columns: 1fr 1fr 1fr !important;
        }
    }

    @media (min-width: 1136px) {
        .dashboard-container {
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr !important;
        }
    }
</style>
@section('content')
    <div class="section-header">
        <h1>{{ $title }}</h1>
    </div>
    <div class="dashboard-container">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                {{-- <i class="far fa-user"></i> --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-clock-check" width="24" height="24"
                    style="color: white"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967"></path>
                    <path d="M12 7v5l3 3"></path>
                    <path d="M15 19l2 2l4 -4"></path>
                </svg>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Hadir</h4>
                </div>
                <div class="card-body">
                    {{ $data['hadir'] }}
                </div>
            </div>
        </div>
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-clock-exclamation" width="24"
                    style="color: white"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M20.986 12.502a9 9 0 1 0 -5.973 7.98"></path>
                    <path d="M12 7v5l3 3"></path>
                    <path d="M19 16v3"></path>
                    <path d="M19 22v.01"></path>
                </svg>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Terlambat</h4>
                </div>
                <div class="card-body">
                    {{ $data['terlambat'] }}
                </div>
            </div>
        </div>
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning" style="background-color: #f59e0b!important">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-mood-sick" width="24" height="24"
                    style="color: white"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"></path>
                    <path d="M9 10h-.01"></path>
                    <path d="M15 10h-.01"></path>
                    <path d="M8 16l1 -1l1.5 1l1.5 -1l1.5 1l1.5 -1l1 1"></path>
                </svg>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Sakit</h4>
                </div>
                <div class="card-body">
                    {{ $data['sakit'] }}
                </div>
            </div>
        </div>
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-mail-check" width="24" height="24"
                    style="color: white"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M11 19h-6a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v6">
                    </path>
                    <path d="M3 7l9 6l9 -6"></path>
                    <path d="M15 19l2 2l4 -4"></path>
                </svg>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Izin</h4>
                </div>
                <div class="card-body">
                    {{ $data['izin'] }}
                </div>
            </div>
        </div>
        <div class="card card-statistic-1">
            <div class="card-icon bg-success" style="background-color: #334155!important">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-school-off" width="24" height="24"
                    style="color: white"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                        d="M22 9l-10 -4l-2.136 .854m-2.864 1.146l-5 2l10 4l.697 -.279m2.878 -1.151l6.425 -2.57v6">
                    </path>
                    <path
                        d="M6 10.6v5.4c0 1.657 2.686 3 6 3c2.334 0 4.357 -.666 5.35 -1.64m.65 -3.36v-3.4">
                    </path>
                    <path d="M3 3l18 18"></path>
                </svg>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Alpa</h4>
                </div>
                <div class="card-body">
                    {{ $data['alpa'] }}
                </div>
            </div>
        </div>
    </div>
@endsection
