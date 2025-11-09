<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Manajemen User</h4>
                <p class="text-muted fs-14">
                    Berikut ini adalah daftar semua user, lengkap dengan email, role, status dan aksi yang dapat dilakukan.
                </p>
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="ri-user-add-line me-1"></i> Tambah User
                    </button>
                </div>

                <table id="selection-datatable-users" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>

                <!-- Modal Tambah User -->
                <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="alertTambahUser" class="alert d-none" role="alert"></div>
                                <form id="formTambahUser" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="tambah_nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="tambah_nama" name="name" placeholder="Masukkan nama" required>
                                            <div class="invalid-feedback">Nama wajib diisi.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tambah_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="tambah_email" name="email" placeholder="Masukkan email" required>
                                            <div class="invalid-feedback">Email tidak valid atau kosong.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tambah_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="tambah_password" name="password" placeholder="Minimal 8 karakter" required minlength="8">
                                            <div class="invalid-feedback">Password minimal 8 karakter.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tambah_password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="tambah_password_confirmation" name="password_confirmation" placeholder="Ulangi password" required minlength="8">
                                            <div class="invalid-feedback">Konfirmasi password harus sama.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tambah_role" class="form-label">Role</label>
                                            <select class="form-select" id="tambah_role" name="role" required>
                                                <option value="" selected disabled>Pilih role</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                            <div class="invalid-feedback">Role wajib dipilih.</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="btnSubmitTambahUser">
                                    <i class="ri-save-3-line me-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit User -->
                <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="alertEditUser" class="alert d-none" role="alert"></div>
                                <form id="formEditUser" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="edit_nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="edit_nama" name="name" placeholder="Masukkan nama" required>
                                            <div class="invalid-feedback">Nama wajib diisi.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="edit_email" name="email" placeholder="Masukkan email" required>
                                            <div class="invalid-feedback">Email tidak valid atau kosong.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_password" class="form-label">Password (Opsional)</label>
                                            <input type="password" class="form-control" id="edit_password" name="password" placeholder="Minimal 8 karakter" minlength="8">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_password_confirmation" class="form-label">Konfirmasi Password (Opsional)</label>
                                            <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" placeholder="Ulangi password" minlength="8">
                                            <div class="invalid-feedback">Konfirmasi password harus sama.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="edit_role" class="form-label">Role</label>
                                            <select class="form-select" id="edit_role" name="role" required>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                            <div class="invalid-feedback">Role wajib dipilih.</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-danger" id="btnDeleteUser">
                                    <i class="ri-delete-bin-line me-1"></i> Hapus
                                </button>
                                <div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" id="btnSubmitEditUser">
                                        <i class="ri-save-3-line me-1"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
