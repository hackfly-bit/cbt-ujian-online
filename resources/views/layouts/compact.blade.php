<!DOCTYPE html>
<html lang="en" data-sidenav-size="compact">

<head>
    @include('layouts.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('layouts.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])

    @vite(['resources/js/head.js'])
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        @include('layouts.shared/topbar')

        @include('layouts.shared/left-sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')
            </div>
            @include('layouts.shared/footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    @include('layouts.shared/right-sidebar')
    @vite(['resources/js/app.js', 'resources/js/layout.js'])
    @include('layouts.shared/footer-script')
    @yield('script')

</body>

</html>
