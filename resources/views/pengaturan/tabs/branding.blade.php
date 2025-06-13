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
                        <!-- Logo Putih -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label d-block">Logo Putih</label>
                                <img id="previewLogoPutih"
                                    src="{{ old('logoPutih', $branding['logoPutih'] ? asset($branding['logoPutih']) : asset('images/placeholder.jpeg')) }}"
                                    alt="Preview Logo Putih" class="img-thumbnail w-100 mb-2"
                                    style="height: 200px; object-fit: contain;">
                                <button type="button" onclick="document.getElementById('logoPutih').click()"
                                    class="btn btn-primary btn-sm w-100">
                                    <i class="ri-pencil-fill me-1"></i> Ubah Logo
                                </button>
                                <input type="file" class="d-none @error('logoPutih') is-invalid @enderror"
                                    id="logoPutih" name="logoPutih" accept="image/*" data-preview-id="previewLogoPutih"
                                    onchange="previewImage(this)">
                                @error('logoPutih')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fav Logo Putih -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label d-block">Fav Logo Putih</label>
                                <img id="previewFavLogoPutih"
                                    src="{{ old('favLogoPutih', $branding['favLogoPutih'] ? asset($branding['favLogoPutih']) : asset('images/placeholder.jpeg')) }}"
                                    alt="Preview Fav Logo Putih" class="img-thumbnail w-100 mb-2"
                                    style="height: 200px; object-fit: contain;">
                                <button type="button" onclick="document.getElementById('favLogoPutih').click()"
                                    class="btn btn-primary btn-sm w-100">
                                    <i class="ri-pencil-fill me-1"></i> Ubah Logo
                                </button>
                                <input type="file" class="d-none @error('favLogoPutih') is-invalid @enderror"
                                    id="favLogoPutih" name="favLogoPutih" accept="image/*"
                                    data-preview-id="previewFavLogoPutih" onchange="previewImage(this)">
                                @error('favLogoPutih')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Logo Hitam -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label d-block">Logo Hitam</label>
                                <img id="previewLogoHitam"
                                    src="{{ old('logoHitam', $branding['logoHitam'] ? asset($branding['logoHitam']) : asset('images/placeholder.jpeg')) }}"
                                    alt="Preview Logo Hitam" class="img-thumbnail w-100 mb-2"
                                    style="height: 200px; object-fit: contain;">
                                <button type="button" onclick="document.getElementById('logoHitam').click()"
                                    class="btn btn-primary btn-sm w-100">
                                    <i class="ri-pencil-fill me-1"></i> Ubah Logo
                                </button>
                                <input type="file" class="d-none @error('logoHitam') is-invalid @enderror"
                                    id="logoHitam" name="logoHitam" accept="image/*" data-preview-id="previewLogoHitam"
                                    onchange="previewImage(this)">
                                @error('logoHitam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fav Logo Hitam -->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label d-block">Fav Logo Hitam</label>
                                <img id="previewFavLogoHitam"
                                    src="{{ old('favLogoHitam', $branding['favLogoHitam'] ? asset($branding['favLogoHitam']) : asset('images/placeholder.jpeg')) }}"
                                    alt="Preview Fav Logo Hitam" class="img-thumbnail w-100 mb-2"
                                    style="height: 200px; object-fit: contain;">
                                <button type="button" onclick="document.getElementById('favLogoHitam').click()"
                                    class="btn btn-primary btn-sm w-100">
                                    <i class="ri-pencil-fill me-1"></i> Ubah Logo
                                </button>
                                <input type="file" class="d-none @error('favLogoHitam') is-invalid @enderror"
                                    id="favLogoHitam" name="favLogoHitam" accept="image/*"
                                    data-preview-id="previewFavLogoHitam" onchange="previewImage(this)">
                                @error('favLogoHitam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
