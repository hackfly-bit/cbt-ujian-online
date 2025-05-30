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
    $('#modal-tambah-kategori').on('hidden.bs.modal', function () {
        $('#form-tambah-kategori')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    $('#modal-edit-kategori').on('hidden.bs.modal', function () {
        $('#form-edit-kategori')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    function initDataTable() {
        table = $('#kategori-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '/kategori',
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
        $('#form-tambah-kategori').on('submit', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#btn-simpan-kategori');
            const $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function () {
                    $('#modal-tambah-kategori').modal('hide');
                    $form[0].reset();
                    table.ajax.reload();
                    showToast('success', 'Kategori berhasil ditambahkan');
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    showValidationErrors(errors);
                    showToast('error', 'Gagal menambahkan kategori');
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
                url: `/kategori/${id}`,
                type: 'GET',
                success: function (data) {

                    $('#edit_id').val(data.data.id);
                    $('#edit_nama').val(data.data.nama);
                    $('#edit_deskripsi').val(data.data.deskripsi);
                    $('#form-edit-kategori').attr('action', `/kategori/${data.data.id}`);
                    $('#modal-edit-kategori').modal('show');
                },
                error: function () {
                    showToast('error', 'Gagal mengambil data kategori');
                }
            });
        });

        $('#form-edit-kategori').on('submit', function (e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $('#btn-update-kategori');
            const $spinner = $submitBtn.find('.spinner-border');

            $submitBtn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr('action'),
                type: 'PUT',
                data: $form.serialize(),
                success: function () {
                    $('#modal-edit-kategori').modal('hide');
                    table.ajax.reload();
                    showToast('success', 'Kategori berhasil diperbarui');
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    showValidationErrors(errors, 'edit_');
                    showToast('error', 'Gagal memperbarui kategori');
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
                url: `/kategori/${deleteId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    $('#modal-hapus').modal('hide');
                    table.ajax.reload();
                    showToast('success', 'Kategori berhasil dihapus');
                },
                error: function () {
                    showToast('error', 'Gagal menghapus kategori');
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
