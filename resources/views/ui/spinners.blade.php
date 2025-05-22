@extends('layouts.vertical', ['page_title' => 'Spinners', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Spinners</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Spinners</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Border Spinner</h4>
                        <p class="text-muted fs-14">Use the border spinners for a lightweight loading indicator.</p>

                        <div class="spinner-border m-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Colors</h4>
                        <p class="text-muted fs-14">You can use any
                            of our text color utilities on the standard spinner.</p>

                        <div class="spinner-border text-primary m-2" role="status"></div>
                        <div class="spinner-border text-secondary m-2" role="status"></div>
                        <div class="spinner-border text-success m-2" role="status"></div>
                        <div class="spinner-border text-danger m-2" role="status"></div>
                        <div class="spinner-border text-warning m-2" role="status"></div>
                        <div class="spinner-border text-info m-2" role="status"></div>
                        <div class="spinner-border text-light m-2" role="status"></div>
                        <div class="spinner-border text-dark m-2" role="status"></div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Alignment</h4>
                        <p class="text-muted fs-14">Use flexbox utilities, float utilities, or text alignment utilities to place spinners exactly where you need them in any situation.</p>

                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status"></div>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Size</h4>
                        <p class="text-muted fs-14">Add <code>.spinner-border-sm</code> and
                            <code>.spinner-border.avatar-**</code> to make a smaller spinner that can quickly be used within other components.
                        </p>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="spinner-border avatar-lg text-primary m-2" role="status"></div>
                                <div class="spinner-grow avatar-lg text-secondary m-2" role="status"></div>
                            </div><!-- end col -->

                            <div class="col-lg-6">
                                <div class="spinner-border avatar-md text-primary m-2" role="status"></div>
                                <div class="spinner-grow avatar-md text-secondary m-2" role="status"></div>
                            </div><!-- end col -->

                            <div class="col-lg-6">
                                <div class="spinner-border avatar-sm text-primary m-2" role="status"></div>
                                <div class="spinner-grow avatar-sm text-secondary m-2" role="status"></div>
                            </div><!-- end col -->

                            <div class="col-lg-6">
                                <div class="spinner-border spinner-border-sm m-2" role="status"></div>
                                <div class="spinner-grow spinner-grow-sm m-2" role="status"></div>
                            </div><!-- end col -->
                        </div>
                        <!--end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Growing Spinner</h4>
                        <p class="text-muted fs-14">If you don’t fancy a border spinner, switch to the grow spinner. While it doesn’t technically spin, it does repeatedly grow!</p>

                        <div class="spinner-grow m-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Color Growing Spinner</h4>
                        <p class="text-muted fs-14">You can use any of our text color utilities on the standard spinner.</p>

                        <div class="spinner-grow text-primary m-2" role="status"></div>
                        <div class="spinner-grow text-secondary m-2" role="status"></div>
                        <div class="spinner-grow text-success m-2" role="status"></div>
                        <div class="spinner-grow text-danger m-2" role="status"></div>
                        <div class="spinner-grow text-warning m-2" role="status"></div>
                        <div class="spinner-grow text-info m-2" role="status"></div>
                        <div class="spinner-grow text-light m-2" role="status"></div>
                        <div class="spinner-grow text-dark m-2" role="status"></div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Placement</h4>
                        <p class="text-muted fs-14">Use <code>flexbox utilities</code>, <code>float utilities</code>, or <code>text alignment</code> utilities to place spinners exactly where you need them in any situation.</p>

                        <div class="d-flex align-items-center">
                            <strong>Loading...</strong>
                            <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Buttons Spinner</h4>
                        <p class="text-muted fs-14">Use spinners within buttons to indicate an action is currently processing or taking place.
                            You may also swap the text out of the spinner element and utilize button text as needed.</p>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>
                                    </button>
                                    <button class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </div><!-- end col -->
                            <div class="col-lg-6">
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="visually-hidden">Loading...</span>
                                    </button>
                                    <button class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                </div>
                            </div><!-- end col -->
                        </div> <!-- end row -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
    <!-- End Content-->
@endsection
