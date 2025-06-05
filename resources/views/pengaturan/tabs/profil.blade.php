<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Informasi Profil</h3>
                <p class="mb-4">Lihat dan perbarui informasi profil Anda</p>

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Kolom Kiri - Preview Gambar -->
                        <div class="col-md-4">
                            <img id="preview" src="{{ asset('images/placeholder.jpeg') }}" alt="Preview"
                                class="img-thumbnail" style="width: 100%; height: 400px; object-fit: cover;">
                        </div>

                        <!-- Kolom Kanan - Form Input -->
                        <div class="col-md-8">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="row">
                                    <!-- Nama -->
                                    <div class="col-md-12 mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            placeholder="Masukkan nama lengkap" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-12 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Masukkan alamat email">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="image" class="form-label">Upload Profile</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image/*" onchange="previewImage(this)">
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
