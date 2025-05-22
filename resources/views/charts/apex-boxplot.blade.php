@extends('layouts.vertical', ['page_title' => 'Apex Boxplot', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Boxplot Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Boxplot Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Basic Boxplot</h4>
                        <div>
                            <div id="basic-boxplot" class="apex-charts" data-colors="#3e60d5,#47ad77"></div>
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
                        <h4 class="header-title mb-4">Scatter Boxplot </h4>
                        <div>
                            <div id="scatter-boxplot" class="apex-charts" data-colors="#fa5c7c,#6c757d"></div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->
        </div>
        <!-- end row-->

        {{-- <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Horizontal BoxPlot</h4>
                        <div dir="ltr">
                            <div id="horizontal-boxplot" class="apex-charts" data-colors="#3e60d5,#47ad77,#e3eaef"></div>
                        </div>
                    </div>
                    <!-- end card body-->
                </div>
                <!-- end card -->
            </div>
            <!-- end col-->
        </div> --}}
        <!-- end row-->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.apex-boxplot.js'])
@endsection
