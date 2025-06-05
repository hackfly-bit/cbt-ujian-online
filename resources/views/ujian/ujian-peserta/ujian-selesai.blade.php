@extends('layouts.app-simple')

@section('title', 'Ujian Selesai')

@section('css')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .completion-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 20px;
    }

    .completion-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        text-align: center;
        margin-bottom: 30px;
    }

    .success-icon {
        font-size: 80px;
        color: #4caf50;
        margin-bottom: 20px;
    }

    .completion-title {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .completion-subtitle {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
    }

    .exam-info {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        text-align: left;
    }

    .exam-info h3 {
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #555;
        flex: 1;
    }

    .info-value {
        font-weight: bold;
        color: #333;
        flex: 1;
        text-align: right;
    }

    .score-highlight {
        background: linear-gradient(135deg, #4caf50, #45a049);
        color: white;
        padding: 20px;
        border-radius: 15px;
        margin: 20px 0;
        text-align: center;
    }

    .score-highlight .score-number {
        font-size: 48px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .score-highlight .score-label {
        font-size: 16px;
        opacity: 0.9;
    }

    .section-results {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .section-results h3 {
        color: #333;
        margin-bottom: 25px;
        font-size: 24px;
        font-weight: bold;
    }

    .section-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 5px solid #2196f3;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .section-name {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .section-score {
        font-size: 20px;
        font-weight: bold;
        color: #4caf50;
    }

    .section-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .stat-item {
        text-align: center;
        padding: 12px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #2196f3;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .progress-bar {
        background: #e9ecef;
        border-radius: 10px;
        height: 8px;
        margin: 10px 0;
        overflow: hidden;
    }

    .progress-fill {
        background: linear-gradient(90deg, #4caf50, #45a049);
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .action-buttons {
        text-align: center;
        margin-top: 40px;
    }

    .btn {
        display: inline-block;
        padding: 12px 30px;
        margin: 0 10px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .completion-time {
        background: #e3f2fd;
        border-radius: 12px;
        padding: 15px;
        margin: 20px 0;
        border-left: 4px solid #2196f3;
    }

    .completion-time strong {
        color: #1976d2;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .completion-container {
            margin: 20px auto;
            padding: 10px;
        }

        .completion-card {
            padding: 30px 20px;
        }

        .completion-title {
            font-size: 28px;
        }

        .section-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .info-value {
            text-align: left;
            margin-top: 5px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .completion-card, .section-results {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Print Styles */
    @media print {
        body {
            background: white !important;
        }

        .action-buttons {
            display: none;
        }

        .completion-card, .section-results, .exam-info {
            box-shadow: none !important;
            border: 1px solid #ddd;
        }
    }
</style>
@endsection

@section('content')
<div class="completion-container">
    <!-- Success Card -->
    <div class="completion-card">
        <div class="success-icon">🎉</div>
        <h1 class="completion-title">Ujian Berhasil Diselesaikan!</h1>
        <p class="completion-subtitle">Terima kasih telah mengikuti ujian dengan baik</p>

        <!-- Overall Score -->
        @if(isset($examSummary))
        <div class="score-highlight">
            <div class="score-number">{{ $examSummary['total_score'] }}%</div>
            <div class="score-label">Nilai Keseluruhan</div>
        </div>
        @endif
    </div>

    <!-- Exam Information -->
    @if(isset($examSummary))
    <div class="exam-info">
        <h3>📋 Informasi Ujian</h3>
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
            <span class="info-value">{{ $examSummary['total_answered'] }} soal ({{ $examSummary['completion_percentage'] }}%)</span>
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
        <strong>⏰ Waktu Penyelesaian:</strong><br>
        Mulai: {{ $examSummary['exam_start_time']->format('d/m/Y H:i:s') }}<br>
        Selesai: {{ $examSummary['exam_end_time']->format('d/m/Y H:i:s') }}
    </div>

    <!-- Section Results -->
    @if(isset($examSummary['section_results']) && count($examSummary['section_results']) > 0)
    <div class="section-results">
        <h3>📊 Hasil Per Section</h3>

        @foreach($examSummary['section_results'] as $section)
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
        <h3>✅ Ujian Selesai</h3>
        <p style="text-align: center; color: #666; font-size: 16px;">
            {{ $message ?? 'Ujian telah selesai. Terima kasih atas partisipasi Anda.' }}
        </p>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ url('/') }}" class="btn btn-primary">🏠 Kembali ke Beranda</a>
        <button onclick="window.print()" class="btn btn-secondary">🖨️ Cetak Hasil</button>
    </div>
</div>
@endsection

@section('script')
<script>
    // Prevent going back to exam
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
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
