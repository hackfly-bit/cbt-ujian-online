@extends('layouts.vertical', ['page_title' => 'Collapse', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Collapse</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Collapse</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Collapse</h4>
                        <p class="text-muted fs-14 mb-3">
                            Bootstrap's collapse provides the way to toggle the visibility of any content or element.
                            Please read the official <a href="https://getbootstrap.com/docs/5.2/components/collapse/" target="_blank">Bootstrap</a>
                            documentation for a full list of options.
                        </p>

                        <p>
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Link with href
                            </a>
                            <button class="btn btn-primary ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Button with data-bs-target
                            </button>
                        </p>
                        <div class="collapse show" id="collapseExample">
                            <div class="card card-body mb-0">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life
                                accusamus terry
                                richardson ad squid. Nihil anim keffiyeh helvetica, craft beer
                                labore wes
                                anderson cred nesciunt sapiente ea proident.
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Collapse Horizontal</h4>
                        <p class="text-muted fs-14 mb-3">The collapse plugin also supports horizontal collapsing. Add the <code>.collapse-horizontal</code> modifier class to transition the <code>width</code> instead of <code>height</code> and set a <code>width</code> on the immediate child element.</p>

                        <p>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                                Toggle width collapse
                            </button>
                        </p>
                        <div style="min-height: 112px;">
                            <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                <div class="card card-body mb-0" style="width: 300px;">
                                    This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

        </div>
        <!-- end row-->


        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Multiple Targets</h4>
                        <p class="text-muted fs-14 mb-3">
                            Multiple <code>&lt;button&gt;</code> or <code>&lt;a&gt;</code> can show and hide an element if
                            they each reference it with their <code>href</code> or <code>data-bs-target</code> attribute
                        </p>

                        <p>
                            <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Toggle second element</button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>
                        </p>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                    <div class="card card-body mb-0">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="collapse multi-collapse" id="multiCollapseExample2">
                                    <div class="card card-body mb-0">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->


    </div> <!-- container -->



    <!-- End Content-->
@endsection
