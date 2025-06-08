<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Preloader'])
    @yield('css')
    @include('layouts.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css', 'resources/js/head.js'])

    <!-- Gunakan Fabric.js 4.6.0 dari CDN -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script> --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto&family=Open+Sans&family=Lato&family=Montserrat&display=swap"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontfaceobserver/2.1.0/fontfaceobserver.standalone.js"></script>


    <style>
        .align-button.active {
            background-color: #6c757d;
            color: white;
        }

        .bg-scale-button.active {
            background-color: #6c757d;
            color: white;
        }
    </style>
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

        @include('sertifikat.topbar')
        @include('sertifikat.sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!-- Bungkus seluruh halaman dengan flex dan tinggi penuh -->
        <div class="content-page">
            <form id="formSertifikat" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="judul" id="judul" value="{{ $sertifikat->judul }}">
                <input type="hidden" name="ujian_id" id="ujian_id" value="{{ $sertifikat->ujian_id }}">
                <input type="hidden" name="sertifikat_template" id="sertifikat_template">
            </form>
            <button class="btn btn-primary mx-2 mt-3" id="edit-background" style="position: fixed">Edit
                Background</button>
            <div class="d-flex justify-content-center align-items-center"
                style="min-height: 100vh; background-color: #f5f5f5; padding: 1rem; overflow-y: auto;">

                <div class="content"
                    style="background-color: #ffffff; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: auto;">
                    <!-- Canvas Sertifikat A4 -->
                    <div style="overflow: auto;">
                        <canvas id="certificate-canvas" width="1123" height="794"
                            style="border: 1px solid #ccc; max-width: 100%; height: auto; display: block;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

        @include('sertifikat.text-properti')
        @include('sertifikat.bg-properti')

    </div>

    <!-- Sertifikat.js dipanggil terakhir -->
    <script>
        let data = @json($sertifikat);
        console.log(data);
    </script>
    @vite(['resources/js/app.js', 'resources/js/layout.js', 'resources/js/main/sertifikat.js'])

    @yield('script')

</body>

</html>
