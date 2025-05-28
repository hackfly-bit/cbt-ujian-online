<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Daftar Soal Listening</h4>
                <p class="text-muted fs-14">
                    Berikut ini adalah daftar soal ujian listening, tingkat
                    kesulitan, jenis soal, dan aksi yang dapat dilakukan.
                </p>

                <!-- FILTERS untuk Tab Listening -->
                <div id="custom-filters-listening" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="filter-difficulty-listening" class="form-select form-select-sm" style="min-width: 200px;"
                            title="Filter by difficulty">
                            <option value="">All</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel untuk Tab Listening -->
                <table id="selection-datatable-listening" class="table table-striped dt-responsive nowrap w-100">
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
