import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

window.$ = $;
window.jQuery = $;

document.addEventListener('DOMContentLoaded', function () {
    // Fungsi umum untuk inisialisasi datatable
    function initDatatable(selector, filterSelector = null, tableIdForSearch = null) {
        const table = new DataTable(selector, {
            select: {
                style: 'multi'
            },
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'>",
                    next: "<i class='ri-arrow-right-s-line'>"
                }
            },
            drawCallback: function () {
                document.querySelectorAll('.dataTables_paginate .pagination').forEach(pagination => {
                    pagination.classList.remove('pagination-rounded');
                });
            }
        });

        // Jika ada filter custom
        if (filterSelector && tableIdForSearch) {
            const $filterWrapper = $(selector + '_filter');
            $filterWrapper.addClass('d-flex align-items-center gap-3 justify-content-end');

            const $customFilters = $(filterSelector).children().detach();
            $filterWrapper.append($customFilters);

            $('#filter-difficulty').on('change', function () {
                table.draw();
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                if (settings.nTable.id !== tableIdForSearch) return true;

                const difficultyFilter = $('#filter-difficulty').val();
                const difficulty = data[3].trim(); // kolom ke-4 = Tingkat

                return difficultyFilter === '' || difficulty === difficultyFilter;
            });
        }

        return table;
    }

    // ✅ Semua tab
    initDatatable('#selection-datatable-semua', '#custom-filters-semua', 'selection-datatable-semua');

    // ✅ Tab Reading
    initDatatable('#selection-datatable-reading', '#custom-filters-reading', 'selection-datatable-reading');

    // Jika kamu punya tab lain seperti Grammar, Listening, dst, tinggal panggil fungsi lagi:
    // initDatatable('#selection-datatable-grammar', '#custom-filters-grammar', 'selection-datatable-grammar');
    // initDatatable('#selection-datatable-listening', '#custom-filters-listening', 'selection-datatable-listening');
});
