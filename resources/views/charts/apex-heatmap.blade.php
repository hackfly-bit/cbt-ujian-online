@extends('layouts.vertical', ['page_title' => 'Apex heatmap', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

         <!-- start page title -->
         <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attex</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Apex</a></li>
                            <li class="breadcrumb-item active">Heatmap Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Heatmap Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Basic Heatmap - Single Series</h4>
                        <div >
                            <div id="basic-heatmap" class="apex-charts" data-colors="#3e60d5"></div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Heatmap - Multiple Series</h4>
                        <div >
                            <div id="multiple-series-heatmap" class="apex-charts" data-colors="#F3B415,#F27036,#663F59,#6A6E94,#4E88B4,#00A7C6,#18D8D8,#A9D794,#46AF78"></div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Heatmap - Color Range</h4>
                        <div >
                            <div id="color-range-heatmap" class="apex-charts" data-colors="#fa5c7c,#ffbc00,#39afd1,#47ad77"></div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Heatmap - Range without Shades</h4>
                        <div >
                            <div id="rounded-heatmap" class="apex-charts" data-colors="#47ad77,#ffbc00"></div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.apex-heatmap.js'])
@endsection
