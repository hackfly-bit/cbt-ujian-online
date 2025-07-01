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
                                            'value' => 'minimal',
                                            'label' => 'Minimal',
                                            'desc' => 'Desain minimalis dan tenang',
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
                                    <div class="col-md-2 mb-3">
                                        <div class="theme-option" data-theme="{{ $theme['value'] }}">
                                            <div class="theme-preview {{ $theme['value'] }}-theme">
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
                                                value="{{ old('primary_color', $ujian->ujianThema->primary_color ?? '#4e73df') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="secondary_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-secondary me-1"></i> Warna Sekunder
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="secondary_color" name="secondary_color"
                                                value="{{ old('secondary_color', $ujian->ujianThema->secondary_color ?? '#1cc88a') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="tertiary_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-success me-1"></i> Warna Aksen
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="tertiary_color" name="tertiary_color"
                                                value="{{ old('tertiary_color', $ujian->ujianThema->tertiary_color ?? '#f6c23e') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="background_color" class="form-label fw-medium">
                                                <i class="ri-circle-fill text-success me-1"></i> Warna Background
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="background_color" name="background_color"
                                                value="{{ old('background_color', $ujian->ujianThema->background_color ?? '#f8f9fc') }}">
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
                                                value="{{ old('header_color', $ujian->ujianThema->header_color ?? '#343a40') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="font_color" class="form-label fw-medium">
                                                <i class="ri-font-size me-1"></i> Warna Font
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="font_color" name="font_color"
                                                value="{{ old('font_color', $ujian->ujianThema->font_color ?? '#343a40') }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="button_color" class="form-label fw-medium">
                                                <i class="ri-square-fill me-1"></i> Warna Tombol
                                            </label>
                                            <input type="color" class="form-control form-control-color w-100"
                                                id="button_color" name="button_color"
                                                value="{{ old('button_color', $ujian->ujianThema->button_color ?? '#1d3557') }}">
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
                                    <div id="live-preview" class="theme-preview-large">
                                        <div class="preview-content">
                                            <div
                                                class="d-flex align-items-center justify-content-center text-center flex-wrap gap-3 mb-3 mt-2">
                                                <div class="preview-logo">
                                                    <div class="logo-placeholder">LOGO</div>
                                                </div>
                                                <div class="preview-institution">
                                                    <h4 id="preview-institution-name" class="mb-0">Nama Institusi
                                                    </h4>
                                                </div>
                                            </div>

                                            <!-- isi pratinjau tetap -->
                                            <div class="preview-header rounded mb-2">
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
                                                            <button class="btn btn-primary mt-2">Mulai Ujian</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <footer>
                                                <div class="text-center mt-4">
                                                    <script>
                                                        document.write(new Date().getFullYear())
                                                    </script> © markazarabiyah.com - Supported by
                                                    <a href="https://aneramedia.com/" class="text-reset link-danger"
                                                        target="_blank">Anera Media</a>
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

                                <!-- Background -->
                                <div class="mb-3">
                                    <label for="background_image" class="form-label">Gambar Latar (Opsional)</label>
                                    <input type="file" class="form-control" id="background_image"
                                        name="background_image" accept="image/*">
                                    <small class="text-muted">Background untuk halaman ujian</small>
                                    @if (!empty($ujian->ujianThema->background_image_path))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $ujian->ujianThema->background_image_path) }}"
                                                alt="Current Background" class="img-thumbnail"
                                                style="max-width: 100px;">
                                        </div>
                                    @endif
                                </div>

                                <!-- Header -->
                                <div class="mb-3">
                                    <label for="header_image" class="form-label">Gambar Header (Opsional)</label>
                                    <input type="file" class="form-control" id="header_image" name="header_image"
                                        accept="image/*">
                                    <small class="text-muted">Banner untuk bagian header</small>
                                    @if (!empty($ujian->ujianThema->header_image_path))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $ujian->ujianThema->header_image_path) }}"
                                                alt="Current Header" class="img-thumbnail" style="max-width: 100px;">
                                        </div>
                                    @endif
                                </div>
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

                                <!-- Checkbox Gunakan Logo Custom -->
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="use_custom_color"
                                        name="use_custom_color" value="1"
                                        {{ old('use_custom_color', $ujian->ujianThema->use_custom_color ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="use_custom_color">
                                        Gunakan Logo Custom
                                    </label>
                                </div>

                                <!-- Group Logo & Nama Institusi -->
                                <div id="custom-logo-institution" style="display: none;">
                                    <!-- Logo -->
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo Institusi</label>
                                        <input type="file" class="form-control" id="logo" name="logo"
                                            accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                                        <small class="text-muted">Format: PNG, JPG, SVG. Maks 200x200px</small>
                                        @if (!empty($ujian->ujianThema->logo_path))
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $ujian->ujianThema->logo_path) }}"
                                                    alt="Current Logo" class="img-thumbnail"
                                                    style="max-width: 100px;">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Nama Institusi -->
                                    <div class="mb-3">
                                        <label for="institution_name" class="form-label">Nama Institusi</label>
                                        <input type="text" class="form-control" id="institution_name"
                                            name="institution_name"
                                            value="{{ old('institution_name', $ujian->ujianThema->institution_name ?? '') }}"
                                            placeholder="Nama sekolah/universitas/institusi">
                                    </div>
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
