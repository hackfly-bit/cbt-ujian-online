<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Informasi Peserta</h3>
                <p class="mb-4">Tentukan informasi apa yang perlu diisi oleh peserta sebelum mengikuti ujian</p>
                <h4 class="fw-bold mb-2">Data yang Dibutuhkan dari Peserta</h4>

                <div class="row">
                    <!-- Nama Ujian -->
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="nama" name="nama"
                                {{ isset($ujian->ujianPesertaForm->nama) && $ujian->ujianPesertaForm->nama ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="nama">
                                Nama Lengkap
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="email" name="email" checked disabled>
                            <label class="form-check-label mb-1" for="email">
                                Email
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="telp" name="telp"
                                {{ isset($ujian->ujianPesertaForm->phone) && $ujian->ujianPesertaForm->phone ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="telp">
                                Nomor Telepon
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sekolah" name="sekolah"
                                {{ isset($ujian->ujianPesertaForm->institusi) && $ujian->ujianPesertaForm->institusi ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="sekolah">
                                Institusi/Sekolah
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="no_induk" name="no_induk"
                                {{ isset($ujian->ujianPesertaForm->nomor_induk) && $ujian->ujianPesertaForm->nomor_induk ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="no_induk">
                                Nomor Induk Siswa/Mahasiswa
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tanggal_lahir" name="tanggal_lahir"
                                {{ isset($ujian->ujianPesertaForm->tanggal_lahir) && $ujian->ujianPesertaForm->tanggal_lahir ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="tanggal_lahir">
                                Tanggal Lahir
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="alamat" name="alamat"
                                {{ isset($ujian->ujianPesertaForm->alamat) && $ujian->ujianPesertaForm->alamat ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="alamat">
                                Alamat
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="foto" name="foto"
                                {{ isset($ujian->ujianPesertaForm->foto) && $ujian->ujianPesertaForm->foto ? 'checked' : '' }}>
                            <label class="form-check-label mb-1" for="foto">
                                Upload Foto
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="goToNextTab('seksi')">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Seksi
                    </button>
                    <button type="button" class="btn btn-primary" onclick="goToNextTab('tampilan')">
                        Lanjut ke Tampilan <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>

    </div><!-- end col-->
</div>
