@extends('layouts.vertical', ['page_title' => $title ?? 'Buat Ujian', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'resources/css/ujian-themes.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.css">
    <style>
        .bg-soft-info {
            background-color: rgba(13, 202, 240, 0.15);
        }

        .bg-soft-secondary {
            background-color: rgba(108, 117, 125, 0.15);
        }

        .bg-light-subtle {
            background-color: #f8f9fa;
        }

        .shadow-sm {
            transition: box-shadow 0.2s ease-in-out;
        }

        .shadow-sm:hover {
            box-shadow: 0 0.4rem 0.8rem rgba(0, 0, 0, 0.06);
        }


        .action-icons {
            text-align: center
        }

        .action-icons a {
            font-size: 20px;
            margin-right: 20px;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        /* dragula */
        .section-item {
            border: 1px solid #e5e7eb;
            border-left: 3px solid #3B82F6;
            /* Garis biru */
            border-radius: 0.5rem;
            background-color: #fff;
        }

        .section-content {
            padding: 1rem 1.5rem;
        }

        .section-title {
            font-weight: 600;
            font-size: 1rem;
            color: #111827;
        }

        .section-drag-handle {
            color: #6c757d;
        }

        .cursor-grab {
            cursor: grab;
        }

        .chevron-toggle {
            height: 32px;
            width: 32px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: none;
            background-color: transparent;
            border-radius: 0.375rem;
            color: #6c757d;
            /* text-muted */
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .chevron-toggle:hover {
            background-color: #0d6efd;
            /* Bootstrap primary */
            color: #fff;
        }

        .section-toolbar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Question selection styles */
        .question-container {
            background-color: #f8f9fa;
        }

        .question-container .form-check {
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .question-container .form-check:hover {
            background-color: #e9ecef !important;
            border-color: #dee2e6 !important;
        }

        .question-container .form-check-input:checked+.form-check-label {
            color: #0d6efd;
            font-weight: 500;
        }

        .question-container .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .category-dropdown {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .category-dropdown:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .selected-count {
            font-weight: 600;
            color: #0d6efd;
        }

        .input-error {
            border: 1px solid red !important;
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ujian</a></li>
                            <li class="breadcrumb-item active">Buat Ujian</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ isset($ujian->id) ? 'Edit Ujian ' . $ujian->nama_ujian : 'Buat Ujian' }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="tabUjian" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                        type="button" role="tab" aria-controls="detail" aria-selected="true">
                        Detail Ujian
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="seksi-tab" data-bs-toggle="tab" data-bs-target="#seksi" type="button"
                        role="tab" aria-controls="seksi" aria-selected="false">
                        Seksi & Soal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="peserta-tab" data-bs-toggle="tab" data-bs-target="#peserta" type="button"
                        role="tab" aria-controls="peserta" aria-selected="false">
                        Data Peserta
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tampilan-tab" data-bs-toggle="tab" data-bs-target="#tampilan"
                        type="button" role="tab" aria-controls="tampilan" aria-selected="false">
                        Tampilan Ujian
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pengaturan-tab" data-bs-toggle="tab" data-bs-target="#pengaturan"
                        type="button" role="tab" aria-controls="pengaturan" aria-selected="false">
                        Pengaturan
                    </button>
                </li>
            </ul>

        </div>


        <!-- Konten Tab -->
        <div class="tab-content" id="tabUjianContent">
            <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                @include('ujian.ujian-tabs.detail')
            </div>
            <div class="tab-pane fade" id="seksi" role="tabpanel" aria-labelledby="seksi-tab">
                @include('ujian.ujian-tabs.seksi')
            </div>
            <div class="tab-pane fade" id="peserta" role="tabpanel" aria-labelledby="peserta-tab">
                @include('ujian.ujian-tabs.peserta')
            </div>
            <div class="tab-pane fade" id="tampilan" role="tabpanel" aria-labelledby="tampilan-tab">
                @include('ujian.ujian-tabs.tampilan')
            </div>
            <div class="tab-pane fade" id="pengaturan" role="tabpanel" aria-labelledby="pengaturan-tab">
                @include('ujian.ujian-tabs.pengaturan')
            </div>
        </div>
        <script>
            // Pass PHP data to JS
            window.ujian = @json($ujian ?? []);
            console.log(window.ujian);
            // You can now access window.ujian in buat-ujian.js
        </script>


        <!-- end row-->

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/main/buat-ujian.js'])
@endsection
