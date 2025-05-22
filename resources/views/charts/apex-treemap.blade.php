@extends('layouts.vertical', ['page_title' => 'Apex Treemap', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Treemap Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Treemap Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Basic Treemap</h4>
                        <div >
                            <div id="basic-treemap" class="apex-charts" data-colors="#39afd1"></div>
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
                        <h4 class="header-title">Treemap Multiple Series</h4>
                        <div >
                            <div id="multiple-treemap" class="apex-charts" data-colors="#fa5c7c,#6c757d"></div>
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
                        <h4 class="header-title">Distributed Treemap</h4>
                        <div >
                            <div id="distributed-treemap" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c,#6c757d,#39afd1,#ffc35a, #eef2f7, #313a46"></div>
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
                        <h4 class="header-title">Color Range Treemap</h4>
                        <div >
                            <div id="color-range-treemap" class="apex-charts" data-colors="#3e60d5,#39afd1"></div>
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
    @vite(['resources/js/pages/demo.apex-treemap.js'])
@endsection
