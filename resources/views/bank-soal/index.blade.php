@extends('layouts.vertical', ['page_title' => 'Profile', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])

    <style>
        .action-icons {
            text-align: center
        }

        .action-icons a {
            font-size: 20px;
            margin-right: 20px;
            transition: color 0.2s ease, transform 0.2s ease;
        }
    </style>
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Profile</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="tabKategori" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua"
                        type="button" role="tab">Semua Soal</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reading-tab" data-bs-toggle="tab" data-bs-target="#reading" type="button"
                        role="tab">Reading</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="listening-tab" data-bs-toggle="tab" data-bs-target="#listening"
                        type="button" role="tab">Listening</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="grammar-tab" data-bs-toggle="tab" data-bs-target="#grammar" type="button"
                        role="tab">Grammar</button>
                </li>
            </ul>

            <!-- Tambah Soal Button -->
            <a href="" class="btn btn-primary">
                <i class="ri-add-line me-1"></i> Tambah Soal
            </a>
        </div>

        <div class="tab-content" id="tabKategoriContent">
            <div class="tab-pane fade show active" id="semua" role="tabpanel">
                @include('bank-soal.tabs.semua')
            </div>
            <div class="tab-pane fade" id="reading" role="tabpanel">
                @include('bank-soal.tabs.reading')
            </div>
            <div class="tab-pane fade" id="listening" role="tabpanel">
                @include('bank-soal.tabs.listening')
            </div>
            <div class="tab-pane fade" id="grammar" role="tabpanel">
                @include('bank-soal.tabs.grammar')
            </div>
        </div>
        
        <!-- end row-->

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.datatable-init.js'])
    @vite(['resources/js/pages/demo.datatable-custom.js'])
@endsection
