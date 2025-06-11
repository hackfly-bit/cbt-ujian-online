import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";

window.$ = $;
window.jQuery = $;

(function () {
    let table;
    let deleteId = null;

    // Initialize DataTables
    initDataTable();

    // Form handlers
    handleAddForm();
    handleEditForm();
    handleDeleteConfirmation();

    // Reset forms when modals are hidden
    $('#modal-tambah-jenis-ujian').on('hidden.bs.modal', function () {
        $('#form-tambah-jenis-ujian')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    $('#modal-edit-jenis-ujian').on('hidden.bs.modal', function () {
        $('#form-edit-jenis-ujian')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    function initDataTable() {
        table = $('#jenis-ujian-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/jenis-ujian',
                type: 'GET',
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            },
            columns: [
                // give index column
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                { data: 'nama', name: 'nama' },
                { data: 'deskripsi', name: 'deskripsi' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'action-icons'
                }
            ],
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
    }

    function handleAddForm() {
        $('#form-tambah-jenis-ujian').on('submit', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#btn-simpan-jenis-ujian');
            const $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function () {
                    $('#modal-tambah-jenis-ujian').modal('hide');
                    $form[0].reset();
                    table.ajax.reload();
                    showToast('success', 'Jenis Ujian berhasil ditambahkan');
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    showValidationErrors(errors);
                    showToast('error', 'Gagal menambahkan jenis ujian');
                },
                complete: function () {
                    $submitBtn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        });
    }

    function handleEditForm() {
        $(document).on('click', '.btn-edit', function () {
            const id = $(this).data('id');

            $.ajax({
                url: `/jenis-ujian/${id}`,
                type: 'GET',
                success: function (data) {

                    $('#edit_id').val(data.data.id);
                    $('#edit_nama').val(data.data.nama);
                    $('#edit_deskripsi').val(data.data.deskripsi);
                    $('#form-edit-jenis-ujian').attr('action', `/jenis-ujian/${data.data.id}`);
                    $('#modal-edit-jenis-ujian').modal('show');
                },
                error: function () {
                    showToast('error', 'Gagal mengambil data jenis ujian');
                }
            });
        });

        $('#form-edit-jenis-ujian').on('submit', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#btn-update-jenis-ujian');
            const $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr('action'),
                type: 'PUT',
                data: $form.serialize(),
                success: function () {
                    $('#modal-edit-jenis-ujian').modal('hide');
                    table.ajax.reload();
                    showToast('success', 'Jenis Ujian berhasil diperbarui');
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    showValidationErrors(errors, 'edit_');
                    showToast('error', 'Gagal memperbarui jenis ujian');
                },
                complete: function () {
                    $submitBtn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        });
    }

    function handleDeleteConfirmation() {
        $(document).on('click', '.btn-delete', function () {
            deleteId = $(this).data('id');
            $('#modal-hapus').modal('show');
        });

        $('#btn-hapus-confirm').on('click', function () {
            if (!deleteId) return;

            const $btn = $(this);
            const $spinner = $btn.find('.spinner-border');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: `/jenis-ujian/${deleteId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    $('#modal-hapus').modal('hide');
                    table.ajax.reload();
                    showToast('success', 'Jenis Ujian berhasil dihapus');
                },
                error: function () {
                    showToast('error', 'Gagal menghapus jenis ujian');
                },
                complete: function () {
                    $btn.prop('disabled', false);
                    $spinner.addClass('d-none');
                    deleteId = null;
                }
            });
        });
    }

    function showValidationErrors(errors, prefix = '') {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        Object.keys(errors).forEach(field => {
            const $field = $(`#${prefix}${field}`);
            if ($field.length) {
                $field.addClass('is-invalid');
                $field.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
            }
        });
    }

    function showToast(type, message) {
        // Replace with your toast implementation
        if (type === 'success') {
            console.log('SUCCESS:', message);
        } else {
            console.log('ERROR:', message);
        }
    }
})();
