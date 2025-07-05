<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Pengaturan Tampilan Ujian</h3>
                <p class="mb-4">Konfigurasikan tema dan tampilan visual untuk ujian ini</p>




                <form id="tampilan-form">
                    <!-- Pilihan Tema -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="mb-3"><i class="ri-palette-line me-1 text-primary"></i> Pilih Tema
                            </h4>
                            <div class="row">
                                @php
                                    $themes = [
                                        [
                                            'value' => 'classic',
                                            'label' => 'Klasik',
                                            'desc' => 'Tampilan sederhana dan profesional',
                                        ],
                                        [
                                            'value' => 'modern',
                                            'label' => 'Modern',
                                            'desc' => 'Desain bersih dengan warna cerah',
                                        ],
                                        [
                                            'value' => 'glow',
                                            'label' => 'Glow',
                                            'desc' => 'Warna gradien dan efek cahaya',
                                        ],
                                        [
                                            'value' => 'custom',
                                            'label' => 'Kustom',
                                            'desc' => 'Sesuaikan warna tema secara manual',
                                        ],
                                    ];
                                    $selectedTheme = old('theme', $ujian->ujianThema->theme ?? 'classic');
                                @endphp

                                @foreach ($themes as $theme)
                                    <div class="col-md-3 mb-3">
                                        <div class="theme-option {{ $theme['value'] }}-preview {{ $theme['value'] }}-theme"
                                            data-theme="{{ $theme['value'] }}">
                                            <div class="theme-preview">
                                                <div
                                                    class="theme-header {{ $theme['value'] === 'custom' ? 'bg-gradient' : '' }}">
                                                </div>
                                                <div class="theme-content"></div>
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="theme"
                                                    id="theme_{{ $theme['value'] }}" value="{{ $theme['value'] }}"
                                                    {{ $selectedTheme == $theme['value'] ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold"
                                                    for="theme_{{ $theme['value'] }}">
                                                    {{ $theme['label'] }}
                                                </label>
                                                <small class="text-muted d-block">{{ $theme['desc'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Custom Colors -->
                            <div id="custom-colors" class="row g-3" style="display: none;">
                                <!-- Warna Primer, Sekunder, Aksen -->
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-3">
                                            <label for="primary_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-primary me-1"></i> Warna Primer

                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="primary_color" name="primary_color"
                                                value="{{ old('primary_color', $ujian->ujianThema->primary_color ?? '#2c2c2c') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="secondary_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-secondary me-1"></i> Warna Sekunder
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="secondary_color" name="secondary_color"
                                                value="{{ old('secondary_color', $ujian->ujianThema->secondary_color ?? '#6c757d') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="tertiary_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-success me-1"></i> Warna Card
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="tertiary_color" name="tertiary_color"
                                                value="{{ old('tertiary_color', $ujian->ujianThema->tertiary_color ?? '#f5f5f5') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="background_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-success me-1"></i> Warna Background
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="background_color" name="background_color"
                                                value="{{ old('background_color', $ujian->ujianThema->background_color ?? '#ffffff') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Warna Font, Tombol, Font Tombol -->
                                <div class="col-12">
                                    <div class="row g-3 mt-2">
                                        <div class="col-3">
                                            <label for="header_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-success me-1"></i> Warna Header
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="header_color" name="header_color"
                                                value="{{ old('header_color', $ujian->ujianThema->header_color ?? '#f0f0f0') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="font_color" class="form-label fw-medium">
                                                <i class="ri-font-size me-1"></i> Warna Font
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="font_color" name="font_color"
                                                value="{{ old('font_color', $ujian->ujianThema->font_color ?? '#212529') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="button_color" class="form-label fw-medium">
                                                <i class="ri-square-fill me-1"></i> Warna Tombol
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="button_color" name="button_color"
                                                value="{{ old('button_color', $ujian->ujianThema->button_color ?? '#0080ff') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="button_font_color" class="form-label fw-medium">
                                                <i class="ri-font-color me-1"></i> Warna Font Tombol
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="button_font_color" name="button_font_color"
                                                value="{{ old('button_font_color', $ujian->ujianThema->button_font_color ?? '#ffffff') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <!-- Kolom Preview (Lebih Lebar) -->
                        <div class="col-lg-8 mb-4">
                            <h4 class="mb-3"><i class="ri-eye-line me-1 text-primary"></i> Preview Tema
                            </h4>
                            <div class="card" id="theme-preview-container">
                                <div class="card-body">
                                    <div id="live-preview" class="theme-preview-large"
                                        data-bg="{{ isset($ujian) && $ujian->ujianThema?->background_image_path ? asset($ujian->ujianThema->background_image_path) : '' }}"
                                        data-header="{{ isset($ujian) && $ujian->ujianThema?->header_image_path ? asset($ujian->ujianThema->header_image_path) : '' }}">
                                        <div class="preview-content" id="live-preview-content">
                                            @php
                                                $branding = [
                                                    'logoHitam' =>
                                                        \App\Models\SystemSetting::where('group', 'branding')
                                                            ->where('key', 'logoHitam')
                                                            ->value('value') ?? '',
                                                ];
                                            @endphp

                                            <div id="preview-logo-container" class="text-center mb-3 mt-2">
                                                {{-- Default: Logo dari branding --}}
                                                <div id="default-logo-preview"
                                                    style="{{ old('use_custom_color', $ujian->ujianThema->use_custom_color ?? false) ? 'display:none;' : '' }}">
                                                    <img src="{{ $branding['logoHitam'] ? asset($branding['logoHitam']) : asset('images/placeholder.jpeg') }}"
                                                        alt="logo" height="60">
                                                </div>

                                                {{-- Custom Logo Only --}}
                                                <div id="preview-logo-only"
                                                    style="{{ old('use_custom_color', $ujian->ujianThema->use_custom_color ?? false) && !old('show_institution_name', $ujian->ujianThema->institution_name) ? '' : 'display:none;' }}">
                                                    <div class="preview-logo">
                                                        <img src="{{ asset($ujian->ujianThema->logo_path ?? 'images/placeholder.jpeg') }}"
                                                            data-placeholder="{{ asset('images/placeholder.jpeg') }}"
                                                            id="live-logo-preview-only" alt="logo"
                                                            height="60">
                                                    </div>
                                                </div>

                                                {{-- Custom Logo + Nama Institusi --}}
                                                <div id="preview-logo-with-institution"
                                                    style="{{ old('use_custom_color', $ujian->ujianThema->use_custom_color ?? false) && old('show_institution_name', $ujian->ujianThema->show_institution_name) ? '' : 'display:none;' }}">
                                                    <div
                                                        class="d-flex align-items-center justify-content-center text-center flex-wrap gap-3">
                                                        <div class="preview-logo">
                                                            <img src="{{ asset($ujian->ujianThema->logo_path ?? 'images/placeholder.jpeg') }}"
                                                                data-placeholder="{{ asset('images/placeholder.jpeg') }}"
                                                                id="live-logo-preview-with-text" alt="logo"
                                                                height="60">
                                                        </div>
                                                        <div class="preview-institution">
                                                            <h4 id="preview-institution-name" class="mb-0">
                                                                {{ old('institution_name', $ujian->ujianThema->institution_name ?? 'Nama Institusi') }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- isi pratinjau tetap -->
                                            <div class="preview-header rounded mb-2" id="live-preview-header">
                                                <div class="preview-welcome">
                                                    <p id="preview-welcome-message">Pesan sambutan akan ditampilkan di
                                                        sini...
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-3 preview-section">
                                                <!-- Kolom kiri -->
                                                <div class="preview-exam-info flex-shrink-0" style="width: 30%;">
                                                    <div class="exam-card">
                                                        <h6>Informasi Ujian</h6>
                                                    </div>
                                                </div>

                                                <!-- Kolom kanan -->
                                                <div class="preview-exam-info flex-grow-1">
                                                    <div class="exam-card">
                                                        <div>
                                                            <h6>Form Peserta</h6>
                                                            <div class="btn btn-primary mt-2">Mulai Ujian</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <footer class="footer-preview">
                                                <div class="text-center mt-4">
                                                    <script>
                                                        document.write(new Date().getFullYear())
                                                    </script> © markazarabiyah.com - Supported by Anera
                                                    Media
                                                </div>
                                            </footer>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Form Input -->
                        <div class="col-lg-4">

                            <!-- Upload Assets -->
                            <div class="mb-4">
                                <h4 class="mb-3"><i class="ri-image-line me-1 text-primary"></i> Background & Header
                                </h4>

                                <input type="hidden" name="remove_background_image"
                                    id="remove_background_image_flag" value="">
                                <input type="hidden" name="remove_header_image" id="remove_header_image_flag"
                                    value="">


                                <!-- Background -->
                                <div class="mb-2">
                                    <label for="background_image" class="form-label">Gambar Latar (Opsional)</label>
                                    <input type="file" class="form-control" id="background_image"
                                        name="background_image" accept="image/*">
                                    <input type="hidden" name="remove_background_image"
                                        id="remove_background_image_flag" value="">
                                    <small class="text-muted">Background untuk halaman ujian</small>
                                </div>

                                <button type="button" id="remove_background_image"
                                    class="btn btn-sm btn-outline-danger mb-3 d-none">
                                    Hapus Gambar Latar
                                </button>

                                <!-- Header -->
                                <div class="mb-2">
                                    <label for="header_image" class="form-label">Gambar Header (Opsional)</label>
                                    <input type="file" class="form-control" id="header_image" name="header_image"
                                        accept="image/*">
                                    <input type="hidden" name="remove_header_image" id="remove_header_image_flag"
                                        value="">
                                    <small class="text-muted">Banner untuk bagian header</small>
                                </div>

                                <button type="button" id="remove_header_image"
                                    class="btn btn-sm btn-outline-danger mb-3 d-none">
                                    Hapus Gambar Header
                                </button>
                            </div>

                            <!-- Informasi Institusi -->
                            <div class="mb-4">
                                <h4 class="mb-3"><i class="ri-building-line me-1 text-primary"></i> Informasi
                                    Institusi</h4>

                                <div class="mb-3">
                                    <label for="welcome_message" class="form-label">Pesan Sambutan</label>
                                    <textarea class="form-control" id="welcome_message" name="welcome_message" rows="3"
                                        placeholder="Selamat datang di ujian online...">{{ old('welcome_message', $ujian->ujianThema->welcome_message ?? '') }}</textarea>
                                </div>

                                <!-- Checkbox 1: Gunakan Logo Custom -->
                                <div class="form-check form-switch mb-3">
                                    <input type="hidden" name="use_custom_color" value="0">
                                    <input class="form-check-input" type="checkbox" id="use_custom_color"
                                        name="use_custom_color" value="1"
                                        {{ old('use_custom_color', $ujian->ujianThema->use_custom_color ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="use_custom_color">
                                        Gunakan Logo Custom
                                    </label>
                                </div>

                                <!-- Section Upload Logo + Checkbox Kedua -->
                                <div id="logo-section-wrapper" style="display: none;">
                                    <!-- Upload Logo -->
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo Institusi</label>
                                        <input type="file" class="form-control" id="logo" name="logo"
                                            accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                                        <small class="text-muted">Format: PNG, JPG, SVG. Maks 200x200px</small>

                                        <!-- Tombol hapus -->
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                style="display: none" id="remove-logo-btn">
                                                Hapus Logo
                                            </button>
                                        </div>
                                    </div>


                                    <!-- Checkbox 2: Tampilkan Nama Institusi -->
                                    <div class="form-check form-switch mb-3">
                                        <input type="hidden" name="show_institution_name" value="0">
                                        <input class="form-check-input" type="checkbox" id="show_institution_name"
                                            name="show_institution_name" value="1"
                                            {{ old('show_institution_name', $ujian->ujianThema->show_institution_name ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_institution_name">
                                            Tampilkan Nama Institusi
                                        </label>
                                    </div>
                                </div>

                                <!-- Input Nama Institusi -->
                                <div id="institution-name-section" class="mb-3" style="display: none;">
                                    <label for="institution_name" class="form-label">Nama Institusi</label>
                                    <input type="text" class="form-control" id="institution_name"
                                        name="institution_name"
                                        value="{{ old('institution_name', $ujian->ujianThema->institution_name ?? '') }}"
                                        placeholder="Nama sekolah/universitas/institusi">
                                </div>


                            </div>


                        </div>

                    </div>

                </form>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="goToNextTab('peserta')">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Peserta
                    </button>
                    <button type="button" class="btn btn-primary" onclick="goToNextTab('pengaturan')">
                        Lanjut ke Pengaturan <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div><!-- end col-->
</div>
