<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Pengaturan Ujian</h3>
                <p class="mb-4">Konfigurasikan pengaturan tambahan untuk ujian ini</p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="metode_penilaian" class="form-label">Metode Penilaian</label>
                        <select class="form-select" id="metode_penilaian" name="metode_penilaian" onchange="toggleNilaiKelulusan()">
                            <option value="">Pilih Metode Penilaian</option>
                            <option value="presentase" {{ old('metode_penilaian', $ujian->ujianPengaturan->metode_penilaian ?? '') == 'presentase' ? 'selected' : '' }}>Presentase</option>
                            <option value="rumus_custom" {{ old('metode_penilaian', $ujian->ujianPengaturan->metode_penilaian ?? '') == 'rumus_custom' ? 'selected' : '' }}>Rumus Custom</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="nilai_kelulusan_group" style="display: none;">
                        <label for="nilai_kelulusan" class="form-label">Nilai Kelulusan</label>
                        <input type="number" class="form-control" id="nilai_kelulusan" name="nilai_kelulusan" min="0" max="100" value="{{ old('nilai_kelulusan', $ujian->ujianPengaturan->nilai_kelulusan ?? '') }}" placeholder="e.g., 75">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hasil_ujian_tersedia" class="form-label">Hasil Ujian Tersedia (%)</label>
                        <input type="number" class="form-control" id="hasil_ujian_tersedia" name="hasil_ujian_tersedia" min="1" max="100" value="{{ old('hasil_ujian_tersedia', $ujian->ujianPengaturan->hasil_ujian_tersedia ?? '') }}" placeholder="e.g., 80">
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="lockscreen" name="lockscreen" value="1" {{ old('lockscreen', $ujian->ujianPengaturan->lockscreen ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lockscreen">
                                <strong>Aktifkan Lockscreen</strong>
                                <br>
                                <small class="text-muted">Mencegah peserta beralih tab, klik kanan, dan menggunakan shortcut keyboard selama ujian</small>
                            </label>
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

    </div><!-- end col-->
</div>
