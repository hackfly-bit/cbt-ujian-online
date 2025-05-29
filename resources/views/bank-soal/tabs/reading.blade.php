<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Daftar Soal Reading</h4>
                <p class="text-muted fs-14">
                    Berikut ini adalah daftar soal ujian reading, tingkat
                    kesulitan, jenis soal, dan aksi yang dapat dilakukan.
                </p>

                <!-- FILTERS -->
                <div id="custom-filters-reading" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="filter-difficulty-reading" class="form-select form-select-sm" style="min-width: 200px;"
                            title="Filter by difficulty">
                            <option value="">All</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel untuk Tab Reading -->
                <table id="selection-datatable-reading" class="table table-striped dt-responsive nowrap w-100">
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
