@php
    $thema = $ujian->ujianThema ?? null;
    $logoPath = $thema->logo_path ?? null;
    $institutionName = $thema->institution_name ?? null;
    $showLogoAndText = $logoPath && $institutionName;
    $showLogoOnly = $logoPath && !$institutionName;
    $brandingLogo =
        \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoHitam')->value('value') ?? '';
@endphp

@extends('layouts.app-simple')

@section('title', 'الاختبار مكتمل')

@section('css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <style>
        @font-face {
            font-family: "Lotus Linotype Bold";
            src: url("https://db.onlinewebfonts.com/t/314d71ddbb9f0768c5f219a7cd0abd42.eot");
            src: url("https://db.onlinewebfonts.com/t/314d71ddbb9f0768c5f219a7cd0abd42.eot?#iefix")format("embedded-opentype"),
                url("https://db.onlinewebfonts.com/t/314d71ddbb9f0768c5f219a7cd0abd42.woff2")format("woff2"),
                url("https://db.onlinewebfonts.com/t/314d71ddbb9f0768c5f219a7cd0abd42.woff")format("woff"),
                url("https://db.onlinewebfonts.com/t/314d71ddbb9f0768c5f219a7cd0abd42.ttf")format("truetype"),
                url("https://db.onlinewebfonts.com/t/314d71ddbb9f0768c5f219a7cd0abd42.svg#Lotus Linotype Bold")format("svg");
        }

        :root {
            --primary-color: {{ $thema->primary_color ?? '#2c2c2c' }};
            --secondary-color: {{ $thema->secondary_color ?? '#6c757d' }};
            --tertiary-color: {{ $thema->tertiary_color ?? '#f5f5f5' }};
            --background-color: {{ $thema->background_color ?? '#ffffff' }};
            --header-color: {{ $thema->header_color ?? '#f0f0f0' }};
            --font-color: {{ $thema->font_color ?? '#212529' }};
            --button-color: {{ $thema->button_color ?? '#0080ff' }};
            --button-font-color: {{ $thema->button_font_color ?? '#ffffff' }};
            --border-color: {{ $thema->border_color ?? '#e5e7eb' }};
        }

        body {
            background: var(--background-color);
            font-family: 'Lotus Linotype Bold', 'Noto Kufi Arabic', 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            direction: rtl;
            
            @if ($ujian->ujianThema && $ujian->ujianThema->background_image_path)
                background-image: url('{{ asset($ujian->ujianThema->background_image_path) }}');
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
            background: var(--tertiary-color, rgba(255, 255, 255, 0.95));
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
        }

        .bento-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-color, #4f46e5);
            border-radius: 24px 24px 0 0;
        }

        .bento-hero {
            grid-column: 1 / -1;
            text-align: center;
            background: var(--header-color, #4f46e5);
            color: var(--secondary-color, #fff);
            border: none;

            @if ($ujian->ujianThema && $ujian->ujianThema->header_image_path)
                background-image: url('{{ asset($ujian->ujianThema->header_image_path) }}');
                background-size: cover;
                background-position: center;
            @endif
        }

        .bento-hero::before {
            display: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .success-icon {
            font-size: 180px;
            line-height: 1;
            margin-bottom: 0px;
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
            margin-bottom: 32px;
        }

        .bento-score {
            grid-column: span 4;
            text-align: center;
            background: color-mix(in srgb, var(--primary-color) 15%, transparent);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: var(--header-color, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
            animation: pulse 2s infinite;
        }

        .score-number {
            font-size: 36px;
            font-weight: 900;
            color: white;
        }

        .score-label {
            font-size: 16px;
            font-weight: 600;
            color: var(--font-color, #374151);
            margin-top: 8px;
        }

        .bento-info {
            grid-column: span 8;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            padding: 20px;
            background: color-mix(in srgb, var(--background-color) 50%, transparent);
            border-radius: 16px;
            border: 1px solid color-mix(in srgb, var(--border-color) 20%, transparent);
        }

        .info-label {
            font-size: 14px;
            font-weight: 500;
            color: color-mix(in srgb, var(--font-color) 80%, transparent);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--font-color, #111827);
        }

        .bento-stats {
            grid-column: span 6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .stat-card {
            text-align: center;
            padding: 24px 16px;
            background: color-mix(in srgb, var(--primary-color) 10%, transparent);
            border-radius: 16px;
            border: 1px solid color-mix(in srgb, var(--border-color) 30%, transparent);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 900;
            color: var(--primary-color, #3b82f6);
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: color-mix(in srgb, var(--font-color) 70%, transparent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bento-time {
            grid-column: span 6;
        }

        .time-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .time-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--header-color, #f59e0b);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
        }

        .time-details h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--font-color, #111827);
            margin-bottom: 8px;
        }

        .time-details p {
            font-size: 14px;
            color: color-mix(in srgb, var(--font-color) 80%, transparent);
            margin: 0;
        }

        .bento-sections {
            grid-column: 1 / -1;
        }

        .sections-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .sections-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-color, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .sections-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--font-color, #111827);
            margin: 0;
        }

        .sections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .section-card {
            background: color-mix(in srgb, var(--primary-color) 10%, transparent);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid color-mix(in srgb, var(--border-color) 30%, transparent);
            position: relative;
            overflow: hidden;
        }

        .section-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--border-color, #3b82f6);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--font-color, #111827);
        }

        .section-score {
            font-size: 24px;
            font-weight: 900;
            color: var(--primary-color, #10b981);
        }

        .section-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .section-stat {
            text-align: center;
            padding: 12px 8px;
            background: color-mix(in srgb, var(--header-color) 50%, transparent);
            border-radius: 12px;
        }

        .section-stat-number {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-color, #3b82f6);
        }

        .section-stat-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--primary-color, #3b82f6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        .progress-bar {
            height: 8px;
            background: color-mix(in srgb, var(--primary-color) 10%, transparent);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 16px;
        }

        .progress-fill {
            height: 100%;
            background: var(--header-color, #10b981);
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .bento-actions {
            grid-column: 1 / -1;
            text-align: center;
        }

        .action-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 32px;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 160px;
            justify-content: center;
        }

        .btn-primary,
        .btn-secondary {
            background: var(--button-color, #3b82f6);
            color: var(--button-font-color, #ffffff);
            box-shadow: 0 8px 32px color-mix(in srgb, var(--button-color) 40%, transparent);
            border: 2px solid var(--border-color, #e5e7eb);
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px color-mix(in srgb, var(--button-color) 50%, transparent);
        }

        .footer-text {
            margin-top: 50px;
            color: var(--primary-color);
            font-size: 14px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
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

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 color-mix(in srgb, var(--primary-color) 70%, transparent);
            }

            70% {
                box-shadow: 0 0 0 20px transparent;
            }

            100% {
                box-shadow: 0 0 0 0 transparent;
            }
        }

        .institution-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInUp 0.6s ease-out;
        }

        .institution-logo {
            max-height: 80px;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        .institution-name {
            font-size: 24px;
            font-weight: 800;
            color: var(--font-color, #111827);
            margin: 0;
        }

        @media (max-width: 1200px) {
            .bento-container {
                grid-template-columns: repeat(8, 1fr);
            }

            .bento-score {
                grid-column: span 8;
            }

            .bento-info {
                grid-column: span 8;
            }

            .bento-stats,
            .bento-time {
                grid-column: span 4;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .bento-container {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .bento-card {
                padding: 24px;
            }

            .bento-score,
            .bento-info,
            .bento-stats,
            .bento-time {
                grid-column: span 1;
            }

            .completion-title {
                font-size: 32px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .sections-grid {
                grid-template-columns: 1fr;
            }

            .section-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media print {
            body {
                background: white !important;
            }

            .bento-card {
                box-shadow: none !important;
                border: 1px solid #ddd;
                page-break-inside: avoid;
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
                @if(isset($examSummary['status_kelulusan']))
                    <div class="status-kelulusan" style="margin-top: 16px; text-align: center;">
                        @if($examSummary['status_kelulusan'] == 'lulus')
                            <span class="badge" style="background-color: #10b981; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px;">
                                <i class="ri-check-line" style="margin-left: 4px;"></i>
                                نجح
                            </span>
                        @else
                            <span class="badge" style="background-color: #ef4444; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 14px;">
                                <i class="ri-close-line" style="margin-left: 4px;"></i>
                                لم ينجح
                            </span>
                        @endif
                        <div style="margin-top: 8px; font-size: 12px; color: #6b7280;">
                            حد النجاح: {{ $examSummary['nilai_kelulusan'] ?? 'غير محدد' }}
                        </div>
                    </div>
                @endif
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
