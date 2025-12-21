import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import Swal from "sweetalert2";
import Quill from "quill/dist/quill.js";
import "quill/dist/quill.snow.css";
import select2 from "select2";
import "select2/dist/css/select2.min.css";
import "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css";

// Initialize Select2 with jQuery
select2($);

window.$ = $;
window.jQuery = $;

// Global variables
let currentSoalId = null;
let jawabanCounter = 0;

// Global variable
let quill = null;
let quillReady = false;

// Inisialisasi Quill editor
document.addEventListener("DOMContentLoaded", function () {
    try {
        const editorElement = document.querySelector("#snow-editor");
        if (!editorElement) {
            console.error("Quill editor element not found");
            return;
        }

        quill = new Quill("#snow-editor", {
            theme: "snow",
            modules: {
                toolbar: [
                    [{ font: [] }],
                    ["bold", "italic", "underline"],
                    [{ list: "ordered" }, { list: "bullet" }],
                    // Hapus icon direction agar tidak membingungkan
                    // [{ align: [] }],
                    ["clean"],
                ],
            },
            placeholder: "Tulis pertanyaan di sini...", // Default
        });

        quillReady = true;

        // Update input tersembunyi saat teks berubah
        quill.on("text-change", function () {
            document.getElementById("pertanyaan").value = quill.root.innerHTML;
        });

        // Default: set ke LTR saat load pertama
        setEditorDirection("ltr");
    } catch (error) {
        console.error("Error initializing Quill:", error);
    }
});

function setEditorDirection(direction) {
    const pertanyaanInput = document.getElementById("pertanyaan");

    // Simpan isi sebagai Delta
    const currentDelta = quill.getContents();

    // Ganti placeholder
    quill.root.dataset.placeholder =
        direction === "rtl"
            ? "اكتب السؤال هنا..." // Arab
            : "Tulis pertanyaan di sini..."; // Latin

    // Set atribut HTML dasar
    quill.root.setAttribute("dir", direction);
    quill.root.style.textAlign = direction === "rtl" ? "right" : "left";

    // Format semua baris
    quill.formatLine(0, quill.getLength(), {
        direction: direction,
        align: direction === "rtl" ? "right" : "left",
    });

    // Bersihkan class RTL jika ganti ke LTR
    if (direction === "ltr") {
        const paragraphs = quill.root.querySelectorAll("p");
        paragraphs.forEach((p) => {
            p.classList.remove("ql-direction-rtl", "ql-align-right");
        });
    }

    // Muat ulang isi editor (optional, untuk pastikan konsistensi)
    quill.setContents(currentDelta);

    // Perbarui input hidden
    pertanyaanInput.value = quill.root.innerHTML;
}

// Event listener dropdown
document.getElementById("jenis_font").addEventListener("change", function () {
    const selectedValue = this.value;
    if (selectedValue === "Arab (RTL)") {
        setEditorDirection("rtl");
    } else {
        setEditorDirection("ltr");
    }

    // Fokus ke editor setelah ganti arah
    if (quill) {
        quill.focus();
    }
});

// Initialize Select2 for all select elements
function initSelect2() {
    console.log("Initializing Select2...");

    // Select2 options
    const select2Options = {
        theme: "bootstrap-5",
        width: "100%",
        placeholder: function () {
            return $(this).data("placeholder") || "Pilih...";
        },
        allowClear: false,
        language: {
            noResults: function () {
                return "Tidak ada hasil yang ditemukan";
            },
            searching: function () {
                return "Mencari...";
            },
        },
        minimumResultsForSearch: Infinity,
    };

    // Initialize Select2 on all select elements
    $(
        "#jenis_font, #jenis_soal, #tingkat_kesulitan, #kategori, #sub_kategori"
    ).each(function () {
        if (!$(this).hasClass("select2-hidden-accessible")) {
            $(this).select2(select2Options);
        }
    });

    // Filter selects
    $(
        "#filter-difficulty-semua, #filter-category-semua, #filter-difficulty-reading, #filter-difficulty-listening, #filter-difficulty-grammar"
    ).each(function () {
        if (!$(this).hasClass("select2-hidden-accessible")) {
            $(this).select2(select2Options);
        }
    });

    console.log("Select2 initialized successfully");
}

// Initialize Select2 specific event handlers
function initSelect2Events() {
    console.log("Initializing Select2 events...");

    // Font change event - Use off() to prevent duplicate bindings
    $("#jenis_font").off("change select2:select").on("change", function () {
        const fontType = $(this).val();
        console.log("Font changed:", fontType);
        handleFontChange(fontType);
    });

    // Question type change event - Use off() to prevent duplicate bindings
    $("#jenis_soal").off("change select2:select").on("change", function () {
        const jenisSoal = $(this).val();
        console.log("Jenis soal changed:", jenisSoal);
        generateJawabanForm(jenisSoal);
    });

    // Category change event - Use off() to prevent duplicate bindings
    $("#kategori").off("change select2:select").on("change", function () {
        const kategoriId = $(this).val();
        console.log("Kategori changed:", kategoriId);
        loadSubKategori(kategoriId);
    });

    console.log("Select2 events initialized");
}

// Reinitialize Select2 in modal
function reinitializeSelect2InModal() {
    console.log("Reinitializing Select2 in modal...");

    // Destroy existing Select2 instances in modal
    $("#tambah-bank-soal select").each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) {
            $(this).select2("destroy");
        }
    });

    // Reinitialize Select2 for modal elements
    setTimeout(() => {
        initSelect2();
        initSelect2Events();
        console.log("Select2 reinitialized in modal");
    }, 100);
}

// Inisialisasi DataTable untuk halaman Bank Soal
document.addEventListener("DOMContentLoaded", function () {
    console.log("Bank Soal JS loaded - DOM ready");

    // Initialize Select2 for all select elements
    initSelect2();

    // Initialize DataTables
    initDataTables();

    // Initialize Form Events
    initFormEvents();

    // Load dropdown data
    loadDropdownData();

    // Make functions globally available for inline event handlers
    window.editSoal = editSoal;
    window.populateFormWithData = populateFormWithData;
    window.loadDropdownData = loadDropdownData;
    window.loadSubKategori = loadSubKategori;
    window.showDeleteConfirmation = showDeleteConfirmation;
    window.testBankSoal = testBankSoal;
    window.populateJawabanSoal = populateJawabanSoal;
    window.populatePilihanGanda = populatePilihanGanda;
    window.populateBenarSalah = populateBenarSalah;
    window.populateIsian = populateIsian;
    window.bindPilihanGandaEvents = bindPilihanGandaEvents;
    window.ensureDropdownDataLoaded = ensureDropdownDataLoaded;
    window.initSelect2 = initSelect2;
    window.reinitializeSelect2InModal = reinitializeSelect2InModal;

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
                {
                    data: "pertanyaan",
                    name: "pertanyaan",
                    render: function (data, type, row) {
                        if (type === "display" || type === "type") {
                            // Strip HTML tags and trim to 50 characters minimum
                            const textContent = data
                                ? data.replace(/<[^>]+>/g, "")
                                : "";
                            return textContent.length > 50
                                ? textContent.substring(0, 50) + "..."
                                : textContent;
                        }
                        return data;
                    },
                },
                {
                    data: "kategori",
                    name: "kategori",
                    className: "text-center",
                },
                {
                    data: "tingkat_kesulitan",
                    name: "tingkat_kesulitan",
                    className: "text-center",
                    orderable: false,
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
            responsive: {
                details: {
                    type: "column",
                    target: "tr"
                }
            },
            scrollX: true,
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
                    .forEach((pagination) => {
                        pagination.classList.remove("pagination-rounded");
                        // Tambahkan margin top pada pagination
                        pagination.style.marginTop = "1rem";
                        pagination.style.marginBottom = "1rem";

                    });
            },
        });

        // Custom filter: pindahkan filter ke bagian datatable
        if (filterWrapperSelector && tableId) {
            const $filterWrapper = $(`${selector}_filter`);
            $filterWrapper.addClass(
                "d-flex align-items-center gap-2 justify-content-end flex-wrap"
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

        // Responsive: adjust columns on window resize
        $(window).on("resize", function () {
            table.columns.adjust().responsive.recalc();
        });

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

    // // Tab Reading
    // window.tableReading = initDatatable({
    //     selector: "#selection-datatable-reading",
    //     filterWrapperSelector: "#custom-filters-reading",
    //     tableId: "selection-datatable-reading",
    //     kategoriParam: "1",
    //     difficultyFilterId: "filter-difficulty-reading",
    // });

    // // Tab Listening
    // window.tableListening = initDatatable({
    //     selector: "#selection-datatable-listening",
    //     filterWrapperSelector: "#custom-filters-listening",
    //     tableId: "selection-datatable-listening",
    //     kategoriParam: "2",
    //     difficultyFilterId: "filter-difficulty-listening",
    // });

    // Tab Grammar
    // window.tableGrammar = initDatatable({
    //     selector: "#selection-datatable-grammar",
    //     filterWrapperSelector: "#custom-filters-grammar",
    //     tableId: "selection-datatable-grammar",
    //     kategoriParam: "3",
    //     difficultyFilterId: "filter-difficulty-grammar",
    // });
}

// Fungsi untuk inisialisasi form events
function initFormEvents() {
    console.log("Initializing form events...");

    // Event untuk checkbox audio
    $("#is_audio").off("change").on("change", function () {
        console.log("Audio checkbox changed:", this.checked);
        if (this.checked) {
            $("#audio-file-container").show();
        } else {
            $("#audio-file-container").hide();
            $("#audio_file").val("");
        }
    });

    // Select2 specific event handlers
    initSelect2Events();

    // Event submit form
    $("#form-bank-soal").on("submit", function (e) {
        e.preventDefault();
        console.log("Form submitted via form event");

        // Update hidden input with Quill content before submit
        const pertanyaanInput = document.getElementById("pertanyaan");
        if (pertanyaanInput) {
            pertanyaanInput.value = quill.root.innerHTML;
        }

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
    $("#btn-submit")
        .off("click.backup")
        .on("click.backup", function (e) {
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

    // Event untuk inisialisasi modal saat dibuka untuk tambah data baru
    $("#tambah-bank-soal").on("show.bs.modal", function (e) {
        // Check if this is for adding new data (not editing)
        const button = $(e.relatedTarget);
        if (!button.hasClass("edit-btn")) {
            console.log("Modal opened for new data, resetting form");
            setTimeout(() => {
                resetForm();
                // Reinitialize Select2 for the modal
                reinitializeSelect2InModal();
            }, 100);
        }
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
                <input type="hidden" name="jawaban_soal[${jawabanCounter}][jawaban_benar]" value="${
        isFirst ? 1 : 0
    }">
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

    $("#pilihan-container .pilihan-item").each(function (index) {
        const isCorrect = index == selectedValue;
        $(this)
            .find("input[name*='[jawaban_benar]']")
            .val(isCorrect ? 1 : 0);
    });
}

// Fungsi untuk update nilai jawaban_benar pada benar/salah
function updateBenarSalahValues() {
    const selectedValue = $("input[name='jawaban_benar']:checked").val();

    // Update hidden inputs berdasarkan pilihan radio button
    $("input[name='jawaban_soal[0][jawaban_benar]']").val(selectedValue == "0" ? "1" : "0");
    $("input[name='jawaban_soal[1][jawaban_benar]']").val(selectedValue == "1" ? "1" : "0");
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
                    <input type="hidden" name="jawaban_soal[0][jawaban_benar]" value="1" class="jawaban-benar-hidden">
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jawaban_benar" value="1" id="salah" required>
                    <label class="form-check-label" for="salah">Salah</label>
                    <input type="hidden" name="jawaban_soal[1][label_jawaban]" value="Salah">
                    <input type="hidden" name="jawaban_soal[1][jawaban]" value="Salah">
                    <input type="hidden" name="jawaban_soal[1][jenis_isian]" value="benar_salah">
                    <input type="hidden" name="jawaban_soal[1][jawaban_benar]" value="0" class="jawaban-benar-hidden">
                </div>
            </div>
        </div>
    `);

    // Add event listener untuk update jawaban_benar values
    $(document).off('change', 'input[name="jawaban_benar"]').on('change', 'input[name="jawaban_benar"]', function() {
        updateBenarSalahValues();
    });
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
    console.log("Loading dropdown data...");

    // Load tingkat kesulitan
    $.ajax({
        url: "/filter/tingkat-kesulitan",
        type: "GET",
        success: function (response) {
            console.log("Tingkat kesulitan loaded:", response);

            const select = $("#tingkat_kesulitan");
            select
                .empty()
                .append('<option value="">Pilih Tingkat Kesulitan</option>');

            if (response && Array.isArray(response)) {
                response.forEach(function (item) {
                    select.append(
                        `<option value="${item.id}">${item.nama}</option>`
                    );
                });
            } else if (response.data && Array.isArray(response.data)) {
                response.data.forEach(function (item) {
                    select.append(
                        `<option value="${item.id}">${item.nama}</option>`
                    );
                });
            }

            // Trigger Select2 update
            select.trigger("change");
        },
        error: function (xhr) {
            console.error("Error loading tingkat kesulitan:", xhr.responseText);
        },
    });

    // Load kategori
    $.ajax({
        url: "/filter/kategori",
        type: "GET",
        success: function (response) {
            console.log("Kategori loaded:", response);

            const select = $("#kategori");
            select.empty().append('<option value="">Pilih Kategori</option>');

            if (response && Array.isArray(response)) {
                response.forEach(function (item) {
                    select.append(
                        `<option value="${item.id}">${item.nama}</option>`
                    );
                });
            } else if (response.data && Array.isArray(response.data)) {
                response.data.forEach(function (item) {
                    select.append(
                        `<option value="${item.id}">${item.nama}</option>`
                    );
                });
            }

            // Trigger Select2 update
            select.trigger("change");
        },
        error: function (xhr) {
            console.error("Error loading kategori:", xhr.responseText);
        },
    });
}

// Load sub kategori berdasarkan kategori
function loadSubKategori(kategoriId) {
    console.log("Loading sub kategori for kategori ID:", kategoriId);

    const select = $("#sub_kategori");
    select.empty().append('<option value="">Pilih Sub Kategori</option>');

    // Trigger Select2 update after clearing
    select.trigger("change");

    if (!kategoriId) {
        return;
    }

    $.ajax({
        url: `/filter/sub-kategori/${kategoriId}`,
        type: "GET",
        success: function (response) {
            console.log("Sub kategori loaded:", response);

            if (response && Array.isArray(response)) {
                response.forEach(function (item) {
                    select.append(
                        `<option value="${item.id}">${item.nama}</option>`
                    );
                });
            } else if (response.data && Array.isArray(response.data)) {
                response.data.forEach(function (item) {
                    select.append(
                        `<option value="${item.id}">${item.nama}</option>`
                    );
                });
            }

            // Trigger Select2 update after loading data
            select.trigger("change");
        },
        error: function (xhr) {
            console.error("Error loading sub kategori:", xhr.responseText);
        },
    });
}

// Robust function to load content into Quill editor
function loadQuillContent(htmlContent, fontType = "Latin") {
    // Wait for Quill to be ready
    const doLoad = () => {
        try {
            if (!htmlContent || htmlContent.trim() === "") {
                console.log("No content to load, clearing editor");
                quill.setText("");
                return;
            }

            console.log("Loading content into Quill:", htmlContent);

            // Clear existing content first
            quill.setText("");

            // Method 1: Using clipboard API (recommended for HTML)
            quill.clipboard.dangerouslyPasteHTML(0, htmlContent);

            // Verify content was set and fallback if needed
            setTimeout(() => {
                if (
                    quill.root.innerHTML.trim() === "" ||
                    quill.root.innerHTML === "<p><br></p>"
                ) {
                    console.warn(
                        "Content may not have loaded properly, trying direct innerHTML"
                    );
                    quill.root.innerHTML = htmlContent;
                }

                // Apply formatting after content is confirmed loaded
                setTimeout(() => {
                    const direction = fontType === "Arab (RTL)" ? "rtl" : "ltr";
                    applyTextDirectionFormatting(direction);

                    // Update hidden input
                    const pertanyaanInput =
                        document.getElementById("pertanyaan");
                    if (pertanyaanInput) {
                        pertanyaanInput.value = quill.root.innerHTML;
                    }

                    console.log("Content loaded and formatted successfully");
                }, 100);
            }, 50);
        } catch (error) {
            console.error("Error loading content into Quill:", error);
            // Fallback: just set text content
            const textContent = htmlContent.replace(/<[^>]*>/g, "");
            quill.setText(textContent);
        }
    };

    // Check if Quill is ready, if not wait a bit
    if (quillReady) {
        doLoad();
    } else {
        console.log("Waiting for Quill to be ready...");
        setTimeout(() => {
            doLoad();
        }, 200);
    }
}

// Helper function to apply text direction formatting to existing content
function applyTextDirectionFormatting(direction = "ltr") {
    const currentLength = quill.getLength();
    if (currentLength > 1) {
        // Quill always has at least 1 character (newline)
        try {
            if (direction === "rtl") {
                quill.formatText(0, currentLength, "direction", "rtl");
                quill.formatText(0, currentLength, "align", "right");
                console.log("Applied RTL formatting to existing content");
            } else {
                quill.formatText(0, currentLength, "direction", "ltr");
                quill.formatText(0, currentLength, "align", "left");
                console.log("Applied LTR formatting to existing content");
            }
        } catch (error) {
            console.warn("Could not apply text direction formatting:", error);
        }
    }
}

// Handle font change - Arabic RTL Support with Quill.js
function handleFontChange(fontType) {
    const quillContainer = document.querySelector("#snow-editor");
    const quillEditor = quillContainer.querySelector(".ql-editor");
    const toolbar = quillContainer.querySelector(".ql-toolbar");
    const fontLabel = $("label[for='pertanyaan']");

    if (fontType === "Arab (RTL)") {
        // Apply Arabic RTL styling to Quill editor
        $(quillEditor).css({
            direction: "rtl",
            "text-align": "right",
            "font-family":
                '"Amiri", "Scheherazade New", Arial, "Times New Roman", sans-serif',
            "font-size": "16px",
            "line-height": "1.6",
            "unicode-bidi": "plaintext",
        });

        // Add Arabic language attribute for better rendering
        $(quillEditor).attr("lang", "ar");
        $(quillContainer).attr("dir", "rtl");

        // Update Quill editor placeholder
        quill.root.dataset.placeholder = "اكتب السؤال هنا... (Arabic RTL mode)";

        // Apply RTL direction using Quill's format system only if there's content
        // Note: This will be called separately after content is loaded in edit mode
        const currentLength = quill.getLength();
        if (currentLength > 1) {
            // Quill always has at least 1 character (newline)
            applyTextDirectionFormatting("rtl");
        }

        // Update container and toolbar styling
        $(quillContainer).addClass("rtl-mode-active");
        $(toolbar).css("direction", "rtl");

        // Add visual indicator to the label
        fontLabel.find(".arabic-indicator").remove();
        fontLabel.append(
            ' <span class="arabic-indicator badge bg-info ms-2">العربية RTL</span>'
        );

        console.log("Arabic RTL mode activated for Quill editor");
    } else {
        // Reset to default Latin styling
        $(quillEditor).css({
            direction: "ltr",
            "text-align": "left",
            "font-family": "",
            "font-size": "",
            "line-height": "",
            "unicode-bidi": "",
        });

        // Remove Arabic language attribute
        $(quillEditor).removeAttr("lang");
        $(quillContainer).removeAttr("dir");

        // Reset Quill editor placeholder
        quill.root.dataset.placeholder = "Tulis pertanyaan di sini...";

        // Reset RTL direction using Quill's format system only if there's content
        // Note: This will be called separately after content is loaded in edit mode
        const currentLength = quill.getLength();
        if (currentLength > 1) {
            // Quill always has at least 1 character (newline)
            applyTextDirectionFormatting("ltr");
        }

        // Reset container and toolbar styling
        $(quillContainer).removeClass("rtl-mode-active");
        $(toolbar).css("direction", "ltr");

        // Remove visual indicator from the label
        fontLabel.find(".arabic-indicator").remove();

        console.log("Latin LTR mode activated for Quill editor");
    }

    // Add a subtle animation effect to the Quill container
    $(quillContainer).addClass("font-change-animation");
    setTimeout(() => {
        $(quillContainer).removeClass("font-change-animation");
    }, 300);

    // Update the hidden input with current content
    const pertanyaanInput = document.getElementById("pertanyaan");
    if (pertanyaanInput) {
        pertanyaanInput.value = quill.root.innerHTML;
    }

    // Trigger change event for form validation
    $(pertanyaanInput).trigger("change");
}

// Submit form
function submitForm() {
    console.log("Submitting form...");

    // Update hidden input with current Quill content
    const pertanyaanInput = document.getElementById("pertanyaan");
    if (pertanyaanInput) {
        pertanyaanInput.value = quill.root.innerHTML;
    }

    // Validasi konten Quill editor
    const quillContent = quill.getText().trim();
    if (!quillContent || quillContent.length === 0) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Pertanyaan tidak boleh kosong. Silakan masukkan pertanyaan terlebih dahulu.",
            confirmButtonColor: "#d33",
        });
        quill.focus();
        return;
    }

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
            icon: "error",
            title: "Error",
            text: "Silakan pilih jenis soal terlebih dahulu.",
            confirmButtonColor: "#d33",
        });
        return;
    }

    // Validasi jawaban berdasarkan jenis soal
    if (jenisSoal === "pilihan_ganda") {
        const jawabanInputs = $("#pilihan-container input[name*='[jawaban]']");
        let hasEmptyAnswer = false;
        jawabanInputs.each(function () {
            if (!$(this).val().trim()) {
                hasEmptyAnswer = true;
                return false;
            }
        });

        if (hasEmptyAnswer) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Semua pilihan jawaban harus diisi.",
                confirmButtonColor: "#d33",
            });
            return;
        }

        if (!$('input[name="jawaban_benar"]:checked').length) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Silakan pilih jawaban yang benar.",
                confirmButtonColor: "#d33",
            });
            return;
        }
    } else if (jenisSoal === "isian") {
        const jawabanIsian = $('input[name="jawaban_soal[0][jawaban]"]').val();
        if (!jawabanIsian || !jawabanIsian.trim()) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Jawaban isian harus diisi.",
                confirmButtonColor: "#d33",
            });
            return;
        }
    }

    console.log("All validations passed, proceeding with form submission");

    // Tampilkan loading
    Swal.fire({
        title: "Menyimpan...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    // Ambil form data
    const formData = new FormData(form);

    // Debug: Log FormData contents
    console.log("FormData contents:");
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            console.log(key, ":", value.name, "(", value.size, "bytes)");
        } else {
            console.log(key, ":", value);
        }
    }

    // Tentukan URL dan method berdasarkan mode edit atau create
    let url = "/bank-soal";
    let methodValue = $("#form-method").get(0)?.value;
    let soal_id = $("#soal-id").get(0)?.value || null;
    console.log("Form method:", methodValue, "Soal ID:", soal_id);

    if (soal_id) {
        url = `/bank-soal/${soal_id}`;
        formData.append("_method", "PUT");
    }

    // Debug: check methodValue and soal_id before submission
    console.log("Form submission method:", methodValue);
    console.log("Soal ID:", soal_id);
    console.log("Form submission URL:", url);

    // Submit dengan AJAX
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
            console.log("Form submitted successfully:", response);
            Swal.close();

            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: response.message || "Data berhasil disimpan!",
                    confirmButtonColor: "#28a745",
                }).then(() => {
                    // Tutup modal
                    $("#tambah-bank-soal").modal("hide");

                    // Refresh datatables
                    if (window.tableSemua) window.tableSemua.ajax.reload();
                    if (window.tableReading) window.tableReading.ajax.reload();
                    if (window.tableListening)
                        window.tableListening.ajax.reload();
                    if (window.tableGrammar) window.tableGrammar.ajax.reload();

                    // Reset form
                    resetForm();
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        response.message ||
                        "Terjadi kesalahan saat menyimpan data.",
                    confirmButtonColor: "#d33",
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Form submission error:", xhr.responseText);
            Swal.close();

            let errorMessage = "Terjadi kesalahan saat menyimpan data.";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON.errors) {
                    // Handle validation errors
                    const errors = xhr.responseJSON.errors;
                    const firstError = Object.values(errors)[0];
                    if (Array.isArray(firstError) && firstError.length > 0) {
                        errorMessage = firstError[0];
                    }
                }
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: errorMessage,
                confirmButtonColor: "#d33",
            });
        },
    });
}

// Reset form
function resetForm() {
    console.log("Resetting form...");

    // Reset form fields
    const form = document.getElementById("form-bank-soal");
    if (form) {
        form.reset();
    }

    // Reset Quill editor secara aman
    quill.setText("");
    document.getElementById("pertanyaan").value = "";
    setEditorDirection("ltr"); // kembali ke mode Latin

    // Reset global variables
    currentSoalId = null;
    jawabanCounter = 0;

    // Reset hidden method input
    $("#form-method").val("POST");

    // Clear jawaban container
    $("#jawaban-container").empty();
    $("#jawaban-wrapper").addClass("d-none");

    // Hide audio container
    $("#audio-file-container").hide();

    // Reset modal title
    $("#modal-title").text("Tambah Soal Baru");

    // Reset Select2 dropdowns
    $("#jenis_font, #jenis_soal, #tingkat_kesulitan, #kategori, #sub_kategori")
        .val("")
        .trigger("change");

    // Clear sub kategori
    $("#sub_kategori")
        .empty()
        .append('<option value="">Pilih Sub Kategori</option>')
        .trigger("change");

    console.log("Form reset completed");
}

// Main edit function
function editSoal(id) {
    console.log("Edit soal with ID:", id);

    // Set current soal ID
    currentSoalId = id;

    // Show loading
    Swal.fire({
        title: "Memuat data...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    // Fetch data from server
    $.ajax({
        url: `/bank-soal/${id}`,
        type: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("Edit data received:", response);

            Swal.close();

            if (response.success && response.data) {
                // Change modal title
                $("#modal-title").text("Edit Soal");

                // Ensure dropdown data is loaded before populating form
                ensureDropdownDataLoaded(() => {
                    // Populate form with data
                    populateFormWithData(response.data);

                    // Show modal after a short delay to ensure all data is loaded
                    setTimeout(() => {
                        $("#tambah-bank-soal").modal("show");
                    }, 100);
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Data tidak ditemukan atau format response tidak valid",
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching edit data:", xhr.responseText);

            Swal.close();

            let errorMessage = "Terjadi kesalahan saat memuat data";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = "Data tidak ditemukan";
            } else if (xhr.status === 403) {
                errorMessage =
                    "Anda tidak memiliki akses untuk mengedit data ini";
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: errorMessage,
            });
        },
    });
}

// Populate form with data (modular approach)
function populateFormWithData(data) {
    console.log("Populating form with data:", data);

    try {
        // Set method to PUT for editing
        $("#form-method").val("PUT");
        $("#soal-id").val(data.id || "");

        // Set basic form fields
        $("#is_audio").prop("checked", data.is_audio == 1);
        setTimeout(() => {
            $("#penjelasan_jawaban").val(data.penjelasan_jawaban || "");
            $("#tag").val(data.tag || "");
        }, 500);

        // Show/hide audio container
        if (data.is_audio == 1) {
            $("#audio-file-container").show();
        } else {
            $("#audio-file-container").hide();
        }

        // Set Select2 dropdowns
        if (data.jenis_font) {
            setTimeout(() => {
                $("#jenis_font").val(data.jenis_font).trigger("change");
            }, 500);
        }

        if (data.tingkat_kesulitan_id) {
            setTimeout(() => {
                $("#tingkat_kesulitan")
                    .val(data.tingkat_kesulitan_id)
                    .trigger("change");
            }, 500);
        }

        if (data.kategori_id) {
            setTimeout(() => {
                $("#kategori").val(data.kategori_id).trigger("change");
            }, 500);

            // Load sub kategori after kategori is set
            if (data.sub_kategori_id) {
                setTimeout(() => {
                    loadSubKategori(data.kategori_id);
                    setTimeout(() => {
                        $("#sub_kategori")
                            .val(data.sub_kategori_id)
                            .trigger("change");
                    }, 500);
                }, 400);
            }
        }

        // Set jenis soal and generate jawaban form
        if (data.jenis_isian) {
            setTimeout(() => {
                $("#jenis_soal").val(data.jenis_isian).trigger("change");
            }, 500);

            //Generate jawaban form and populate answers
            setTimeout(() => {
                generateJawabanForm(data.jenis_isian);

                if (data.jawaban_soals && data.jawaban_soals.length > 0) {
                    setTimeout(() => {
                        populateJawabanSoal(
                            data.jawaban_soals,
                            data.jenis_isian
                        );
                    }, 300);
                }
            }, 100);
        }

        // Load content into Quill editor
        if (data.pertanyaan) {
            setTimeout(() => {
                loadQuillContent(data.pertanyaan, data.jenis_font || "Latin");
            }, 500);
        }

        console.log("Form populated successfully");
    } catch (error) {
        console.error("Error populating form:", error);

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Terjadi kesalahan saat memuat data ke form",
        });
    }
}

// Populate jawaban soal (modular approach)
function populateJawabanSoal(jawabanSoals, jenisSoal) {
    console.log(
        "Populating jawaban soal:",
        jawabanSoals,
        "for type:",
        jenisSoal
    );

    if (!jawabanSoals || jawabanSoals.length === 0) {
        console.log("No jawaban soals to populate");
        return;
    }

    try {
        if (jenisSoal === "pilihan_ganda") {
            populatePilihanGanda(jawabanSoals);
        } else if (jenisSoal === "benar_salah") {
            populateBenarSalah(jawabanSoals);
        } else if (jenisSoal === "isian") {
            populateIsian(jawabanSoals);
        }

        console.log("Jawaban soal populated successfully");
    } catch (error) {
        console.error("Error populating jawaban soal:", error);
    }
}

// Populate pilihan ganda answers
function populatePilihanGanda(jawabanSoals) {
    console.log("Populating pilihan ganda with:", jawabanSoals);

    // Wait for pilihan container to be ready
    const populateWhenReady = () => {
        const container = $("#pilihan-container");

        if (container.length === 0 || container.children().length === 0) {
            setTimeout(populateWhenReady, 50);
            return;
        }

        // Clear existing options first
        container.empty();
        jawabanCounter = 0;

        // Add options based on jawaban data
        jawabanSoals.forEach((jawaban, index) => {
            const label = jawaban.label_jawaban
                ? jawaban.label_jawaban.replace("Pilihan ", "")
                : String.fromCharCode(65 + index);

            const isCorrect = jawaban.jawaban_benar == 1;

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
                                ${isCorrect ? "checked" : ""}
                                required
                            >
                            <label
                                class="form-check-label label-benar"
                                for="jawaban_${jawabanCounter}"
                                style="display: ${
                                    isCorrect ? "inline" : "none"
                                }"
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
                               value="${jawaban.jawaban}"
                               placeholder="Masukkan jawaban pilihan ${label}" required>
                        <input type="hidden" name="jawaban_soal[${jawabanCounter}][jenis_isian]" value="pilihan_ganda">
                        <input type="hidden" name="jawaban_soal[${jawabanCounter}][jawaban_benar]" value="${
                isCorrect ? 1 : 0
            }">
                        <input type="hidden" name="jawaban_soal[${jawabanCounter}][id]" value="${
                jawaban.id
            }">
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

            container.append(pilihanHtml);
            jawabanCounter++;
        });

        // Re-bind events
        bindPilihanGandaEvents();
    };

    populateWhenReady();
}

// Populate benar/salah answers
function populateBenarSalah(jawabanSoals) {
    console.log("Populating benar salah with:", jawabanSoals);

    if (jawabanSoals.length > 0) {
        const jawaban = jawabanSoals[0];
        const isBenar = jawaban.jawaban_benar == 1;

        // Set radio button
        $(`input[name="jawaban_benar"][value="${isBenar ? "0" : "1"}"]`).prop(
            "checked",
            true
        );

        // Set hidden inputs for both options
        jawabanSoals.forEach((jawaban, index) => {
            $(`input[name="jawaban_soal[${index}][id]"]`).val(jawaban.id);
        });

        // Update jawaban_benar values setelah set radio button
        setTimeout(() => {
            updateBenarSalahValues();
        }, 100);
    }
}

// Populate isian answers
function populateIsian(jawabanSoals) {
    console.log("Populating isian with:", jawabanSoals);

    if (jawabanSoals.length > 0) {
        const jawaban = jawabanSoals[0];

        // Set jawaban text
        $('input[name="jawaban_soal[0][jawaban]"]').val(jawaban.jawaban);

        // Set hidden input
        $('input[name="jawaban_soal[0][id]"]').val(jawaban.id);
    }
}

// Bind pilihan ganda events
function bindPilihanGandaEvents() {
    // Event untuk hapus pilihan
    $(".remove-pilihan")
        .off("click")
        .on("click", function () {
            $(this).closest(".pilihan-item").remove();
            updatePilihanIndexes();
            updateLabelBenar();
        });

    // Event untuk radio button
    $("input[name='jawaban_benar']")
        .off("change")
        .on("change", function () {
            updateLabelBenar();
            updateJawabanBenarValues();
        });
}

// Ensure dropdown data is loaded before proceeding
function ensureDropdownDataLoaded(callback) {
    // Check if dropdown data is already loaded
    const tingkatKesulitanLoaded = $("#tingkat_kesulitan option").length > 1;
    const kategoriLoaded = $("#kategori option").length > 1;

    if (tingkatKesulitanLoaded && kategoriLoaded) {
        callback();
    } else {
        // Wait for data to load
        setTimeout(() => {
            ensureDropdownDataLoaded(callback);
        }, 100);
    }
}

// Delete soal
function deleteSoal(id) {
    console.log("Deleting soal with ID:", id);

    Swal.fire({
        title: "Menghapus...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        url: `/bank-soal/${id}`,
        type: "DELETE",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("Delete success:", response);
            Swal.close();

            if (response.success) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: response.message || "Data berhasil dihapus!",
                    confirmButtonColor: "#28a745",
                }).then(() => {
                    // Refresh datatables
                    if (window.tableSemua) window.tableSemua.ajax.reload();
                    if (window.tableReading) window.tableReading.ajax.reload();
                    if (window.tableListening)
                        window.tableListening.ajax.reload();
                    if (window.tableGrammar) window.tableGrammar.ajax.reload();

                    // Reset current soal ID
                    currentSoalId = null;
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text:
                        response.message ||
                        "Terjadi kesalahan saat menghapus data.",
                    confirmButtonColor: "#d33",
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Delete error:", xhr.responseText);
            Swal.close();

            let errorMessage = "Terjadi kesalahan saat menghapus data.";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: errorMessage,
                confirmButtonColor: "#d33",
            });
        },
    });
}

// Show delete confirmation
function showDeleteConfirmation(id) {
    console.log("Show delete confirmation for ID:", id);

    currentSoalId = id;

    Swal.fire({
        title: "Konfirmasi Hapus",
        text: "Apakah Anda yakin ingin menghapus soal ini? Data yang sudah dihapus tidak dapat dikembalikan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            deleteSoal(id);
        }
    });
}

// Test function for debugging
function testBankSoal() {
    console.log("Testing Bank Soal functions...");
    console.log("Current soal ID:", currentSoalId);
    console.log("Jawaban counter:", jawabanCounter);
    console.log("Quill ready:", quillReady);
    console.log("Functions available:", {
        editSoal: typeof window.editSoal,
        populateFormWithData: typeof window.populateFormWithData,
        loadDropdownData: typeof window.loadDropdownData,
        showDeleteConfirmation: typeof window.showDeleteConfirmation,
    });
}
