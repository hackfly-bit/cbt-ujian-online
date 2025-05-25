import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

window.$ = $;
window.jQuery = $;

// Global variables
let currentSoalId = null;
let jawabanCounter = 0;

// Inisialisasi DataTable untuk halaman Bank Soal
document.addEventListener('DOMContentLoaded', function () {
    console.log('Bank Soal JS loaded');

    // Initialize DataTables
    initDataTables();

    // Initialize Form Events
    initFormEvents();

    // Load dropdown data
    loadDropdownData();
});

// Fungsi untuk inisialisasi DataTables
function initDataTables() {
    // Fungsi umum untuk inisialisasi datatable
    function initDatatable(selector, filterSelector = null, tableIdForSearch = null) {
        const table = new DataTable(selector, {
            processing: true,
            serverSide: true,
            ajax: {
                url: '/bank-soal',
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'pertanyaan', name: 'pertanyaan' },
                { data: 'kategori', name: 'kategori', className: 'text-center' },
                { data: 'tingkat_kesulitan', name: 'tingkat_kesulitan', className: 'text-center' },
                { data: 'jenis_soal', name: 'jenis_soal', className: 'text-center' },
                {
                    data: 'is_audio',
                    name: 'is_audio',
                    className: 'text-center',
                    render: function (data) {
                        return data ? '<i class="ri-volume-up-line text-primary"></i>' : '';
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            select: {
                style: 'multi'
            },
            responsive: true,
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'></i>",
                    next: "<i class='ri-arrow-right-s-line'></i>"
                }
            },
            drawCallback: function () {
                document.querySelectorAll('.dataTables_paginate .pagination').forEach(pagination => {
                    pagination.classList.remove('pagination-rounded');
                });
            }
        });

        // Handle custom filter if provided
        if (filterSelector && tableIdForSearch) {
            const $filterWrapper = $(`${selector}_filter`);
            $filterWrapper.addClass('d-flex align-items-center gap-3 justify-content-end');

            const $customFilters = $(filterSelector).children().detach();
            $filterWrapper.append($customFilters);

            // Trigger redraw on filter change
            $('#filter-difficulty').on('change', function () {
                table.draw();
            });

            // Extend DataTables search to include difficulty filter
            $.fn.dataTable.ext.search.push(function (settings, data) {
                if (settings.nTable.id !== tableIdForSearch) return true;

                const difficultyFilter = $('#filter-difficulty').val();
                const difficulty = data[3]?.trim(); // Column 4: Tingkat Kesulitan

                return !difficultyFilter || difficulty === difficultyFilter;
            });
        }

        return table;
    }


    // ✅ Semua tab
    window.tableSemua = initDatatable('#selection-datatable-semua', '#custom-filters-semua', 'selection-datatable-semua');

    // ✅ Tab Reading
    window.tableReading = initDatatable('#selection-datatable-reading', '#custom-filters-reading', 'selection-datatable-reading');

    // ✅ Tab Grammar
    window.tableGrammar = initDatatable('#selection-datatable-grammar', '#custom-filters-grammar', 'selection-datatable-grammar');

    // ✅ Tab Listening
    window.tableListening = initDatatable('#selection-datatable-listening', '#custom-filters-listening', 'selection-datatable-listening');
}

// Fungsi untuk inisialisasi form events
function initFormEvents() {
    // Event untuk checkbox audio
    $('#is_audio').on('change', function () {
        if (this.checked) {
            $('#audio-file-container').show();
        } else {
            $('#audio-file-container').hide();
            $('#audio_file').val('');
        }
    });

    // Event untuk perubahan jenis soal
    $('#jenis_soal').on('change', function () {
        generateJawabanForm(this.value);
    });

    // Event untuk perubahan kategori
    $('#kategori').on('change', function () {
        loadSubKategori(this.value);
    });

    // Event submit form
    $('#form-bank-soal').on('submit', function (e) {
        e.preventDefault();
        submitForm();
    });

    // Event untuk reset modal saat ditutup
    $('#tambah-bank-soal').on('hidden.bs.modal', function () {
        resetForm();
    });

    // Event konfirmasi hapus
    $('#btn-hapus-confirm').on('click', function () {
        if (currentSoalId) {
            deleteSoal(currentSoalId);
        }
    });
}

// Fungsi untuk generate form jawaban berdasarkan jenis soal
function generateJawabanForm(jenisSoal) {
    const container = $('#jawaban-container');
    container.empty();
    jawabanCounter = 0;

    if (!jenisSoal) return;

    if (jenisSoal === 'pilihan_ganda') {
        generatePilihanGandaForm(container);
    } else if (jenisSoal === 'benar_salah') {
        generateBenarSalahForm(container);
    } else if (jenisSoal === 'isian') {
        generateIsianForm(container);
    }
}

// Generate form pilihan ganda
function generatePilihanGandaForm(container) {
    const pilihanLabels = ['A', 'B', 'C', 'D'];

    container.append(`
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Pilihan Jawaban</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-pilihan">
                <i class="ri-add-line"></i> Tambah Pilihan
            </button>
        </div>
        <div id="pilihan-container"></div>
    `);

    // Generate 4 pilihan default
    for (let i = 0; i < 4; i++) {
        addPilihanGanda(pilihanLabels[i]);
    }

    // Event untuk tambah pilihan
    $('#add-pilihan').on('click', function () {
        const nextLabel = String.fromCharCode(65 + jawabanCounter); // A, B, C, D, E, F, ...
        addPilihanGanda(nextLabel);
    });
}

// Tambah pilihan ganda
function addPilihanGanda(label) {
    const isFirst = jawabanCounter === 0;
    const pilihanHtml = `
        <div class="row align-items-center mb-2 pilihan-item" data-index="${jawabanCounter}">
            <div class="col-1">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jawaban_benar" value="${jawabanCounter}" ${isFirst ? 'checked' : ''} required>
                </div>
            </div>
            <div class="col-2">
                <input type="text" class="form-control form-control-sm"
                       name="jawaban_soal[${jawabanCounter}][label_jawaban]"
                       value="Pilihan ${label}" readonly>
            </div>
            <div class="col-8">
                <input type="text" class="form-control"
                       name="jawaban_soal[${jawabanCounter}][jawaban]"
                       placeholder="Masukkan jawaban pilihan ${label}" required>
                <input type="hidden" name="jawaban_soal[${jawabanCounter}][jenis_isian]" value="pilihan_ganda">
            </div>
            <div class="col-1">
                ${jawabanCounter > 3 ? `
                    <button type="button" class="btn btn-sm btn-outline-danger remove-pilihan">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                ` : ''}
            </div>
        </div>
    `;

    $('#pilihan-container').append(pilihanHtml);
    jawabanCounter++;

    // Event untuk hapus pilihan (hanya jika lebih dari 4)
    $('.remove-pilihan').off('click').on('click', function () {
        $(this).closest('.pilihan-item').remove();
        updatePilihanIndexes();
    });
}

// Update indexes setelah hapus pilihan
function updatePilihanIndexes() {
    $('#pilihan-container .pilihan-item').each(function (index) {
        const $item = $(this);
        $item.attr('data-index', index);
        $item.find('input[name^="jawaban_soal"]').each(function () {
            const name = $(this).attr('name');
            const newName = name.replace(/\[\d+\]/, `[${index}]`);
            $(this).attr('name', newName);
        });
        $item.find('input[name="jawaban_benar"]').val(index);
    });
    jawabanCounter = $('#pilihan-container .pilihan-item').length;
}

// Generate form benar/salah
function generateBenarSalahForm(container) {
    container.append(`
        <div class="row">
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jawaban_benar" value="0" id="benar" checked required>
                    <label class="form-check-label" for="benar">Benar</label>
                    <input type="hidden" name="jawaban_soal[0][label_jawaban]" value="Benar">
                    <input type="hidden" name="jawaban_soal[0][jawaban]" value="Benar">
                    <input type="hidden" name="jawaban_soal[0][jenis_isian]" value="benar_salah">
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jawaban_benar" value="1" id="salah" required>
                    <label class="form-check-label" for="salah">Salah</label>
                    <input type="hidden" name="jawaban_soal[1][label_jawaban]" value="Salah">
                    <input type="hidden" name="jawaban_soal[1][jawaban]" value="Salah">
                    <input type="hidden" name="jawaban_soal[1][jenis_isian]" value="benar_salah">
                </div>
            </div>
        </div>
    `);
}

// Generate form isian
function generateIsianForm(container) {
    container.append(`
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" name="jawaban_soal[0][label_jawaban]" value="Isian" readonly>
            </div>
            <div class="col-9">
                <input type="text" class="form-control" name="jawaban_soal[0][jawaban]" placeholder="Masukkan jawaban yang benar" required>
                <input type="hidden" name="jawaban_soal[0][jenis_isian]" value="isian">
                <input type="hidden" name="jawaban_benar" value="0">
            </div>
        </div>
    `);
}

// Load dropdown data
function loadDropdownData() {
    // Load tingkat kesulitan
    $.get('/filter/tingkat-kesulitan', function (data) {
        const select = $('#tingkat_kesulitan');
        select.empty().append('<option value="">Pilih Tingkat Kesulitan</option>');
        data.forEach(item => {
            select.append(`<option value="${item.id}">${item.nama}</option>`);
        });
    }).fail(function () {
        console.error('Failed to load tingkat kesulitan');
    });

    // Load kategori
    $.get('/filter/kategori', function (data) {
        const select = $('#kategori');
        select.empty().append('<option value="">Pilih Kategori</option>');
        data.forEach(item => {
            select.append(`<option value="${item.id}">${item.nama}</option>`);
        });
    }).fail(function () {
        console.error('Failed to load kategori');
    });
}

// Load sub kategori berdasarkan kategori
function loadSubKategori(kategoriId) {
    const select = $('#sub_kategori');
    select.empty().append('<option value="">Pilih Sub Kategori</option>');

    if (!kategoriId) return;

    $.get(`/filter/sub-kategori/${kategoriId}`, function (data) {
        data.forEach(item => {
            select.append(`<option value="${item.id}">${item.nama}</option>`);
        });
    }).fail(function () {
        console.error('Failed to load sub kategori');
    });
}

// Submit form
function submitForm() {
    const form = document.getElementById('form-bank-soal');
    const formData = new FormData(form);
    const method = $('#form-method').val();
    const isEdit = method === 'PUT';

    // Set jawaban_benar untuk setiap jawaban
    if ($('#jenis_soal').val() === 'pilihan_ganda') {
        const selectedIndex = $('input[name="jawaban_benar"]:checked').val();
        $('#pilihan-container .pilihan-item').each(function (index) {
            const isCorrect = index == selectedIndex;
            $(this).append(`<input type="hidden" name="jawaban_soal[${index}][jawaban_benar]" value="${isCorrect ? 1 : 0}">`);
        });
    } else if ($('#jenis_soal').val() === 'benar_salah') {
        const selectedValue = $('input[name="jawaban_benar"]:checked').val();
        formData.append('jawaban_soal[0][jawaban_benar]', selectedValue == 0 ? 1 : 0);
        formData.append('jawaban_soal[1][jawaban_benar]', selectedValue == 1 ? 1 : 0);
    } else if ($('#jenis_soal').val() === 'isian') {
        formData.append('jawaban_soal[0][jawaban_benar]', 1);
    }

    // Add jenis_soal to formData
    formData.append('jenis_soal', $('#jenis_soal').val());

    const btn = $('#btn-submit');
    const spinner = btn.find('.spinner-border');

    btn.prop('disabled', true);
    spinner.removeClass('d-none');

    const url = isEdit ? `/bank-soal/${currentSoalId}` : '/bank-soal';

    if (isEdit) {
        formData.append('_method', 'PUT');
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                $('#tambah-bank-soal').modal('hide');

                // Refresh all tables
                if (window.tableSemua) window.tableSemua.ajax.reload();
                if (window.tableReading) window.tableReading.ajax.reload();
                if (window.tableGrammar) window.tableGrammar.ajax.reload();
                if (window.tableListening) window.tableListening.ajax.reload();

                showAlert('success', response.message);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function (xhr) {
            let message = 'Terjadi kesalahan saat menyimpan data.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                message = errors.join('<br>');
            }
            showAlert('error', message);
        },
        complete: function () {
            btn.prop('disabled', false);
            spinner.addClass('d-none');
        }
    });
}

// Edit soal
function editSoal(id) {
    currentSoalId = id;

    $.get(`/bank-soal/${id}`, function (response) {
        console.log('Response data:', response);
        if (response.success) {
            const data = response.data;

            // Set modal title
            $('#modal-title').text('Edit Soal');
            $('#form-method').val('PUT');

            // Fill form fields
            $('#pertanyaan').val(data.pertanyaan);
            $('#jenis_font').val(data.jenis_font);
            $('#is_audio').prop('checked', data.is_audio == 1);
            $('#tingkat_kesulitan').val(data.tingkat_kesulitan_id);
            $('#kategori').val(data.kategori_id);
            $('#penjelasan_jawaban').val(data.penjelasan_jawaban);
            $('#tag').val(data.tag);

            // Show/hide audio container
            if (data.is_audio) {
                $('#audio-file-container').show();
            }

            // Load sub kategori and set value
            if (data.kategori_id) {
                loadSubKategori(data.kategori_id);
                setTimeout(() => {
                    $('#sub_kategori').val(data.sub_kategori_id);
                }, 500);
            }

            // Detect jenis soal from jawaban
            let jenisSoal = 'isian';
            if (data.jawaban_soals && data.jawaban_soals.length > 0) {
                if (data.jawaban_soals.length === 2 &&
                    data.jawaban_soals.some(j => j.jawaban === 'Benar') &&
                    data.jawaban_soals.some(j => j.jawaban === 'Salah')) {
                    jenisSoal = 'benar_salah';
                } else if (data.jawaban_soals.length > 1) {
                    jenisSoal = 'pilihan_ganda';
                }
            }

            $('#jenis_soal').val(jenisSoal);
            generateJawabanForm(jenisSoal);

            // Fill jawaban data
            setTimeout(() => {
                fillJawabanData(data.jawaban_soals, jenisSoal);
            }, 100);

            // Show modal
            $('#tambah-bank-soal').modal('show');
        }
    }).fail(function () {
        showAlert('error', 'Gagal memuat data soal.');
    });
}

// Fill jawaban data for edit
function fillJawabanData(jawabanData, jenisSoal) {
    if (!jawabanData || jawabanData.length === 0) return;

    if (jenisSoal === 'pilihan_ganda') {
        jawabanData.forEach((jawaban, index) => {
            const input = $(`input[name="jawaban_soal[${index}][jawaban]"]`);
            if (input.length) {
                input.val(jawaban.jawaban);
            } else {
                // Add more options if needed
                const label = String.fromCharCode(65 + index);
                addPilihanGanda(label);
                $(`input[name="jawaban_soal[${index}][jawaban]"]`).val(jawaban.jawaban);
            }

            if (jawaban.jawaban_benar) {
                $(`input[name="jawaban_benar"][value="${index}"]`).prop('checked', true);
            }
        });
    } else if (jenisSoal === 'benar_salah') {
        const benarJawaban = jawabanData.find(j => j.jawaban === 'Benar');
        if (benarJawaban && benarJawaban.jawaban_benar) {
            $('input[name="jawaban_benar"][value="0"]').prop('checked', true);
        } else {
            $('input[name="jawaban_benar"][value="1"]').prop('checked', true);
        }
    } else if (jenisSoal === 'isian') {
        if (jawabanData[0]) {
            $('input[name="jawaban_soal[0][jawaban]"]').val(jawabanData[0].jawaban);
        }
    }
}

// Delete soal
function deleteSoal(id) {
    const btn = $('#btn-hapus-confirm');
    const spinner = btn.find('.spinner-border');

    btn.prop('disabled', true);
    spinner.removeClass('d-none');

    $.ajax({
        url: `/bank-soal/${id}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                $('#modal-hapus').modal('hide');

                // Refresh all tables
                if (window.tableSemua) window.tableSemua.ajax.reload();
                if (window.tableReading) window.tableReading.ajax.reload();
                if (window.tableGrammar) window.tableGrammar.ajax.reload();
                if (window.tableListening) window.tableListening.ajax.reload();

                showAlert('success', response.message);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function () {
            showAlert('error', 'Gagal menghapus soal.');
        },
        complete: function () {
            btn.prop('disabled', false);
            spinner.addClass('d-none');
            currentSoalId = null;
        }
    });
}

// Show delete confirmation
function showDeleteConfirmation(id) {
    currentSoalId = id;
    $('#modal-hapus').modal('show');
}

// Reset form
function resetForm() {
    document.getElementById('form-bank-soal').reset();
    $('#modal-title').text('Tambah Soal Baru');
    $('#form-method').val('POST');
    $('#audio-file-container').hide();
    $('#jawaban-container').empty();
    $('#sub_kategori').empty().append('<option value="">Pilih Sub Kategori</option>');
    currentSoalId = null;
    jawabanCounter = 0;
}

// Show alert
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const iconClass = type === 'success' ? 'ri-check-line' : 'ri-error-warning-line';

    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Remove existing alerts
    $('.alert').remove();

    // Add new alert at the top of container
    $('.container-fluid').prepend(alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
}

// Make functions globally available
window.editSoal = editSoal;
window.showDeleteConfirmation = showDeleteConfirmation;



