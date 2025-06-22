<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layouts.shared/title-meta', ['title' => 'تسجيل الدخول'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
    <style>
        body {
            background-color: {{ $ujian->ujianThema->background_color ?? '#f0f2f5' }};
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            direction: rtl;
        }

        @if ($ujian->ujianThema && $ujian->ujianThema->background_image_path)
            body.authentication-bg {
                background-image: url('{{ asset('storage/' . $ujian->ujianThema->background_image_path) }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        @endif

        .card-header {
            background-color: {{ $ujian->ujianThema->header_color ?? '#ffffff' }};
        }

        @if ($ujian->ujianThema && $ujian->ujianThema->use_custom_color)
            .btn-primary {
                background-color: {{ $ujian->ujianThema->button_color ?? '#0d6efd' }};
                border-color: {{ $ujian->ujianThema->button_color ?? '#0d6efd' }};
                color: {{ $ujian->ujianThema->button_font_color ?? 'white' }};
            }

            .text-primary {
                color: {{ $ujian->ujianThema->primary_color ?? '#0d6efd' }} !important;
            }

            .border-primary {
                border-color: {{ $ujian->ujianThema->secondary_color ?? '#0d6efd' }} !important;
            }
        @endif

        @if ($ujian->ujianThema && $ujian->ujianThema->font_color)
            .text-muted,
            .text-dark,
            h4,
            h5,
            label {
                color: {{ $ujian->ujianThema->font_color }} !important;
            }
        @endif

        @if ($ujian->ujianThema && $ujian->ujianThema->border_color)
            .card,
            .form-control,
            .input-group-text {
                border-color: {{ $ujian->ujianThema->border_color }} !important;
            }
        @endif
    </style>
</head>

<body class="authentication-bg position-relative"
    style="{{ $ujian->ujianThema ? 'background-color: ' . $ujian->ujianThema->background_color . ';' : '' }} {{ $ujian->ujianThema && $ujian->ujianThema->background_image_path ? 'background-image: url(\'' . asset('storage/' . $ujian->ujianThema->background_image_path) . '\'); background-size: cover; background-position: center;' : '' }}">

    {{-- <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns:svgjs="http://svgjs.com/svgjs" width="100%" height="100%" preserveAspectRatio="none"
            viewBox="0 0 1920 1028">
            <g mask="url(&quot;#SvgjsMask1166&quot;)" fill="none">
                <use xlink:href="#SvgjsSymbol1173" x="0" y="0"></use>
                <use xlink:href="#SvgjsSymbol1173" x="0" y="720"></use>
                <use xlink:href="#SvgjsSymbol1173" x="720" y="0"></use>
                <use xlink:href="#SvgjsSymbol1173" x="720" y="720"></use>
                <use xlink:href="#SvgjsSymbol1173" x="1440" y="0"></use>
                <use xlink:href="#SvgjsSymbol1173" x="1440" y="720"></use>
            </g>
            <defs>
                <mask id="SvgjsMask1166">
                    <rect width="1920" height="1028" fill="#ffffff"></rect>
                </mask>
                <path d="M-1 0 a1 1 0 1 0 2 0 a1 1 0 1 0 -2 0z" id="SvgjsPath1171"></path>
                <path d="M-3 0 a3 3 0 1 0 6 0 a3 3 0 1 0 -6 0z" id="SvgjsPath1170"></path>
                <path d="M-5 0 a5 5 0 1 0 10 0 a5 5 0 1 0 -10 0z" id="SvgjsPath1169"></path>
                <path d="M2 -2 L-2 2z" id="SvgjsPath1168"></path>
                <path d="M6 -6 L-6 6z" id="SvgjsPath1167"></path>
                <path d="M30 -30 L-30 30z" id="SvgjsPath1172"></path>
            </defs>
            <symbol id="SvgjsSymbol1173">
                <use xlink:href="#SvgjsPath1167" x="30" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="30" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="30" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="30" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="90" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="90" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="90" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="150" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="150" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="150" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="150" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="210" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="210" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="210" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="210" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="270" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="270" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="270" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="270" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="270" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1172" x="270" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"
                    stroke-width="3"></use>
                <use xlink:href="#SvgjsPath1171" x="270" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="330" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="330" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="330" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="390" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="390" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="390" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="390" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="390" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="390" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="390" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="390" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="450" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="450" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="450" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="450" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="450" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="450" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1172" x="450" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"
                    stroke-width="3"></use>
                <use xlink:href="#SvgjsPath1168" x="450" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="510" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="510" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1172" x="510" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"
                    stroke-width="3"></use>
                <use xlink:href="#SvgjsPath1171" x="510" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="510" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="510" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="510" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="570" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="570" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="570" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="570" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="570" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="570" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="570" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="570" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="630" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="630" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="630" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="630" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="630" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="630" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="690" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="690" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="690" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="690" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="690" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="690" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
            </symbol>
        </svg>
    </div> --}}
    {{-- <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <!-- Informasi Ujian Card -->
                    <div class="card mb-3">
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold mb-3">معلومات الاختبار</h6>
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">المدة</span>
                                        <span class="fw-semibold">{{ $ujian->durasi }} دقيقة</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">عدد الأقسام</span>
                                        <span class="fw-semibold">{{ $ujian->total_section }} قسم</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">عدد الأسئلة</span>
                                        <span class="fw-semibold">{{ $ujian->total_soal }} سؤال</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <a href="{{ route('any', 'index') }}">
                                <span><img src="/images/logo.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">تسجيل الدخول للاختبار</h4>
                                <p class="text-muted mb-4">أدخل بريدك الإلكتروني وكلمة المرور للوصول إلى الاختبار.</p>
                            </div>

                            <form action="{{ route('ujian.generateSession', $ujian->link) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">البريد الإلكتروني</label>
                                    <input class="form-control" type="email" id="emailaddress" name="email" required
                                        placeholder="أدخل بريدك الإلكتروني">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">كلمة المرور</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="أدخل كلمة المرور">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">تسجيل الدخول</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div> --}}

    <div class="account-pages pt-5 pb-4 d-flex flex-column min-vh-100">
        <div class="container flex-grow-1">

            <div class="text-center my-5">
                <!-- Logo -->
                <div class="text-center">
                    <a href="{{ route('any', 'index') }}">
                        @if ($ujian->ujianThema && $ujian->ujianThema->logo_path)
                            <span><img src="{{ asset('storage/' . $ujian->ujianThema->logo_path) }}" alt="logo"
                                    height="40"></span>
                        @else
                            <span><img src="/images/logo-dark.png" alt="logo" height="40"></span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- القسم العلوي: المعلومات والنموذج -->
            <div class="row justify-content-center mb-5">
                <!-- معلومات الاختبار -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-body">
                            <h4 class="fw-bold mb-2">{{ $ujian->nama_ujian }}</h4>
                            <p class="text-base mb-3">{{ $ujian->deskripsi }}</p>

                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>المدة</span>
                                <span class="fw-semibold text-dark">{{ $ujian->durasi }} دقيقة</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>عدد الأقسام</span>
                                <span class="fw-semibold text-dark">{{ $ujian->total_section }} قسم</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>عدد الأسئلة</span>
                                <span class="fw-semibold text-dark">{{ $ujian->total_soal }} سؤال</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نموذج تسجيل الدخول -->
                <div class="col-md-5">
                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-body p-4"
                            style="{{ $ujian->ujianThema && $ujian->ujianThema->header_color ? 'background-color: ' . $ujian->ujianThema->header_color . ';' : '' }}">
                            @if ($ujian->ujianThema && $ujian->ujianThema->institution_name)
                                <h4 class="fw-bold mb-3">{{ $ujian->ujianThema->institution_name }}</h4>
                            @else
                                <h4 class="fw-bold mb-3">تسجيل الدخول للاختبار</h4>
                            @endif
                            @if ($ujian->ujianThema && $ujian->ujianThema->welcome_message)
                                <p class="text-muted mb-4">{{ $ujian->ujianThema->welcome_message }}</p>
                            @else
                                <p class="text-muted mb-4">أدخل بياناتك للوصول إلى الاختبار</p>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('ujian.generateSession', $ujian->link) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">البريد الإلكتروني</label>
                                    <input class="form-control" type="email" id="emailaddress" name="email" required
                                        placeholder="أدخل بريدك الإلكتروني">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">كلمة المرور</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="أدخل كلمة المرور">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button class="btn btn-primary" type="submit"
                                        style="{{ $ujian->ujianThema && $ujian->ujianThema->button_color ? 'background-color: ' . $ujian->ujianThema->button_color . '; border-color: ' . $ujian->ujianThema->button_color . '; color: ' . ($ujian->ujianThema->button_font_color ?? 'white') . ';' : '' }}">تسجيل
                                        الدخول</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- القسم السفلي: التعليمات -->
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-3">تعليمات الاختبار</h4>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary me-3">
                                            <i class="ri-time-line fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mt-0 mb-1">إدارة الوقت</h5>
                                            <p class="text-muted">راقب الوقت المتبقي في الجزء العلوي من الشاشة. سيتم
                                                تقديم الاختبار تلقائيًا عند انتهاء الوقت.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary me-3">
                                            <i class="ri-file-list-3-line fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mt-0 mb-1">الأقسام والأسئلة</h5>
                                            <p class="text-muted">يتكون الاختبار من عدة أقسام. يجب إكمال كل قسم قبل
                                                الانتقال إلى القسم التالي.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary me-3">
                                            <i class="ri-save-line fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mt-0 mb-1">حفظ الإجابات</h5>
                                            <p class="text-muted">يتم حفظ إجاباتك تلقائيًا عند الانتقال إلى السؤال
                                                التالي أو القسم التالي.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary me-3">
                                            <i class="ri-error-warning-line fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="mt-0 mb-1">تجنب الغش</h5>
                                            <p class="text-muted">يحظر استخدام أدوات المطور أو تبديل علامات التبويب
                                                أثناء الاختبار. قد يؤدي ذلك إلى إنهاء الاختبار تلقائيًا.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <footer class="footer footer-alt">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                &copy; {{ date('Y') }} جميع الحقوق محفوظة
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        $(document).ready(function() {
            $('.password-eye').on('click', function() {
                var $this = $(this);
                var $input = $('#password');
                var $parent = $this.parent();

                if ($parent.attr('data-password') === 'false') {
                    $parent.attr('data-password', 'true');
                    $input.attr('type', 'text');
                    $this.addClass('show');
                } else {
                    $parent.attr('data-password', 'false');
                    $input.attr('type', 'password');
                    $this.removeClass('show');
                }
            });
        });
    </script>

</body>

</html>
