import $ from "jquery";
import "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";

window.$ = $;
window.jQuery = $;

// Fungsi umum untuk preview gambar, dengan target elemen preview dinamis
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const previewId = input.dataset.previewId || "preview"; // default fallback
            const preview = document.getElementById(previewId);
            if (preview) preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Toggle visibilitas password
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(`${inputId}_icon`);

    if (!input || !icon) return;

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("ri-eye-line", "ri-eye-off-line");
    } else {
        input.type = "password";
        icon.classList.replace("ri-eye-off-line", "ri-eye-line");
    }
}

$(function () {
    const table = $('#selection-datatable-users').DataTable({
        ajax: {
            url: '/pengaturan/users',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: 'no', className: 'text-center' },
            { data: 'name' },
            { data: 'email' },
            {
                data: 'role', className: 'text-center', render: function (data, _, row) {
                    return `<select class='form-select form-select-sm user-role' data-id='${row.id}'>
                    <option value='admin' ${data === 'admin' ? 'selected' : ''}>Admin</option>
                    <option value='user' ${data === 'user' ? 'selected' : ''}>User</option>
                </select>`;
                }
            },
            {
                data: 'status', className: 'text-center', render: function (data, _, row) {
                    return `<select class='form-select form-select-sm user-status' data-id='${row.id}'>
                    <option value='active' ${data === 'active' ? 'selected' : ''}>Active</option>
                    <option value='inactive' ${data === 'inactive' ? 'selected' : ''}>Inactive</option>
                </select>`;
                }
            },
            {
                data: null, className: 'text-center', render: function (_, __, row) {
                    return `
                        <button class='btn btn-outline-primary btn-sm me-1 btn-edit-user' data-id='${row.id}'>Edit</button>
                        <button class='btn btn-danger btn-sm btn-delete-user' data-id='${row.id}'>Hapus</button>
                    `;
                }
            }
        ]
    });

    // Update status
    $(document).on('change', '.user-status', function () {
        const id = $(this).data('id');
        const status = $(this).val();
        $.ajax({
            url: `/pengaturan/users/${id}/status`,
            type: 'PUT',
            data: { status, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function () { table.ajax.reload(null, false); showToast('success', 'Status user diperbarui'); },
            error: function () { showToast('error', 'Gagal update status'); }
        });
    });
    // Update role
    $(document).on('change', '.user-role', function () {
        const id = $(this).data('id');
        const role = $(this).val();
        $.ajax({
            url: `/pengaturan/users/${id}/role`,
            type: 'PUT',
            data: { role, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function () { table.ajax.reload(null, false); showToast('success', 'Role user diperbarui'); },
            error: function () { showToast('error', 'Gagal update role'); }
        });
    });
    // Hapus user
    $(document).on('click', '.btn-delete-user', function () {
        if (!confirm('Yakin hapus user ini?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: `/pengaturan/users/${id}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function () { table.ajax.reload(null, false); showToast('success', 'User dihapus'); },
            error: function () { showToast('error', 'Gagal hapus user'); }
        });
    });

    // Submit Tambah User
    $('#btnSubmitTambahUser').on('click', function () {
        const form = document.getElementById('formTambahUser');
        const token = $('#formTambahUser input[name=_token]').val() || $('meta[name="csrf-token"]').attr('content');

        const name = $('#tambah_nama').val().trim();
        const email = $('#tambah_email').val().trim();
        const password = $('#tambah_password').val();
        const password_confirmation = $('#tambah_password_confirmation').val();
        const role = $('#tambah_role').val();

        let valid = true;
        // HTML5 constraint validation
        if (!form.checkValidity()) valid = false;
        if (password !== password_confirmation) {
            valid = false;
            $('#tambah_password_confirmation')[0].setCustomValidity('Konfirmasi password tidak sama');
        } else {
            $('#tambah_password_confirmation')[0].setCustomValidity('');
        }
        form.classList.add('was-validated');
        if (!valid) return;

        $.ajax({
            url: '/pengaturan/users',
            type: 'POST',
            data: { name, email, password, password_confirmation, role, _token: token },
            success: function () {
                showToast('success', 'User berhasil ditambahkan');
                $('#modalTambahUser').modal('hide');
                form.reset();
                form.classList.remove('was-validated');
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal menambahkan user';
                showFormAlert('#alertTambahUser', 'danger', msg, xhr.responseJSON?.errors);
            }
        });
    });

    // Buka modal Edit User
    $(document).on('click', '.btn-edit-user', function () {
        const id = $(this).data('id');
        $.ajax({
            url: `/pengaturan/users/${id}`,
            type: 'GET',
            success: function (data) {
                $('#edit_id').val(data.id);
                $('#edit_nama').val(data.name);
                $('#edit_email').val(data.email);
                $('#edit_role').val(data.role || 'user');
                $('#edit_password').val('');
                $('#edit_password_confirmation').val('');
                $('#alertEditUser').addClass('d-none').removeClass('alert-success alert-danger').empty();
                $('#modalEditUser').modal('show');
            },
            error: function () {
                showToast('error', 'Gagal memuat data user');
            }
        });
    });

    // Submit Edit User
    $('#btnSubmitEditUser').on('click', function () {
        const form = document.getElementById('formEditUser');
        const token = $('#formEditUser input[name=_token]').val() || $('meta[name="csrf-token"]').attr('content');
        const id = $('#edit_id').val();
        const name = $('#edit_nama').val().trim();
        const email = $('#edit_email').val().trim();
        const role = $('#edit_role').val();
        const password = $('#edit_password').val();
        const password_confirmation = $('#edit_password_confirmation').val();

        let valid = true;
        if (!form.checkValidity()) valid = false;
        if ((password || password_confirmation) && password !== password_confirmation) {
            valid = false;
            $('#edit_password_confirmation')[0].setCustomValidity('Konfirmasi password tidak sama');
        } else {
            $('#edit_password_confirmation')[0].setCustomValidity('');
        }
        form.classList.add('was-validated');
        if (!valid) return;

        const payload = { name, email, role, _token: token };
        if (password) {
            payload.password = password;
            payload.password_confirmation = password_confirmation;
        }

        $.ajax({
            url: `/pengaturan/users/${id}`,
            type: 'PUT',
            data: payload,
            success: function () {
                showToast('success', 'User berhasil diperbarui');
                $('#modalEditUser').modal('hide');
                form.classList.remove('was-validated');
                table.ajax.reload(null, false);
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Gagal memperbarui user';
                showFormAlert('#alertEditUser', 'danger', msg, xhr.responseJSON?.errors);
            }
        });
    });

    // Delete dari modal Edit
    $('#btnDeleteUser').on('click', function () {
        if (!confirm('Yakin hapus user ini?')) return;
        const id = $('#edit_id').val();
        const token = $('#formEditUser input[name=_token]').val() || $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: `/pengaturan/users/${id}`,
            type: 'DELETE',
            data: { _token: token },
            success: function () {
                showToast('success', 'User dihapus');
                $('#modalEditUser').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function () { showToast('error', 'Gagal hapus user'); }
        });
    });
});
function showToast(type, message) {
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
        `;
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toast = document.createElement('div');
    const toastId = 'toast-' + Date.now();
    toast.id = toastId;

    const bgColor = type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff';
    const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ';

    toast.style.cssText = `
        background: ${bgColor};
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 14px;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    `;

    toast.innerHTML = `
        <span style="margin-right: 8px; font-weight: bold; font-size: 16px;">${icon}</span>
        <span>${message}</span>
        <button onclick="document.getElementById('${toastId}').remove()"
                style="background: none; border: none; color: white; margin-left: auto; cursor: pointer; font-size: 16px; opacity: 0.7;">×</button>
    `;

    toastContainer.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';
    }, 10);

    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Buat fungsi global agar bisa dipanggil lewat HTML (karena pakai Vite)
window.previewImage = previewImage;
window.togglePassword = togglePassword;

function showFormAlert(selector, type, message, errors) {
    const el = document.querySelector(selector);
    if (!el) return;
    el.classList.remove('d-none', 'alert-success', 'alert-danger');
    el.classList.add(`alert-${type}`);
    let html = message ? `<div class="mb-1">${message}</div>` : '';
    if (errors) {
        html += '<ul class="mb-0">';
        Object.keys(errors).forEach(k => {
            errors[k].forEach(msg => { html += `<li>${msg}</li>`; });
        });
        html += '</ul>';
    }
    el.innerHTML = html;
}


