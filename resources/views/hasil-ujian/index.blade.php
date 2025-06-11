@extends('layouts.vertical', ['page_title' => 'Bank Soal', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Hasil Ujian</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Hasil Ujian</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="header-title">Daftar Semua Ujian</h4>
                                <p class="text-muted fs-14 mb-0">
                                    Berikut ini adalah daftar semua ujian, lengkap dengan status, soal, durasi, peserta dan
                                    aksi
                                    yang dapat dilakukan.
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('ujian.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line me-1"></i> Download Hasil Ujian
                                </a>
                            </div>
                        </div>

                        <table id="selection-datatable-ujian-semua" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Peserta</th>
                                    <th>Ujian</th>
                                    <th class="text-center">Waktu</th>
                                    <th class="text-center">Skor</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>


                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
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
    {{-- @vite(['resources/js/main/ujian.js']) --}}
@endsection
