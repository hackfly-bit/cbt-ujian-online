@extends('layouts.vertical', ['page_title' => 'Breadcrumb', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Breadcrumbs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Breadcrumbs</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Example</h4>
                        <p class="text-muted fs-14">
                            Indicate the current page’s location within a navigational hierarchy that automatically adds separators via CSS.
                            Please read the official <a target="_blank" href="https://getbootstrap.com/docs/5.3/components/breadcrumb/">Bootstrap</a> documentation for more options.
                        </p>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                            </ol>
                        </nav>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                            </ol>
                        </nav>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 py-2">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                            </ol>
                        </nav>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">With Icons</h4>
                        <p class="text-muted fs-14">
                            Optionally you can also specify the icon with your breadcrumb item.
                        </p>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1 p-2 bg-light-subtle">
                                <li class="breadcrumb-item active" aria-current="page"><i class="ri-home-4-line me-1"></i>Home</li>
                            </ol>
                        </nav>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1 p-2 bg-light-subtle">
                                <li class="breadcrumb-item"><a href="#"><i class="ri-home-4-line"></i> Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                            </ol>
                        </nav>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-2 bg-light-subtle">
                                <li class="breadcrumb-item"><a href="#"><i class="ri-home-4-line"></i> Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                            </ol>
                        </nav>

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->

        </div> <!-- end row -->

    </div> <!-- container -->
    <!-- End Content-->
@endsection
