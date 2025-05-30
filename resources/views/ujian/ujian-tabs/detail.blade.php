<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Informasi Dasar</h3>
                <p class="mb-4">Masukkan detail dasar untuk ujian baru</p>

                <div class="row">
                    <!-- Nama Ujian -->
                    <div class="col-md-12 mb-3">
                        <label for="nama_ujian" class="form-label">Nama Ujian</label>
                        <input type="text" id="nama_ujian" name="nama_ujian" class="form-control" value="{{ $ujian->nama_ujian ?? '' }}" required
                            placeholder="e.g., TOAFL Reguler Batch 6">
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"
                            placeholder="Deskripsi singkat tentang ujian ini">{{ $ujian->deskripsi ?? '' }}</textarea>
                    </div>

                    <!-- Jenis Ujian & Durasi Total -->
                    <div class="col-md-6 mb-3">
                        <label for="jenis_ujian" class="form-label">Jenis Ujian</label>
                        <select id="jenis_ujian" name="jenis_ujian" class="form-select">
                            <option value="">Pilih Jenis Ujian</option>
                            @foreach($jenisUjian as $jenis)
                                <option value="{{ $jenis->id }}" {{ (isset($ujian) && $ujian->jenis_ujian_id == $jenis->id) ? 'selected' : '' }}>
                                    {{ $jenis->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="durasi" class="form-label">Durasi Total (menit)</label>
                        <div class="input-group mb-1">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="number" min="1" id="durasi" name="durasi" class="form-control"
                                value="{{ $ujian->durasi ?? '120' }}" placeholder="e.g., 60">
                        </div>
                        <span>Total waktu untuk menyelesaikan ujian</span>
                    </div>

                    <!-- Tanggal Kedaluwarsa -->
                    <div class="col-md-12 mb-3">
                        <label for="tanggal_kedaluwarsa" class="form-label">Tanggal Kedaluwarsa (Opsional)</label>
                        <div class="input-group mb-1">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="text" id="tanggal_kedaluwarsa" name="tanggal_kedaluwarsa"
                                class="form-control datepicker">
                        </div>
                        <span>Ujian tidak dapat diakses setelah tanggal ini</span>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary" id="btn-lanjut-seksi" onclick="goToNextTab('seksi')">
                        Lanjut ke Seksi & Soal <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>

    </div><!-- end col-->
</div>
