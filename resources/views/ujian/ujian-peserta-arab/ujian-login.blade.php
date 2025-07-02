<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @include('layouts.shared/title-meta', ['title' => 'تسجيل الدخول'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
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

         body {
             background-color: {{ $ujian->ujianThema->background_color ?? '#f0f2f5' }};
             font-family: 'Lotus Linotype Bold', 'Noto Kufi Arabic', 'Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif';
             font-size: 16px;
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
    </style>
</head>

<body class="authentication-bg position-relative">

    <div class="account-pages pt-5 pb-4 d-flex flex-column min-vh-100">
        <div class="container flex-grow-1">

            <div class="text-center mb-5">
                <!-- Logo -->
                <div class="text-center">
                    <a href="{{ route('home') }}">
                        @php
                            $branding = [
                                'logoHitam' =>
                                    \App\Models\SystemSetting::where('group', 'branding')
                                        ->where('key', 'logoHitam')
                                        ->value('value') ?? '',
                            ];
                        @endphp
                        <span>
                            <img src="{{ $branding['logoHitam'] ? asset($branding['logoHitam']) : asset('images/placeholder.jpeg') }}"
                                alt="logo" height="60">
                        </span>
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-md-10">
                    <div class="card card-header-form shadow-sm border-0 rounded-2 py-5 px-4">
                        @if ($ujian->ujianThema && $ujian->ujianThema->welcome_message)
                            <h4 class="fw-bold text-center">{{ $ujian->ujianThema->welcome_message }}</h4>
                        @endif
                    </div>
                </div>
            </div>

            <!-- الجزء العلوي: المعلومات والنموذج -->
            <div class="row justify-content-center mb-5">
                <!-- معلومات الاختبار -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-header">
                            @if ($ujian->ujianThema && $ujian->ujianThema->institution_name)
                                <h5 class="text-center mb-0">{{ $ujian->ujianThema->institution_name }}</h5>
                            @endif
                        </div>
                        <div class="card-body">
                            <h4 class="fw-bold mb-2">{{ $ujian->nama_ujian }}</h4>
                            <p class="text-base mb-3">{{ $ujian->deskripsi }}</p>

                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>المدة</span>
                                <span class="fw-semibold text-dark">{{ $ujian->durasi }} دقيقة</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>عدد الأقسام</span>
                                <span class="fw-semibold text-dark">{{ count($ujian->ujianSections) }} قسم</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted">
                                <span>عدد الأسئلة</span>
                                <span class="fw-semibold text-dark">
                                    {{ $ujian->ujianSections->flatMap->ujianSectionSoals->count() }} سؤال
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نموذج التسجيل -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-body">
                            <h4 class="fw-bold mb-2">تسجيل المشارك</h4>
                            <p class="text-base mb-4">املأ بياناتك الشخصية لبدء الاختبار</p>
                            <form method="POST" action="{{ route('ujian.generateSession', $ujian->link) }}" enctype="multipart/form-data" >
                                @if (sizeof($errors) > 0)
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @csrf

                                <input type="hidden" name="ujian_id" value="{{ $ujian->id }}">
                                <input type="hidden" name="ujian_link" value="{{ $ujian->link }}">
                                @if (isset($pesertaForm))
                                    @if (isset($pesertaForm['nama']) && $pesertaForm['nama'])
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">الاسم</label>
                                            <input class="form-control" type="text" id="nama" name="nama"
                                                placeholder="أدخل الاسم" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['email']) && $pesertaForm['email'])
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">البريد الإلكتروني</label>
                                            <input class="form-control" type="email" id="emailaddress" name="email"
                                                placeholder="أدخل بريدك الإلكتروني" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['phone']) && $pesertaForm['phone'])
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">رقم الهاتف</label>
                                            <input class="form-control" type="text" id="phone" name="phone"
                                                placeholder="أدخل رقم الهاتف" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['institusi']) && $pesertaForm['institusi'])
                                        <div class="mb-3">
                                            <label for="institusi" class="form-label">المؤسسة</label>
                                            <input class="form-control" type="text" id="institusi" name="institusi"
                                                placeholder="أدخل المؤسسة" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['nomor_induk']) && $pesertaForm['nomor_induk'])
                                        <div class="mb-3">
                                            <label for="nomor_induk" class="form-label">الرقم التعريفي</label>
                                            <input class="form-control" type="text" id="nomor_induk"
                                                name="nomor_induk" placeholder="أدخل الرقم التعريفي" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['tanggal_lahir']) && $pesertaForm['tanggal_lahir'])
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">تاريخ الميلاد</label>
                                            <input class="form-control" type="date" id="tanggal_lahir"
                                                name="tanggal_lahir" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['alamat']) && $pesertaForm['alamat'])
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">العنوان</label>
                                            <input class="form-control" type="text" id="alamat" name="alamat"
                                                placeholder="أدخل العنوان" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['foto']) && $pesertaForm['foto'])
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">الصورة</label>
                                            <input class="form-control" type="file" id="foto" name="foto"
                                                accept="image/*" required>
                                        </div>
                                    @endif
                                @endif

                                <div class=" mb-0">
                                    <button class="btn btn-primary" type="submit"> بدء الاختبار </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer>
            <div class="text-center">
                <p class="text-base mb-0">© {{ date('Y') }} <a href="{{ route('any', 'index') }}ml"
                        class="text-primary">MyLMS</a>. جميع الحقوق محفوظة.</p>
            </div>
        </footer>

    </div>

    <!-- end page -->
    <script>
        console.log(@json($ujian));
    </script>
    @vite(['resources/js/app.js'])
    @include('layouts.shared/footer-script')
</body>

</html>
