<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Daftar Semua Soal</h4>
                <p class="text-muted fs-14">
                    Berikut ini adalah daftar semua soal ujian, lengkap dengan kategori, tingkat
                    kesulitan, jenis soal, dan aksi yang dapat dilakukan.
                </p>

                <!-- FILTERS -->
                <div id="custom-filters-aktif" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="filter-difficulty" class="form-select form-select-sm" title="Filter by difficulty">
                            <option value="">All</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel untuk Tab Reading -->
                <table id="selection-datatable-aktif" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Soal</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Tingkat</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Media</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Easy</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Medium</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Hard</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">4</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Easy</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">5</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Medium</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">6</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Hard</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">7</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Easy</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">8</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Medium</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">9</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Hard</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">10</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Easy</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">11</td>
                            <td>اختر الإجابة الصحيحة: هذا ......</td>
                            <td class="text-center">Grammar</td>
                            <td class="text-center">Medium</td>
                            <td class="text-center">Pilihan Ganda</td>
                            <td class="text-center"></td>
                            <td class="action-icons">
                                <a href="#edit" class="text-primary" title="Edit">
                                    <i class="ri-edit-2-line"></i>
                                </a>
                                <a href="#delete" class="text-danger" title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus soal ini?');">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
