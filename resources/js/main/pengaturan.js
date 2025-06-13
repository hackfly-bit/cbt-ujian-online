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
                    <option value='Super Admin' ${data === 'Super Admin' ? 'selected' : ''}>Super Admin</option>
                    <option value='Admin' ${data === 'Admin' ? 'selected' : ''}>Admin</option>
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
                    return `<button class='btn btn-danger btn-sm btn-delete-user' data-id='${row.id}'>Hapus</button>`;
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


