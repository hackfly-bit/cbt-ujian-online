@extends('layouts.vertical', ['page_title' => 'Bootstrap Icons', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Icons</a></li>
                            <li class="breadcrumb-item active">Bootstrap Icons</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bootstrap Icons</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Icons</h5>
                        <p class="text-muted mb-2">Use class <code>&lt;i class=&quot;bi bi-123&quot;&gt;&lt;/i&gt;</code></p>
                        <div class="row icons-list-demo" id="bootstrap-icons"></div>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.bootstrapicons.js'])
@endsection
