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

// Buat fungsi global agar bisa dipanggil lewat HTML (karena pakai Vite)
window.previewImage = previewImage;
window.togglePassword = togglePassword;
