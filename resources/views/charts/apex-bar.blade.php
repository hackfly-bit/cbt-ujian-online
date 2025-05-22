@extends('layouts.vertical', ['page_title' => 'Apex Bar', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
@endsection

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
                            <li class="breadcrumb-item active">Bar Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bar Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Basic Bar Chart</h4>
                        <div >
                            <div id="basic-bar" class="apex-charts" data-colors="#39afd1"></div>
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
                        <h4 class="header-title">Grouped Bar Chart</h4>
                        <div >
                            <div id="grouped-bar" class="apex-charts" data-colors="#fa5c7c,#6c757d"></div>
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
                        <h4 class="header-title">Stacked Bar Chart</h4>
                        <div >
                            <div id="stacked-bar" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c,#6c757d,#39afd1"></div>
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
                        <h4 class="header-title">100% Stacked Bar Chart</h4>
                        <div >
                            <div id="full-stacked-bar" class="apex-charts" data-colors="#ffbc00,#39afd1,#6c757d,#e3eaef,#3e60d5"></div>
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
                        <h4 class="header-title">Bar with Negative Values</h4>
                        <div >
                            <div id="negative-bar" class="apex-charts" data-colors="#fa5c7c,#47ad77"></div>
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
                        <h4 class="header-title">Reversed Bar Chart</h4>
                        <div >
                            <div id="reversed-bar" class="apex-charts" data-colors="#3e60d5,#47ad77"></div>
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
                        <h4 class="header-title">Bar with Image Fill</h4>
                        <div >
                            <div id="image-fill-bar" class="apex-charts" data-colors="#3e60d5,#47ad77,#e3eaef"></div>
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
                        <h4 class="header-title">Custom DataLabels Bar</h4>
                        <div >
                            <div id="datalables-bar" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c,#6c757d,#39afd1,#2b908f,#ffbc00,#90ee7e,#f48024,#212730"></div>
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
                        <h4 class="header-title">Patterned Bar Chart</h4>
                        <div >
                            <div id="pattern-bar" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c,#39afd1"></div>
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
                        <h4 class="header-title">Bar with Markers</h4>
                        <div >
                            <div id="bar-markers" class="apex-charts" data-colors="#47ad77,#fa5c7c"></div>
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
    @vite(['resources/js/pages/demo.apex-bar.js'])
@endsection
