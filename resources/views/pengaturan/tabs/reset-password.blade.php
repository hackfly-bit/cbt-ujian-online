<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-2">Ubah Password</h3>
                <p class="mb-4">Kelola pengaturan keamanan akun Anda</p>

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Password Saat Ini -->
                        <div class="col-md-12 mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <input type="password" id="current_password" name="current_password"
                                    class="form-control" placeholder="Masukkan password saat ini" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('current_password')">
                                    <i class="ri-eye-line" id="current_password_icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="row">

                                    <!-- Password Baru -->
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" id="new_password" name="new_password"
                                                class="form-control" placeholder="Masukkan password baru" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('new_password')">
                                                <i class="ri-eye-line" id="new_password_icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi
                                            Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                class="form-control" placeholder="Konfirmasi password baru" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="togglePassword('password_confirmation')">
                                                <i class="ri-eye-line" id="password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Ubah Password
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
