<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Pengaturan Ujian</h3>
                <p class="mb-4">Konfigurasikan pengaturan tambahan untuk ujian ini</p>

                <div class="row">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label">Formula Penilaian</label>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span>(</span>
                                <select class="form-select" name="answer_type" style="width: auto">
                                    <option value="correctAnswer" {{ old('answer_type', $ujian->ujianPengaturan->answer_type ?? '') == 'correctSection' ? 'selected' : '' }}>Section Benar</option>
                                    <option value="incorrectAnswer" {{ old('answer_type', $ujian->ujianPengaturan->answer_type ?? '') == 'incorrectSection' ? 'selected' : '' }}>Section Salah</option>
                                </select>
                                <select class="form-select" name="operation" style="width: auto">
                                    <option value="*" {{ old('operation', $ujian->ujianPengaturan->operation ?? '') == '*' ? 'selected' : '' }}>×</option>
                                    <option value="+" {{ old('operation', $ujian->ujianPengaturan->operation ?? '') == '+' ? 'selected' : '' }}>+</option>
                                    <option value="-" {{ old('operation', $ujian->ujianPengaturan->operation ?? '') == '-' ? 'selected' : '' }}>-</option>
                                    <option value="/" {{ old('operation', $ujian->ujianPengaturan->operation ?? '') == '/' ? 'selected' : '' }}>÷</option>
                                </select>
                                <input type="number" class="form-control" name="value" placeholder="n" style="width: 80px" value="{{ old('value', $ujian->ujianPengaturan->value ?? '') }}">
                                <span>)</span>
                                <select class="form-select" name="operation2" style="width: auto">
                                    <option value="*" {{ old('operation2', $ujian->ujianPengaturan->operation2 ?? '') == '*' ? 'selected' : '' }}>×</option>
                                    <option value="+" {{ old('operation2', $ujian->ujianPengaturan->operation2 ?? '') == '+' ? 'selected' : '' }}>+</option>
                                    <option value="-" {{ old('operation2', $ujian->ujianPengaturan->operation2 ?? '') == '-' ? 'selected' : '' }}>-</option>
                                    <option value="/" {{ old('operation2', $ujian->ujianPengaturan->operation2 ?? '') == '/' ? 'selected' : '' }}>÷</option>
                                </select>
                                <input type="number" class="form-control" name="value2" placeholder="n" style="width: 80px" value="{{ old('value2', $ujian->ujianPengaturan->value2 ?? '') }}">
                            </div>
                            <small class="text-muted">
                                Contoh: (Jawaban Benar × n) × n
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nilai Kelulusan</label>
                            <div class="input-group" style="max-width: 600px;">
                                <input type="number"
                                    class="form-control"
                                    name="nilai_kelulusan"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="Contoh: 75"
                                    value="{{ old('nilai_kelulusan', $ujian->ujianPengaturan->nilai_kelulusan ?? '') }}"
                                >
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-muted">
                                Batas nilai minimum untuk dinyatakan lulus ujian
                            </small>
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="hasil_ujian_tersedia" name="hasil_ujian_tersedia" value="1" {{ old('hasil_ujian_tersedia', $ujian->ujianPengaturan->hasil_ujian_tersedia ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hasil_ujian_tersedia">
                                <strong>Tampilkan Hasil Ujian</strong>
                                <br>
                                <small class="text-muted">Mengizinkan peserta melihat hasil ujian setelah selesai</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="acak_soal" name="acak_soal" value="1" {{ old('acak_soal', $ujian->ujianPengaturan->acak_soal ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="acak_soal">
                                <strong>Acak Soal</strong>
                                <br>
                                <small class="text-muted">Mengacak urutan soal untuk setiap peserta</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="acak_jawaban" name="acak_jawaban" value="1" {{ old('acak_jawaban', $ujian->ujianPengaturan->acak_jawaban ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="acak_jawaban">
                                <strong>Acak Jawaban</strong>
                                <br>
                                <small class="text-muted">Mengacak urutan pilihan jawaban untuk setiap soal</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="lihat_hasil" name="lihat_hasil" value="1" {{ old('lihat_hasil', $ujian->ujianPengaturan->lihat_hasil ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lihat_hasil">
                                <strong>Lihat Hasil per Soal</strong>
                                <br>
                                <small class="text-muted">Mengizinkan peserta melihat hasil per soal setelah ujian</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="lihat_pembahasan" name="lihat_pembahasan" value="1" {{ old('lihat_pembahasan', $ujian->ujianPengaturan->lihat_pembahasan ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lihat_pembahasan">
                                <strong>Lihat Pembahasan</strong>
                                <br>
                                <small class="text-muted">Mengizinkan peserta melihat pembahasan soal setelah ujian</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_arabic" name="is_arabic" value="1" {{ old('is_arabic', $ujian->ujianPengaturan->is_arabic ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_arabic">
                                <strong>Aktifkan Mode Arabic</strong>
                                <br>
                                <small class="text-muted">Mengaktifkan dukungan penulisan teks Arab dari kanan ke kiri (RTL)</small>
                            </label>
                        </div>
                    </div>

                    <div id="formula_settings" class="col-12 mb-3" style="display: none;">
                        <div class="card border">
                            <div class="card-body">
                                <h5>Pengaturan Rumus Custom</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Operasi 1</label>
                                        <select class="form-select" name="operation_1">
                                            <option value="*" {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '*' ? 'selected' : '' }}>Kali (*)</option>
                                            <option value="+" {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '+' ? 'selected' : '' }}>Tambah (+)</option>
                                            <option value="-" {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '-' ? 'selected' : '' }}>Kurang (-)</option>
                                            <option value="/" {{ old('operation_1', $ujian->ujianPengaturan->operation_1 ?? '*') == '/' ? 'selected' : '' }}>Bagi (/)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nilai 1</label>
                                        <input type="number" class="form-control" name="value_1" step="0.01" value="{{ old('value_1', $ujian->ujianPengaturan->value_1 ?? 1) }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Operasi 2</label>
                                        <select class="form-select" name="operation_2">
                                            <option value="*" {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '*' ? 'selected' : '' }}>Kali (*)</option>
                                            <option value="+" {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '+' ? 'selected' : '' }}>Tambah (+)</option>
                                            <option value="-" {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '-' ? 'selected' : '' }}>Kurang (-)</option>
                                            <option value="/" {{ old('operation_2', $ujian->ujianPengaturan->operation_2 ?? '*') == '/' ? 'selected' : '' }}>Bagi (/)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nilai 2</label>
                                        <input type="number" class="form-control" name="value_2" step="0.01" value="{{ old('value_2', $ujian->ujianPengaturan->value_2 ?? 1) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="goToNextTab('tampilan')">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Tampilan
                    </button>
                    <button type="button" class="btn btn-success" onclick="handleSaveUjian()">
                        <i class="bi bi-check-circle me-1"></i> Simpan Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
