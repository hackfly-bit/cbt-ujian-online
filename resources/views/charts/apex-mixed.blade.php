@extends('layouts.vertical', ['page_title' => 'Apex Mixed', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Mixed Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Mixed Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Line & Column Chart</h4>
                        <div >
                            <div id="line-column-mixed" class="apex-charts" data-colors="#3e60d5,#47ad77"></div>
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
                        <h4 class="header-title">Multiple Y-Axis Chart</h4>
                        <div >
                            <div id="multiple-yaxis-mixed" class="apex-charts" data-colors="#3e60d5,#39afd1,#fa5c7c"></div>
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
                        <h4 class="header-title">Line & Area Chart</h4>
                        <div >
                            <div id="line-area-mixed" class="apex-charts" data-colors="#47ad77,#fa5c7c"></div>
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
                        <h4 class="header-title">Line, Column & Area Chart</h4>
                        <div >
                            <div id="all-mixed" class="apex-charts" data-colors="#3e60d5,#39afd1,#fa5c7c"></div>
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
    @vite(['resources/js/pages/demo.apex-mixed.js'])
@endsection
