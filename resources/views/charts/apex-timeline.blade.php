@extends('layouts.vertical', ['page_title' => 'Apex Timeline', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Timeline Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Timeline Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Basic Timeline</h4>
                        <div >
                            <div id="basic-timeline" class="apex-charts" data-colors="#fa6767"></div>
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
                        <h4 class="header-title mb-3">Distributed Timeline </h4>
                        <div >
                            <div id="distributed-timeline" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c,#6c757d,#39afd1"></div>
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
                        <h4 class="header-title mb-3">Multi Series Timeline</h4>

                        <div >
                            <div id="multi-series-timeline" class="apex-charts" data-colors="#6c757d,#39afd1"></div>
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
                        <h4 class="header-title mb-3">Advanced Timeline</h4>
                        <div >
                            <div id="advanced-timeline" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c"></div>
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
                        <h4 class="header-title mb-3">Multiple Series - Group Rows</h4>
                        <div >
                            <div id="group-rows-timeline" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c,#6c757d,#39afd1,#ffc35a, #eef2f7, #313a46,#3577f1, #0ab39c, #f0a548,#68eaff"></div>
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
    @vite(['resources/js/pages/demo.apex-timeline.js'])
@endsection
