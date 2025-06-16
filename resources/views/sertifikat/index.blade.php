@extends('layouts.vertical', ['page_title' => 'Bank Soal', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        {{-- Pesan Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Pesan Gagal --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validasi error (jika ada error dari $errors Laravel) --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-x-circle me-2"></i>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attex</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sertifikat</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List Sertifikat</h4>
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
                                <h4 class="header-title">Daftar Semua Template Sertifikat</h4>
                                <p class="text-muted fs-14">
                                    Berikut ini adalah daftar semua ujian, lengkap dengan status, soal, durasi, peserta dan
                                    aksi
                                    yang dapat dilakukan.
                                </p>
                            </div>
                            <!-- Tambah Soal Button -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah-sertifikat">
                                <i class="ri-add-line me-1"></i> Buat Sertifikat Custom
                            </button>

                            <!-- Modal Tambah Sertifikat -->
                            <div class="modal fade" id="modal-tambah-sertifikat" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Template Sertifikat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('sertifikat.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="judul" class="form-label">Judul Sertifikat</label>
                                                    <input type="text" class="form-control" id="judul" name="judul"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="ujian_id" class="form-label">Pilih Ujian</label>
                                                    {{-- <input type="text" class="form-control" id="ujian_id" name="ujian_id"> --}}
                                                    <select name="ujian_id" id="ujian_id" class="form-select" required>
                                                        <option value="">Pilih Ujian</option>
                                                        @foreach (App\Models\Ujian::all() as $ujian)
                                                            <option value="{{ $ujian->id }}">{{ $ujian->nama_ujian }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- <div class="mb-3">
                                                    <label for="ujian_id" class="form-label">Pilih Ujian</label>
                                                    <select class="form-select" id="ujian_id" name="ujian_id" required>
                                                        <option value="">Pilih Ujian</option>
                                                        <option value="1">TOALF (Test of Academic Language Fluency)
                                                        </option>
                                                        <option value="2">TOEFL (Test of English as a Foreign Language)
                                                        </option>
                                                    </select>
                                                </div> --}}
                                                {{-- <div class="mb-3">
                                                    <label for="ujian_id" class="form-label">Pilih Ujian</label>
                                                    <select class="form-select" id="ujian_id" name="ujian_id" required>
                                                        <option value="">Pilih Ujian</option>
                                                        @foreach ($ujians as $ujian)
                                                            <option value="{{ $ujian->id }}">{{ $ujian->nama_ujian }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <input type="hidden" name="is_custom" id="is_custom" value="1">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Buka Canvas</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('sertifikat.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Template
                            </a>
                        </div>

                        <!-- FILTERS -->
                        <div id="custom-filters-ujian-semua" class="mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <select id="filter-category-ujian-semua" class="form-select form-select-sm"
                                    style="min-width: 200px;" title="Filter by category">
                                    <option value="">All</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>

                        <table id="selection-datatable-ujian-semua"
                            class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Ujian</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Soal</th>
                                    <th class="text-center">Durasi</th>
                                    <th class="text-center">Peserta</th>
                                    <th class="text-center">Tanggal Selesai</th>
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
    @vite(['resources/js/main/list-sertifikat.js'])
@endsection
