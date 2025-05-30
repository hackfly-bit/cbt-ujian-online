import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";

window.$ = $;
window.jQuery = $;

// Global variables
let currentUjianId = null;
initDataTables();
// Initialize DataTables when document is ready

function initDataTables() {
    // Function to initialize individual datatable
    function initDatatable({
        selector,
        filterWrapperSelector,
        tableId,
        statusParam = null,
    }) {
        const table = new DataTable(selector, {
            processing: true,
            serverSide: true,
            ajax: {
                url: "/ujian",
                type: "GET",
                data: function (d) {
                    if (statusParam) {
                        d.status = statusParam;
                    }
                },
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "nama_ujian",
                    name: "nama_ujian"
                },
                {
                    data: "status",
                    name: "status",
                    className: "text-center",
                },
                {
                    data: "soal",
                    name: "soal",
                    className: "text-center",
                },
                {
                    data: "durasi",
                    name: "durasi",
                    className: "text-center",
                },
                {
                    data: "peserta",
                    name: "peserta",
                    className: "text-center",
                },
                {
                    data: "tanggal_selesai",
                    name: "tanggal_selesai",
                    className: "text-center",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
            ],
            responsive: true,
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'></i>",
                    next: "<i class='ri-arrow-right-s-line'></i>",
                },
                emptyTable: "Data tidak ditemukan.",
            },
            drawCallback: function () {
                document
                    .querySelectorAll(".dataTables_paginate .pagination")
                    .forEach((pagination) =>
                        pagination.classList.remove("pagination-rounded")
                    );
            },
        });

        // if (filterWrapperSelector && tableId) {
        //     const $filterWrapper = $(`${selector}_filter`);
        //     $filterWrapper.addClass(
        //         "d-flex align-items-center gap-2 justify-content-end"
        //     );

        //     const $customFilters = $(filterWrapperSelector).children().detach();
        //     $filterWrapper.append($customFilters);

        //     // Event trigger saat filter berubah
        //     [difficultyFilterId, categoryFilterId].forEach((filterId) => {
        //         if (filterId) {
        //             $(`#${filterId}`).on("change", () => {
        //                 table.draw();
        //             });
        //         }
        //     });
        // }

        return table;
    }

    // Initialize all datatables
    if (document.getElementById('selection-datatable-ujian-semua')) {
        window.tableUjianSemua = initDatatable({
            selector: "#selection-datatable-ujian-semua",
            filterWrapperSelector: "#custom-filters-ujian-semua",
            tableId: "selection-datatable-ujian-semua",
            statusParam: null,
        });
    }


    if (document.getElementById('selection-datatable-ujian-aktif')) {
        window.tableUjianAktif = initDatatable({
            selector: "#selection-datatable-ujian-aktif",
            // filterWrapperSelector: "#custom-filters-ujian-aktif",s
            // tableId: "selection-datatable-ujian-aktif",
            statusParam: "aktif",
        });
    }

    if (document.getElementById('selection-datatable-ujian-draft')) {
        window.tableUjianDraft = initDatatable({
            selector: "#selection-datatable-ujian-draft",
            // filterWrapperSelector: "#custom-filters-ujian-draft",s
            tableId: "selection-datatable-ujian-draft",
            statusParam: "draft",
        });
    }

    if (document.getElementById('selection-datatable-ujian-selesai')) {
        window.tableUjianSelesai = initDatatable({
            selector: "#selection-datatable-ujian-selesai",
            // filterWrapperSelector: "#custom-filters-ujian-selesai",s
            // tableId: "selection-datatable-ujian-selesai",
            statusParam: "selesai",
        });
    }
}

// Function to edit ujian
// window.editUjian = function (id) {
//     currentUjianId = id;

//     const url = `/ujian/${id}`;
//     $.ajax({
//         url: url,
//         method: 'GET',
//         success: function (data) {
//             // // Assuming data contains the ujian details
//             // $('#editUjianModal #nama_ujian').val(data.nama_ujian);
//             // $('#editUjianModal #durasi').val(data.durasi);
//             // $('#editUjianModal #tanggal_selesai').val(data.tanggal_selesai);
//             // // Add other fields as necessary

//             // $('#editUjianModal').modal('show');
//             console.log('Edit data:', data);
//         },
//         error: function (xhr) {
//             alert('Terjadi kesalahan saat mengambil data ujian');
//             console.error('Edit error:', xhr);
//         }
//     });
// };

// Function to show delete confirmation
window.showDeleteConfirmation = function (id) {
    currentUjianId = id;
    $('#modal-hapus').modal('show');
};

// Handle delete confirmation
$(document).on('click', '#btn-hapus-confirm', function () {
    if (currentUjianId) {
        const $btn = $(this);
        const $spinner = $btn.find('.spinner-border');

        // Show loading state
        $btn.prop('disabled', true);
        $spinner.removeClass('d-none');

        // Make delete request
        $.ajax({
            url: `/ujian/${currentUjianId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#modal-hapus').modal('hide');

                    // Refresh all tables
                    if (window.tableUjianSemua) window.tableUjianSemua.ajax.reload();
                    if (window.tableUjianAktif) window.tableUjianAktif.ajax.reload();
                    if (window.tableUjianDraft) window.tableUjianDraft.ajax.reload();
                    if (window.tableUjianSelesai) window.tableUjianSelesai.ajax.reload();

                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Ujian berhasil dihapus');
                    }
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Terjadi kesalahan saat menghapus ujian');
                console.error('Delete error:', xhr);
            },
            complete: function () {
                // Hide loading state
                $btn.prop('disabled', false);
                $spinner.addClass('d-none');
                currentUjianId = null;
            }
        });
    }
});


