<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Pengaturan Ujian</h3>
                <p class="mb-4">Konfigurasikan pengaturan tambahan untuk ujian ini</p>

                <div class="row">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="answer_type">
                                Formula Penilaian
                                <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span>(</span>
                                <select class="form-select" id="answer_type" name="answer_type" style="width: auto" required>
                                    <option value="correctAnswer"
                                        {{ old('answer_type', $ujian->ujianPengaturan->formula_type ?? '') == 'correctSection' ? 'selected' : '' }}>
                                        Section Benar</option>
                                    <option value="incorrectAnswer"
                                        {{ old('answer_type', $ujian->ujianPengaturan->formula_type ?? '') == 'incorrectSection' ? 'selected' : '' }}>
                                        Section Salah</option>
                                </select>
                                <select class="form-select" id="operation" name="operation" style="width: auto" required>
                                    <option value="*"
                                        {{ old('operation', $ujian->ujianPengaturan->operation_1 ?? '') == '*' ? 'selected' : '' }}>
                                        ×</option>
                                    <option value="+"
                                        {{ old('operation', $ujian->ujianPengaturan->operation_1 ?? '') == '+' ? 'selected' : '' }}>
                                        +</option>
                                    <option value="-"
                                        {{ old('operation', $ujian->ujianPengaturan->operation_1 ?? '') == '-' ? 'selected' : '' }}>
                                        -</option>
                                    <option value="/"
                                        {{ old('operation', $ujian->ujianPengaturan->operation_1 ?? '') == '/' ? 'selected' : '' }}>
                                        ÷</option>
                                </select>
                                <input type="number" class="form-control" id="value" name="value" placeholder="1"
                                    style="width: 80px"
                                    value="{{ old('value', $ujian->ujianPengaturan->value_1 ?? '') }}" required>
                                <span>)</span>
                                <select class="form-select" id="operation2" name="operation2" style="width: auto" required>
                                    <option value="*"
                                        {{ old('operation2', $ujian->ujianPengaturan->operation_2 ?? '') == '*' ? 'selected' : '' }}>
                                        ×</option>
                                    <option value="+"
                                        {{ old('operation2', $ujian->ujianPengaturan->operation_2 ?? '') == '+' ? 'selected' : '' }}>
                                        +</option>
                                    <option value="-"
                                        {{ old('operation2', $ujian->ujianPengaturan->operation_2 ?? '') == '-' ? 'selected' : '' }}>
                                        -</option>
                                    <option value="/"
                                        {{ old('operation2', $ujian->ujianPengaturan->operation_2 ?? '') == '/' ? 'selected' : '' }}>
                                        ÷</option>
                                </select>
                                <input type="number" class="form-control" id="value2" name="value2" placeholder="0"
                                    style="width: 80px"
                                    value="{{ old('value2', $ujian->ujianPengaturan->value_2 ?? '') }}" required>
                            </div>
                            <small class="text-muted">
                                Formula penilaian standar: (Jumlah Jawaban Benar × 1) + 0
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="nilai_kelulusan">
                                Nilai Kelulusan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group" style="max-width: 600px;">
                                <input type="number" class="form-control" id="nilai_kelulusan" name="nilai_kelulusan"
                                    min="0" max="100" step="0.01" placeholder="Contoh: 75"
                                    value="{{ old('nilai_kelulusan', $ujian->ujianPengaturan->nilai_kelulusan ?? '') }}" required>
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-muted">
                                Batas nilai minimum untuk dinyatakan lulus ujian
                            </small>
                        </div>
                    </div>




                    <!-- Fitur acak soal dan acak jawaban telah dinonaktifkan -->



                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="lockscreen"
                                name="lockscreen" value="1"
                                {{ old('lockscreen', $ujian->ujianPengaturan->lockscreen ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lockscreen">
                                <strong>Aktifkan Lockscreen</strong>
                                <br>
                                <small class="text-muted">Mencegah peserta keluar dari halaman ujian selama ujian berlangsung</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_arabic" name="is_arabic"
                                value="1"
                                {{ old('is_arabic', $ujian->ujianPengaturan->is_arabic ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_arabic">
                                <strong>Aktifkan Mode Arabic</strong>
                                <br>
                                <small class="text-muted">Mengaktifkan dukungan penulisan teks Arab dari kanan ke kiri
                                    (RTL)</small>
                            </label>
                        </div>
                    </div>

                    <div id="formula_settings" class="col-12 mb-3" style="display: none;">
                        <div class="card border">
                            <div class="card-body">
                                <h5>Pengaturan Rumus Custom</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="operation_1">Operasi 1</label>
                                        <select class="form-select" id="operation_1" name="operation_1">
                                            <option value="*"
                                                {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '*' ? 'selected' : '' }}>
                                                Kali (*)</option>
                                            <option value="+"
                                                {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '+' ? 'selected' : '' }}>
                                                Tambah (+)</option>
                                            <option value="-"
                                                {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '-' ? 'selected' : '' }}>
                                                Kurang (-)</option>
                                            <option value="/"
                                                {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '/' ? 'selected' : '' }}>
                                                Bagi (/)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="value_1">Nilai 1</label>
                                        <input type="number" class="form-control" id="value_1" name="value_1"
                                            step="0.01"
                                            value="{{ old('value_1', $ujian->ujianPengaturan->value_1 ?? 1) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="operation_2">Operasi 2</label>
                                        <select class="form-select" id="operation_2" name="operation_2">
                                            <option value="*"
                                                {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '*' ? 'selected' : '' }}>
                                                Kali (*)</option>
                                            <option value="+"
                                                {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '+' ? 'selected' : '' }}>
                                                Tambah (+)</option>
                                            <option value="-"
                                                {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '-' ? 'selected' : '' }}>
                                                Kurang (-)</option>
                                            <option value="/"
                                                {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '/' ? 'selected' : '' }}>
                                                Bagi (/)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="value_2">Nilai 2</label>
                                        <input type="number" class="form-control" id="value_2" name="value_2"
                                            step="0.01"
                                            value="{{ old('value_2', $ujian->ujianPengaturan->value_2 ?? 1) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary" id="btn-back"
                        onclick="goToNextTab('tampilan')">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Tampilan
                    </button>
                    <button type="button" class="btn btn-success" id="btn-save" onclick="handleSaveUjian()">
                        <i class="bi bi-check-circle me-1"></i> Simpan Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
