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
                            <li class="breadcrumb-item active">Bank Soal</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bank Soal</h4>
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
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-bank-soal">
                <i class="ri-add-line me-1"></i> Buat Ujian Baru
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


        {{-- modal Create And Update --}}
        <div class="modal fade" id="tambah-bank-soal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Tambah Soal Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <form id="form-bank-soal" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="soal-id" name="soal_id">
                            <input type="hidden" id="form-method" name="_method" value="POST">
                            <div class="row">
                                <!-- Jenis Font -->
                                <div class="col-md-12 mb-3">
                                    <label for="jenis_font" class="form-label">Jenis Font <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select mb-1" id="jenis_font" name="jenis_font" required>
                                        <option value="">Pilih Jenis Font</option>
                                        <option value="Latin">Latin</option>
                                        <option value="Arab (RTL)">Arab (RTL)</option>
                                    </select>
                                    <span>Pilih "Arab" untuk menulis soal dengan huruf Arab (teks dari kanan ke
                                        kiri)</span>
                                </div>

                                <!-- Pertanyaan -->
                                <div class="col-12 mb-3">
                                    <label for="pertanyaan" class="form-label">Pertanyaan <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control mb-1" id="pertanyaan" name="pertanyaan" rows="4" required></textarea>
                                    <span>Teks pertanyaan yang akan ditampilkan kepada peserta</span>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <!-- Soal Dengan Audio -->
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_audio"
                                                    name="is_audio" value="1">
                                                <label class="form-check-label mb-1" for="is_audio">
                                                    Soal Dengan Audio
                                                </label>
                                            </div>
                                            <span>Centang jika soal ini memerlukan file audio</span>
                                        </div>

                                        <!-- Audio File -->
                                        <div class="col-md-6" id="audio-file-container" style="display: none;">
                                            <label for="audio_file" class="form-label">File Audio</label>
                                            <input type="file" class="form-control" id="audio_file" name="audio_file"
                                                accept=".mp3,.wav,.ogg">
                                            <small class="text-muted">Format yang didukung: MP3, WAV, OGG (Max:
                                                10MB)</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jenis Soal -->
                                <div class="col-md-12 mb-3">
                                    <label for="jenis_soal" class="form-label">Jenis Soal <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="jenis_soal" name="jenis_soal" required>
                                        <option value="">Pilih Jenis Soal</option>
                                        <option value="pilihan_ganda">Pilihan Ganda</option>
                                        <option value="benar_salah">Benar/Salah</option>
                                        <option value="isian">Isian</option>
                                    </select>
                                </div>

                                <!-- Jawaban Soal -->
                                <div id="jawaban-wrapper" class="col-12 mb-3 d-none">
                                    <label class="form-label">Jawaban Soal <span class="text-danger">*</span></label>
                                    <div id="jawaban-container">
                                        <!-- Dynamic content based on jenis_soal -->
                                    </div>
                                </div>


                                <!-- Tingkat Kesulitan -->
                                <div class="col-md-4 mb-3">
                                    <label for="tingkat_kesulitan" class="form-label">Tingkat Kesulitan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="tingkat_kesulitan" name="tingkat_kesulitan_id"
                                        required>
                                        <option value="">Pilih Tingkat Kesulitan</option>
                                    </select>
                                </div>

                                <!-- Kategori -->
                                <div class="col-md-4 mb-3">
                                    <label for="kategori" class="form-label">Kategori <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="kategori" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                    </select>
                                </div>

                                <!-- Sub Kategori -->
                                <div class="col-md-4 mb-3">
                                    <label for="sub_kategori" class="form-label">Sub Kategori</label>
                                    <select class="form-select" id="sub_kategori" name="sub_kategori_id">
                                        <option value="">Pilih Sub Kategori</option>
                                    </select>
                                </div>



                                <!-- Penjelasan Jawaban -->
                                <div class="col-12 mb-3">
                                    <label for="penjelasan_jawaban" class="form-label">Penjelasan Jawaban</label>
                                    <textarea class="form-control" id="penjelasan_jawaban" name="penjelasan_jawaban" rows="3"></textarea>
                                </div>

                                <!-- Tag -->
                                <div class="col-12 mb-3">
                                    <label for="tag" class="form-label">Tag</label>
                                    <input type="text" class="form-control" id="tag" name="tag"
                                        placeholder="Pisahkan dengan koma (,)">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                            Simpan
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        {{-- Modal Konfirmasi Hapus --}}
        <div class="modal fade" id="modal-hapus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus soal ini?</p>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
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
    @vite(['resources/js/main/bank-soal.js'])
@endsection
