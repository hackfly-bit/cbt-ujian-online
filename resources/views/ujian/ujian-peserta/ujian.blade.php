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

@section('title', 'Ujian Online')

@section('css')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh; 
            

            @if ($ujian->ujianThema && $ujian->ujianThema->background_image_path)
                background-image: url('{{ asset($ujian->ujianThema->background_image_path) }}');
                background-size: cover;
                background-position: center;
            @endif
        }

        .exam-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 0 40px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100vh;
        }

        .exam-header {
            background: var(--header-color, #4f46e5);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;

            /* @if ($ujian->ujianThema && $ujian->ujianThema->header_image_path)
                background-image: url('{{ asset($ujian->ujianThema->header_image_path) }}');
                background-size: cover;
                background-position: center;
            @endif */
        }

        .exam-title {
            font-size: 24px;
            font-weight: bold;
            color: var(--secondary-color);
            margin: 0;
        }

        .exam-subtitle {
            margin-top: 8px;
            font-size: 14px;
            color: var(--secondary-color, #666);
        }

        .exam-subtitle-text {
            margin-top: 5px;
            font-size: 12px;
            color: #d33;
            font-weight: bold;
        }

        .timer {
            background: red;
            color: var(--button-font-color, white);
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 18px;
        }

        .exam-content {
            display: flex;
            gap: 20px;
        }

        .question-panel {
            flex: 1;
            background: var(--tertiary-color, #f8f9fa);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
        }

        .section-title {
            font-weight: bold;
            color: var(--font-color);
            margin-bottom: 5px;
        }

        .section-instruction {
            color: #666;
            font-size: 14px;
        }

        .question-number {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .question-text {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #333;
            font-weight: 500;
        }

        .answer-options {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .answer-option {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            /* Tambahkan border */
            border-radius: 8px;
            padding: 12px 16px;
            /* Tambahkan padding ke container */
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .answer-option input[type="radio"] {
            margin-right: 12px;
            transform: scale(1.2);
            accent-color: #2196f3;
            /* warna radio saat dipilih */
            flex-shrink: 0;
        }

        .answer-option input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s;
        }

        .answer-option input[type="text"]:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .answer-option label {
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            /* Hapus padding dari label */
            margin: 0;
            flex-grow: 1;
            direction: rtl;
            /* untuk teks Arab */
            text-align: right;
        }

        .answer-option:hover {
            background-color: #f5f5f5;
        }

        .answer-option input[type="radio"]:checked+label {
            color: #1976d2;
            font-weight: bold;
        }



        .audio-player {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }

        .audio-player audio {
            width: 100%;
            height: 40px;
        }

        .question-type-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .type-multiple-choice {
            background: #e3f2fd;
            color: #1976d2;
        }

        .type-essay {
            background: #fff3e0;
            color: #f57c00;
        }

        .type-true-false {
            background: #e8f5e8;
            color: #388e3c;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-sm {
            padding: 3px 6px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .btn-primary {
            color: #fff;
            background-color: #2196f3;
            border-color: #2196f3;
        }

        .btn-primary:hover {
            background-color: #1976d2;
            border-color: #1976d2;
        }

        .btn-outline-secondary {
            color: #6c757d;
            background-color: transparent;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .section-progress {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
        }

        .section-progress-bar {
            background: #e9ecef;
            border-radius: 4px;
            height: 8px;
            margin: 5px 0;
            overflow: hidden;
        }

        .section-progress-fill {
            background: #4caf50;
            height: 100%;
            transition: width 0.3s ease;
        }

        .section-nav-container {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .section-nav-btn {
            padding: 6px 10px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.2s;
            min-width: 45px;
        }

        .section-nav-btn.active {
            background: #2196f3;
            color: white;
            border-color: #2196f3;
        }

        .section-nav-btn.completed {
            background: #4caf50;
            color: white;
            border-color: #4caf50;
        }

        .section-nav-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navigation-panel {
            width: 300px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .progress-info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }

        .question-navigation {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .question-nav-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s;
        }

        .question-nav-btn.current {
            background: #2196f3;
            color: white;
            border-color: #2196f3;
        }

        .question-nav-btn.answered {
            background: #4caf50;
            color: white;
            border-color: #4caf50;
        }

        .question-nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .control-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn-prev,
        .btn-next {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-prev {
            background: #f5f5f5;
            color: #666;
        }

        .btn-next {
            background: var(--button-color);
            color: var(--button-font-color);
        }

        .btn-prev:hover,
        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-prev:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .legend {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }

        .legend-current {
            background: #2196f3;
        }

        .legend-answered {
            background: #4caf50;
        }

        .legend-unanswered {
            background: white;
            border: 2px solid #ddd;
        }

        /* Responsive design untuk mobile */
        @media (max-width: 768px) {
            .exam-content {
                flex-direction: column;
            }

            .navigation-panel {
                width: 100%;
                margin-top: 20px;
            }

            .question-navigation {
                grid-template-columns: repeat(6, 1fr);
            }

            .exam-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }

        /* Audio player improvements */
        .audio-player audio::-webkit-media-controls-panel {
            background-color: #2196f3;
        }

        .audio-player audio::-webkit-media-controls-play-button {
            background-color: #2196f3;
            border-radius: 50%;
        }

        /* Section timer animation */
        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0.3;
            }
        }

        /* Warning styles for section timer */
        .section-timer-warning {
            animation: blink 1s infinite;
            color: #d33 !important;
            font-weight: bold;
        }

        /* Lockscreen styles */
        .lockscreen-indicator {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
        }

        .lockscreen-indicator.active {
            background: #28a745;
        }

        .lockscreen-warning-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(220, 53, 69, 0.1);
            z-index: 999;
            pointer-events: none;
            display: none;
        }

        .lockscreen-warning-overlay.show {
            display: block;
            animation: flash 0.5s ease-in-out;
        }

        @keyframes flash {

            0%,
            100% {
                background: rgba(220, 53, 69, 0.1);
            }

            50% {
                background: rgba(220, 53, 69, 0.3);
            }
        }

        /* Disable text selection when lockscreen is active */
        .lockscreen-active {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .lockscreen-active input,
        .lockscreen-active textarea {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
    </style>
@endsection

@section('content')
    <!-- Lockscreen Indicator -->
    @if ($lockscreenEnabled)
        <div class="lockscreen-indicator active" id="lockscreenIndicator">
            🔒 LOCKSCREEN AKTIF
        </div>
        <div class="lockscreen-warning-overlay" id="lockscreenOverlay"></div>
    @endif

    <div class="exam-container @if ($lockscreenEnabled) lockscreen-active @endif">
        <!-- Header -->
        <div class="exam-header">
            <div>
                <h1 class="exam-title">{{ $ujian->nama_ujian ?? 'TEST' }}</h1>
                <div class="exam-subtitle">
                    <strong>Section {{ $currentSectionNumber ?? 1 }} dari {{ $totalSections ?? 1 }}</strong>
                    | {{ $totalQuestionsInSection ?? 0 }} soal dalam section ini
                    | Total: {{ $totalQuestions ?? 0 }} soal
                </div>
                @if (isset($sectionTimeRemaining) && $sectionTimeRemaining !== null)
                    <div class="exam-subtitle-text">
                        ⏱️ Waktu Section: <span id="section-timer">{{ gmdate('i:s', $sectionTimeRemaining) }}</span>
                    </div>
                @endif
            </div>
            <div class="timer" id="timer">
                <span id="time-display">119:11</span>
            </div>
        </div>

        <div class="exam-content">
            <!-- Question Panel -->
            <div class="question-panel">
                <!-- Section Info -->
                <div class="section-info">
                    <div class="section-title">{{ $currentSection->nama ?? 'Section ' . ($currentSectionNumber ?? 1) }}
                    </div>
                    <div class="section-instruction">
                        {{ $currentSection->instruksi ?? 'Jawablah pertanyaan berikut dengan tepat.' }}
                    </div>
                    <div style="margin-top: 8px; font-size: 12px; color: #888;">
                        Durasi Section: {{ $currentSection->durasi ?? '-' }} menit
                        | Soal dalam section: {{ $totalQuestionsInSection ?? 0 }}
                    </div>
                </div>

                <!-- Question -->
                <div class="question-number">
                    Soal {{ $currentQuestionNumber ?? 1 }} dari {{ $totalQuestionsInSection ?? 6 }}
                    <span style="color: #999;">(Section {{ $currentSectionNumber ?? 1 }})</span>
                </div>

                @if (isset($currentQuestion) && $currentQuestion->jenis_isian)
                    <div
                        class="question-type-indicator
                        @if ($currentQuestion->jenis_isian === 'multiple_choice' || $currentQuestion->jenis_isian === 'pilihan_ganda') type-multiple-choice
                        @elseif($currentQuestion->jenis_isian === 'isian') type-essay
                        @elseif($currentQuestion->jenis_isian === 'true_false') type-true-false @endif">
                        @if ($currentQuestion->jenis_isian === 'multiple_choice' || $currentQuestion->jenis_isian === 'pilihan_ganda')
                            Pilihan Ganda
                        @elseif($currentQuestion->jenis_isian === 'isian')
                            Isian
                        @elseif($currentQuestion->jenis_isian === 'true_false')
                            Benar/Salah
                        @endif
                    </div>
                @endif

                @if (isset($currentQuestion))
                    @if ($currentQuestion->is_audio && $currentQuestion->audio_file)
                        <div class="audio-player">
                            <audio controls preload="metadata">
                                <source src="{{ asset('/' . $currentQuestion->audio_file) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endif

                    <div class="question-text">
                        {{ $currentQuestion->pertanyaan ?? '"اختر الجمع الصحيح لكلمة "مؤنث' }}
                    </div>
                @endif
                <!-- Answer Options -->
                <form id="exam-form">
                    <ul class="answer-options">
                        @if (isset($currentQuestion) && $currentQuestion->jenis_isian)
                            @if ($currentQuestion->jenis_isian === 'multiple_choice' || $currentQuestion->jenis_isian === 'pilihan_ganda')
                                @if ($currentQuestion->jawabanSoals && $currentQuestion->jawabanSoals->count() > 0)
                                    @foreach ($currentQuestion->jawabanSoals as $index => $jawaban)
                                        <li class="answer-option">
                                            <input type="radio" name="jawaban_{{ $currentQuestion->id }}"
                                                value="{{ $jawaban->id }}" id="option_{{ $index }}"
                                                {{ isset($selectedAnswers[$currentQuestion->id]) && $selectedAnswers[$currentQuestion->id] == $jawaban->id ? 'checked' : '' }}>
                                            <label for="option_{{ $index }}">{{ $jawaban->jawaban }}</label>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="answer-option">
                                        <p>Tidak ada pilihan jawaban tersedia untuk soal ini.</p>
                                    </li>
                                @endif
                            @elseif($currentQuestion->jenis_isian === 'isian')
                                <li class="answer-option">
                                    <input type="text" name="jawaban_{{ $currentQuestion->id }}"
                                        id="jawaban_{{ $currentQuestion->id }}" placeholder="Tulis jawaban Anda di sini..."
                                        value="{{ $savedTextAnswers[$currentQuestion->id] ?? '' }}">
                                </li>
                            @elseif($currentQuestion->jenis_isian === 'true_false')
                                <li class="answer-option">
                                    <input type="radio" name="jawaban_{{ $currentQuestion->id }}"
                                        id="jawaban_true_{{ $currentQuestion->id }}" value="true"
                                        {{ isset($savedTextAnswers[$currentQuestion->id]) && $savedTextAnswers[$currentQuestion->id] === 'true' ? 'checked' : '' }}>
                                    <label for="jawaban_true_{{ $currentQuestion->id }}">Benar (True)</label>
                                </li>
                                <li class="answer-option">
                                    <input type="radio" name="jawaban_{{ $currentQuestion->id }}"
                                        id="jawaban_false_{{ $currentQuestion->id }}" value="false"
                                        {{ isset($savedTextAnswers[$currentQuestion->id]) && $savedTextAnswers[$currentQuestion->id] === 'false' ? 'checked' : '' }}>
                                    <label for="jawaban_false_{{ $currentQuestion->id }}">Salah (False)</label>
                                </li>
                            @endif
                        @else
                            {{-- No dummy question/answer here, only show if data exists --}}
                        @endif
                    </ul>
                </form>


                <!-- Section Progress -->
                <div class="section-progress">
                    <div class="section-progress-bar">
                        <div class="section-progress-fill"
                            style="width: {{ (($answeredCountInSection ?? 0) / ($totalQuestionsInSection ?? 1)) * 100 }}%;">
                        </div>
                    </div>
                    <div style="font-size: 12px; color: #666; text-align: right;">
                        {{ $answeredCountInSection ?? 0 }} dari {{ $totalQuestionsInSection ?? 0 }} soal telah dijawab
                    </div>
                </div>
            </div>

            <!-- Navigation Panel -->
            <div class="navigation-panel">
                <!-- Overall Progress -->
                <div class="section-progress">
                    <div style="font-size: 12px; font-weight: bold; color: #666; margin-bottom: 5px;">
                        Progress Keseluruhan
                    </div>
                    <div class="section-progress-bar">
                        <div class="section-progress-fill"
                            style="width: {{ $totalQuestions > 0 ? ($totalAnsweredQuestions / $totalQuestions) * 100 : 0 }}%">
                        </div>
                    </div>
                    <div style="font-size: 11px; color: #888; margin-top: 3px;">
                        {{ $totalAnsweredQuestions ?? 0 }}/{{ $totalQuestions ?? 6 }} soal dijawab
                    </div>
                </div>

                <!-- Section Navigation -->
                @if (($totalSections ?? 1) > 1)
                    <div style="margin-bottom: 15px;">
                        <div style="font-size: 12px; font-weight: bold; margin-bottom: 8px; color: #666;">
                            Navigasi Section:
                        </div>
                        <div class="section-nav-container">
                            @php
                                $sectionsData = [];
                                foreach ($ujian->ujianSections as $index => $section) {
                                    $sectionNumber = $index + 1;
                                    $sectionSoalCount = $section->ujianSectionSoals->count();
                                    $sectionAnsweredCount = 0;

                                    foreach ($section->ujianSectionSoals as $sectionSoal) {
                                        $soalId = $sectionSoal->soal->id;
                                        if (isset($savedAnswers) && $savedAnswers->where('soal_id', $soalId)->first()) {
                                            $sectionAnsweredCount++;
                                        }
                                    }

                                    $sectionsData[] = [
                                        'number' => $sectionNumber,
                                        'total' => $sectionSoalCount,
                                        'answered' => $sectionAnsweredCount,
                                        'completed' => $sectionAnsweredCount >= $sectionSoalCount,
                                    ];
                                }
                            @endphp

                            @foreach ($sectionsData as $sectionData)
                                <button
                                    class="section-nav-btn
                                    {{ $sectionData['number'] == ($currentSectionNumber ?? 1) ? 'active' : '' }}
                                    {{ $sectionData['completed'] ? 'completed' : '' }}"
                                    onclick="goToSection({{ $sectionData['number'] }})"
                                    title="Section {{ $sectionData['number'] }}: {{ $sectionData['answered'] }}/{{ $sectionData['total'] }} dijawab">
                                    S{{ $sectionData['number'] }}
                                    <br>
                                    <span
                                        style="font-size: 10px;">{{ $sectionData['answered'] }}/{{ $sectionData['total'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Current Section Progress -->
                <div class="progress-info">
                    <strong>Section {{ $currentSectionNumber ?? 1 }}:
                        {{ $answeredCountInSection ?? 0 }}/{{ $totalQuestionsInSection ?? 6 }} dijawab</strong>
                    <div class="section-progress-bar" style="margin: 8px 0;">
                        <div class="section-progress-fill"
                            style="width: {{ $totalQuestionsInSection > 0 ? ($answeredCountInSection / $totalQuestionsInSection) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color legend-current"></div>
                        <span>Saat ini</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-answered"></div>
                        <span>Dijawab</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-unanswered"></div>
                        <span>Belum</span>
                    </div>
                </div>

                <!-- Question Navigation (untuk section saat ini) -->
                <div class="question-navigation">
                    @for ($i = 1; $i <= ($totalQuestionsInSection ?? 6); $i++)
                        <button
                            class="question-nav-btn
                        {{ $i == ($currentQuestionNumber ?? 1) ? 'current' : '' }}
                        {{ in_array($i, $answeredQuestionsInSection ?? []) ? 'answered' : '' }}"
                            onclick="goToQuestion({{ $i }})">
                            {{ $i }}
                        </button>
                    @endfor
                </div>

                <!-- Section Navigation (tombol kecil untuk setiap section) -->
                <div class="section-nav-container">
                    @for ($s = 1; $s <= ($totalSections ?? 1); $s++)
                        <button
                            class="section-nav-btn
                            {{ $s == ($currentSectionNumber ?? 1) ? 'active' : '' }}
                            {{ in_array($s, $completedSections ?? []) ? 'completed' : '' }}"
                            onclick="goToSection({{ $s }})">
                            S{{ $s }}
                        </button>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="control-buttons">
            <button class="btn-prev" onclick="previousQuestion()"
                {{ ($currentQuestionNumber ?? 1) <= 1 ? 'disabled' : '' }}>
                ← Sebelumnya
            </button>
            <div style="display: flex; gap: 10px;">
                @if (
                    ($currentQuestionNumber ?? 1) == ($totalQuestionsInSection ?? 6) &&
                        ($currentSectionNumber ?? 1) < ($totalSections ?? 1))
                    <button class="btn btn-warning" onclick="nextSection()"
                        style="padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold;">
                        Lanjut ke Section {{ ($currentSectionNumber ?? 1) + 1 }} →
                    </button>
                @elseif(
                    ($currentQuestionNumber ?? 1) == ($totalQuestionsInSection ?? 6) &&
                        ($currentSectionNumber ?? 1) == ($totalSections ?? 1))
                    <button class="btn-next" onclick="submitExam()">
                        Kumpulkan Hasil Ujian
                    </button>
                @else
                    <button class="btn-next" onclick="nextQuestion()">
                        Selanjutnya →
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- SweetAlert2 JS -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        console.log(@json($ujian ?? 'TEST'));

        console.log(@json(Session::all()));

        // Auto fullscreen when user has filled exam data
        function enableFullscreen() {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        }

        // Check if user has exam session and auto enable fullscreen
        @if (session('ujian_id') && session('email'))
            // User has filled exam data, enable fullscreen
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    enableFullscreen();
                }, 1000); // Delay 1 second to ensure page is fully loaded
            });
        @endif

        let currentQuestion = {{ $currentQuestionNumber ?? 1 }};
        let currentSection = {{ $currentSectionNumber ?? 1 }};
        let totalQuestions = {{ $totalQuestions ?? 6 }};
        let totalQuestionsInSection = {{ $totalQuestionsInSection ?? 6 }};
        let totalSections = {{ $totalSections ?? 1 }};
        let timeRemaining = {{ $timeRemaining ?? 7151 }}; // in seconds
        let sectionTimeRemaining = {{ $sectionTimeRemaining ?? 'null' }}; // section time limit
        let answeredQuestionsInSection = @json($answeredQuestionsInSection ?? []);
        let lockscreenEnabled = {{ $lockscreenEnabled ? 'true' : 'false' }};

        // Lockscreen functionality
        if (lockscreenEnabled) {
            // Track tab switching
            let isTabActive = true;
            let tabSwitchCount = 0;
            const maxTabSwitches = 3; // Maximum allowed tab switches
            let isNavigating = false; // Flag to track legitimate navigation
            let hasShownInitialWarning = localStorage.getItem('lockscreenInitialWarningShown') === 'true';

            // Prevent context menu (right click)
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showLockscreenWarning('Context menu dinonaktifkan selama ujian berlangsung.');
                return false;
            });

            // Prevent keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Prevent F12 (Developer Tools)
                if (e.keyCode === 123) {
                    e.preventDefault();
                    showLockscreenWarning('Developer tools dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Ctrl+Shift+I (Developer Tools)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                    e.preventDefault();
                    showLockscreenWarning('Developer tools dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Ctrl+Shift+C (Select Element)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
                    e.preventDefault();
                    showLockscreenWarning('Inspect element dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Ctrl+U (View Source)
                if (e.ctrlKey && e.keyCode === 85) {
                    e.preventDefault();
                    showLockscreenWarning('View source dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Ctrl+S (Save Page)
                if (e.ctrlKey && e.keyCode === 83) {
                    e.preventDefault();
                    showLockscreenWarning('Menyimpan halaman dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Ctrl+C (Copy) - allow in input fields
                if (e.ctrlKey && e.keyCode === 67 && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                    e.preventDefault();
                    showLockscreenWarning('Copy dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Ctrl+V (Paste) - allow in input fields
                if (e.ctrlKey && e.keyCode === 86 && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                    e.preventDefault();
                    showLockscreenWarning('Paste dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Alt+Tab (Task switching) - limited effectiveness
                if (e.altKey && e.keyCode === 9) {
                    e.preventDefault();
                    showLockscreenWarning('Task switching dinonaktifkan selama ujian berlangsung.');
                    return false;
                }

                // Prevent Windows key
                if (e.keyCode === 91 || e.keyCode === 92) {
                    e.preventDefault();
                    showLockscreenWarning('Windows key dinonaktifkan selama ujian berlangsung.');
                    return false;
                }
            });

            // Track page visibility (tab switching detection)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    isTabActive = false;

                    // Only count as violation if not navigating legitimately
                    if (!isNavigating) {
                        tabSwitchCount++;
                        console.log('Tab switched away (violation), count:', tabSwitchCount);

                        // Store tab switch in session/local storage for tracking
                        localStorage.setItem('tabSwitchCount', tabSwitchCount);

                        // Update indicator
                        updateLockscreenIndicator(tabSwitchCount);

                        if (tabSwitchCount >= maxTabSwitches) {
                            // Force submit exam after maximum violations
                            Swal.fire({
                                icon: 'error',
                                title: 'Ujian Berakhir!',
                                html: `
                                    <p>Anda telah melakukan pelanggaran terlalu banyak kali.</p>
                                    <p>Ujian akan otomatis diselesaikan.</p>
                                `,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                // Auto submit exam
                                navigateToUrl(`{{ route('ujian.submit', $ujian->link) }}`);
                            });
                        }
                    } else {
                        console.log('Tab switched away (navigation) - allowed');
                    }
                } else {
                    isTabActive = true;

                    // Reset navigation flag when returning to tab
                    if (isNavigating) {
                        isNavigating = false;
                        console.log('Returned from navigation');
                    } else if (tabSwitchCount > 0 && tabSwitchCount < maxTabSwitches) {
                        // Only show warning if we haven't shown initial warning yet
                        if (hasShownInitialWarning) {
                            showTabSwitchWarning();
                        }
                    }
                }
            });

            // Prevent printing
            window.addEventListener('beforeprint', function(e) {
                e.preventDefault();
                showLockscreenWarning('Mencetak halaman dinonaktifkan selama ujian berlangsung.');
                return false;
            });

            // Monitor for developer tools (basic detection)
            let devtools = {
                open: false,
                orientation: null
            };

            setInterval(function() {
                if (window.outerHeight - window.innerHeight > 200 || window.outerWidth - window.innerWidth > 200) {
                    if (!devtools.open) {
                        devtools.open = true;
                        showLockscreenWarning('Developer tools terdeteksi. Harap tutup untuk melanjutkan ujian.');
                    }
                } else {
                    devtools.open = false;
                }
            }, 500);

            function showLockscreenWarning(message) {
                // Show visual overlay
                const overlay = document.getElementById('lockscreenOverlay');
                if (overlay) {
                    overlay.classList.add('show');
                    setTimeout(() => {
                        overlay.classList.remove('show');
                    }, 1000);
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan Lockscreen!',
                    text: message,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#dc3545'
                });
            }

            function showTabSwitchWarning() {
                const remaining = maxTabSwitches - tabSwitchCount;
                Swal.fire({
                    icon: 'error',
                    title: 'Peringatan: Tab Switching Terdeteksi!',
                    html: `
                        <p>Anda telah beralih tab sebanyak <strong>${tabSwitchCount}</strong> kali.</p>
                        <p>Peringatan tersisa: <strong>${remaining}</strong></p>
                        <p class="text-danger">Jika Anda mencapai batas maksimum, ujian akan otomatis berakhir!</p>
                    `,
                    confirmButtonText: 'Saya Mengerti',
                    confirmButtonColor: '#dc3545'
                });
            }

            // Show initial lockscreen info - only once per exam session
            if (!hasShownInitialWarning) {
                Swal.fire({
                    icon: 'info',
                    title: 'Lockscreen Aktif',
                    html: `
                        <p>Ujian ini menggunakan sistem lockscreen untuk menjaga integritas.</p>
                        <p><strong>Yang tidak diperbolehkan:</strong></p>
                        <ul style="text-align: left; margin-left: 20px;">
                            <li>Beralih tab untuk browsing lain (maksimal ${maxTabSwitches} kali)</li>
                            <li>Membuka context menu (klik kanan)</li>
                            <li>Menggunakan developer tools</li>
                            <li>Menggunakan shortcut keyboard tertentu</li>
                            <li>Mencetak halaman</li>
                        </ul>
                        <p class="text-success">✅ Navigasi antar soal dan section diperbolehkan</p>
                        <p class="text-warning">Pelanggaran berulang akan mengakhiri ujian secara otomatis!</p>
                    `,
                    confirmButtonText: 'Saya Mengerti dan Siap Memulai',
                    confirmButtonColor: '#007bff',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    // Mark that initial warning has been shown
                    localStorage.setItem('lockscreenInitialWarningShown', 'true');
                    hasShownInitialWarning = true;
                });
            }

            // Load tab switch count from storage if exists
            const storedCount = localStorage.getItem('tabSwitchCount');
            if (storedCount) {
                tabSwitchCount = parseInt(storedCount);
            }

            // Add lockscreen class to body
            document.body.classList.add('lockscreen-active');

            // Function to set navigation flag
            window.setNavigationFlag = function() {
                isNavigating = true;
                console.log('Navigation flag set - tab switching allowed');

                // Auto-reset flag after 3 seconds as safety measure
                setTimeout(() => {
                    if (isNavigating) {
                        isNavigating = false;
                        console.log('Navigation flag auto-reset');
                    }
                }, 3000);
            };

            // Update lockscreen indicator
            function updateLockscreenIndicator(violations) {
                const indicator = document.getElementById('lockscreenIndicator');
                if (indicator) {
                    if (violations >= maxTabSwitches) {
                        indicator.style.background = '#dc3545';
                        indicator.innerHTML = '🚫 LOCKSCREEN - VIOLATION LIMIT';
                    } else if (violations > 0) {
                        indicator.style.background = '#ffc107';
                        indicator.innerHTML = `⚠️ LOCKSCREEN - ${violations}/${maxTabSwitches} VIOLATIONS`;
                    } else {
                        indicator.style.background = '#28a745';
                        indicator.innerHTML = '🔒 LOCKSCREEN AKTIF';
                    }
                }
            }

            // Initial indicator update
            updateLockscreenIndicator(tabSwitchCount);
        }

        // Update navigation buttons on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateNavigationButtons();

            // Show section time warning if applicable
            if (sectionTimeRemaining !== null && sectionTimeRemaining < 300) { // 5 minutes warning
                showSectionTimeWarning();
            }
        });

        function showSectionTimeWarning() {
            const minutes = Math.floor(sectionTimeRemaining / 60);
            const seconds = sectionTimeRemaining % 60;

            Swal.fire({
                icon: 'warning',
                title: 'Waktu Section Hampir Habis!',
                html: `
                    <p>Waktu untuk section ini akan berakhir dalam <strong>${minutes}:${seconds.toString().padStart(2, '0')}</strong></p>
                    <p>Pastikan semua jawaban sudah tersimpan.</p>
                `,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#ffc107'
            });
        }

        function updateNavigationButtons() {
            // Remove current class from all buttons first
            document.querySelectorAll('.question-nav-btn').forEach(btn => {
                btn.classList.remove('current');
            });

            // Add current class to the current question button
            const currentBtn = document.querySelector(`.question-nav-btn:nth-child(${currentQuestion})`);
            if (currentBtn) {
                currentBtn.classList.add('current');
            }
        }

        // Timer functionality
        function updateTimer() {
            const hours = Math.floor(timeRemaining / 3600);
            const minutes = Math.floor((timeRemaining % 3600) / 60);
            const seconds = timeRemaining % 60;

            const display =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('time-display').textContent = display;

            // Update section timer if it exists
            if (sectionTimeRemaining !== null) {
                const sectionMinutes = Math.floor(sectionTimeRemaining / 60);
                const sectionSeconds = sectionTimeRemaining % 60;
                const sectionDisplay =
                    `${sectionMinutes.toString().padStart(2, '0')}:${sectionSeconds.toString().padStart(2, '0')}`;

                const sectionTimerElement = document.getElementById('section-timer');
                if (sectionTimerElement) {
                    sectionTimerElement.textContent = sectionDisplay;

                    // Change color based on remaining time
                    if (sectionTimeRemaining <= 60) {
                        sectionTimerElement.style.color = '#d33';
                        sectionTimerElement.style.animation = 'blink 1s infinite';
                    } else if (sectionTimeRemaining <= 300) {
                        sectionTimerElement.style.color = '#ffc107';
                    }
                }
            }

            // Check for section time limit first
            if (sectionTimeRemaining !== null && sectionTimeRemaining <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Waktu Section Habis!',
                    text: 'Waktu untuk section ini telah berakhir. Akan dilanjutkan ke section berikutnya.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    if (currentSection < totalSections) {
                        goToSection(currentSection + 1);
                    } else {
                        submitExam();
                    }
                });
                return;
            }

            if (timeRemaining <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Waktu Habis!',
                    text: 'Waktu ujian telah berakhir. Ujian akan disubmit otomatis.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    submitExam();
                });
                return;
            }

            // Show section time warning
            if (sectionTimeRemaining !== null) {
                if (sectionTimeRemaining === 300) { // 5 minutes warning
                    showSectionTimeWarning();
                } else if (sectionTimeRemaining === 60) { // 1 minute warning
                    Swal.fire({
                        icon: 'error',
                        title: 'Peringatan Terakhir!',
                        text: 'Waktu section akan berakhir dalam 1 menit!',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#d33',
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
                sectionTimeRemaining--;
            }

            timeRemaining--;
        }

        // Start timer
        updateTimer();
        setInterval(updateTimer, 1000);

        // Question navigation
        function goToQuestion(questionNum) {
            if (questionNum >= 1 && questionNum <= totalQuestionsInSection) {
                // Set navigation flag before navigating
                if (lockscreenEnabled && window.setNavigationFlag) {
                    window.setNavigationFlag();
                }
                navigateToUrl(
                    `{{ route('ujian.peserta', $ujian->link ?? 'test') }}?section=${currentSection}&question=${questionNum}`
                    );
            }
        }

        function goToSection(sectionNum) {
            if (sectionNum >= 1 && sectionNum <= totalSections) {
                // Set navigation flag before navigating
                if (lockscreenEnabled && window.setNavigationFlag) {
                    window.setNavigationFlag();
                }
                navigateToUrl(
                    `{{ route('ujian.peserta', $ujian->link ?? 'test') }}?section=${sectionNum}&question=1`);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 1) {
                goToQuestion(currentQuestion - 1);
            } else if (currentSection > 1) {
                // Pindah ke section sebelumnya, soal terakhir
                if (lockscreenEnabled && window.setNavigationFlag) {
                    window.setNavigationFlag();
                }
                navigateToUrl(
                    `{{ route('ujian.peserta', $ujian->link ?? 'test') }}?section=${currentSection - 1}&question=last`);
            }
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestionsInSection) {
                goToQuestion(currentQuestion + 1);
            } else {
                nextSection();
            }
        }

        function nextSection() {
            if (currentSection < totalSections) {
                // Cek apakah masih ada soal yang belum dijawab di section ini
                const unansweredCount = totalQuestionsInSection - answeredQuestionsInSection.length;

                if (unansweredCount > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        html: `
                            <p>Masih ada <strong>${unansweredCount} soal</strong> yang belum dijawab di section ini.</p>
                            <p>Apakah Anda yakin ingin lanjut ke section berikutnya?</p>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Lanjut',
                        cancelButtonText: 'Kembali',
                        confirmButtonColor: '#ffc107',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            goToSection(currentSection + 1);
                        }
                    });
                } else {
                    goToSection(currentSection + 1);
                }
            } else {
                // Jika sudah section terakhir, submit ujian
                submitExam();
            }
        }

        // Save answer
        function saveAnswer() {
            const form = document.getElementById('exam-form');
            const formData = new FormData(form);
            formData.append('question', currentQuestion);

            fetch('{{ route('ujian.save-answer', $ujian->link ?? 'test') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI to show question as answered
                        updateQuestionStatus(currentQuestion, 'answered');

                        // Show success toast
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Jawaban tersimpan',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan',
                            text: 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error saving answer:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Bermasalah',
                        text: 'Tidak dapat menyimpan jawaban. Periksa koneksi internet Anda.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Listen for answer changes (radio buttons and text inputs)
        document.addEventListener('change', function(e) {
            //   console.log('Jawaban berubah:', e.target.name, e.target.value);
            if (e.target.name && e.target.name.startsWith('jawaban_')) {
                console.log('Jawaban berubah:', e.target.name, e.target.value);
                saveAnswer();
            }
        });

        // Also listen for text input changes with debouncing
        document.addEventListener('input', function(e) {
            if (e.target.name && e.target.name.startsWith('jawaban_') && e.target.type === 'text') {
                clearTimeout(window.saveTimeout);
                window.saveTimeout = setTimeout(() => {
                    saveAnswer();
                }, 1000); // Save after 1 second of no typing
            }
        });

        function updateQuestionStatus(questionNum, status) {
            const btn = document.querySelector(`.question-nav-btn:nth-child(${questionNum})`);
            if (btn) {
                btn.classList.remove('current', 'answered');
                if (status === 'answered') {
                    btn.classList.add('answered');
                    if (!answeredQuestionsInSection.includes(questionNum)) {
                        answeredQuestionsInSection.push(questionNum);
                    }
                } else if (status === 'current') {
                    btn.classList.add('current');
                }

                // Update progress untuk section saat ini
                document.querySelector('.progress-info strong').textContent =
                    `Section ${currentSection}: ${answeredQuestionsInSection.length}/${totalQuestionsInSection} dijawab`;
            }
        }

        function submitExam() {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi Submit',
                html: `
                    <p>Apakah Anda yakin ingin mengakhiri ujian?</p>
                    <div style="margin: 15px 0; padding: 10px; background: #f8f9fa; border-radius: 5px; font-size: 14px;">
                        <strong>Ringkasan Jawaban:</strong><br>
                        Total Section: ${totalSections}<br>
                        Total Soal: ${totalQuestions}<br>
                        Section Saat Ini: ${currentSection}<br>
                        Soal Dijawab di Section Ini: ${answeredQuestionsInSection.length}/${totalQuestionsInSection}
                    </div>
                    <p style="color: #d33; font-size: 14px;">Jawaban yang telah disimpan tidak dapat diubah lagi.</p>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Akhiri Ujian',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memproses hasil ujian Anda',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    navigateToUrl('{{ route('ujian.submit', $ujian->link ?? 'test') }}');
                }
            });
        }

        // Prevent cheating
        // document.addEventListener('keydown', function(e) {
        //     // Disable F12, Ctrl+Shift+I, Ctrl+U
        //     if (e.key === 'F12' ||
        //         (e.ctrlKey && e.shiftKey && e.key === 'I') ||
        //         (e.ctrlKey && e.key === 'u')) {
        //         e.preventDefault();

        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Aksi Tidak Diizinkan',
        //             text: 'Penggunaan developer tools tidak diperbolehkan selama ujian.',
        //             confirmButtonText: 'Mengerti'
        //         });

        //         return false;
        //     }
        // });

        // Disable right click
        // document.addEventListener('contextmenu', function(e) {
        //     e.preventDefault();

        //     Swal.fire({
        //         icon: 'warning',
        //         title: 'Right Click Dinonaktifkan',
        //         text: 'Right click tidak diperbolehkan selama ujian berlangsung.',
        //         confirmButtonText: 'Mengerti',
        //         timer: 2000,
        //         timerProgressBar: true
        //     });
        // });

        // Warn before leaving page
        // window.addEventListener('beforeunload', function(e) {
        //     e.preventDefault();
        //     e.returnValue = 'Anda akan keluar dari ujian. Pastikan jawaban sudah tersimpan.';
        // });

        // Cleanup lockscreen data when exam is submitted
        function cleanupLockscreenData() {
            if (lockscreenEnabled) {
                localStorage.removeItem('tabSwitchCount');
                localStorage.removeItem('lockscreenInitialWarningShown'); // Clean up the warning flag too
                document.body.classList.remove('lockscreen-active');
            }
        }

        // Safe navigation function that maintains lockscreen state
        function navigateToUrl(url) {
            // Set navigation flag for legitimate navigation
            if (lockscreenEnabled && window.setNavigationFlag) {
                window.setNavigationFlag();
            }

            // Don't cleanup on normal navigation, only on exam end
            if (url.includes('submit')) {
                cleanupLockscreenData();
            }
            window.location.href = url;
        }

        // Add cleanup to exam submission
        window.addEventListener('beforeunload', function(e) {
            // Only cleanup if we're actually leaving the exam domain
            if (!window.location.href.includes('ujian')) {
                cleanupLockscreenData();
            }
        });
    </script>
@endsection
