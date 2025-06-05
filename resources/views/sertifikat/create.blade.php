@extends('layouts.vertical', ['page_title' => 'Bank Soal', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
    <style>
        .template-card {
            border: 2px solid transparent;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .template-card.selected {
            border-color: #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);
        }

        .template-card.selected .checkmark {
            display: block !important;
        }

        .checkmark {
            display: none;
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Sertifikat</a></li>
                            <li class="breadcrumb-item active">Buat Sertifikat</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Buat Sertifikat</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title">Daftar Semua Template Sertifikat</h4>

                        <form action="{{ route('sertifikat.store') }}" method="POST" id="formSertifikat">
                            @csrf
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Sertifikat</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    placeholder="Masukkan judul sertifikat" required>
                            </div>

                            <div class="mb-3">
                                <label for="ujian_id" class="form-label">Pilih Ujian</label>
                                <select class="form-select" id="ujian_id" name="ujian_id">
                                    <option value="">Tanpa Ujian (opsional)</option>
                                    @foreach ($ujians as $ujian)
                                        <option value="{{ $ujian->id }}">{{ $ujian->nama ?? 'Ujian #' . $ujian->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="d-flex flex-nowrap overflow-auto">
                                    @if (count($templates) > 0)
                                        @foreach ($templates as $template)
                                            <div class="col-md-3" style="min-width: 250px;">
                                                <div class="card template-card position-relative me-3"
                                                    data-template-json='@json($template['content'])'>

                                                    <img src="{{ $template['image'] }}" class="card-img-top"
                                                        alt="{{ $template['name'] }}"
                                                        onerror="this.src='{{ asset('images/placeholder.png') }}'">

                                                    <div class="card-body text-center">
                                                        <h6 class="card-title mb-0">{{ $template['name'] }}</h6>
                                                    </div>

                                                    <!-- Icon centang -->
                                                    <div class="checkmark position-absolute top-0 end-0 m-2 d-none">
                                                        <span class="badge bg-primary rounded-circle p-2">
                                                            <i class="bi bi-check-lg text-white"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center">
                                            <p class="text-muted">Tidak ada template tersedia.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Ini input hidden yang akan menyimpan JSON dari template yang dipilih -->
                            <input type="hidden" id="template" name="template" required>

                            <button type="submit" class="btn btn-primary ">Add Sertifikat</button>
                        </form>



                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>


        <!-- end row-->

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/main/list-sertifikat.js'])
@endsection
