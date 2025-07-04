@php
    $thema = $ujian->ujianThema ?? null;
    $logoPath = $thema->logo_path ?? null;
    $institutionName = $thema->institution_name ?? null;
    $showLogoAndText = $logoPath && $institutionName;
    $showLogoOnly = $logoPath && !$institutionName;
    $brandingLogo = \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoHitam')->value('value') ?? '';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Log In'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
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
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--font-color);
        }

        /* ✅ Validasi background image */
        @if ($thema && $thema->background_image_path)
            body.authentication-bg {
                background-image: url('{{ asset($thema->background_image_path) }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        @else
            body.authentication-bg {
                background: var(--background-color);
            }
        @endif

        /* ✅ Validasi header image */
        @if ($thema && $thema->header_image_path)
            .card-header-form {
                background-image: url('{{ asset($thema->header_image_path) }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                color: var(--font-color);
                text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            }
        @else
            .card-header-form {
                background: var(--header-color) !important;
            }
            .card-header-form h4 {
                color: var(--secondary-color) !important;
            }
        @endif

        .text-muted,
        .text-dark,
        h4,
        h5,
        label {
            color: var(--font-color);
        }
        .card {
            background-color: var(--tertiary-color);
        }

        .footer-text {
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--button-color);
            border-color: var(--button-color);
            color: var(--button-font-color);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--secondary-color) !important;
        }
    </style>

</head>

<body class="authentication-bg position-relative">

    <div class="account-pages pt-5 pb-4 d-flex flex-column min-vh-100">
        <div class="container flex-grow-1">

            @php
                $thema = $ujian->ujianThema ?? null;

                $logoPath = $thema->logo_path ?? null;
                $institutionName = $thema->institution_name ?? null;

                $showLogoAndText = $logoPath && $institutionName;
                $showLogoOnly = $logoPath && !$institutionName;

                // Logo default dari pengaturan branding
                $brandingLogo =
                    \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoHitam')->value('value') ??
                    '';
            @endphp

            <div class="text-center mb-5">
                {{-- ✅ Logo + Nama Institusi --}}
                @if ($showLogoAndText)
                    <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                        <div class="preview-logo">
                            <img src="{{ asset($logoPath) }}" alt="logo" height="50">
                        </div>
                        <div class="preview-institution">
                            <h3 class="fw-bold mb-0">{{ $institutionName }}</h3>
                        </div>
                    </div>

                    {{-- ✅ Logo saja --}}
                @elseif ($showLogoOnly)
                    <div class="preview-logo">
                        <img src="{{ asset($logoPath) }}" alt="logo" height="80">
                    </div>

                    {{-- ❌ Tidak ada logo dan nama institusi → pakai logo default --}}
                @else
                    <div class="preview-logo">
                        <img src="{{ $brandingLogo ? asset($brandingLogo) : asset('images/placeholder.jpeg') }}"
                            alt="logo" height="60">
                    </div>
                @endif
            </div>


            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-header-form shadow-sm border-0 rounded-2 py-5 px-4">
                        @if ($ujian->ujianThema && $ujian->ujianThema->welcome_message)
                            <h4 class="text-center mb-0">{{ $ujian->ujianThema->welcome_message }}</h4>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bagian Atas: Informasi dan Formulir -->
            <div class="row justify-content-center mb-5">
                <!-- Informasi Ujian -->
                <div class="col-md-4 mb-3">

                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-body">
                            <h4 class="fw-bold mb-2">{{ $ujian->nama_ujian }}</h4>
                            <p class="text-base mb-3">{{ $ujian->deskripsi }}</p>

                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>Durasi</span>
                                <span class="fw-semibold text-dark">{{ $ujian->durasi }} menit</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted mb-2">
                                <span>Jumlah Section</span>
                                <span class="fw-semibold text-dark">{{ count($ujian->ujianSections) }} section</span>
                            </div>
                            <div class="d-flex justify-content-between text-muted">
                                <span>Jumlah Soal</span>
                                <span class="fw-semibold text-dark">
                                    {{ $ujian->ujianSections->flatMap->ujianSectionSoals->count() }} soal
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Pendaftaran -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-2">
                        <div class="card-body">
                            <h4 class="fw-bold mb-2">Pendaftaran Peserta</h4>
                            <p class="text-base mb-4">Lengkapi data diri Anda untuk mulai mengikuti ujian</p>

                            <form method="POST" action="{{ route('ujian.generateSession', $ujian->link) }}"
                                enctype="multipart/form-data">
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
                                            <label for="nama" class="form-label">Nama</label>
                                            <input class="form-control" type="text" id="nama" name="nama"
                                                placeholder="Masukkan nama" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['email']) && $pesertaForm['email'])
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">Email address</label>
                                            <input class="form-control" type="email" id="emailaddress" name="email"
                                                placeholder="Enter your email" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['phone']) && $pesertaForm['phone'])
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">No. HP</label>
                                            <input class="form-control" type="text" id="phone" name="phone"
                                                placeholder="Masukkan nomor HP" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['institusi']) && $pesertaForm['institusi'])
                                        <div class="mb-3">
                                            <label for="institusi" class="form-label">Institusi</label>
                                            <input class="form-control" type="text" id="institusi" name="institusi"
                                                placeholder="Masukkan institusi" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['nomor_induk']) && $pesertaForm['nomor_induk'])
                                        <div class="mb-3">
                                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                                            <input class="form-control" type="text" id="nomor_induk"
                                                name="nomor_induk" placeholder="Masukkan nomor induk" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['tanggal_lahir']) && $pesertaForm['tanggal_lahir'])
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input class="form-control" type="date" id="tanggal_lahir"
                                                name="tanggal_lahir" required>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['alamat']) && $pesertaForm['alamat'])
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" required></textarea>
                                        </div>
                                    @endif

                                    @if (isset($pesertaForm['foto']) && $pesertaForm['foto'])
                                        <div class="mb-3">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input class="form-control" type="file" id="foto" name="foto"
                                                accept="image/*" required>
                                        </div>
                                    @endif
                                @endif

                                <div class=" mb-0">
                                    <button class="btn btn-primary" type="submit"> Mulai Ujian </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <footer class="footer-text">
            <div class="text-center">
                <script>
                    document.write(new Date().getFullYear())
                </script> © markazarabiyah.com - Supported by
                <a href="https://aneramedia.com/" class="text-reset link-danger" target="_blank">Anera Media</a>
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
