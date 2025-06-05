@extends('layouts.app-simple')

@section('title', 'Ujian Selesai')

@section('css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .completion-container {
            max-width: 860px;
            margin: 60px auto;
            padding: 20px;
        }

        .completion-card {
            background: #fff;
            border-radius: 16px;
            padding: 36px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 30px;
            animation: fadeInUp 0.6s ease-out;
        }

        .success-icon {
            font-size: 64px;
            color: #4caf50;
            margin-bottom: 16px;
        }

        .completion-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .completion-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 24px;
        }

        .exam-info {
            background: #f9fafb;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            text-align: left;
        }

        .exam-info h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #555;
            flex: 1;
        }

        .info-value {
            font-weight: 600;
            color: #222;
            flex: 1;
            text-align: right;
        }

        .score-highlight {
            background: #4caf50;
            color: #fff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin: 20px 0;
        }

        .score-number {
            font-size: 40px;
            font-weight: 700;
        }

        .score-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .section-results {
            background: #fff;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease-out;
        }

        .section-results h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        .section-card {
            background: #f5f7fa;
            border-left: 4px solid #2196f3;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .section-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .section-score {
            font-size: 18px;
            color: #4caf50;
        }

        .section-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 12px;
        }

        .stat-item {
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 600;
            color: #2196f3;
        }

        .stat-label {
            font-size: 11px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .progress-bar {
            background: #e0e0e0;
            height: 8px;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            background: #4caf50;
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }

        .action-buttons {
            text-align: center;
            margin-top: 36px;
        }

        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 20px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin: 0 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: #2196f3;
            color: #fff;
        }

        .btn-primary:hover {
            background: #1976d2;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .completion-time {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 24px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 16px;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .completion-container {
                padding: 10px;
                margin: 20px auto;
            }

            .completion-title {
                font-size: 24px;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-value {
                text-align: left;
                margin-top: 4px;
            }

            .section-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Print */
        @media print {
            body {
                background: #fff !important;
            }

            .action-buttons {
                display: none;
            }

            .completion-card,
            .section-results,
            .exam-info {
                box-shadow: none !important;
                border: 1px solid #ccc;
            }
        }
    </style>
@endsection

@section('content')
    <div class="completion-container">
        <!-- Success Card -->
        <div class="completion-card">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px" y="0px" viewBox="0 0 117.72 117.72"
                style="enable-background:new 0 0 117.72 117.72; width: 120px; height: 120px;" xml:space="preserve">
                <style type="text/css">
                    <![CDATA[
                    .st0 {
                        fill: #4caf50;
                    }
                    ]]>
                </style>
                <g>
                    <path class="st0"
                        d="M58.86,0c9.13,0,17.77,2.08,25.49,5.79c-3.16,2.5-6.09,4.9-8.82,7.21c-5.2-1.89-10.81-2.92-16.66-2.92 c-13.47,0-25.67,5.46-34.49,14.29c-8.83,8.83-14.29,21.02-14.29,34.49c0,13.47,5.46,25.66,14.29,34.49 c8.83,8.83,21.02,14.29,34.49,14.29s25.67-5.46,34.49-14.29c8.83-8.83,14.29-21.02,14.29-34.49c0-3.2-0.31-6.34-0.9-9.37 c2.53-3.3,5.12-6.59,7.77-9.85c2.08,6.02,3.21,12.49,3.21,19.22c0,16.25-6.59,30.97-17.24,41.62 c-10.65,10.65-25.37,17.24-41.62,17.24c-16.25,0-30.97-6.59-41.62-17.24C6.59,89.83,0,75.11,0,58.86 c0-16.25,6.59-30.97,17.24-41.62S42.61,0,58.86,0L58.86,0z M31.44,49.19L45.8,49l1.07,0.28c2.9,1.67,5.63,3.58,8.18,5.74 c1.84,1.56,3.6,3.26,5.27,5.1c5.15-8.29,10.64-15.9,16.44-22.9c6.35-7.67,13.09-14.63,20.17-20.98l1.4-0.54H114l-3.16,3.51 C101.13,30,92.32,41.15,84.36,52.65C76.4,64.16,69.28,76.04,62.95,88.27l-1.97,3.8l-1.81-3.87c-3.34-7.17-7.34-13.75-12.11-19.63 c-4.77-5.88-10.32-11.1-16.79-15.54L31.44,49.19L31.44,49.19z" />
                </g>
            </svg>
            <h1 class="completion-title mt-3">Ujian Berhasil Diselesaikan!</h1>
            <p class="completion-subtitle">Terima kasih telah mengikuti ujian dengan baik</p>

            <!-- Overall Score -->
            @if (isset($examSummary))
                <div class="score-highlight">
                    <div class="score-number">{{ $examSummary['total_score'] }}%</div>
                    <div class="score-label">Nilai Keseluruhan</div>
                </div>
            @endif
        </div>

        <!-- Exam Information -->
        @if (isset($examSummary))
            <div class="exam-info">
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-survey-line me-2 fs-3"></i>
                    <h3 class="mb-0">Informasi Ujian</h3>
                </div>

                <div class="info-row">
                    <span class="info-label">Nama Ujian:</span>
                    <span class="info-value">{{ $examSummary['ujian_name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Peserta:</span>
                    <span class="info-value">{{ $examSummary['peserta_name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $examSummary['peserta_email'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Section:</span>
                    <span class="info-value">{{ $examSummary['total_sections'] }} section</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Soal:</span>
                    <span class="info-value">{{ $examSummary['total_questions'] }} soal</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Soal Dijawab:</span>
                    <span class="info-value">{{ $examSummary['total_answered'] }} soal
                        ({{ $examSummary['completion_percentage'] }}%)</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jawaban Benar:</span>
                    <span class="info-value">{{ $examSummary['total_correct'] }} jawaban</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Durasi Pengerjaan:</span>
                    <span class="info-value">{{ $examSummary['exam_duration_minutes'] }} menit</span>
                </div>
            </div>

            <!-- Completion Time Info -->
            <div class="completion-time">
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-time-line me-2 fs-4"></i>
                    <h5 class="mb-0">Waktu Penyelesaian:</h5>
                </div>
                <div class="text-base">
                    Mulai: {{ $examSummary['exam_start_time']->format('d/m/Y H:i:s') }} | Selesai:
                    {{ $examSummary['exam_end_time']->format('d/m/Y H:i:s') }}
                </div>
            </div>

            <!-- Section Results -->
            @if (isset($examSummary['section_results']) && count($examSummary['section_results']) > 0)
                <div class="section-results">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ri-bar-chart-line me-2 fs-3"></i>
                        <h3 class="mb-0">Hasil Per Section</h3>
                    </div>

                    @foreach ($examSummary['section_results'] as $section)
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-name">
                                    {{ $section['section_name'] }}
                                </div>
                                <div class="section-score">
                                    {{ $section['score_percentage'] }}%
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $section['completion_percentage'] }}%;"></div>
                            </div>

                            <!-- Section Statistics -->
                            <div class="section-stats">
                                <div class="stat-item">
                                    <div class="stat-value">{{ $section['total_questions'] }}</div>
                                    <div class="stat-label">Total Soal</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $section['answered_questions'] }}</div>
                                    <div class="stat-label">Dijawab</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $section['correct_answers'] }}</div>
                                    <div class="stat-label">Benar</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ $section['completion_percentage'] }}%</div>
                                    <div class="stat-label">Kelengkapan</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <!-- Fallback for simple completion message -->
            <div class="exam-info">
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-checkbox-circle-line me-2 fs-3"></i>
                    <h3 class="mb-0">Ujian Selesai</h3>
                </div>
                <p style="text-align: center; color: #666; font-size: 16px;">
                    {{ $message ?? 'Ujian telah selesai. Terima kasih atas partisipasi Anda.' }}
                </p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
            <button onclick="window.print()" class="btn btn-secondary">Cetak Hasil</button>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Prevent going back to exam
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        // Auto-scroll animation
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll to show all content
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endsection
