<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .result-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header-section {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .score-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            color: #4facfe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .info-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #4facfe;
        }
        .section-score {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }
        .print-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        @media print {
            body {
                background: white !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="result-card">
                    <!-- Header Section -->
                    <div class="header-section">
                        <div class="score-circle">
                            {{ $hasil_ujian['hasil']['hasil_nilai'] }}
                        </div>
                        <h2 class="mb-2">{{ $hasil_ujian['peserta']['nama'] }}</h2>
                        <p class="mb-0 opacity-75">{{ $hasil_ujian['ujian']['nama_ujian'] }}</p>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4">
                        <!-- Informasi Peserta -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-user-line me-2 text-primary"></i>
                                        <strong>Informasi Peserta</strong>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-1"><strong>Nama:</strong> {{ $hasil_ujian['peserta']['nama'] }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $hasil_ujian['peserta']['email'] }}</p>
                                        @if($hasil_ujian['peserta']['phone'])
                                        <p class="mb-1"><strong>Telepon:</strong> {{ $hasil_ujian['peserta']['phone'] }}</p>
                                        @endif
                                        @if($hasil_ujian['peserta']['institusi'])
                                        <p class="mb-0"><strong>Institusi:</strong> {{ $hasil_ujian['peserta']['institusi'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-file-text-line me-2 text-primary"></i>
                                        <strong>Informasi Ujian</strong>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-1"><strong>Nama Ujian:</strong> {{ $hasil_ujian['ujian']['nama_ujian'] }}</p>
                                        @if($hasil_ujian['ujian']['deskripsi'])
                                        <p class="mb-0"><strong>Deskripsi:</strong> {{ $hasil_ujian['ujian']['deskripsi'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hasil Ujian -->
                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-bar-chart-line me-2 text-primary"></i>
                                <strong>Hasil Ujian</strong>
                            </div>
                            <div class="row ms-3">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <div class="h4 text-primary mb-1">{{ $hasil_ujian['hasil']['total_soal'] }}</div>
                                        <small class="text-muted">Total Soal</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <div class="h4 text-success mb-1">{{ $hasil_ujian['hasil']['soal_dijawab'] }}</div>
                                        <small class="text-muted">Soal Dijawab</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <div class="h4 text-info mb-1">{{ $hasil_ujian['hasil']['jawaban_benar'] }}</div>
                                        <small class="text-muted">Jawaban Benar</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="text-center">
                                        <div class="h4 text-warning mb-1">{{ $hasil_ujian['hasil']['durasi_pengerjaan'] }}</div>
                                        <small class="text-muted">Durasi</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Section (jika ada) -->
                        @if($hasil_ujian['detail_section'] && count($hasil_ujian['detail_section']) > 0)
                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-list-check-line me-2 text-primary"></i>
                                <strong>Detail Nilai per Bagian</strong>
                            </div>
                            <div class="ms-3">
                                @foreach($hasil_ujian['detail_section'] as $section)
                                <div class="section-score">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">{{ $section['section_name'] }}</span>
                                        <span class="badge bg-primary rounded-pill">{{ number_format($section['score'], 2) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Waktu Ujian -->
                        <div class="info-item mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-time-line me-2 text-primary"></i>
                                <strong>Waktu Ujian</strong>
                            </div>
                            <div class="ms-3">
                                <p class="mb-1"><strong>Mulai:</strong> {{ $hasil_ujian['waktu']['waktu_mulai'] }}</p>
                                <p class="mb-0"><strong>Selesai:</strong> {{ $hasil_ujian['waktu']['waktu_selesai'] }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="text-center no-print">
                            <button onclick="window.print()" class="btn print-btn me-2">
                                <i class="ri-printer-line me-2"></i>Cetak Hasil
                            </button>
                            @if($hasil_ujian['sertifikat_available'])
                            <a href="#" class="btn btn-outline-success rounded-pill px-4">
                                <i class="ri-award-line me-2"></i>Lihat Sertifikat
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4 no-print">
                    <p class="text-white-50 mb-0">
                        <i class="ri-shield-check-line me-1"></i>
                        Hasil ujian ini telah diverifikasi dan sah
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>