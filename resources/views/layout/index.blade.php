<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            @if (Auth::guard('web')->user())
                                <img alt="image"
                                    src="{{ Auth::guard('web')->user()->image == null ? asset('assets/img/default.jpg') : asset('storage/user/' . Auth::guard('web')->user()->image) }}"
                                    style="border-radius: 50%; display: inline-block; width: 30px; height: 30px; overflow: hidden">
                            @else
                                <img alt="image"
                                    src="{{ Auth::guard('teacher')->user()->image == null ? asset('assets/img/default.jpg') : asset('storage/teacher/' . Auth::guard('teacher')->user()->image) }}"
                                    style="border-radius: 50%; display: inline-block; width: 30px; height: 30px; overflow: hidden">
                            @endif
                            @if (Auth::guard('web')->user())
                                <div class="d-sm-none d-lg-inline-block" style="font-size: 16px">Hi,
                                    {{ Auth::guard('web')->user()->name }}</div>
                            @else
                                <div class="d-sm-none d-lg-inline-block" style="font-size: 16px">Hi,
                                    {{ Auth::guard('teacher')->user()->nama }}</div>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if (Auth::guard('web')->user())
                                <a href="/auth/me" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                            @else
                                <a href="/auth/wali-kelas/me" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a href="/auth/logout" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    {{-- <div class="sidebar-brand"> --}}
                    <a href="/">
                        <img style="display: block; width: 50px; height: 50px; margin: 10px auto"
                            src="{{ asset('assets/img/logo.png') }}" alt="">
                    </a>
                    {{-- </div> --}}
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="dropdown {{ Request()->is('/') ? 'active' : '' }}">
                            <a href="/" class="">
                                <i class="fas fa-fire"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-header">Master</li>
                        @if (Auth::guard('web')->user())
                            <li class="dropdown {{ Request()->is('kelas*') ? 'active' : '' }}">
                                <a href="/kelas">
                                    <i class="fas fa-columns"></i>
                                    <span>Kelas</span>
                                </a>
                            </li>
                            <li class="dropdown {{ Request()->is('wali-kelas*') ? 'active' : '' }}">
                                <a href="/wali-kelas">
                                    <i class="fas fa-columns"></i>
                                    <span>Wali Kelas</span>
                                </a>
                            </li>
                        @endif
                        <li class="dropdown {{ Request()->is('siswa*') ? 'active' : '' }}">
                            <a href="/siswa">
                                <i class="fas fa-columns"></i>
                                <span>Siswa</span>
                            </a>
                        </li>
                        <li class="dropdown {{ Request()->is('agenda*') ? 'active' : '' }}">
                            <a href="/agenda">
                                <i class="fas fa-columns"></i>
                                <span>Agenda</span>
                            </a>
                        </li>
                        <li
                            class="dropdown {{ Request()->is('presensi-siswa') || Request()->is('izin-siswa*') ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                                <span>Monitoring</span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown {{ Request()->is('presensi-siswa') ? 'active' : '' }}"><a
                                        href="/presensi-siswa" class="nav-link" href="bootstrap-alert.html">Presensi
                                        Siswa</a></li>
                                <li class="dropdown {{ Request()->is('izin-siswa') ? 'active' : '' }}"><a
                                        href="/izin-siswa" class="nav-link" href="bootstrap-alert.html">Izin Siswa</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{ Request()->is('presensi-siswa/rekap/bulanan') ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                                <span>Rekap Presensi</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ Request()->is('presensi-siswa/import') ? 'active' : '' }}"><a
                                    href="/presensi-siswa/import" class="nav-link"
                                    href="bootstrap-alert.html">Import Data Presensi</a></li>
                                <li class="{{ Request()->is('presensi-siswa/rekap/bulanan') ? 'active' : '' }}"><a
                                        href="/presensi-siswa/rekap/bulanan" class="nav-link"
                                        href="bootstrap-alert.html">Bulanan</a></li>
                                {{-- <li class="{{ Request()->is('presensi-siswa/rekap/smt-gasal-tengah') ? 'active' : '' }}"><a
                                        href="/presensi-siswa/rekap/smt-gasal-tengah" class="nav-link"
                                        href="bootstrap-alert.html">Tengah Semester Gasal</a></li>
                                <li class="{{ Request()->is('presensi-siswa/rekap/smt-gasal-akhir') ? 'active' : '' }}"><a
                                        href="/presensi-siswa/rekap/smt-gasal-akhir" class="nav-link"
                                        href="bootstrap-alert.html">Akhir Semester Gasal</a></li>
                                <li class="{{ Request()->is('presensi-siswa/rekap/smt-genap-tengah') ? 'active' : '' }}"><a
                                            href="/presensi-siswa/rekap/smt-genap-tengah" class="nav-link"
                                            href="bootstrap-alert.html">Tengah Semester Genap</a></li>
                                <li class="{{ Request()->is('presensi-siswa/rekap/smt-genap-akhir') ? 'active' : '' }}"><a
                                                href="/presensi-siswa/rekap/smt-genap-akhir" class="nav-link"
                                                href="bootstrap-alert.html">Akhir Semester Genap</a></li> --}}
                            </ul>
                        </li>
                        <li class="dropdown {{ Request()->is('jadwal*') ? 'active' : '' }}">
                            <a href="/jadwal">
                                <i class="fas fa-columns"></i>
                                <span>Jadwal Presensi</span>
                            </a>
                        </li>
                        <li class="dropdown {{ Request()->is('pengumuman*') ? 'active' : '' }}">
                            <a href="/pengumuman">
                                <i class="fas fa-columns"></i>
                                <span>Pengumuman</span>
                            </a>
                        </li>
                        <li class="dropdown {{ Request()->is('pengaturan*') ? 'active' : '' }}">
                            <a href="/pengaturan">
                                <i class="fas fa-columns"></i>
                                <span>Pengaturan</span>
                            </a>
                        </li>
                    </ul>

                    {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-rocket"></i> Documentation
                        </a>
                    </div> --}}
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('content')
                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ \Carbon\Carbon::now()->year }} <div class="bullet"></div> Design By <a
                        href="https://nazaridev.vercel.app/">Muhamad Nazir Azhari</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->

    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/features-post-create.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        const inputUpld = document.querySelector('.input-upld')
        const imgUpld = document.querySelector('.img-upld')
        inputUpld.addEventListener('change', function(e) {
            const file = inputUpld.files[0]
            const reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = function() {
                imgUpld.src = reader.result
            }
        })
    </script>
</body>

</html>
