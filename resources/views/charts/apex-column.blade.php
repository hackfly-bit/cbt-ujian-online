@extends('layouts.vertical', ['page_title' => 'Apex column', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Column Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Column Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Basic Column Chart</h4>
                        <div >
                            <div id="basic-column" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c"></div>
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
                        <h4 class="header-title mb-3">Column Chart with Datalabels</h4>
                        <div >
                            <div id="datalabels-column" class="apex-charts" data-colors="#3e60d5"></div>
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
                        <h4 class="header-title">Stacked Column Chart</h4>
                        <div >
                            <div id="stacked-column" class="apex-charts" data-colors="#39afd1,#ffbc00,#e3eaef"></div>
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
                        <h4 class="header-title">100% Stacked Column Chart</h4>
                        <div >
                            <div id="full-stacked-column" class="apex-charts" data-colors="#39afd1,#47ad77,#e3eaef"></div>
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
                        <h4 class="header-title">Column with Markers</h4>
                        <div >
                            <div id="column-with-markers" class="apex-charts" data-colors="#3e60d5,#ffbc00"></div>
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
                        <h4 class="header-title">Column with Group Label</h4>
                        <div >
                            <div id="column-with-group-label" class="apex-charts" data-colors="#39afd1,#47ad77,#e3eaef"></div>
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
                        <h4 class="header-title">Column Chart with rotated labels & Annotations</h4>
                        <div >
                            <div id="rotate-labels-column" class="apex-charts" data-colors="#fa5c7c"></div>
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
                        <h4 class="header-title">Column Chart with negative values</h4>
                        <div >
                            <div id="negative-value-column" class="apex-charts" data-colors="#3e60d5"></div>
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
                        <h4 class="header-title">Distributed Column Chart</h4>
                        <div >
                            <div id="distributed-column" class="apex-charts" data-colors="#3e60d5,#6c757d,#47ad77,#fa5c7c,#ffbc00,#39afd1,#e3eaef,#313a46"></div>
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
                        <h4 class="header-title">Range Column Chart</h4>
                        <div >
                            <div id="range-column" class="apex-charts" data-colors="#47ad77,#39afd1"></div>
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
            <div class="col-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Dynamic Loaded Chart</h4>
                        <div class="flex-shrink-0">
                            <select id="model" class="form-select form-select-sm">
                                <option value="iphone5">iPhone 5</option>
                                <option value="iphone6">iPhone 6</option>
                                <option value="iphone7">iPhone 7</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <h4 class="header-title"></h4>
                        <div >
                            <div class="row">
                                <div class="col-sm-6">
                                    <div id="chart-year" data-colors="#3e60d5,#6c757d,#47ad77,#fa5c7c,#ffbc00,#39afd1"></div>
                                </div>
                                <div class="col-sm-6">
                                    <div id="chart-quarter" data-colors="#3e60d5,#6c757d,#47ad77,#fa5c7c,#ffbc00,#39afd1"></div>
                                </div>
                            </div> <!-- end row-->
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
    <!-- Apex Chart Column Demo js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/dayjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/plugin/quarterOfYear.min.js"></script>
    @vite(['resources/js/pages/demo.apex-column.js'])
@endsection
