@extends('layouts.app-simple')

@section('title', 'الاختبار مكتمل')

@section('css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <style>
        body {
            background-color: {{ $ujian->ujianThema && $ujian->ujianThema->background_color ? $ujian->ujianThema->background_color : '#f8f9fa' }};
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            direction: rtl;

            @if ($ujian->ujianThema && $ujian->ujianThema->background_image_path)
                background-image: url('{{ asset('storage/' . $ujian->ujianThema->background_image_path) }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            @endif
        }

        .bento-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: auto auto auto auto;
            gap: 24px;
            animation: fadeInUp 0.8s ease-out;
        }

        .bento-card {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->header_color ? $ujian->ujianThema->header_color : 'rgba(255, 255, 255, 0.95)' }};
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;

            @if ($ujian->ujianThema && $ujian->ujianThema->header_image_path)
                background-image: url('{{ asset('storage/' . $ujian->ujianThema->header_image_path) }}');
                background-size: cover;
                background-position: center;
            @endif
        }

        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .bento-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 4px;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4f46e5' }};
            border-radius: 24px 24px 0 0;
        }

        .bento-hero {
            grid-column: 1 / -1;
            text-align: center;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4f46e5' }};
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : '#fff' }};
            border: none;
        }

        .bento-hero::before {
            display: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .success-icon {
            font-size: 80px;
            margin-bottom: 24px;
            animation: bounce 2s infinite;
        }

        .completion-title {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 16px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .completion-subtitle {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 400;
            margin-bottom: 0;
        }

        .bento-score {
            grid-column: 1 / 4;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->secondary_color ? $ujian->ujianThema->secondary_color : '#10b981' }};
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : '#fff' }};
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .bento-score::before {
            display: none;
        }

        .score-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            position: relative;
            backdrop-filter: blur(10px);
        }

        .score-number {
            font-size: 36px;
            font-weight: 900;
            line-height: 1;
        }

        .score-label {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .bento-info {
            grid-column: 4 / -1;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->background_color ? $ujian->ujianThema->background_color . '20' : 'rgba(59, 130, 246, 0.05)' }};
            padding: 20px;
            border-radius: 16px;
            border: 1px solid {{ $ujian->ujianThema && $ujian->ujianThema->border_color ? $ujian->ujianThema->border_color : 'rgba(59, 130, 246, 0.1)' }};
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color . '80' : '#6b7280' }};
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }};
            line-height: 1.3;
        }

        .bento-stats {
            grid-column: 1 / 7;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-card {
            text-align: center;
            padding: 24px 16px;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->background_color ? $ujian->ujianThema->background_color . '10' : 'rgba(79, 70, 229, 0.05)' }};
            border-radius: 16px;
            border: 1px solid {{ $ujian->ujianThema && $ujian->ujianThema->border_color ? $ujian->ujianThema->border_color : 'rgba(79, 70, 229, 0.1)' }};
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 900;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4f46e5' }};
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color . '80' : '#6b7280' }};
        }

        .bento-time {
            grid-column: 7 / -1;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->tertiary_color ? $ujian->ujianThema->tertiary_color : '#f59e0b' }};
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : '#fff' }};
        }

        .bento-time::before {
            display: none;
        }

        .time-content {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .time-icon {
            font-size: 48px;
            margin-left: 24px;
            opacity: 0.8;
        }

        .time-details h4 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .time-details p {
            font-size: 16px;
            margin: 0;
            opacity: 0.9;
        }

        .bento-sections {
            grid-column: 1 / -1;
        }

        .sections-header {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
        }

        .sections-icon {
            width: 48px;
            height: 48px;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->secondary_color ? $ujian->ujianThema->secondary_color : '#06b6d4' }};
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 16px;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : '#fff' }};
            font-size: 20px;
        }

        .sections-title {
            font-size: 24px;
            font-weight: 800;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }};
            margin: 0;
        }

        .sections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        .section-card {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->background_color ? $ujian->ujianThema->background_color . '10' : 'rgba(99, 102, 241, 0.05)' }};
            padding: 24px;
            border-radius: 20px;
            border: 1px solid {{ $ujian->ujianThema && $ujian->ujianThema->border_color ? $ujian->ujianThema->border_color : 'rgba(99, 102, 241, 0.1)' }};
            transition: all 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-name {
            font-size: 16px;
            font-weight: 700;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }};
        }

        .section-score {
            font-size: 20px;
            font-weight: 900;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4f46e5' }};
        }

        .progress-bar {
            height: 8px;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->background_color ? $ujian->ujianThema->background_color . '30' : 'rgba(229, 231, 235, 0.5)' }};
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            height: 100%;
            background: {{ $ujian->ujianThema && $ujian->ujianThema->secondary_color ? $ujian->ujianThema->secondary_color : '#10b981' }};
            border-radius: 4px;
            transition: width 1s ease-out;
        }

        .section-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .section-stat {
            text-align: center;
        }

        .section-stat-number {
            font-size: 20px;
            font-weight: 900;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4f46e5' }};
            margin-bottom: 4px;
        }

        .section-stat-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color . '80' : '#6b7280' }};
        }

        .bento-actions {
            grid-column: 1 / -1;
            text-align: center;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4f46e5' }};
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : '#fff' }};
        }

        .btn-primary:hover {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color . 'dd' : '#4338ca' }};
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->secondary_color ? $ujian->ujianThema->secondary_color : '#6b7280' }};
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : '#fff' }};
        }

        .btn-secondary:hover {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->secondary_color ? $ujian->ujianThema->secondary_color . 'dd' : '#4b5563' }};
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(107, 114, 128, 0.3);
        }

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

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        @media (max-width: 768px) {
            .bento-container {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 0 16px;
            }

            .bento-card {
                padding: 24px;
            }

            .bento-score,
            .bento-info,
            .bento-stats,
            .bento-time,
            .bento-sections,
            .bento-actions {
                grid-column: 1 / -1;
            }

            .completion-title {
                font-size: 28px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .sections-grid {
                grid-template-columns: 1fr;
            }

            .time-content {
                flex-direction: column;
                text-align: center;
            }

            .time-icon {
                margin-left: 0;
                margin-bottom: 16px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
            }

            .bento-card {
                background: white !important;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                page-break-inside: avoid;
            }

            .btn {
                display: none;
            }

            .bento-actions {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    <!-- Bento Grid Container -->
    <div class="bento-container">
        <!-- Hero Section -->
        <div class="bento-card bento-hero">
            <div class="hero-content">
                <div class="success-icon">
                    <i class="ri-checkbox-circle-fill"></i>
                </div>
                <h1 class="completion-title">تم إنجاز الاختبار بنجاح!</h1>
                <p class="completion-subtitle">شكراً لك على اتباع الاختبار بشكل جيد</p>
            </div>
        </div>

        @if (isset($examSummary))
            <!-- Score Section -->
            <div class="bento-card bento-score">
                <div class="score-circle">
                    <div class="score-number">{{ $examSummary['total_score'] }}</div>
                </div>
                <div class="score-label">النتيجة الإجمالية</div>
            </div>

            <!-- Info Section -->
            <div class="bento-card bento-info">
                <h3
                    style="color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }}; margin-bottom: 24px; font-weight: 800;">
                    <i class="ri-survey-line"
                        style="color: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#3b82f6' }}; margin-left: 12px;"></i>
                    معلومات الاختبار
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">اسم الاختبار</div>
                        <div class="info-value">{{ $examSummary['ujian_name'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">اسم المشارك</div>
                        <div class="info-value">{{ $examSummary['peserta_name'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">البريد الإلكتروني</div>
                        <div class="info-value">{{ $examSummary['peserta_email'] }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">إجمالي الأقسام</div>
                        <div class="info-value">{{ $examSummary['total_sections'] }} قسم</div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bento-card bento-stats">
                <h4
                    style="color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }}; margin-bottom: 24px; font-weight: 700;">
                    <i class="ri-bar-chart-fill"
                        style="color: {{ $ujian->ujianThema && $ujian->ujianThema->secondary_color ? $ujian->ujianThema->secondary_color : '#06b6d4' }}; margin-left: 8px;"></i>
                    الإحصائيات
                </h4>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $examSummary['total_questions'] }}</div>
                        <div class="stat-label">إجمالي الأسئلة</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $examSummary['total_answered'] }}</div>
                        <div class="stat-label">مُجاب عليها</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $examSummary['total_correct'] }}</div>
                        <div class="stat-label">صحيحة</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $examSummary['total_incorrect'] }}</div>
                        <div class="stat-label">خاطئة</div>
                    </div>
                </div>
            </div>

            <!-- Time Section -->
            <div class="bento-card bento-time">
                <div class="time-content">
                    <div class="time-icon">
                        <i class="ri-time-line"></i>
                    </div>
                    <div class="time-details">
                        <h4>مدة الإنجاز</h4>
                        <p>{{ $examSummary['exam_duration_minutes'] }} دقيقة</p>
                        <p style="margin-top: 8px; font-size: 12px;">
                            البداية: {{ $examSummary['exam_start_time'] }}<br>
                            النهاية: {{ $examSummary['exam_end_time'] }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Section Results -->
        @if (isset($examSummary['section_results']) && count($examSummary['section_results']) > 0)
            <div class="bento-card bento-sections">
                <div class="sections-header">
                    <div class="sections-icon">
                        <i class="ri-bar-chart-line"></i>
                    </div>
                    <h3 class="sections-title">النتائج حسب القسم</h3>
                </div>

                <div class="sections-grid">
                    @foreach ($examSummary['section_results'] as $section)
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-name">{{ $section['section_name'] }}</div>
                                <div class="section-score">{{ $section['score_percentage'] }}%</div>
                            </div>

                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $section['completion_percentage'] }}%;"></div>
                            </div>

                            <div class="section-stats">
                                <div class="section-stat">
                                    <div class="section-stat-number">{{ $section['total_questions'] }}</div>
                                    <div class="section-stat-label">الإجمالي</div>
                                </div>
                                <div class="section-stat">
                                    <div class="section-stat-number">{{ $section['answered_questions'] }}</div>
                                    <div class="section-stat-label">مُجاب عليها</div>
                                </div>
                                <div class="section-stat">
                                    <div class="section-stat-number">{{ $section['correct_answers'] }}</div>
                                    <div class="section-stat-label">صحيحة</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        <!-- Action Buttons -->
        <div class="bento-card bento-actions">
            <h4
                style="color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }}; margin-bottom: 32px; font-weight: 700; text-align: center;">
                <i class="ri-settings-3-line"
                    style="color: {{ $ujian->ujianThema && $ujian->ujianThema->tertiary_color ? $ujian->ujianThema->tertiary_color : '#f59e0b' }}; margin-left: 8px;"></i>
                الإجراءات التالية
            </h4>
            <div class="action-buttons">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="ri-home-line"></i>
                    العودة إلى الصفحة الرئيسية
                </a>
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="ri-printer-line"></i>
                    طباعة النتائج
                </button>
            </div>
        </div>
        @endif

        @if (!isset($examSummary))
            <!-- Fallback for simple completion message -->
            <div class="bento-card bento-info" style="grid-column: 1 / -1;">
                <div style="text-align: center;">
                    <i class="ri-checkbox-circle-line"
                        style="font-size: 48px; color: {{ $ujian->ujianThema && $ujian->ujianThema->primary_color ? $ujian->ujianThema->primary_color : '#4caf50' }}; margin-bottom: 24px;"></i>
                    <h3
                        style="color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#111827' }}; margin-bottom: 16px;">
                        الاختبار مكتمل</h3>
                    <p
                        style="color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color . '99' : '#666' }}; font-size: 16px; margin-bottom: 32px;">
                        {{ $message ?? 'تم الانتهاء من الاختبار. شكراً لك على مشاركتك.' }}
                    </p>
                    <div class="action-buttons">
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="ri-home-line"></i>
                            العودة إلى الصفحة الرئيسية
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('script')
    <script>
        console.log(@json($examSummary ?? []));
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
