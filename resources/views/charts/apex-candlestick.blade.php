@extends('layouts.vertical', ['page_title' => 'Apex Candlestick', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Candalstick Charts</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Candalstick Charts</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Simple Candlestick Chart</h4>
                        <div >
                            <div id="simple-candlestick" class="apex-charts" data-colors="#47ad77,#fa5c7c"></div>
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
                        <h4 class="header-title">Combo Candlestick Chart</h4>
                        <div >
                            <div id="combo-candlestick" class="apex-charts" data-colors="#47ad77,#fa5c7c"></div>
                            <div id="combo-bar-candlestick" class="apex-charts" data-colors="#3e60d5,#ffbc00"></div>
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
                        <h4 class="header-title mb-3">Category X-Axis</h4>
                        <div >
                            <div id="x-axis-candlestick" class="apex-charts" data-colors="#47ad77,#fa5c7c,#3e60d5"></div>
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
                        <h4 class="header-title mb-3">Candlestick with Line</h4>
                        <div >
                            <div id="candlestick-with-line" class="apex-charts" data-colors="#3e60d5,#47ad77,#fa5c7c"></div>
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
    <script src="https://apexcharts.com/samples/assets/ohlc.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.8.17/dayjs.min.js"></script>
    @vite(['resources/js/pages/demo.apex-candlestick.js'])
@endsection
