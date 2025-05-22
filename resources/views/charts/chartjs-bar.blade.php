@extends('layouts.vertical', ['page_title' => 'ChartJs Bar', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Charts
                            </a></li>
                            <li class="breadcrumb-item active">Chartjs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Chartjs</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Border Radius</h4>

                        <div >
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="border-radius-example" data-colors="#3e60d5,#47ad77"></canvas>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Floating</h4>

                        <div >
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="floating-example" data-colors="#3e60d5,#47ad77"></canvas>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->


        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Horizontal</h4>

                        <div >
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="horizontal-example" data-colors="#3e60d5,#47ad77"></canvas>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Stacked</h4>

                        <div >
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="stacked-example" data-colors="#3e60d5,#47ad77"></canvas>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Stacked with Groups</h4>

                        <div >
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="group-stack-example" data-colors="#3e60d5,#47ad77"></canvas>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Vertical</h4>

                        <div >
                            <div class="mt-3 chartjs-chart" style="height: 320px;">
                                <canvas id="vertical-example" data-colors="#3e60d5,#47ad77"></canvas>
                            </div>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.chartjs-bar.js'])
@endsection
