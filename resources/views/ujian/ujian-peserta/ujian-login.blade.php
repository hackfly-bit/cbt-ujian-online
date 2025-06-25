<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Log In'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
    <style>
        body {
            background-color: {{ $ujian->ujianThema->background_color ?? '#f0f2f5' }};
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

            <div class="text-center my-5">
                <!-- Logo -->
                <div class="text-center">
                    @if ($ujian->ujianThema && $ujian->ujianThema->logo_path)
                        <a href="{{ route('any', 'index') }}">
                            <span><img src="{{ asset('storage/' . $ujian->ujianThema->logo_path) }}" alt="logo"
                                    height="60"></span>
                        </a>
                    @else
                        <a href="{{ route('any', 'index') }}">
                            <span><img src="/images/logo-dark.png" alt="logo" height="40"></span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Bagian Atas: Informasi dan Formulir -->
            <div class="row justify-content-center mb-5">
                <!-- Informasi Ujian -->
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
                            @if ($ujian->ujianThema && $ujian->ujianThema->welcome_message)
                                <h4 class="fw-bold mb-2">{{ $ujian->ujianThema->welcome_message }}</h4>
                            @else
                                <h4 class="fw-bold mb-2">Pendaftaran Peserta</h4>
                                <p class="text-base mb-4">Lengkapi data diri Anda untuk mulai mengikuti ujian</p>
                            @endif
                            <form method="POST" action="{{ route('ujian.generateSession', $ujian->link) }}">
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

        <footer>
            <div class="text-center">
                <p class="text-base mb-0">© {{ date('Y') }} <a href="{{ route('any', 'index') }}ml"
                        class="text-primary">MyLMS</a>. All rights reserved.</p>
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
