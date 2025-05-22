@extends('layouts.vertical', ['page_title' => 'Ratings', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                            <li class="breadcrumb-item active">Ratings</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Ratings</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Default Ratings</h4>
                        <p class="text-muted fs-14"></p>

                        <div class="rateit" data-rateit-mode="font">
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Icon Font - Change icon</h4>
                        <p class="text-muted fs-14"></p>

                        <div class="rateit" data-rateit-icon="@" data-rateit-mode="font">
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Progressive enhancement (using select)</h4>
                        <p class="text-muted fs-14"></p>

                        <select id="backing3b">
                            <option value="0">Bad</option>
                            <option value="1" selected="selected">OK</option>
                            <option value="2">Good</option>
                            <option value="3">Great</option>
                            <option value="4">Excellent</option>
                        </select>
                        <div class="rateit rateit-remix" data-rateit-backingfld="#backing3b" data-rateit-mode="font" data-rateit-icon="&#xF186;"></div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Javascript interaction</h4>
                        <p class="text-muted fs-14"></p>

                        <div class="rateit rateit-remix" id="js-interaction" data-rateit-min="0" data-rateit-mode="font" data-rateit-icon="&#xF18B;">
                        </div>
                        <div>
                            <span id="jsvalue"></span>
                            <span id="jshover"></span>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">RTL support</h4>
                        <p class="text-muted fs-14">Now we are in RTL mode. No changes needed to make this work</p>

                        <div style="direction: rtl">
                            <div class="rateit rateit-remix" data-rateit-mode="font" data-rateit-icon="&#xF186;">
                            </div>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Remix Icons</h4>
                        <p class="text-muted fs-14"></p>

                        <div class="rateit rateit-remix" data-rateit-mode="font" data-rateit-icon="&#xF18F;">
                        </div>

                        <br />

                        <div class="rateit rateit-remix mt-3" data-rateit-mode="font" data-rateit-icon="&#xEE0F;">
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Icon Font - Sizing</h4>
                        <p class="text-muted fs-14"></p>

                        <div class="rateit rateit-remix" data-rateit-mode="font" data-rateit-icon="&#xF18B;" style="font-size: 36px;">
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Readonly and preset value</h4>
                        <p class="text-muted fs-14"></p>

                        <div class="rateit rateit-remix" data-rateit-mode="font" data-rateit-icon="&#xF18B;" data-rateit-value="2.5" data-rateit-ispreset="true" data-rateit-readonly="true">
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Setting and Getting values</h4>
                        <p class="text-muted fs-14">All properties can also be set on the fly. Here are a few examples:</p>

                        <div class="rateit rateit-remix" data-rateit-mode="font" data-rateit-icon="&#xF18B;" id="getting-values">
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <button class="btn btn-sm btn-primary" onclick="alert($('#getting-values').rateit('value'))">Get value</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#getting-values').rateit('value', prompt('Input numerical value'))">Set value</button>
                            <button class="btn btn-sm btn-primary" onclick="alert($('#getting-values').rateit('max'))">Get max value</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#getting-values').rateit('max', prompt('Input numerical value'))">Set max value</button>
                            <button class="btn btn-sm btn-primary" onclick="alert($('#getting-values').rateit('step'))">Get step size</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#getting-values').rateit('step', prompt('Input numerical value'))">Set step size</button>
                            <button class="btn btn-sm btn-primary" onclick="alert($('#getting-values').rateit('readonly'))">Get readonly value</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#getting-values').rateit('readonly',!$('#getting-values').rateit('readonly'))">Toggle readonly</button>
                            <button class="btn btn-sm btn-primary" onclick="alert($('#getting-values').rateit('ispreset'))">Get ispreset value</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#getting-values').rateit('ispreset',!$('#getting-values').rateit('ispreset'))">Toggle ispreset</button>
                            <button class="btn btn-sm btn-primary" onclick="$('#getting-values').rateit('reset')">Reset</button>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/component.rating.js'])
@endsection
