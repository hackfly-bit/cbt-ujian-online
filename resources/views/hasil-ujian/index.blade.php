@extends('layouts.vertical', ['page_title' => 'Hasil Ujian', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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

        .badge-status {
            font-size: 12px;
            padding: 4px 8px;
        }

        .modal-certificate {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .certificate-container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .certificate-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="%23f0f0f0"/><circle cx="80" cy="80" r="1" fill="%23f0f0f0"/><circle cx="40" cy="60" r="1" fill="%23f0f0f0"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.1;
            pointer-events: none;
        }

        .certificate-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .certificate-subtitle {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .certificate-name {
            font-size: 2rem;
            font-weight: bold;
            color: #2980b9;
            margin: 20px 0;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            display: inline-block;
        }

        .certificate-course {
            font-size: 1.5rem;
            color: #2c3e50;
            margin: 20px 0;
        }

        .certificate-score {
            font-size: 1.8rem;
            font-weight: bold;
            color: #e74c3c;
            margin: 20px 0;
        }

        .certificate-date {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-top: 30px;
        }

        .certificate-seal {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #f39c12, #e67e22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            border: 4px solid #d35400;
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
                                <h4 class="header-title">Daftar Hasil Ujian</h4>
                                <p class="text-muted fs-14 mb-0">
                                    Berikut ini adalah daftar hasil ujian semua peserta, lengkap dengan skor, waktu
                                    penyelesaian, dan sertifikat.
                                </p>
                            </div>
                            <div>
                                <a href="javascript:void(0)" id="btn-download-results" class="btn btn-primary">
                                    <i class="ri-download-line me-1"></i> Download Hasil Ujian
                                </a>
                            </div>
                        </div>

                        <table id="hasil-ujian-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Peserta</th>
                                    <th>Ujian</th>
                                    <th class="text-center">Waktu Selesai</th>
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

        {{-- Modal Detail Hasil Ujian --}}
        <div class="modal fade" id="modal-detail" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Hasil Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detail-content">
                            <!-- Content will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Sertifikat -->
        <div class="modal fade" id="modal-certificate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" style="padding: 30px;">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview Sertifikat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- LEFT PANEL -->
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <strong>Ujian:</strong><br>
                                    <span class="text-muted" id="certificate-ujian">-</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Nama Peserta:</strong><br>
                                    <span class="text-muted" id="peserta-name">-</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Tanggal Ujian:</strong><br>
                                    <span class="text-muted" id="tanggal-ujian">-</span>
                                </div>
                                <div class="mb-3">
                                    <strong>Status Template:</strong><br>
                                    <span class="badge" id="certificate-status">-</span>
                                </div>
                                <div class="mt-4 d-grid gap-2">
                                    <a href="javascript:void(0)" id="btn-download-certificate" class="btn btn-primary">
                                        <i class="ri-download-2-line me-1"></i> Download PNG
                                    </a>

                                    <a href="javascript:void(0)" id="btn-download-pdf" class="btn btn-danger">
                                        <i class="ri-file-pdf-line me-1"></i> Download PDF
                                    </a>


                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>

                            <!-- RIGHT PANEL -->
                            <div class="col-md-10">
                                <div class="border rounded bg-white p-4 d-flex flex-column align-items-center justify-content-center"
                                    style="min-height: 600px; overflow: auto;">
                                    <div id="certificate-content"
                                        class="w-100 d-flex justify-content-center align-items-center"
                                        style="min-height: 500px;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /row -->
                    </div> <!-- /modal-body -->
                </div>
            </div>
        </div>



    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/main/hasil-ujian.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
@endsection
