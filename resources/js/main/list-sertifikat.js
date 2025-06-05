document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".template-card");
    const inputJudul = document.getElementById("judul");
    const inputUjianId = document.getElementById("ujian_id");
    const inputTemplate = document.getElementById("template");

    if (!inputJudul || !inputUjianId || !inputTemplate) {
        console.error("Required form elements not found");
        return;
    }

    if (cards.length === 0) {
        console.error("No template cards found");
        return;
    }

    cards.forEach((card) => {
        card.addEventListener("click", function () {
            const isCurrentlySelected = this.classList.contains("selected");

            // Hilangkan semua yang selected
            cards.forEach((c) => {
                c.classList.remove("selected");
                c.querySelector(".checkmark").classList.add("d-none");
            });

            // Jika tidak sedang selected, maka pilih. Jika sedang selected, biarkan tidak terpilih
            if (!isCurrentlySelected) {
                this.classList.add("selected");
                this.querySelector(".checkmark").classList.remove("d-none");
                this.classList.add("selected");
                this.querySelector(".checkmark").classList.remove("d-none");
                inputTemplate.value = this.getAttribute("data-template-json");
            } else {
                inputTemplate.value = ""; // Clear input when deselecting
            }
        });
    });

    // Validasi saat submit
    const form = document.getElementById("formSertifikat");
    if (form) {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();
            const selected = document.querySelector(".template-card.selected");
            const confirmMessage = selected
                ? "Anda yakin ingin membuat sertifikat dengan template ini?"
                : "Tidak ada template yang dipilih. Lanjutkan dengan sertifikat custom?";

            if (confirm(confirmMessage)) {
                form.submit();
            } else if (!selected) {
                window.location.href = route("template");
            }
        });
    }

    // ====================
    // Tombol "Buat Sertifikat Custom"
    // ====================
    const customTemplateLink = document.getElementById("customTemplateLink");
    if (customTemplateLink) {
        customTemplateLink.addEventListener("click", function (e) {
            e.preventDefault();

            const judul = inputJudul.value;
            const ujianId = inputUjianId.value;
            const templateJson = inputTemplate.value || "{}";

            if (!judul) {
                alert("Judul sertifikat wajib diisi!");
                return;
            }

            // Simpan ke localStorage
            localStorage.setItem("sertifikat_judul", judul);
            localStorage.setItem("sertifikat_ujian_id", ujianId);
            localStorage.setItem("sertifikat_template", templateJson);

            // Arahkan ke halaman custom template
            window.location.href = this.href;
        });
    }
});
