@extends('layouts.vertical', ['page_title' => 'Apex Pie', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Pie Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pie Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Simple Pie Chart</h4>
                        <div >
                            <div id="simple-pie" class="apex-charts" data-colors="#3e60d5,#6c757d,#47ad77,#fa5c7c,#e3eaef"></div>
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
                        <h4 class="header-title">Simple Donut Chart</h4>
                        <div >
                            <div id="simple-donut" class="apex-charts" data-colors="#39afd1,#ffbc00,#313a46,#fa5c7c,#47ad77"></div>
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
                        <h4 class="header-title mb-4">Monochrome Pie Chart</h4>
                        <div >
                            <div id="monochrome-pie" class="apex-charts"></div>
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
                        <h4 class="header-title mb-4">Gradient Donut Chart</h4>
                        <div >
                            <div id="gradient-donut" class="apex-charts" data-colors="#3e60d5,#6c757d,#47ad77,#fa5c7c,#e3eaef"></div>
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
                        <h4 class="header-title mb-4">Patterned Donut Chart</h4>
                        <div >
                            <div id="patterned-donut" class="apex-charts" data-colors="#39afd1,#ffbc00,#313a46,#fa5c7c,#47ad77"></div>
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
                        <h4 class="header-title mb-4">Pie Chart with Image fill</h4>
                        <div >
                            <div id="image-pie" class="apex-charts" data-colors="#39afd1,#ffbc00,#3e60d5,#47ad77"></div>
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
                        <h4 class="header-title mb-4">Donut Update</h4>
                        <div >
                            <div id="update-donut" class="apex-charts" data-colors="#3e60d5,#6c757d,#47ad77,#fa5c7c"></div>
                        </div>

                        <div class="text-center mt-2">
                            <button class="btn btn-sm btn-primary" id="randomize">RANDOMIZE</button>
                            <button class="btn btn-sm btn-primary" id="add">ADD</button>
                            <button class="btn btn-sm btn-primary" id="remove">REMOVE</button>
                            <button class="btn btn-sm btn-primary" id="reset">RESET</button>
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
    @vite(['resources/js/pages/demo.apex-pie.js'])
@endsection
