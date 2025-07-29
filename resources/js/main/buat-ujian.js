import jQuery from "jquery/dist/jquery.min.js";
import Swal from "sweetalert2";
import flatpickr from "flatpickr";
import DragulaSections from "./dragula-section.js";
// import Datepicker from "bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js";

(function ($) {
    "use strict";
    // Initialize DragulaSections
    const dragulaSections = new DragulaSections();
    dragulaSections.init();

})(window.jQuery);

// Custom functions and scripts section
(function ($) {
    "use strict";

    flatpickr("#tanggal_kedaluwarsa", {
        dateFormat: "Y-m-d",
        allowInput: true,
        // default value if ujian.tanggal_selesai is not null
        defaultDate: ujian.tanggal_selesai || null,
    });

    window.toggleNilaiKelulusan = () => {
        const metode = document.getElementById("metode_penilaian").value;
        const group = document.getElementById("nilai_kelulusan_group");
        group.style.display = metode === "rumus_custom" ? "block" : "none";
    };
    // document.addEventListener('DOMContentLoaded', toggleNilaiKelulusan);

    // Function to navigate to the next tab
    window.goToNextTab = function (targetTabId) {
        // Hide current active tab
        const $currentActiveTab = $(".tab-pane.show.active");
        const $currentActiveNavTab = $(".nav-link.active");

        $currentActiveTab.removeClass("show active");
        $currentActiveNavTab
            .removeClass("active")
            .attr("aria-selected", "false");

        // Show target tab
        const $targetTab = $("#" + targetTabId);
        const $targetNavTab = $("#" + targetTabId + "-tab");

        $targetTab.addClass("show active");
        $targetNavTab.addClass("active").attr("aria-selected", "true");
    };

    // Function to get all section data for form submission
    window.getSectionData = function () {
        const sections = [];

        $("#section-container .section-item").each(function () {
            const $section = $(this);
            const $form = $section.find(".section-form");

            // console.log('Processing section:', $form.find('select[name="kategori_id"]').val());

            const sectionData = {
                nama_section: $form.find('input[name="nama_section"]').val(),
                // bobot_nilai: parseFloat($form.find('input[name="bobot_nilai"]').val()) || 0,
                instruksi: $form.find('textarea[name="instruksi"]').val(),
                kategori_id: $form.find('select[name="kategori_id"]').val(),
                formula_type: $form.find('select[name="answer_type"]').val(),
                operation_1:
                    $form.find('select[name="operation"]').val() || "*",
                value_1:
                    parseFloat($form.find('input[name="value"]').val()) || 1,
                operation_2:
                    $form.find('select[name="operation2"]').val() || "*",
                value_2:
                    parseFloat($form.find('input[name="value2"]').val()) || 1,
                selected_questions: [],
            };

            // // Collect selected questions from checkboxes (create mode)
            // $form.find(".question-checkbox:checked").each(function () {
            //     const questionId = $(this).val();
            //     // Validate questionId is a valid number
            //     if (questionId && !isNaN(questionId) && parseInt(questionId) > 0 && !sectionData.selected_questions.includes(questionId)) {
            //         sectionData.selected_questions.push(parseInt(questionId));
            //     }
            // });

            // Collect selected questions from selected-questions-container (edit mode)
            $form.find(".selected-questions-container").find(".question-box").each(function () {
                const questionId = $(this).attr('data-question-id');
                // Validate questionId is a valid number
                if (questionId && !isNaN(questionId) && parseInt(questionId) > 0 && !sectionData.selected_questions.includes(questionId)) {
                    sectionData.selected_questions.push(parseInt(questionId));
                }
            });

            sections.push(sectionData);
        });

        return sections;
    };

    // Function to handle saving ujian
    window.handleSaveUjian = function () {
        const sectionData = getSectionData();

        if (typeof Swal === "undefined") {
            alert("Harap tambahkan minimal satu seksi ujian.");
            return;
        }

        if (sectionData.length === 0) {
            return Swal.fire({
                icon: "warning",
                title: "Peringatan",
                text: "Harap tambahkan minimal satu seksi ujian.",
                confirmButtonText: "OK",
            }).then(() => goToNextTab("seksi"));
        }

        for (let i = 0; i < sectionData.length; i++) {
            const section = sectionData[i];

            if (!section.nama_section) {
                return Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: `Harap isi nama seksi untuk Seksi ${i + 1}.`,
                    confirmButtonText: "OK",
                }).then(() => goToNextTab("seksi"));
            }

            if (section.selected_questions.length === 0) {
                return Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: `Harap pilih minimal satu soal untuk ${section.nama_section}.`,
                    confirmButtonText: "OK",
                }).then(() => goToNextTab("seksi"));
            }
        }

        const totalQuestions = sectionData.reduce(
            (sum, section) => sum + section.selected_questions.length,
            0
        );
        const confirmMessage = `Anda akan menyimpan ujian dengan ${sectionData.length} seksi dan total ${totalQuestions} soal. Lanjutkan?`;

        Swal.fire({
            title: "Konfirmasi",
            text: confirmMessage,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (!result.isConfirmed) return;

            Swal.fire({
                title: "Menyimpan...",
                text: "Mohon tunggu sebentar",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            // Ambil ID dari URL jika ada
            const urlParts = window.location.pathname.split("/");
            let ujianId =
                urlParts[1] === "ujian" && /^\d+$/.test(urlParts[2])
                    ? urlParts[2]
                    : null;
            const url = ujianId ? `/ujian/${ujianId}` : "/ujian";
            const method = ujianId ? "POST" : "POST"; // Jika pakai Route::put(), ganti method jadi PUT

            const tampilanData = getTampilanData(); // Pastikan return-nya adalah FormData

            // append put

            if (ujianId) {
                tampilanData.append("_method", "PUT");
            }

            // Tambah data tambahan
            tampilanData.append("sections", JSON.stringify(sectionData));
            tampilanData.append(
                "detail",
                JSON.stringify({
                    nama: $("#nama_ujian").val(),
                    deskripsi: $("#deskripsi").val(),
                    durasi: $("#durasi_ujian").val() || 120,
                    jenis_ujian: $("#jenis_ujian").val(),
                    tanggal_selesai: $("#tanggal_kedaluwarsa").val(),
                    status: $("#status_ujian").val(),
                })
            );
            tampilanData.append(
                "peserta",
                JSON.stringify({
                    nama: $("#nama").is(":checked"),
                    email: $("#email").is(":checked"),
                    phone: $("#telp").is(":checked"),
                    institusi: $("#sekolah").is(":checked"),
                    nomor_induk: $("#no_induk").is(":checked"),
                    tanggal_lahir: $("#tanggal_lahir").is(":checked"),
                    alamat: $("#alamat").is(":checked"),
                    foto: $("#foto").is(":checked"),
                })
            );
            tampilanData.append(
                "pengaturan",
                JSON.stringify({
                    nilai_kelulusan: $("#nilai_kelulusan").val(),
                    // Fitur acak soal dan acak jawaban telah dinonaktifkan
                    acak_soal: 0,
                    acak_jawaban: 0,
                    // lihat_pembahasan: $('#lihat_pembahasan').is(':checked'),
                    is_arabic: $("#is_arabic").is(":checked"),
                    answer_type: $("#answer_type").val(),
                    operation: $("#operation").val(),
                    value: $("#value").val(),
                    operation2: $("#operation2").val(),
                    value2: $("#value2").val(),
                    lockscreen: $("#lockscreen").is(":checked"),
                    foto: $("#foto").is(":checked"),
                })
            );
            //

            // Handle file uploads
            if (tampilanData.has("logo")) {
                const logoFile = tampilanData.get("logo");
                tampilanData.delete("logo");
                tampilanData.append("logo", logoFile);
            }

            $.ajax({
                url: url,
                type: method,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                processData: false,
                contentType: false,
                data: tampilanData,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Ujian berhasil disimpan!",
                            confirmButtonText: "OK",
                        }).then(() => {
                            window.location.href = "/ujian";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: response.message || "Gagal menyimpan ujian.",
                            confirmButtonText: "OK",
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text:
                            xhr.responseJSON?.message ||
                            "Terjadi kesalahan saat menyimpan ujian.",
                        confirmButtonText: "OK",
                    });
                },
            });
        });
    };

    // Prevent form submission on Enter key in section for

    // Inisialisasi & DOM Ready
    $(document).ready(function () {
        if ($("#tampilan-form").length) {
            initThemePreview();
        }
    });

    // Variabel global untuk menyimpan background & header preview
    let bgImagePreviewUrl = "";
    let headerImagePreviewUrl = "";

    // Fungsi Utama Preview Tema
    window.initThemePreview = function () {
        // Ambil dari data-preview jika ada
        bgImagePreviewUrl = $("#live-preview").data("bg") || "";
        headerImagePreviewUrl = $("#live-preview").data("header") || "";

        // Klik kotak tema = pilih radio input
        $(".theme-option").on("click", function () {
            const radio = $(this).find('input[type="radio"]');
            radio.prop("checked", true).trigger("change");
        });

        // Saat tema atau warna berubah, update preview
        $('input[name="theme"], input[type="color"]').on(
            "change input",
            function () {
                updatePreview();
                toggleCustomColors();
            }
        );

        // Nama institusi & sambutan update preview
        $("#institution_name, #welcome_message").on("input", updatePreview);

        // Preview logo langsung saat file dipilih
        $("#logo").on("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $(".preview-logo .logo-placeholder").html(
                        `<img src="${e.target.result}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;">`
                    );
                };
                reader.readAsDataURL(file);
            }
        });

        // Preview awal saat pertama kali load
        updatePreview();
        toggleCustomColors();
    };

    // Update Tampilan Preview
    window.updatePreview = function () {
        const theme = $('input[name="theme"]:checked').val();
        const isCustom = theme === "custom";

        const colors = isCustom
            ? {
                primary: $("#primary_color").val(),
                secondary: $("#secondary_color").val(),
                tertiary: $("#tertiary_color").val(),
                background: $("#background_color").val(),
                header: $("#header_color").val(),
                font: $("#font_color").val(),
                button: $("#button_color").val(),
                buttonFont: $("#button_font_color").val(),
            }
            : {
                background: $("#background_color").val(),
                header: $("#header_color").val(),
            };

        applyThemeToPreview(
            theme,
            colors,
            $("#institution_name").val() || "Nama Institusi",
            $("#welcome_message").val() ||
            "Pesan sambutan akan ditampilkan di sini...",
            isCustom
        );
    };

    // Terapkan Tema ke Preview
    window.applyThemeToPreview = function (
        theme,
        colors,
        name,
        message,
        isCustom
    ) {
        const $preview = $("#live-preview");
        const $header = $preview.find(".preview-header");
        const $content = $preview.find(".preview-content");
        const $welcomeText = $preview.find(".preview-welcome p");
        const $institutionTitle = $preview.find(".preview-institution h4");
        const $examCard = $preview.find(".exam-card");
        const $button = $preview.find(".exam-card button");
        const $footer = $(".footer-preview");

        // Reset kelas tema dan tambahkan kelas baru
        $preview
            .removeClass(
                "classic-preview modern-preview glow-preview minimal-preview custom-preview"
            )
            .addClass(`${theme}-preview`);

        // Update teks
        $("#preview-institution-name").text(name);
        $("#preview-welcome-message").text(message);

        // Terapkan warna custom
        if (isCustom) {
            $header.css({ backgroundColor: colors.header });
            $institutionTitle.css({ color: colors.primary });
            $content.css({ backgroundColor: colors.background });
            $welcomeText.css({ color: colors.secondary });
            $examCard.css({
                backgroundColor: colors.tertiary,
                color: colors.font,
                border: `1px solid ${colors.tertiary}`,
            });
            $button.css({
                backgroundColor: colors.button,
                color: colors.buttonFont,
                border: "none",
            });
            $footer.css({ color: colors.primary });
        } else {
            // Reset styling jika bukan custom
            [
                $header,
                $institutionTitle,
                $content,
                $welcomeText,
                $examCard,
                $button,
                $footer,
            ].forEach(($el) => {
                $el.removeAttr("style");
            });
        }

        // === Handle gambar background & header ===
        const $livePreview = $("#live-preview");
        const removeBg = $("#remove_background_image_flag").val() === "1";
        const removeHeader = $("#remove_header_image_flag").val() === "1";

        // Coba ambil ulang gambar dari input file jika ada
        const bgFile = $("#background_image")[0]?.files[0];
        const headerFile = $("#header_image")[0]?.files[0];

        if (bgFile && !removeBg) {
            const reader = new FileReader();
            reader.onload = function (e) {
                window.bgImagePreviewUrl = e.target.result;
                $content.css({
                    backgroundImage: `url('${e.target.result}')`,
                    backgroundSize: "cover",
                    backgroundRepeat: "no-repeat",
                    backgroundPosition: "center center",
                });
                $("#remove_background_image").removeClass("d-none");
            };
            reader.readAsDataURL(bgFile);
        } else if (
            !removeBg &&
            (window.bgImagePreviewUrl || $livePreview.data("bg"))
        ) {
            const bgUrl = window.bgImagePreviewUrl || $livePreview.data("bg");
            $content.css({
                backgroundImage: `url('${bgUrl}')`,
                backgroundSize: "cover",
                backgroundRepeat: "no-repeat",
                backgroundPosition: "center center",
            });
            $("#remove_background_image").removeClass("d-none");
        } else {
            $content.css({
                backgroundImage: "",
                backgroundSize: "",
                backgroundRepeat: "",
                backgroundPosition: "",
                backgroundColor: "",
            });
            $("#remove_background_image").addClass("d-none");
            window.bgImagePreviewUrl = "";
        }

        if (headerFile && !removeHeader) {
            const reader = new FileReader();
            reader.onload = function (e) {
                window.headerImagePreviewUrl = e.target.result;
                $header.css({
                    backgroundImage: `url('${e.target.result}')`,
                    backgroundSize: "cover",
                    backgroundRepeat: "no-repeat",
                    backgroundPosition: "center center",
                    backgroundColor: "transparent",
                });
                $("#remove_header_image").removeClass("d-none");
            };
            reader.readAsDataURL(headerFile);
        } else if (
            !removeHeader &&
            (window.headerImagePreviewUrl || $livePreview.data("header"))
        ) {
            const headerUrl =
                window.headerImagePreviewUrl || $livePreview.data("header");
            $header.css({
                backgroundImage: `url('${headerUrl}')`,
                backgroundSize: "cover",
                backgroundRepeat: "no-repeat",
                backgroundPosition: "center center",
                backgroundColor: "transparent",
            });
            $("#remove_header_image").removeClass("d-none");
        } else {
            $header.css({
                backgroundImage: "",
                backgroundSize: "",
                backgroundRepeat: "",
                backgroundPosition: "",
                backgroundColor: "",
            });
            $("#remove_header_image").addClass("d-none");
            window.headerImagePreviewUrl = "";
        }
    };

    window.getTampilanData = function () {
        const formData = new FormData();
        const selectedTheme = $('input[name="theme"]:checked').val();
        const isCustom = selectedTheme === "custom";

        formData.append("theme", selectedTheme);
        formData.append("institution_name", $("#institution_name").val() || "");
        formData.append("welcome_message", $("#welcome_message").val() || "");
        formData.append(
            "use_custom_color",
            $("#use_custom_color").is(":checked")
        );
        formData.append(
            "show_institution_name",
            $("#show_institution_name").is(":checked")
        );

        if (isCustom) {
            formData.append("primary_color", $("#primary_color").val() || "");
            formData.append(
                "secondary_color",
                $("#secondary_color").val() || ""
            );
            formData.append("tertiary_color", $("#tertiary_color").val() || "");
            formData.append(
                "background_color",
                $("#background_color").val() || ""
            );
            formData.append("header_color", $("#header_color").val() || "");
            formData.append("font_color", $("#font_color").val() || "");
            formData.append("button_color", $("#button_color").val() || "");
            formData.append(
                "button_font_color",
                $("#button_font_color").val() || ""
            );
        }

        formData.append(
            "background_image_path",
            $("#background_image_path").val() || ""
        );
        formData.append(
            "header_image_path",
            $("#header_image_path").val() || ""
        );

        const logo = $("#logo")[0]?.files[0];
        if (logo) formData.append("logo", logo);

        const bg = $("#background_image")[0]?.files[0];
        if (bg) formData.append("background_image", bg);

        const header = $("#header_image")[0]?.files[0];
        if (header) formData.append("header_image", header);

        // 🔥 Tambahkan ini agar controller bisa tahu apakah gambar dihapus
        formData.append(
            "remove_background_image",
            $("#remove_background_image_flag").val() || "0"
        );
        formData.append(
            "remove_header_image",
            $("#remove_header_image_flag").val() || "0"
        );

        return formData;
    };

    // Tampilkan/Sembunyikan Panel Warna Kustom
    window.toggleCustomColors = function () {
        const selectedTheme = $('input[name="theme"]:checked').val();
        const show = selectedTheme === "custom";

        $("#custom-colors").toggle(show);
        $("#default-colors").toggle(!show);
        $("#custom-logo-institution").toggle(show);
    };

    // Toggle Logo dan Institusi
    $(function () {
        const checkbox1 = document.getElementById("use_custom_color");
        const checkbox2 = document.getElementById("show_institution_name");
        const logoSection = document.getElementById("logo-section-wrapper");
        const institutionNameSection = document.getElementById(
            "institution-name-section"
        );

        const defaultLogo = document.getElementById("default-logo-preview");
        const logoOnly = document.getElementById("preview-logo-only");
        const logoWithInstitution = document.getElementById(
            "preview-logo-with-institution"
        );

        const logoInput = document.getElementById("logo");
        const previewImgOnly = document.getElementById(
            "live-logo-preview-only"
        );
        const previewImgWithText = document.getElementById(
            "live-logo-preview-with-text"
        );

        const institutionInput = document.getElementById("institution_name");
        const institutionPreview = document.getElementById(
            "preview-institution-name"
        );

        const placeholder =
            previewImgOnly?.dataset.placeholder || "/images/placeholder.jpeg";

        function toggleLogoPreview() {
            const isLogoChecked = checkbox1.checked;
            const isInstitutionChecked = checkbox2.checked;

            defaultLogo?.style.setProperty("display", "none");
            logoOnly?.style.setProperty("display", "none");
            logoWithInstitution?.style.setProperty("display", "none");

            if (!isLogoChecked) {
                defaultLogo?.style.setProperty("display", "block");
            } else if (isLogoChecked && !isInstitutionChecked) {
                logoOnly?.style.setProperty("display", "block");
            } else if (isLogoChecked && isInstitutionChecked) {
                logoWithInstitution?.style.setProperty("display", "block");
            }
        }

        function toggleLogoSection() {
            const isLogoChecked = checkbox1.checked;
            logoSection.style.display = isLogoChecked ? "block" : "none";

            if (!isLogoChecked) {
                institutionNameSection.style.display = "none";
                checkbox2.checked = false;
                resetLogoPreview();
            }

            toggleLogoPreview();
        }

        function toggleInstitutionName() {
            const isChecked = checkbox2.checked;
            institutionNameSection.style.display = isChecked ? "block" : "none";

            if (!isChecked) {
                if (institutionInput) institutionInput.value = "";
                if (institutionPreview)
                    institutionPreview.textContent = "Nama Institusi";
            }

            toggleLogoPreview();
        }

        function resetLogoPreview() {
            if (logoInput) logoInput.value = "";
            if (previewImgOnly) previewImgOnly.src = placeholder;
            if (previewImgWithText) previewImgWithText.src = placeholder;
            if (institutionInput) institutionInput.value = "";
            if (institutionPreview)
                institutionPreview.textContent = "Nama Institusi";
        }

        if (logoInput) {
            logoInput.addEventListener("change", function () {
                const file = this.files[0];
                if (file && file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (previewImgOnly)
                            previewImgOnly.src = e.target.result;
                        if (previewImgWithText)
                            previewImgWithText.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    resetLogoPreview();
                }
            });
        }

        toggleLogoSection();
        toggleInstitutionName();

        checkbox1.addEventListener("change", toggleLogoSection);
        checkbox2.addEventListener("change", toggleInstitutionName);
    });

    // Handle background dan header image
    $(function () {
        const backgroundInput = document.getElementById("background_image");
        const headerInput = document.getElementById("header_image");

        const removeBgBtn = document.getElementById("remove_background_image");
        const removeHeaderBtn = document.getElementById("remove_header_image");

        const previewContent = document.getElementById("live-preview-content");
        const previewHeader = document.getElementById("live-preview-header");

        const previewWrapper = document.getElementById("live-preview");

        // Hidden input untuk tandai penghapusan gambar dari DB
        const removeBgFlag = document.getElementById(
            "remove_background_image_flag"
        );
        const removeHeaderFlag = document.getElementById(
            "remove_header_image_flag"
        );

        function applyBackgroundImage(input, element, removeBtn) {
            const file = input.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imageUrl = e.target.result;
                    element.style.backgroundImage = `url(${imageUrl})`;
                    element.style.backgroundSize = "cover";
                    element.style.backgroundRepeat = "no-repeat";
                    element.style.backgroundPosition = "center center";
                    element.style.backgroundColor = "transparent";
                    removeBtn.classList.remove("d-none");

                    if (input === backgroundInput) {
                        bgImagePreviewUrl = imageUrl;
                        removeBgFlag.value = ""; // Reset flag jika ada upload baru
                    } else if (input === headerInput) {
                        headerImagePreviewUrl = imageUrl;
                        removeHeaderFlag.value = "";
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        function resetBackground(element, input, removeBtn, flagInput) {
            input.value = "";
            element.style.backgroundImage = "";
            element.style.backgroundSize = "";
            element.style.backgroundRepeat = "";
            element.style.backgroundPosition = "";
            element.style.backgroundColor = "";
            removeBtn.classList.add("d-none");

            if (input === backgroundInput) bgImagePreviewUrl = "";
            if (input === headerInput) headerImagePreviewUrl = "";

            if (flagInput) flagInput.value = "1"; // tandai agar backend menghapus file
        }

        // === Tambahan: tampilkan tombol hapus jika gambar awal dari DB ===
        const initialBgImage = previewWrapper.getAttribute("data-bg");
        const initialHeaderImage = previewWrapper.getAttribute("data-header");

        if (initialBgImage && initialBgImage.trim() !== "") {
            removeBgBtn.classList.remove("d-none");
        }

        if (initialHeaderImage && initialHeaderImage.trim() !== "") {
            removeHeaderBtn.classList.remove("d-none");
        }

        // === Event Listeners ===
        if (backgroundInput) {
            backgroundInput.addEventListener("change", function () {
                applyBackgroundImage(this, previewContent, removeBgBtn);
            });
        }

        if (removeBgBtn) {
            removeBgBtn.addEventListener("click", function () {
                resetBackground(
                    previewContent,
                    backgroundInput,
                    removeBgBtn,
                    removeBgFlag
                );
            });
        }

        if (headerInput) {
            headerInput.addEventListener("change", function () {
                applyBackgroundImage(this, previewHeader, removeHeaderBtn);
            });
        }

        if (removeHeaderBtn) {
            removeHeaderBtn.addEventListener("click", function () {
                resetBackground(
                    previewHeader,
                    headerInput,
                    removeHeaderBtn,
                    removeHeaderFlag
                );
            });
        }
    });

    // Error handling for input fields
    $(document).ready(function () {
        // Tambah kelas merah jika blur dan kosong
        $("input[required], textarea[required], select[required]").on(
            "blur",
            function () {
                if (!$(this).val()) {
                    $(this).addClass("input-error");
                } else {
                    $(this).removeClass("input-error");
                }
            }
        );

        // Saat tombol diklik
        $("#btn-lanjut-seksi").on("click", function () {
            let isValid = true;

            // Cek semua input required
            $("input[required], textarea[required], select[required]").each(
                function () {
                    if (!$(this).val()) {
                        $(this).addClass("input-error");
                        isValid = false;
                    } else {
                        $(this).removeClass("input-error");
                    }
                }
            );

            if (isValid) {
                // Tidak ada error → lanjut ke tab berikutnya
                goToNextTab("seksi");
            } else {
                // Opsional: scroll ke atas ke input error pertama
                $("html, body").animate(
                    {
                        scrollTop: $(".input-error").first().offset().top - 100,
                    },
                    500
                );
            }
        });
    });

    // ...existing code...
})(window.jQuery);
