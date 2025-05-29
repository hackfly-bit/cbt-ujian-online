@extends('layouts.vertical', ['page_title' => 'Buat Ujian', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.css">


    <style>
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ujian</a></li>
                            <li class="breadcrumb-item active">Buat Ujian</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Buat Ujian</h4>
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
            <div class="tab-pane fade" id="pengaturan" role="tabpanel" aria-labelledby="pengaturan-tab">
                @include('ujian.ujian-tabs.pengaturan')
            </div>
        </div>


        <!-- end row-->

    </div>
    <!-- container -->
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/main/buat-ujian.js'])
@endsection
