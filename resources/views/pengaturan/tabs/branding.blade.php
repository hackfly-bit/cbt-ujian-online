<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Upload Logo</h3>
                <p class="mb-4">Upload dan kelola logo aplikasi</p>

                <form action="{{ route('pengaturan.updateLogo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Kolom Kiri - Preview Logo -->
                        <div class="col-md-4">
                            <img id="previewLogo" src="{{ $logo ? asset($logo) : asset('images/placeholder.jpeg') }}"
                                alt="Preview Logo" class="img-thumbnail"
                                style="width: 100%; height: 400px; object-fit: contain;">
                        </div>

                        <!-- Kolom Kanan - Form Input -->
                        <div class="col-md-8">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <label for="logoImage" class="form-label">Upload Logo</label>
                                        <input type="file" class="form-control" id="logoImage" name="logoImage"
                                            accept="image/*" data-preview-id="previewLogo"
                                            onchange="previewImage(this)">

                                    </div>

                                    <!-- Tambah kolom lain di sini jika diperlukan -->
                                </div>

                                <!-- Tombol Submit -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
