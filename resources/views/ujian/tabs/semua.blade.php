<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Daftar Semua Ujian</h4>
                <p class="text-muted fs-14">
                    Berikut ini adalah daftar semua ujian, lengkap dengan status, soal, durasi, peserta dan aksi yang dapat dilakukan.
                </p>

                <!-- FILTERS -->
                <div id="custom-filters-ujian-semua" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="filter-category-ujian-semua" class="form-select form-select-sm" style="min-width: 200px;"
                            title="Filter by category">
                            <option value="">All</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Draft">Draft</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <table id="selection-datatable-ujian-semua" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Ujian</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Soal</th>
                            <th class="text-center">Durasi</th>
                            <th class="text-center">Peserta</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>


            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
