@extends('layouts.app-simple')

@section('title', 'الاختبار عبر الإنترنت')

@section('css')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            background-color: {{ $ujian->ujianThema && $ujian->ujianThema->background_color ? $ujian->ujianThema->background_color : '#f8f9fa' }};
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
            @if($ujian->ujianThema && $ujian->ujianThema->background_image_path)
            background-image: url('{{ asset("storage/" . $ujian->ujianThema->background_image_path) }}');
            background-size: cover;
            background-position: center;
            @endif
        }

        .exam-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 0 40px 0;
        }

        .exam-header {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->header_color ? $ujian->ujianThema->header_color : 'white' }};
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            @if($ujian->ujianThema && $ujian->ujianThema->header_image_path)
            background-image: url('{{ asset("storage/" . $ujian->ujianThema->header_image_path) }}');
            background-size: cover;
            background-position: center;
            @endif
        }

        .exam-title {
            font-size: 24px;
            font-weight: bold;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#333' }};
            margin: 0;
        }

        .timer {
            background: {{ $ujian->ujianThema && $ujian->ujianThema->button_color ? $ujian->ujianThema->button_color : '#d33' }};
            color: {{ $ujian->ujianThema && $ujian->ujianThema->button_font_color ? $ujian->ujianThema->button_font_color : 'white' }};
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
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-info {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-right: 4px solid {{ $ujian->ujianThema && $ujian->ujianThema->border_color ? $ujian->ujianThema->border_color : '#2196f3' }};
            border-left: none;
        }

        .section-title {
            font-weight: bold;
            color: {{ $ujian->ujianThema && $ujian->ujianThema->font_color ? $ujian->ujianThema->font_color : '#1976d2' }};
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
            border-radius: 8px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .answer-option input[type="radio"] {
            margin-left: 12px;
            margin-right: 0;
            transform: scale(1.2);
            accent-color: #2196f3;
            flex-shrink: 0;
        }

        .answer-option input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s;
            text-align: right;
            direction: rtl;
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
            margin: 0;
            flex-grow: 1;
            direction: rtl;
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
            background: #2196f3;
            color: white;
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

        /* تصميم متجاوب للجوال */
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

        /* تحسينات مشغل الصوت */
        .audio-player audio::-webkit-media-controls-panel {
            background-color: #2196f3;
        }

        .audio-player audio::-webkit-media-controls-play-button {
            background-color: #2196f3;
            border-radius: 50%;
        }

        /* رسوم متحركة لمؤقت القسم */
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

        /* أنماط التحذير لمؤقت القسم */
        .section-timer-warning {
            animation: blink 1s infinite;
            color: #d33 !important;
            font-weight: bold;
        }

        /* أنماط قفل الشاشة */
        .lockscreen-indicator {
            position: fixed;
            top: 10px;
            left: 10px;
            right: auto;
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
            0%, 100% { background: rgba(220, 53, 69, 0.1); }
            50% { background: rgba(220, 53, 69, 0.3); }
        }

        /* تعطيل تحديد النص عندما يكون قفل الشاشة نشطًا */
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
    <!-- مؤشر قفل الشاشة -->
    @if($lockscreenEnabled)
        <div class="lockscreen-indicator active" id="lockscreenIndicator">
            🔒 قفل الشاشة نشط
        </div>
        <div class="lockscreen-warning-overlay" id="lockscreenOverlay"></div>
    @endif

    <div class="exam-container @if($lockscreenEnabled) lockscreen-active @endif">
        <!-- الرأس -->
        <div class="exam-header">
            <div>
                <h1 class="exam-title">{{ $ujian->nama_ujian ?? 'اختبار' }}</h1>
                <div style="margin-top: 8px; font-size: 14px; color: #666;">
                    <strong>القسم {{ $currentSectionNumber ?? 1 }} من {{ $totalSections ?? 1 }}</strong>
                    | {{ $totalQuestionsInSection ?? 0 }} سؤال في هذا القسم
                    | المجموع: {{ $totalQuestions ?? 0 }} سؤال
                </div>
                @if (isset($sectionTimeRemaining) && $sectionTimeRemaining !== null)
                    <div style="margin-top: 5px; font-size: 12px; color: #d33; font-weight: bold;">
                        ⏱️ وقت القسم: <span id="section-timer">{{ gmdate('i:s', $sectionTimeRemaining) }}</span>
                    </div>
                @endif
            </div>
            <div class="timer" id="timer">
                <span id="time-display">119:11</span>
            </div>
        </div>

        <div class="exam-content">
            <!-- لوحة الأسئلة -->
            <div class="question-panel">
                <!-- معلومات القسم -->
                <div class="section-info">
                    <div class="section-title">{{ $currentSection->nama ?? 'القسم ' . ($currentSectionNumber ?? 1) }}
                    </div>
                    <div class="section-instruction">
                        {{ $currentSection->instruksi ?? 'أجب على الأسئلة التالية بدقة.' }}
                    </div>
                    <div style="margin-top: 8px; font-size: 12px; color: #888;">
                        مدة القسم: {{ $currentSection->durasi ?? '-' }} دقيقة
                        | الأسئلة في القسم: {{ $totalQuestionsInSection ?? 0 }}
                    </div>
                </div>

                <!-- السؤال -->
                <div class="question-number">
                    سؤال {{ $currentQuestionNumber ?? 1 }} من {{ $totalQuestionsInSection ?? 6 }}
                    <span style="color: #999;">(القسم {{ $currentSectionNumber ?? 1 }})</span>
                </div>

                @if (isset($currentQuestion) && $currentQuestion->jenis_isian)
                    <div
                        class="question-type-indicator
                        @if ($currentQuestion->jenis_isian === 'multiple_choice' || $currentQuestion->jenis_isian === 'pilihan_ganda') type-multiple-choice
                        @elseif($currentQuestion->jenis_isian === 'isian') type-essay
                        @elseif($currentQuestion->jenis_isian === 'true_false') type-true-false @endif">
                        @if ($currentQuestion->jenis_isian === 'multiple_choice' || $currentQuestion->jenis_isian === 'pilihan_ganda')
                            اختيار متعدد
                        @elseif($currentQuestion->jenis_isian === 'isian')
                            إجابة مقالية
                        @elseif($currentQuestion->jenis_isian === 'true_false')
                            صح/خطأ
                        @endif
                    </div>
                @endif

                    @if (isset($currentQuestion))
                        @if ($currentQuestion->is_audio && $currentQuestion->audio_file)
                            <div class="audio-player">
                                <audio controls preload="metadata">
                                    <source src="{{ asset('/' . $currentQuestion->audio_file) }}" type="audio/mpeg">
                                    متصفحك لا يدعم عنصر الصوت.
                                </audio>
                            </div>
                        @endif

                        <div class="question-text">
                            {{ $currentQuestion->pertanyaan ?? 'اختر الجمع الصحيح لكلمة "مؤنث"' }}
                        </div>
                    @endif
                <!-- خيارات الإجابة -->
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
                                        <p>لا توجد خيارات إجابة متاحة لهذا السؤال.</p>
                                    </li>
                                @endif
                            @elseif($currentQuestion->jenis_isian === 'isian')
                                <li class="answer-option">
                                    <input type="text" name="jawaban_{{ $currentQuestion->id }}"
                                        id="jawaban_{{ $currentQuestion->id }}" placeholder="اكتب إجابتك هنا..."
                                        value="{{ $savedTextAnswers[$currentQuestion->id] ?? '' }}">
                                </li>
                            @elseif($currentQuestion->jenis_isian === 'true_false')
                                <li class="answer-option">
                                    <input type="radio" name="jawaban_{{ $currentQuestion->id }}"
                                        id="jawaban_true_{{ $currentQuestion->id }}" value="true"
                                        {{ isset($savedTextAnswers[$currentQuestion->id]) && $savedTextAnswers[$currentQuestion->id] === 'true' ? 'checked' : '' }}>
                                    <label for="jawaban_true_{{ $currentQuestion->id }}">صحيح (True)</label>
                                </li>
                                <li class="answer-option">
                                    <input type="radio" name="jawaban_{{ $currentQuestion->id }}"
                                        id="jawaban_false_{{ $currentQuestion->id }}" value="false"
                                        {{ isset($savedTextAnswers[$currentQuestion->id]) && $savedTextAnswers[$currentQuestion->id] === 'false' ? 'checked' : '' }}>
                                    <label for="jawaban_false_{{ $currentQuestion->id }}">خطأ (False)</label>
                                </li>
                            @endif
                        @else
                            {{-- لا توجد أسئلة وهمية/إجابات هنا، تظهر فقط إذا كانت البيانات موجودة --}}
                        @endif
                    </ul>
                </form>


                <!-- تقدم القسم -->
                <div class="section-progress">
                    <div class="section-progress-bar">
                        <div class="section-progress-fill"
                            style="width: {{ (($answeredCountInSection ?? 0) / ($totalQuestionsInSection ?? 1)) * 100 }}%;">
                        </div>
                    </div>
                    <div style="font-size: 12px; color: #666; text-align: left;">
                        {{ $answeredCountInSection ?? 0 }} من {{ $totalQuestionsInSection ?? 0 }} سؤال تمت الإجابة عليه
                    </div>
                </div>
            </div>

            <!-- لوحة التنقل -->
            <div class="navigation-panel">
                <!-- التقدم العام -->
                <div class="section-progress">
                    <div style="font-size: 12px; font-weight: bold; color: #666; margin-bottom: 5px;">
                        التقدم الكلي
                    </div>
                    <div class="section-progress-bar">
                        <div class="section-progress-fill"
                            style="width: {{ $totalQuestions > 0 ? ($totalAnsweredQuestions / $totalQuestions) * 100 : 0 }}%">
                        </div>
                    </div>
                    <div style="font-size: 11px; color: #888; margin-top: 3px;">
                        {{ $totalAnsweredQuestions ?? 0 }}/{{ $totalQuestions ?? 6 }} سؤال تمت الإجابة عليه
                    </div>
                </div>

                <!-- التنقل بين الأقسام -->
                @if (($totalSections ?? 1) > 1)
                    <div style="margin-bottom: 15px;">
                        <div style="font-size: 12px; font-weight: bold; margin-bottom: 8px; color: #666;">
                            التنقل بين الأقسام:
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
                                    title="القسم {{ $sectionData['number'] }}: {{ $sectionData['answered'] }}/{{ $sectionData['total'] }} تمت الإجابة">
                                    ق{{ $sectionData['number'] }}
                                    <br>
                                    <span
                                        style="font-size: 10px;">{{ $sectionData['answered'] }}/{{ $sectionData['total'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- تقدم القسم الحالي -->
                <div class="progress-info">
                    <strong>القسم {{ $currentSectionNumber ?? 1 }}:
                        {{ $answeredCountInSection ?? 0 }}/{{ $totalQuestionsInSection ?? 6 }} تمت الإجابة</strong>
                    <div class="section-progress-bar" style="margin: 8px 0;">
                        <div class="section-progress-fill"
                            style="width: {{ $totalQuestionsInSection > 0 ? ($answeredCountInSection / $totalQuestionsInSection) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- المفتاح -->
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color legend-current"></div>
                        <span>الحالي</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-answered"></div>
                        <span>تمت الإجابة</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color legend-unanswered"></div>
                        <span>لم تتم الإجابة</span>
                    </div>
                </div>

                <!-- التنقل بين الأسئلة (للقسم الحالي) -->
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

                <!-- التنقل بين الأقسام (أزرار صغيرة لكل قسم) -->
                <div class="section-nav-container">
                    @for ($s = 1; $s <= ($totalSections ?? 1); $s++)
                        <button
                            class="section-nav-btn
                            {{ $s == ($currentSectionNumber ?? 1) ? 'active' : '' }}
                            {{ in_array($s, $completedSections ?? []) ? 'completed' : '' }}"
                            onclick="goToSection({{ $s }})">
                            ق{{ $s }}
                        </button>
                    @endfor
                </div>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="control-buttons">
            <button class="btn-prev" onclick="previousQuestion()"
                {{ ($currentQuestionNumber ?? 1) <= 1 ? 'disabled' : '' }}>
                السابق ←
            </button>
            <div style="display: flex; gap: 10px;">
                @if (
                    ($currentQuestionNumber ?? 1) == ($totalQuestionsInSection ?? 6) &&
                        ($currentSectionNumber ?? 1) < ($totalSections ?? 1))
                    <button class="btn btn-warning" onclick="nextSection()"
                        style="padding: 12px 24px; border: none; border-radius: 8px; font-weight: bold;">
                        الانتقال إلى القسم {{ ($currentSectionNumber ?? 1) + 1 }} →
                    </button>
                @elseif(
                    ($currentQuestionNumber ?? 1) == ($totalQuestionsInSection ?? 6) &&
                        ($currentSectionNumber ?? 1) == ($totalSections ?? 1))
                    <button class="btn-next" onclick="submitExam()">
                        تسليم نتائج الاختبار
                    </button>
                @else
                    <button class="btn-next" onclick="nextQuestion()">
                        التالي →
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

        // وظيفة تمكين وضع ملء الشاشة
        function enableFullscreen() {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                // enableFullscreen(); // تم تعطيل وضع ملء الشاشة مؤقتاً
            }, 1000);
        });

        let currentQuestion = {{ $currentQuestionNumber ?? 1 }};
        let currentSection = {{ $currentSectionNumber ?? 1 }};
        let totalQuestions = {{ $totalQuestions ?? 6 }};
        let totalQuestionsInSection = {{ $totalQuestionsInSection ?? 6 }};
        let totalSections = {{ $totalSections ?? 1 }};
        let timeRemaining = {{ $timeRemaining ?? 7151 }}; // بالثواني
        let sectionTimeRemaining = {{ $sectionTimeRemaining ?? 'null' }}; // حد وقت القسم
        let answeredQuestionsInSection = @json($answeredQuestionsInSection ?? []);
        let lockscreenEnabled = {{ $lockscreenEnabled ? 'true' : 'false' }};

        // وظائف قفل الشاشة
        if (lockscreenEnabled) {
            // تتبع تبديل علامات التبويب
            let isTabActive = true;
            let tabSwitchCount = 0;
            const maxTabSwitches = 3; // الحد الأقصى المسموح به لتبديل علامات التبويب
            let isNavigating = false; // علامة لتتبع التنقل المشروع
            let hasShownInitialWarning = localStorage.getItem('lockscreenInitialWarningShown') === 'true';

            // منع قائمة السياق (النقر بزر الماوس الأيمن)
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showLockscreenWarning('تم تعطيل قائمة السياق أثناء الاختبار.');
                return false;
            });

            // منع اختصارات لوحة المفاتيح
            document.addEventListener('keydown', function(e) {
                // منع F12 (أدوات المطور)
                if (e.keyCode === 123) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل أدوات المطور أثناء الاختبار.');
                    return false;
                }

                // منع Ctrl+Shift+I (أدوات المطور)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل أدوات المطور أثناء الاختبار.');
                    return false;
                }

                // منع Ctrl+Shift+C (تحديد العنصر)
                if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل فحص العنصر أثناء الاختبار.');
                    return false;
                }

                // منع Ctrl+U (عرض المصدر)
                if (e.ctrlKey && e.keyCode === 85) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل عرض المصدر أثناء الاختبار.');
                    return false;
                }

                // منع Ctrl+S (حفظ الصفحة)
                if (e.ctrlKey && e.keyCode === 83) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل حفظ الصفحة أثناء الاختبار.');
                    return false;
                }

                // منع Ctrl+C (نسخ) - السماح في حقول الإدخال
                if (e.ctrlKey && e.keyCode === 67 && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل النسخ أثناء الاختبار.');
                    return false;
                }

                // منع Ctrl+V (لصق) - السماح في حقول الإدخال
                if (e.ctrlKey && e.keyCode === 86 && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل اللصق أثناء الاختبار.');
                    return false;
                }

                // منع Alt+Tab (تبديل المهام) - فعالية محدودة
                if (e.altKey && e.keyCode === 9) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل تبديل المهام أثناء الاختبار.');
                    return false;
                }

                // منع مفتاح Windows
                if (e.keyCode === 91 || e.keyCode === 92) {
                    e.preventDefault();
                    showLockscreenWarning('تم تعطيل مفتاح Windows أثناء الاختبار.');
                    return false;
                }
            });

            // تتبع رؤية الصفحة (اكتشاف تبديل علامات التبويب)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    isTabActive = false;

                    // يتم احتسابها كمخالفة فقط إذا لم تكن تنقلًا مشروعًا
                    if (!isNavigating) {
                        tabSwitchCount++;
                        console.log('تم تبديل علامة التبويب (مخالفة)، العدد:', tabSwitchCount);

                        // تخزين تبديل علامة التبويب في الجلسة/التخزين المحلي للتتبع
                        localStorage.setItem('tabSwitchCount', tabSwitchCount);

                        // تحديث المؤشر
                        updateLockscreenIndicator(tabSwitchCount);

                        if (tabSwitchCount >= maxTabSwitches) {
                            // فرض تقديم الاختبار بعد الحد الأقصى من المخالفات
                            Swal.fire({
                                icon: 'error',
                                title: 'انتهى الاختبار!',
                                html: `
                                    <p>لقد ارتكبت مخالفات كثيرة جدًا.</p>
                                    <p>سيتم إنهاء الاختبار تلقائيًا.</p>
                                `,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                // تقديم الاختبار تلقائيًا
                                navigateToUrl(`{{ route('ujian.submit', $ujian->link) }}`);
                            });
                        }
                    } else {
                        console.log('تم تبديل علامة التبويب (تنقل) - مسموح به');
                    }
                } else {
                    isTabActive = true;

                    // إعادة تعيين علامة التنقل عند العودة إلى علامة التبويب
                    if (isNavigating) {
                        isNavigating = false;
                        console.log('العودة من التنقل');
                    } else if (tabSwitchCount > 0 && tabSwitchCount < maxTabSwitches) {
                        // إظهار التحذير فقط إذا لم نعرض التحذير الأولي بعد
                        if (hasShownInitialWarning) {
                            showTabSwitchWarning();
                        }
                    }
                }
            });

            // منع الطباعة
            window.addEventListener('beforeprint', function(e) {
                e.preventDefault();
                showLockscreenWarning('تم تعطيل طباعة الصفحة أثناء الاختبار.');
                return false;
            });

            // مراقبة أدوات المطور (اكتشاف أساسي)
            let devtools = {
                open: false,
                orientation: null
            };

            setInterval(function() {
                if (window.outerHeight - window.innerHeight > 200 || window.outerWidth - window.innerWidth > 200) {
                    if (!devtools.open) {
                        devtools.open = true;
                        showLockscreenWarning('تم اكتشاف أدوات المطور. يرجى إغلاقها لمواصلة الاختبار.');
                    }
                } else {
                    devtools.open = false;
                }
            }, 500);

            function showLockscreenWarning(message) {
                // إظهار تراكب مرئي
                const overlay = document.getElementById('lockscreenOverlay');
                if (overlay) {
                    overlay.classList.add('show');
                    setTimeout(() => {
                        overlay.classList.remove('show');
                    }, 1000);
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'تحذير قفل الشاشة!',
                    text: message,
                    confirmButtonText: 'فهمت',
                    confirmButtonColor: '#dc3545'
                });
            }

            function showTabSwitchWarning() {
                const remaining = maxTabSwitches - tabSwitchCount;
                Swal.fire({
                    icon: 'error',
                    title: 'تحذير: تم اكتشاف تبديل علامة التبويب!',
                    html: `
                        <p>لقد قمت بتبديل علامة التبويب <strong>${tabSwitchCount}</strong> مرة.</p>
                        <p>التحذيرات المتبقية: <strong>${remaining}</strong></p>
                        <p class="text-danger">إذا وصلت إلى الحد الأقصى، سينتهي الاختبار تلقائيًا!</p>
                    `,
                    confirmButtonText: 'أنا أفهم',
                    confirmButtonColor: '#dc3545'
                });
            }

            // إظهار معلومات قفل الشاشة الأولية - مرة واحدة فقط لكل جلسة اختبار
            if (!hasShownInitialWarning) {
                Swal.fire({
                    icon: 'info',
                    title: 'قفل الشاشة نشط',
                    html: `
                        <p>يستخدم هذا الاختبار نظام قفل الشاشة للحفاظ على النزاهة.</p>
                        <p><strong>ما هو غير مسموح به:</strong></p>
                        <ul style="text-align: right; margin-right: 20px;">
                            <li>تبديل علامات التبويب للتصفح (الحد الأقصى ${maxTabSwitches} مرات)</li>
                            <li>فتح قائمة السياق (النقر بزر الماوس الأيمن)</li>
                            <li>استخدام أدوات المطور</li>
                            <li>استخدام اختصارات لوحة المفاتيح المحددة</li>
                            <li>طباعة الصفحة</li>
                        </ul>
                        <p class="text-success">✅ التنقل بين الأسئلة والأقسام مسموح به</p>
                        <p class="text-warning">المخالفات المتكررة ستنهي الاختبار تلقائيًا!</p>
                    `,
                    confirmButtonText: 'أنا أفهم وجاهز للبدء',
                    confirmButtonColor: '#007bff',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    // وضع علامة على أن التحذير الأولي قد تم عرضه
                    localStorage.setItem('lockscreenInitialWarningShown', 'true');
                    hasShownInitialWarning = true;
                });
            }

            // تحميل عدد تبديلات علامة التبويب من التخزين إذا كان موجودًا
            const storedCount = localStorage.getItem('tabSwitchCount');
            if (storedCount) {
                tabSwitchCount = parseInt(storedCount);
            }

            // إضافة فئة قفل الشاشة إلى الجسم
            document.body.classList.add('lockscreen-active');

            // وظيفة لتعيين علامة التنقل
            window.setNavigationFlag = function() {
                isNavigating = true;
                console.log('تم تعيين علامة التنقل - مسموح بتبديل علامة التبويب');

                // إعادة تعيين العلامة تلقائيًا بعد 3 ثوانٍ كإجراء أمان
                setTimeout(() => {
                    if (isNavigating) {
                        isNavigating = false;
                        console.log('إعادة تعيين علامة التنقل تلقائيًا');
                    }
                }, 3000);
            };

            // تحديث مؤشر قفل الشاشة
            function updateLockscreenIndicator(violations) {
                const indicator = document.getElementById('lockscreenIndicator');
                if (indicator) {
                    if (violations >= maxTabSwitches) {
                        indicator.style.background = '#dc3545';
                        indicator.innerHTML = '🚫 قفل الشاشة - تجاوز حد المخالفات';
                    } else if (violations > 0) {
                        indicator.style.background = '#ffc107';
                        indicator.innerHTML = `⚠️ قفل الشاشة - ${violations}/${maxTabSwitches} مخالفات`;
                    } else {
                        indicator.style.background = '#28a745';
                        indicator.innerHTML = '🔒 قفل الشاشة نشط';
                    }
                }
            }

            // تحديث المؤشر الأولي
            updateLockscreenIndicator(tabSwitchCount);
        }

        // تحديث أزرار التنقل عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateNavigationButtons();

            // إظهار تحذير وقت القسم إذا كان قابلاً للتطبيق
            if (sectionTimeRemaining !== null && sectionTimeRemaining < 300) { // تحذير 5 دقائق
                showSectionTimeWarning();
            }
        });

        function showSectionTimeWarning() {
            const minutes = Math.floor(sectionTimeRemaining / 60);
            const seconds = sectionTimeRemaining % 60;

            Swal.fire({
                icon: 'warning',
                title: 'وقت القسم على وشك الانتهاء!',
                html: `
                    <p>سينتهي وقت هذا القسم في <strong>${minutes}:${seconds.toString().padStart(2, '0')}</strong></p>
                    <p>تأكد من حفظ جميع الإجابات.</p>
                `,
                confirmButtonText: 'فهمت',
                confirmButtonColor: '#ffc107'
            });
        }

        function updateNavigationButtons() {
            // إزالة فئة الحالي من جميع الأزرار أولاً
            document.querySelectorAll('.question-nav-btn').forEach(btn => {
                btn.classList.remove('current');
            });

            // إضافة فئة الحالي إلى زر السؤال الحالي
            const currentBtn = document.querySelector(`.question-nav-btn:nth-child(${currentQuestion})`);
            if (currentBtn) {
                currentBtn.classList.add('current');
            }
        }

        // وظيفة المؤقت
        function updateTimer() {
            const hours = Math.floor(timeRemaining / 3600);
            const minutes = Math.floor((timeRemaining % 3600) / 60);
            const seconds = timeRemaining % 60;

            const display =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('time-display').textContent = display;

            // تحديث مؤقت القسم إذا كان موجودًا
            if (sectionTimeRemaining !== null) {
                const sectionMinutes = Math.floor(sectionTimeRemaining / 60);
                const sectionSeconds = sectionTimeRemaining % 60;
                const sectionDisplay =
                    `${sectionMinutes.toString().padStart(2, '0')}:${sectionSeconds.toString().padStart(2, '0')}`;

                const sectionTimerElement = document.getElementById('section-timer');
                if (sectionTimerElement) {
                    sectionTimerElement.textContent = sectionDisplay;

                    // تغيير اللون بناءً على الوقت المتبقي
                    if (sectionTimeRemaining <= 60) {
                        sectionTimerElement.style.color = '#d33';
                        sectionTimerElement.style.animation = 'blink 1s infinite';
                    } else if (sectionTimeRemaining <= 300) {
                        sectionTimerElement.style.color = '#ffc107';
                    }
                }
            }

            // التحقق من حد وقت القسم أولاً
            if (sectionTimeRemaining !== null && sectionTimeRemaining <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'انتهى وقت القسم!',
                    text: 'انتهى وقت هذا القسم. سيتم الانتقال إلى القسم التالي.',
                    confirmButtonText: 'موافق',
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
                    title: 'انتهى الوقت!',
                    text: 'انتهى وقت الاختبار. سيتم تقديم الاختبار تلقائيًا.',
                    confirmButtonText: 'موافق',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    submitExam();
                });
                return;
            }

            // إظهار تحذير وقت القسم
            if (sectionTimeRemaining !== null) {
                if (sectionTimeRemaining === 300) { // تحذير 5 دقائق
                    showSectionTimeWarning();
                } else if (sectionTimeRemaining === 60) { // تحذير دقيقة واحدة
                    Swal.fire({
                        icon: 'error',
                        title: 'التحذير الأخير!',
                        text: 'سينتهي وقت القسم في دقيقة واحدة!',
                        confirmButtonText: 'فهمت',
                        confirmButtonColor: '#d33',
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
                sectionTimeRemaining--;
            }

            timeRemaining--;
        }

        // بدء المؤقت
        updateTimer();
        setInterval(updateTimer, 1000);

        // التنقل بين الأسئلة
        function goToQuestion(questionNum) {
            if (questionNum >= 1 && questionNum <= totalQuestionsInSection) {
                // تعيين علامة التنقل قبل التنقل
                if (lockscreenEnabled && window.setNavigationFlag) {
                    window.setNavigationFlag();
                }
                navigateToUrl(
                    `{{ route('ujian.peserta', $ujian->link ?? 'test') }}?section=${currentSection}&question=${questionNum}`);
            }
        }

        function goToSection(sectionNum) {
            if (sectionNum >= 1 && sectionNum <= totalSections) {
                // تعيين علامة التنقل قبل التنقل
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
                // الانتقال إلى القسم السابق، السؤال الأخير
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
                // التحقق مما إذا كان هناك أسئلة لم تتم الإجابة عليها في هذا القسم
                const unansweredCount = totalQuestionsInSection - answeredQuestionsInSection.length;

                if (unansweredCount > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'انتبه!',
                        html: `
                            <p>لا يزال هناك <strong>${unansweredCount} سؤال</strong> لم تتم الإجابة عليه في هذا القسم.</p>
                            <p>هل أنت متأكد من أنك تريد الانتقال إلى القسم التالي؟</p>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'نعم، انتقل',
                        cancelButtonText: 'العودة',
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
                // إذا كان هذا هو القسم الأخير، قم بتقديم الاختبار
                submitExam();
            }
        }

        // حفظ الإجابة
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
                    console.log('تم حفظ الإجابة:', data);

                    // تحديث واجهة المستخدم لتعكس الإجابة المحفوظة
                    if (data.success) {
                        // تحديث مصفوفة الأسئلة التي تمت الإجابة عليها
                        if (!answeredQuestionsInSection.includes(currentQuestion)) {
                            answeredQuestionsInSection.push(currentQuestion);
                        }

                        // تحديث زر التنقل للسؤال الحالي
                        const currentBtn = document.querySelector(`.question-nav-btn:nth-child(${currentQuestion})`);
                        if (currentBtn) {
                            currentBtn.classList.add('answered');
                        }

                        // تحديث شريط التقدم
                        const progressFill = document.querySelector('.section-progress-fill');
                        if (progressFill) {
                            const percentage = (answeredQuestionsInSection.length / totalQuestionsInSection) * 100;
                            progressFill.style.width = `${percentage}%`;
                        }

                        // تحديث نص التقدم
                        const progressText = document.querySelector('.section-progress div');
                        if (progressText) {
                            progressText.textContent = `${answeredQuestionsInSection.length} من ${totalQuestionsInSection} سؤال تمت الإجابة عليه`;
                        }
                    }
                })
                .catch(error => {
                    console.error('خطأ في حفظ الإجابة:', error);
                });
        }

        // معالجة تغييرات الإدخال لحفظ الإجابات
        document.addEventListener('DOMContentLoaded', function() {
            // معالجة تغييرات زر الراديو
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    saveAnswer();
                });
            });

            // معالجة تغييرات حقل النص (مع تأخير)
            let debounceTimeout;
            document.querySelectorAll('input[type="text"], textarea').forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(() => {
                        saveAnswer();
                    }, 1000); // حفظ بعد ثانية واحدة من التوقف عن الكتابة
                });
            });
        });

        // تحديث واجهة المستخدم بناءً على حالة السؤال
        function updateUI() {
            // تحديث أزرار التنقل
            document.querySelectorAll('.question-nav-btn').forEach((btn, index) => {
                const questionNum = index + 1;
                if (answeredQuestionsInSection.includes(questionNum)) {
                    btn.classList.add('answered');
                }
                if (questionNum === currentQuestion) {
                    btn.classList.add('current');
                } else {
                    btn.classList.remove('current');
                }
            });
        }

        // تحديث حالة السؤال في واجهة المستخدم
        function updateQuestionStatus(questionNum, status) {
            const navBtn = document.querySelector(`[onclick="goToQuestion(${questionNum})"]`);
            if (navBtn) {
                navBtn.classList.remove('answered', 'current');
                if (status === 'answered') {
                    navBtn.classList.add('answered');
                    if (!answeredQuestionsInSection.includes(questionNum)) {
                        answeredQuestionsInSection.push(questionNum);
                    }
                } else if (status === 'current') {
                    navBtn.classList.add('current');
                }
            }
        }

        // تقديم الاختبار
        function submitExam() {
            Swal.fire({
                icon: 'question',
                title: 'هل أنت متأكد من تقديم الاختبار؟',
                html: `
                    <p>بمجرد التقديم، لن تتمكن من العودة وتغيير إجاباتك.</p>
                    <p>الأسئلة التي تمت الإجابة عليها: <strong>${answeredQuestionsInSection.length}/${totalQuestionsInSection}</strong> (القسم الحالي)</p>
                `,
                showCancelButton: true,
                confirmButtonText: 'نعم، قدم الاختبار',
                cancelButtonText: 'العودة',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    // تعيين علامة التنقل قبل التقديم
                    if (lockscreenEnabled && window.setNavigationFlag) {
                        window.setNavigationFlag();
                    }
                    navigateToUrl('{{ route('ujian.submit', $ujian->link ?? 'test') }}');
                }
            });
        }

        // التنقل إلى عنوان URL
        function navigateToUrl(url) {
            // تنظيف بيانات قفل الشاشة قبل المغادرة
            if (lockscreenEnabled) {
                // لا تقم بتنظيف عدد تبديلات علامة التبويب عند التنقل داخل الاختبار
                // localStorage.removeItem('tabSwitchCount');
            }

            window.location.href = url;
        }

        // تنظيف بيانات قفل الشاشة عند تقديم الاختبار أو مغادرة مجال الاختبار
        window.addEventListener('beforeunload', function(e) {
            // التحقق مما إذا كان المستخدم يغادر مجال الاختبار
            const currentDomain = window.location.hostname;
            const examDomain = '{{ request()->getHost() }}';

            if (currentDomain !== examDomain) {
                // تنظيف بيانات قفل الشاشة
                localStorage.removeItem('tabSwitchCount');
                localStorage.removeItem('lockscreenInitialWarningShown');
            }
        });

        // تنظيف بيانات قفل الشاشة
        function cleanupLockscreenData() {
            // إزالة بيانات قفل الشاشة من localStorage
            localStorage.removeItem('lockscreen_violations');
            localStorage.removeItem('lockscreen_warnings');
            localStorage.removeItem('tab_switch_count');
            localStorage.removeItem('exam_start_time');
            
            // إعادة تعيين المتغيرات
            tabSwitchCount = 0;
            isTabActive = true;
            
            console.log('تم تنظيف بيانات قفل الشاشة');
        }

        // منع الغش (تم تعطيله لصالح نهج قفل الشاشة الأكثر تقدمًا أعلاه)
        /*
        // منع أدوات المطور
        document.addEventListener('keydown', function(e) {
            if (e.keyCode == 123) { // F12
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) { // Ctrl+Shift+I
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) { // Ctrl+Shift+C
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) { // Ctrl+Shift+J
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) { // Ctrl+U
                return false;
            }
        });

        // منع النقر بزر الماوس الأيمن
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // منع مغادرة الصفحة
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = '';
        });
        */
    </script>
@endsection