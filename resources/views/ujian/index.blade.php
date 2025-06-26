@extends('layouts.vertical', ['page_title' => 'Ujian', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ujian</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Ujian</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="tabUjian" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua"
                        type="button" role="tab">Semua Ujian</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif" type="button"
                        role="tab">Aktif</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft" type="button"
                        role="tab">Draft</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button"
                        role="tab">Selesai</button>
                </li>
            </ul>

            <!-- Tambah Soal Button -->
            <a href="{{ route('ujian.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i> Buat Ujian Baru
            </a>
        </div>

        <!-- Konten Tab -->
        <div class="tab-content" id="tabUjianContent">
            <div class="tab-pane fade show active" id="semua" role="tabpanel">
                @include('ujian.tabs.semua')
            </div>
            <div class="tab-pane fade" id="aktif" role="tabpanel">
                @include('ujian.tabs.aktif')
            </div>
            <div class="tab-pane fade" id="draft" role="tabpanel">
                @include('ujian.tabs.draft')
            </div>
            <div class="tab-pane fade" id="selesai" role="tabpanel">
                @include('ujian.tabs.selesai')
            </div>
        </div>

        <!-- end row-->

        {{-- Modal Konfirmasi Hapus --}}
        <div class="modal fade" id="modal-hapus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data ujian ini?</p>
                        {{-- <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="btn-hapus-confirm">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/main/ujian.js'])
@endsection
