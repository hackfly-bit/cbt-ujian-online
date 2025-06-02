<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Preloader'])
    @yield('css')
    @include('layouts.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css', 'resources/js/head.js'])

    <!-- Gunakan Fabric.js 4.6.0 dari CDN -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script> --}}
</head>

<body>

    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->

    <div class="wrapper">

        @include('layouts.shared/topbar')
        @include('sertifikat.sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Canvas Sertifikat -->
                <canvas id="certificate-canvas" width="1000" height="700"
                    style="border: 1px solid #ccc; background: #fff;"></canvas>
            </div>

            <!-- Tombol menu sidebar untuk tambah teks -->
            <li class="side-nav-item">
                <a href="javascript:void(0);" class="side-nav-link" id="btn-add-text">
                    <i class="ri-file-edit-line"></i>
                    <span> Text </span>
                </a>
            </li>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    @include('layouts.shared/right-sidebar')

    <!-- Sertifikat.js dipanggil terakhir -->
    @vite([
        'resources/js/app.js',
        'resources/js/layout.js',
        'resources/js/main/sertifikat.js'
    ])

    @yield('script')

</body>

</html>
