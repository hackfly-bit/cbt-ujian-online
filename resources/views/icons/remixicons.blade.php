@extends('layouts.vertical', ['page_title' => 'Remix Icons', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item active">Remix Icons</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Remix Icons</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12" id="icons"></div> <!-- end col-->
        </div><!-- end row -->
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.remixicons.js'])
@endsection
