import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";

window.$ = $;
window.jQuery = $;

(function () {
    let table;
    let deleteId = null;

    initDataTable();
    handleAddForm();
    handleEditForm();
    handleDeleteConfirmation();

    $('#modal-tambah-tingkat').on('hidden.bs.modal', function () {
        $('#form-tambah-tingkat')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    $('#modal-edit-tingkat').on('hidden.bs.modal', function () {
        $('#form-edit-tingkat')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    function initDataTable() {
        table = $('#tingkat-kesulitan-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/tingkat-kesulitan',
                type: 'GET',
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
        $('#form-tambah-tingkat').on('submit', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#btn-simpan-tingkat');
            const $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function () {
                    $('#modal-tambah-tingkat').modal('hide');
                    $form[0].reset();
                    table.ajax.reload();
                    showToast('success', 'Tingkat kesulitan berhasil ditambahkan');
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    showValidationErrors(errors);
                    showToast('error', 'Gagal menambahkan tingkat kesulitan');
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
                url: `/tingkat-kesulitan/${id}`,
                type: 'GET',
                success: function (data) {
                    $('#edit_id').val(data.data.id);
                    $('#edit_nama').val(data.data.nama);
                    $('#edit_deskripsi').val(data.data.deskripsi);
                    $('#form-edit-tingkat').attr('action', `/tingkat-kesulitan/${data.data.id}`);
                    $('#modal-edit-tingkat').modal('show');
                },
                error: function () {
                    showToast('error', 'Gagal mengambil data tingkat kesulitan');
                }
            });
        });

        $('#form-edit-tingkat').on('submit', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#btn-update-tingkat');
            const $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr('action'),
                type: 'PUT',
                data: $form.serialize(),
                success: function () {
                    $('#modal-edit-tingkat').modal('hide');
                    table.ajax.reload();
                    showToast('success', 'Tingkat kesulitan berhasil diperbarui');
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    showValidationErrors(errors, 'edit_');
                    showToast('error', 'Gagal memperbarui tingkat kesulitan');
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
                url: `/tingkat-kesulitan/${deleteId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    $('#modal-hapus').modal('hide');
                    table.ajax.reload();
                    showToast('success', 'Tingkat kesulitan berhasil dihapus');
                },
                error: function () {
                    showToast('error', 'Gagal menghapus tingkat kesulitan');
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
        if (type === 'success') {
            console.log('SUCCESS:', message);
        } else {
            console.log('ERROR:', message);
        }
    }
})();