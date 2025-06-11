@extends('layouts.vertical', ['page_title' => 'Dashboard', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'])
    <style>
        .stat-icon {
            width: 60px;
            height: 60px;
        }

        .quick-action-icon {
            width: 70px;
            height: 70px;
        }

        .icon-size-28 {
            font-size: 28px;
        }

        .icon-size-32 {
            font-size: 32px;
        }

        .bg-blue-light {
            background-color: #e7f1ff;
        }

        .bg-green-light {
            background-color: #d6ffe6;
        }

        .bg-purple-light {
            background-color: #f6e7ff;
        }

        .bg-nature-light {
            background-color: #f1ffe7;
        }

        .bg-yellow-light {
            background-color: #fff8e1;
        }

        .text-blue {
            color: #0d6efd;
        }

        .text-green {
            color: #198754;
        }

        .text-purple {
            color: #6f42c1;
        }

        .text-success-dark {
            color: #28a745;
        }

        .text-warning {
            color: #ffc107;
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>

        <!-- Statistik Atas -->
        <div class="row g-3 mb-3">
            <div class="col-md-3 col-6">
                <div class="border rounded p-4 d-flex align-items-center gap-4 bg-white shadow-sm">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 stat-icon bg-blue-light">
                        <i class="ri-file-list-3-line icon-size-28 text-blue"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3">3</div>
                        <div class="text-muted">Total Ujian</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="border rounded p-4 d-flex align-items-center gap-4 bg-white shadow-sm">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 stat-icon bg-green-light">
                        <i class="ri-book-2-line icon-size-28 text-green"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3">6</div>
                        <div class="text-muted">Bank Soal</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="border rounded p-4 d-flex align-items-center gap-4 bg-white shadow-sm">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 stat-icon bg-purple-light">
                        <i class="ri-group-line icon-size-28 text-purple"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3">0</div>
                        <div class="text-muted">Peserta</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="border rounded p-4 d-flex align-items-center gap-4 bg-white shadow-sm">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 stat-icon bg-nature-light">
                        <i class="ri-checkbox-circle-line icon-size-28 text-success-dark"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-3">0</div>
                        <div class="text-muted">Selesai Ujian</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Ujian Terbaru -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Ujian Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr class="text-muted">
                                <th class="py-3">Nama Ujian</th>
                                <th class="py-3 text-center">Tanggal</th>
                                <th class="py-3 text-center">Peserta</th>
                                <th class="py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3">TEST</td>
                                <td class="py-3 text-center">22 Mei 2025</td>
                                <td class="py-3 text-center">3</td>
                                <td class="py-3 text-center">
                                    <span class="badge text-success px-4 py-2 rounded-md bg-green-light">Aktif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3">TOAFL 11 Juni</td>
                                <td class="py-3 text-center">22 Mei 2025</td>
                                <td class="py-3 text-center">3</td>
                                <td class="py-3 text-center">
                                    <span class="badge text-success px-4 py-2 rounded-md bg-green-light">Aktif</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3">toafl 11 april</td>
                                <td class="py-3 text-center">20 Mei 2025</td>
                                <td class="py-3 text-center">2</td>
                                <td class="py-3 text-center">
                                    <span class="badge text-success px-4 py-2 rounded-md bg-green-light">Aktif</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Aksi Cepat</h5>
                <div class="row g-4">
                    <div class="col-md-4 col-6">
                        <a href="#" class="text-decoration-none text-dark d-block text-center p-4 border rounded h-100 shadow-sm hover-shadow">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3 quick-action-icon bg-blue-light">
                                <i class="ri-edit-2-line icon-size-32 text-blue"></i>
                            </div>
                            <div class="fs-5 fw-semibold">Buat Ujian Baru</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="#" class="text-decoration-none text-dark d-block text-center p-4 border rounded h-100 shadow-sm hover-shadow">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3 quick-action-icon bg-green-light">
                                <i class="ri-add-line icon-size-32 text-success-dark"></i>
                            </div>
                            <div class="fs-5 fw-semibold">Tambah Soal</div>
                        </a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="#" class="text-decoration-none text-dark d-block text-center p-4 border rounded h-100 shadow-sm hover-shadow">
                            <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3 quick-action-icon bg-yellow-light">
                                <i class="ri-bar-chart-2-line icon-size-32 text-warning"></i>
                            </div>
                            <div class="fs-5 fw-semibold">Lihat Laporan</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.dashboard.js'])
@endsection
