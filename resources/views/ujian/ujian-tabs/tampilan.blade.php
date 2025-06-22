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
                            <h5 class="mb-3">🎨 Pilih Tema</h5>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="theme-option" data-theme="classic">
                                        <div class="theme-preview classic-theme">
                                            <div class="theme-header"></div>
                                            <div class="theme-content"></div>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="theme"
                                                id="theme_classic" value="classic"
                                                {{ old('theme', $ujian->ujianThema->theme ?? 'classic') == 'classic' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="theme_classic">
                                                Klasik
                                            </label>
                                            <small class="text-muted d-block">Tampilan sederhana dan profesional</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="theme-option" data-theme="modern">
                                        <div class="theme-preview modern-theme">
                                            <div class="theme-header"></div>
                                            <div class="theme-content"></div>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="theme"
                                                id="theme_modern" value="modern"
                                                {{ old('theme', $ujian->ujianThema->theme ?? '') == 'modern' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="theme_modern">
                                                Modern
                                            </label>
                                            <small class="text-muted d-block">Desain bersih dengan warna cerah</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="theme-option" data-theme="glow">
                                        <div class="theme-preview glow-theme">
                                            <div class="theme-header"></div>
                                            <div class="theme-content"></div>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="theme"
                                                id="theme_glow" value="glow"
                                                {{ old('theme', $ujian->ujianThema->theme ?? '') == 'glow' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="theme_glow">
                                                Glow
                                            </label>
                                            <small class="text-muted d-block">Warna gradien dan efek cahaya</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="theme-option" data-theme="minimal">
                                        <div class="theme-preview minimal-theme">
                                            <div class="theme-header"></div>
                                            <div class="theme-content"></div>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="theme"
                                                id="theme_minimal" value="minimal"
                                                {{ old('theme', $ujian->ujianThema->theme ?? '') == 'minimal' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="theme_minimal">
                                                Minimal
                                            </label>
                                            <small class="text-muted d-block">Desain minimalis dan tenang</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Assets -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">🏫 Logo & Branding</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="logo" class="form-label">Logo Institusi</label>
                            <input type="file" class="form-control" id="logo" name="logo"
                                accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                            <small class="text-muted">Format: PNG, JPG, SVG. Maks 200x200px</small>
                            @if (isset($ujian->ujianThema->logo_path) && $ujian->ujianThema->logo_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $ujian->ujianThema->logo_path) }}"
                                        alt="Current Logo" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="background_image" class="form-label">Gambar Latar (Opsional)</label>
                            <input type="file" class="form-control" id="background_image" name="background_image"
                                accept="image/*">
                            <small class="text-muted">Background untuk halaman ujian</small>
                            @if (isset($ujian->ujianThema->background_image_path) && $ujian->ujianThema->background_image_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $ujian->ujianThema->background_image_path) }}"
                                        alt="Current Background" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="header_image" class="form-label">Gambar Header (Opsional)</label>
                            <input type="file" class="form-control" id="header_image" name="header_image"
                                accept="image/*">
                            <small class="text-muted">Banner untuk bagian header</small>
                            @if (isset($ujian->ujianThema->header_image_path) && $ujian->ujianThema->header_image_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $ujian->ujianThema->header_image_path) }}"
                                        alt="Current Header" class="img-thumbnail" style="max-width: 100px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Institusi -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="institution_name" class="form-label">Nama Institusi</label>
                            <input type="text" class="form-control" id="institution_name" name="institution_name"
                                value="{{ old('institution_name', $ujian->ujianThema->institution_name ?? '') }}"
                                placeholder="Nama sekolah/universitas/institusi">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="welcome_message" class="form-label">Pesan Sambutan</label>
                            <textarea class="form-control" id="welcome_message" name="welcome_message" rows="3"
                                placeholder="Selamat datang di ujian online...">{{ old('welcome_message', $ujian->ujianThema->welcome_message ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Kustomisasi Warna -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">🌈 Kustomisasi Warna</h5>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="use_custom_color"
                                    name="use_custom_color" value="1"
                                    {{ old('use_custom_color', $ujian->ujianThema->use_custom_color ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="use_custom_color">
                                    Gunakan Warna Kustom
                                </label>
                            </div>

                            <div id="default-colors" class="row mb-3">
                                <div class="col-md-6">
                                    <label for="background_color" class="form-label">Warna Latar</label>
                                    <input type="color" class="form-control form-control-color"
                                        id="background_color" name="background_color"
                                        value="{{ old('background_color', $ujian->ujianThema->background_color ?? '#ffffff') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="header_color" class="form-label">Warna Header</label>
                                    <input type="color" class="form-control form-control-color" id="header_color"
                                        name="header_color"
                                        value="{{ old('header_color', $ujian->ujianThema->header_color ?? '#f8f9fa') }}">
                                </div>
                            </div>

                            <div id="custom-colors" class="row g-4" style="display: none;">
                                <!-- Primary Colors Section -->
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="color-picker-group">
                                                <label for="primary_color" class="form-label fw-medium">
                                                    <i class="bi bi-circle-fill text-primary me-1"></i>
                                                    Warna Primer
                                                </label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                    id="primary_color" name="primary_color"
                                                    value="{{ old('primary_color', $ujian->ujianThema->primary_color ?? '#0d6efd') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="color-picker-group">
                                                <label for="secondary_color" class="form-label fw-medium">
                                                    <i class="bi bi-circle-fill text-secondary me-1"></i>
                                                    Warna Sekunder
                                                </label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                    id="secondary_color" name="secondary_color"
                                                    value="{{ old('secondary_color', $ujian->ujianThema->secondary_color ?? '#6c757d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="color-picker-group">
                                                <label for="tertiary_color" class="form-label fw-medium">
                                                    <i class="bi bi-circle-fill text-success me-1"></i>
                                                    Warna Aksen
                                                </label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                    id="tertiary_color" name="tertiary_color"
                                                    value="{{ old('tertiary_color', $ujian->ujianThema->tertiary_color ?? '#20c997') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text & Button Colors Section -->
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="color-picker-group">
                                                <label for="font_color" class="form-label fw-medium">
                                                    <i class="bi bi-type me-1"></i>
                                                    Warna Font
                                                </label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                    id="font_color" name="font_color"
                                                    value="{{ old('font_color', $ujian->ujianThema->font_color ?? '#212529') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="color-picker-group">
                                                <label for="button_color" class="form-label fw-medium">
                                                    <i class="bi bi-square-fill me-1"></i>
                                                    Warna Tombol
                                                </label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                    id="button_color" name="button_color"
                                                    value="{{ old('button_color', $ujian->ujianThema->button_color ?? '#0d6efd') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="color-picker-group">
                                                <label for="button_font_color" class="form-label fw-medium">
                                                    <i class="bi bi-type me-1"></i>
                                                    Warna Font Tombol
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
                    </div>

                    <!-- Preview -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">👀 Pratinjau</h5>
                            <div class="card" id="theme-preview-container">
                                <div class="card-body">
                                    <div id="live-preview" class="theme-preview-large">
                                        <div class="preview-header">
                                            <div class="preview-logo">
                                                <div class="logo-placeholder">LOGO</div>
                                            </div>
                                            <div class="preview-institution">
                                                <h4 id="preview-institution-name">Nama Institusi</h4>
                                            </div>
                                        </div>
                                        <div class="preview-content">
                                            <div class="preview-welcome">
                                                <h5>Selamat Datang</h5>
                                                <p id="preview-welcome-message">Pesan sambutan akan ditampilkan di
                                                    sini...</p>
                                            </div>
                                            <div class="preview-exam-info">
                                                <div class="exam-card">
                                                    <h6>Informasi Ujian</h6>
                                                    <p>{{ $ujian->nama_ujian ?? 'Nama Ujian' }}</p>
                                                    <button class="btn btn-primary">Mulai Ujian</button>
                                                </div>
                                            </div>
                                        </div>
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
