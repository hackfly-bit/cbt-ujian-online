import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import Swal from 'sweetalert2';

window.$ = $;
window.jQuery = $;

// Global variables
let currentSoalId = null;
let jawabanCounter = 0;

// Inisialisasi DataTable untuk halaman Bank Soal
document.addEventListener("DOMContentLoaded", function () {
    console.log("Bank Soal JS loaded - DOM ready");

    // Initialize DataTables
    initDataTables();

    // Initialize Form Events
    initFormEvents();

    // Load dropdown data
    loadDropdownData();

    console.log("Bank Soal initialization completed");
});

function initDataTables() {
    function initDatatable({
        selector,
        filterWrapperSelector,
        tableId,
        kategoriParam,
        difficultyFilterId = null,
        categoryFilterId = null,
    }) {
        const table = new DataTable(selector, {
            processing: true,
            serverSide: true,
            ajax: {
                url: "/bank-soal",
                type: "GET",
                data: function (d) {
                    d.kategori = kategoriParam;

                    // Tambahkan filter tingkat kesulitan jika tersedia
                    if (difficultyFilterId) {
                        d.tingkat_kesulitan = $(`#${difficultyFilterId}`).val();
                    }

                    // Tambahkan filter kategori jika tersedia
                    if (categoryFilterId) {
                        d.filter_kategori = $(`#${categoryFilterId}`).val();
                    }
                },
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
                { data: "pertanyaan", name: "pertanyaan" },
                {
                    data: "kategori",
                    name: "kategori",
                    className: "text-center",
                },
                {
                    data: "tingkat_kesulitan",
                    name: "tingkat_kesulitan",
                    className: "text-center",
                },
                {
                    data: "jenis_soal",
                    name: "jenis_soal",
                    className: "text-center",
                },
                {
                    data: "media",
                    name: "media",
                    className: "text-center",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
            ],
            responsive: true,
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

        // Custom filter: pindahkan filter ke bagian datatable
        if (filterWrapperSelector && tableId) {
            const $filterWrapper = $(`${selector}_filter`);
            $filterWrapper.addClass(
                "d-flex align-items-center gap-2 justify-content-end"
            );

            const $customFilters = $(filterWrapperSelector).children().detach();
            $filterWrapper.append($customFilters);

            // Event trigger saat filter berubah
            [difficultyFilterId, categoryFilterId].forEach((filterId) => {
                if (filterId) {
                    $(`#${filterId}`).on("change", () => {
                        table.draw();
                    });
                }
            });
        }

        return table;
    }

    // Semua tab
    window.tableSemua = initDatatable({
        selector: "#selection-datatable-semua",
        filterWrapperSelector: "#custom-filters-semua",
        tableId: "selection-datatable-semua",
        kategoriParam: "all",
        difficultyFilterId: "filter-difficulty-semua",
        categoryFilterId: "filter-category-semua",
    });

    // Tab Reading
    window.tableReading = initDatatable({
        selector: "#selection-datatable-reading",
        filterWrapperSelector: "#custom-filters-reading",
        tableId: "selection-datatable-reading",
        kategoriParam: "1",
        difficultyFilterId: "filter-difficulty-reading",
    });

    // Tab Listening
    window.tableListening = initDatatable({
        selector: "#selection-datatable-listening",
        filterWrapperSelector: "#custom-filters-listening",
        tableId: "selection-datatable-listening",
        kategoriParam: "2",
        difficultyFilterId: "filter-difficulty-listening",
    });

    // Tab Grammar
    window.tableGrammar = initDatatable({
        selector: "#selection-datatable-grammar",
        filterWrapperSelector: "#custom-filters-grammar",
        tableId: "selection-datatable-grammar",
        kategoriParam: "3",
        difficultyFilterId: "filter-difficulty-grammar",
    });
}

// Fungsi untuk inisialisasi form events
function initFormEvents() {
    console.log("Initializing form events...");

    // Event untuk checkbox audio
    $("#is_audio").on("change", function () {
        console.log("Audio checkbox changed:", this.checked);
        if (this.checked) {
            $("#audio-file-container").show();
        } else {
            $("#audio-file-container").hide();
            $("#audio_file").val("");
        }
    });

    // Event untuk perubahan jenis soal
    $("#jenis_soal").on("change", function () {
        console.log("Jenis soal changed:", this.value);
        generateJawabanForm(this.value);
    });

    // Event untuk perubahan kategori
    $("#kategori").on("change", function () {
        console.log("Kategori changed:", this.value);
        loadSubKategori(this.value);
    });

    // Event untuk perubahan jenis font - Arabic RTL Support
    $("#jenis_font").on("change", function () {
        console.log("Font type changed:", this.value);
        handleFontChange(this.value);
    });

    // Event submit form
    $("#form-bank-soal").on("submit", function (e) {
        e.preventDefault();
        console.log("Form submitted via form event");
        submitForm();
    });

    // Event untuk tombol submit (karena tombol berada di luar form)
    $(document).on("click", "#btn-submit", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("Submit button clicked (delegated event)");

        const form = $("#form-bank-soal")[0];
        if (!form) {
            console.error("Form not found!");
            return;
        }

        console.log("Form found, checking validity...");

        // Cek apakah form valid menggunakan HTML5 validation
        if (form.checkValidity()) {
            console.log("Form is valid, submitting...");
            submitForm();
        } else {
            console.log("Form validation failed, showing validation messages");
            // Trigger validasi HTML5 untuk menampilkan pesan error
            form.reportValidity();
        }
    });

    // Backup event handler langsung ke button
    $("#btn-submit").off("click.backup").on("click.backup", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("Submit button clicked (backup event)");

        const form = $("#form-bank-soal")[0];
        if (form && form.checkValidity()) {
            submitForm();
        } else if (form) {
            form.reportValidity();
        }
    });

    // Event untuk reset modal saat ditutup
    $("#tambah-bank-soal").on("hidden.bs.modal", function () {
        console.log("Modal closed, resetting form");
        resetForm();
    });

    // Event konfirmasi hapus
    $("#btn-hapus-confirm").on("click", function () {
        console.log("Delete confirmation clicked, soal ID:", currentSoalId);
        if (currentSoalId) {
            deleteSoal(currentSoalId);
        }
    });

    console.log("Form events initialized successfully");
}

function generateJawabanForm(jenisSoal) {
    console.log("Generating jawaban form for:", jenisSoal);

    const container = $("#jawaban-container");
    const wrapper = $("#jawaban-wrapper");

    // Clear container terlebih dahulu
    container.empty();
    jawabanCounter = 0;

    // Sembunyikan dulu wrapper-nya
    wrapper.addClass("d-none");

    if (!jenisSoal) {
        console.log("No jenis soal selected, hiding wrapper");
        return;
    }

    // Tampilkan wrapper saat jenis soal valid
    wrapper.removeClass("d-none");
    console.log("Wrapper shown for jenis soal:", jenisSoal);

    if (jenisSoal === "pilihan_ganda") {
        generatePilihanGandaForm(container);
    } else if (jenisSoal === "benar_salah") {
        generateBenarSalahForm(container);
    } else if (jenisSoal === "isian") {
        generateIsianForm(container);
    }

    console.log("Jawaban form generated successfully");
}

// Generate form pilihan ganda
function generatePilihanGandaForm(container) {
    const pilihanLabels = ["A", "B", "C", "D"];

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
    $("#add-pilihan").on("click", function () {
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
                <div class="form-check d-flex align-items-center gap-1">
                    <input
                        class="form-check-input jawaban-radio"
                        type="radio"
                        name="jawaban_benar"
                        value="${jawabanCounter}"
                        id="jawaban_${jawabanCounter}"
                        ${isFirst ? "checked" : ""}
                        required
                    >
                    <label
                        class="form-check-label label-benar"
                        for="jawaban_${jawabanCounter}"
                        style="display: ${isFirst ? "inline" : "none"}"
                    >Benar</label>
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
                <input type="hidden" name="jawaban_soal[${jawabanCounter}][jawaban_benar]" value="${isFirst ? 1 : 0}">
            </div>
            <div class="col-1">
                ${
                    jawabanCounter > 3
                        ? `
                    <button type="button" class="btn btn-sm btn-outline-danger remove-pilihan">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                `
                        : ""
                }
            </div>
        </div>
    `;

    $("#pilihan-container").append(pilihanHtml);
    jawabanCounter++;

    // Event untuk hapus pilihan (hanya jika lebih dari 4)
    $(".remove-pilihan")
        .off("click")
        .on("click", function () {
            $(this).closest(".pilihan-item").remove();
            updatePilihanIndexes();
            updateLabelBenar(); // Pastikan label di-refresh saat ada item yang dihapus
        });

    // Re-bind event radio untuk menampilkan label "Benar"
    $("input[name='jawaban_benar']")
        .off("change")
        .on("change", function () {
            updateLabelBenar();
            updateJawabanBenarValues();
        });
}

// Fungsi untuk update label "Benar" hanya pada radio yang dipilih
function updateLabelBenar() {
    $(".label-benar").hide(); // Sembunyikan semua label
    $("input[name='jawaban_benar']:checked")
        .closest(".form-check")
        .find(".label-benar")
        .show(); // Tampilkan hanya label pada radio yang dipilih
}

// Fungsi untuk update nilai jawaban_benar hidden inputs
function updateJawabanBenarValues() {
    const selectedValue = $("input[name='jawaban_benar']:checked").val();

    $("#pilihan-container .pilihan-item").each(function(index) {
        const isCorrect = index == selectedValue;
        $(this).find("input[name*='[jawaban_benar]']").val(isCorrect ? 1 : 0);
    });
}

// Update indexes setelah hapus pilihan
function updatePilihanIndexes() {
    $("#pilihan-container .pilihan-item").each(function (index) {
        const $item = $(this);
        $item.attr("data-index", index);
        $item.find('input[name^="jawaban_soal"]').each(function () {
            const name = $(this).attr("name");
            const newName = name.replace(/\[\d+\]/, `[${index}]`);
            $(this).attr("name", newName);
        });
        $item.find('input[name="jawaban_benar"]').val(index);
    });
    jawabanCounter = $("#pilihan-container .pilihan-item").length;
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
    $.get("/filter/tingkat-kesulitan", function (data) {
        const select = $("#tingkat_kesulitan");
        select
            .empty()
            .append('<option value="">Pilih Tingkat Kesulitan</option>');
        data.forEach((item) => {
            select.append(`<option value="${item.id}">${item.nama}</option>`);
        });
    }).fail(function () {
        console.error("Failed to load tingkat kesulitan");
    });

    // Load kategori
    $.get("/filter/kategori", function (data) {
        const select = $("#kategori");
        select.empty().append('<option value="">Pilih Kategori</option>');
        data.forEach((item) => {
            select.append(`<option value="${item.id}">${item.nama}</option>`);
        });
    }).fail(function () {
        console.error("Failed to load kategori");
    });
}

// Load sub kategori berdasarkan kategori
function loadSubKategori(kategoriId) {
    const select = $("#sub_kategori");
    select.empty().append('<option value="">Pilih Sub Kategori</option>');

    if (!kategoriId) return;

    $.get(`/filter/sub-kategori/${kategoriId}`, function (data) {
        data.forEach((item) => {
            select.append(`<option value="${item.id}">${item.nama}</option>`);
        });
    }).fail(function () {
        console.error("Failed to load sub kategori");
    });
}

// Handle font change - Arabic RTL Support
function handleFontChange(fontType) {
    const questionTextarea = $("#pertanyaan");
    const fontLabel = $("label[for='pertanyaan']");

    if (fontType === "Arab (RTL)") {
        // Apply Arabic RTL styling
        questionTextarea.css({
            'direction': 'rtl',
            'text-align': 'right',
            'font-family': 'Arial, "Times New Roman", "Amiri", "Scheherazade New", sans-serif',
            'font-size': '16px',
            'line-height': '1.6',
            'unicode-bidi': 'plaintext'
        });

        // Add Arabic language attribute for better rendering
        questionTextarea.attr('lang', 'ar');

        // Update placeholder text
        questionTextarea.attr('placeholder', 'اكتب السؤال هنا... (Arabic RTL mode)');

        // Add visual indicator to the label
        if (!fontLabel.find('.arabic-indicator').length) {
            fontLabel.append(' <span class="arabic-indicator badge bg-info ms-2">العربية RTL</span>');
        }

        console.log('Arabic RTL mode activated');
    } else {
        // Reset to default Latin styling
        questionTextarea.css({
            'direction': 'ltr',
            'text-align': 'left',
            'font-family': '',
            'font-size': '',
            'line-height': '',
            'unicode-bidi': ''
        });

        // Remove Arabic language attribute
        questionTextarea.removeAttr('lang');

        // Reset placeholder text
        questionTextarea.attr('placeholder', 'Masukkan pertanyaan soal...');

        // Remove visual indicator from the label
        fontLabel.find('.arabic-indicator').remove();

        console.log('Latin LTR mode activated');
    }

    // Add a subtle animation effect
    questionTextarea.addClass('font-change-animation');
    setTimeout(() => {
        questionTextarea.removeClass('font-change-animation');
    }, 300);
}

// Submit form
function submitForm() {
    console.log("Submitting form...");

    // Validasi form terlebih dahulu
    const form = document.getElementById("form-bank-soal");
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Validasi khusus untuk jawaban
    const jenisSoal = $("#jenis_soal").val();
    if (!jenisSoal) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Silakan pilih jenis soal terlebih dahulu.',
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Validasi jawaban berdasarkan jenis soal
    if (jenisSoal === "pilihan_ganda") {
        const jawabanInputs = $("#pilihan-container input[name*='[jawaban]']");
        let hasEmptyAnswer = false;
        jawabanInputs.each(function() {
            if (!$(this).val().trim()) {
                hasEmptyAnswer = true;
                return false;
            }
        });

        if (hasEmptyAnswer) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua pilihan jawaban harus diisi.',
                confirmButtonColor: '#d33'
            });
            return;
        }

        if (!$('input[name="jawaban_benar"]:checked').length) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Silakan pilih jawaban yang benar.',
                confirmButtonColor: '#d33'
            });
            return;
        }
    }

    const formData = new FormData(form);
    const method = $("#form-method").val();
    const isEdit = method === "PUT";

    // Set jawaban_benar untuk setiap jawaban
    if (jenisSoal === "pilihan_ganda") {
        const selectedIndex = $('input[name="jawaban_benar"]:checked').val();
        $("#pilihan-container .pilihan-item").each(function (index) {
            const isCorrect = index == selectedIndex;
            $(this).append(
                `<input type="hidden" name="jawaban_soal[${index}][jawaban_benar]" value="${
                    isCorrect ? 1 : 0
                }">`
            );
        });
    } else if (jenisSoal === "benar_salah") {
        const selectedValue = $('input[name="jawaban_benar"]:checked').val();
        formData.append(
            "jawaban_soal[0][jawaban_benar]",
            selectedValue == 0 ? 1 : 0
        );
        formData.append(
            "jawaban_soal[1][jawaban_benar]",
            selectedValue == 1 ? 1 : 0
        );
    } else if (jenisSoal === "isian") {
        formData.append("jawaban_soal[0][jawaban_benar]", 1);
    }

    // Add jenis_soal to formData
    formData.append("jenis_soal", jenisSoal);

    const btn = $("#btn-submit");
    const spinner = btn.find(".spinner-border");

    btn.prop("disabled", true);
    spinner.removeClass("d-none");

    const url = isEdit ? `/bank-soal/${currentSoalId}` : "/bank-soal";

    if (isEdit) {
        formData.append("_method", "PUT");
    }

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#tambah-bank-soal").modal("hide");

                // Refresh all tables
                if (window.tableSemua) window.tableSemua.ajax.reload();
                if (window.tableReading) window.tableReading.ajax.reload();
                if (window.tableGrammar) window.tableGrammar.ajax.reload();
                if (window.tableListening) window.tableListening.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function (xhr) {
            console.error("AJAX Error:", xhr);
            let message = "Terjadi kesalahan saat menyimpan data.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                message = errors.join("<br>");
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: message,
                confirmButtonColor: '#d33'
            });
        },
        complete: function () {
            btn.prop("disabled", false);
            spinner.addClass("d-none");
        },
    });
}

// Edit soal
function editSoal(id) {
    currentSoalId = id;

    $.get(`/bank-soal/${id}`, function (response) {
        console.log("Response data:", response);
        if (response.success) {
            const data = response.data;

            // Set modal title
            $("#modal-title").text("Edit Soal");
            $("#form-method").val("PUT");

            // Fill form fields
            $("#pertanyaan").val(data.pertanyaan);
            $("#jenis_font").val(data.jenis_font);
            $("#is_audio").prop("checked", data.is_audio == 1);
            $("#tingkat_kesulitan").val(data.tingkat_kesulitan_id);
            $("#kategori").val(data.kategori_id);
            $("#penjelasan_jawaban").val(data.penjelasan_jawaban);
            $("#tag").val(data.tag);

            // Apply font styling based on selected font type
            handleFontChange(data.jenis_font);

            // Show/hide audio container
            if (data.is_audio) {
                $("#audio-file-container").show();
            }

            // Load sub kategori and set value
            if (data.kategori_id) {
                loadSubKategori(data.kategori_id);
                setTimeout(() => {
                    $("#sub_kategori").val(data.sub_kategori_id);
                }, 500);
            }

            // Detect jenis soal from jawaban
            let jenisSoal = "isian";
            if (data.jawaban_soals && data.jawaban_soals.length > 0) {
                if (
                    data.jawaban_soals.length === 2 &&
                    data.jawaban_soals.some((j) => j.jawaban === "Benar") &&
                    data.jawaban_soals.some((j) => j.jawaban === "Salah")
                ) {
                    jenisSoal = "benar_salah";
                } else if (data.jawaban_soals.length > 1) {
                    jenisSoal = "pilihan_ganda";
                }
            }

            $("#jenis_soal").val(jenisSoal);
            generateJawabanForm(jenisSoal);

            // Fill jawaban data
            setTimeout(() => {
                fillJawabanData(data.jawaban_soals, jenisSoal);
            }, 100);

            // Show modal
            $("#tambah-bank-soal").modal("show");
        }
    }).fail(function () {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal memuat data soal.',
            confirmButtonColor: '#d33'
        });
    });
}

// Fill jawaban data for edit
function fillJawabanData(jawabanData, jenisSoal) {
    if (!jawabanData || jawabanData.length === 0) return;

    if (jenisSoal === "pilihan_ganda") {
        jawabanData.forEach((jawaban, index) => {
            const input = $(`input[name="jawaban_soal[${index}][jawaban]"]`);
            if (input.length) {
                input.val(jawaban.jawaban);
            } else {
                // Add more options if needed
                const label = String.fromCharCode(65 + index);
                addPilihanGanda(label);
                $(`input[name="jawaban_soal[${index}][jawaban]"]`).val(
                    jawaban.jawaban
                );
            }

            if (jawaban.jawaban_benar) {
                $(`input[name="jawaban_benar"][value="${index}"]`).prop(
                    "checked",
                    true
                );
            }
        });
    } else if (jenisSoal === "benar_salah") {
        const benarJawaban = jawabanData.find((j) => j.jawaban === "Benar");
        if (benarJawaban && benarJawaban.jawaban_benar) {
            $('input[name="jawaban_benar"][value="0"]').prop("checked", true);
        } else {
            $('input[name="jawaban_benar"][value="1"]').prop("checked", true);
        }
    } else if (jenisSoal === "isian") {
        if (jawabanData[0]) {
            $('input[name="jawaban_soal[0][jawaban]"]').val(
                jawabanData[0].jawaban
            );
        }
    }
}

// Delete soal
function deleteSoal(id) {
    const btn = $("#btn-hapus-confirm");
    const spinner = btn.find(".spinner-border");

    btn.prop("disabled", true);
    spinner.removeClass("d-none");

    $.ajax({
        url: `/bank-soal/${id}`,
        type: "DELETE",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#modal-hapus").modal("hide");

                // Refresh all tables
                if (window.tableSemua) window.tableSemua.ajax.reload();
                if (window.tableReading) window.tableReading.ajax.reload();
                if (window.tableGrammar) window.tableGrammar.ajax.reload();
                if (window.tableListening) window.tableListening.ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal menghapus soal.',
                confirmButtonColor: '#d33'
            });
        },
        complete: function () {
            btn.prop("disabled", false);
            spinner.addClass("d-none");
            currentSoalId = null;
        },
    });
}

// Show delete confirmation
function showDeleteConfirmation(id) {
    currentSoalId = id;

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteSoal(currentSoalId);
        } else {
            currentSoalId = null;
        }
    });
}

// Reset form
function resetForm() {
    console.log("Resetting form...");

    // Reset form HTML
    const form = document.getElementById("form-bank-soal");
    if (form) {
        form.reset();
    }

    // Reset modal title dan method
    $("#modal-title").text("Tambah Soal Baru");
    $("#form-method").val("POST");

    // Hide audio container
    $("#audio-file-container").hide();

    // Clear jawaban container
    $("#jawaban-container").empty();
    $("#jawaban-wrapper").addClass("d-none");

    // Reset sub kategori dropdown
    $("#sub_kategori")
        .empty()
        .append('<option value="">Pilih Sub Kategori</option>');

    // Reset font styling to default (Latin)
    handleFontChange("Latin");

    // Reset jenis font dropdown
    $("#jenis_font").val("").trigger('change');

    // Reset all form validation states
    form.classList.remove('was-validated');
    $(form).find('.is-invalid').removeClass('is-invalid');
    $(form).find('.invalid-feedback').remove();

    // Reset global variables
    currentSoalId = null;
    jawabanCounter = 0;

    console.log("Form reset completed");
}

// Test function untuk debugging - hapus di production
function testBankSoal() {
    console.log("=== TESTING BANK SOAL FUNCTIONALITY ===");

    // Test button exists
    const submitBtn = $("#btn-submit");
    console.log("Submit button found:", submitBtn.length > 0);

    // Test form exists
    const form = $("#form-bank-soal");
    console.log("Form found:", form.length > 0);

    // Test modal exists
    const modal = $("#tambah-bank-soal");
    console.log("Modal found:", modal.length > 0);

    // Test dropdowns
    console.log("Jenis font dropdown:", $("#jenis_font").length > 0);
    console.log("Jenis soal dropdown:", $("#jenis_soal").length > 0);
    console.log("Kategori dropdown:", $("#kategori").length > 0);
    console.log("Tingkat kesulitan dropdown:", $("#tingkat_kesulitan").length > 0);

    // Test CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log("CSRF token found:", csrfToken !== undefined);

    console.log("=== END TEST ===");
}

// Make functions globally available
window.editSoal = editSoal;
window.showDeleteConfirmation = showDeleteConfirmation;
window.testBankSoal = testBankSoal;
