<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                <div class="position-relative mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold mb-2">Seksi Ujian</h3>
                    </div>

                    <!-- Tombol di pojok kanan atas -->
                    <button id="btn-tambah-seksi" class="btn btn-outline-primary btn-sm position-absolute top-0 end-0">
                        <i class="bi bi-plus"></i> Tambah Seksi
                    </button>
                </div>

                {{-- <div id="section-container" data-plugin="dragula" data-containers='["section-list"]'
                    data-handleclass="section-drag-handle"> --}}
                <div id="section-container" data-plugin="dragula" data-handleclass="section-drag-handle">

                </div>

                <!-- Tombol Navigasi -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary" onclick="goToNextTab('detail')">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
                    </button>
                    <button type="button" class="btn btn-primary" onclick="goToNextTab('peserta')">
                        Lanjut ke Data Peserta <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>

    </div><!-- end col-->
</div>
