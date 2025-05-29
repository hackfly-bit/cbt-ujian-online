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
                <div id="custom-filters-semua" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="filter-category" class="form-select form-select-sm" title="Filter by category">
                            <option value="">All</option>
                            <option value="Reading">Reading</option>
                            <option value="Listening">Listening</option>
                            <option value="Grammar">Grammar</option>
                        </select>
                        <select id="filter-difficulty" class="form-select form-select-sm" title="Filter by difficulty">
                            <option value="">All</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>

                <table id="selection-datatable-semua" class="table table-striped dt-responsive nowrap w-100">
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
                </table>


            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
