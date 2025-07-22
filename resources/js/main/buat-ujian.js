import dragula from "dragula/dist/dragula.min.js";
import jQuery from "jquery/dist/jquery.min.js";
import Swal from "sweetalert2";
import flatpickr from "flatpickr";
// import Datepicker from "bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js";

(function ($) {
    "use strict";

    var DragulaSections = function () {
        this.$body = $("body");
        this.sectionCount = 0;
        this.categoriesCache = null;
        this.loadingStates = {};
        this.categoryChangeTimeout = null;
    };

    flatpickr("#tanggal_kedaluwarsa", {
        dateFormat: "Y-m-d",
        allowInput: true,
        // default value if ujian.tanggal_selesai is not null
        defaultDate: ujian.tanggal_selesai || null,
    });

    DragulaSections.prototype.init = function () {
        const self = this;

        // Inisialisasi dragula
        $('[data-plugin="dragula"]').each(function () {
            const $this = $(this);
            const containerId = $this.attr("id");
            const handleClass =
                $this.data("handleclass") || "section-drag-handle";

            if (!containerId) return;

            const container = document.getElementById(containerId);
            if (!container) return;

            dragula([container], {
                moves: function (el, source, handle) {
                    return (
                        handle &&
                        (handle.classList.contains(handleClass) ||
                            handle.closest(`.${handleClass}`))
                    );
                },
            });
        });

        // Tambah seksi
        $("#btn-tambah-seksi").on("click", function () {
            self.sectionCount++;

            const $container = $("#section-container");
            const collapseId = `collapse-seksi-${self.sectionCount}`;
            const sectionHTML = `
                <div class="section-item mb-2">
                    <div class="section-content d-flex justify-content-between align-items-center px-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="section-drag-handle cursor-grab text-muted">
                                <i class="bi bi-grip-vertical fs-2"></i>
                            </span>
                            <strong class="section-title m-0">Seksi ${self.sectionCount}</strong>
                        </div>
                        <div class="text-muted section-toolbar d-flex align-items-center gap-2">
                            <span>0 soal</span>
                            <button class="chevron-toggle btn btn-sm p-1" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#${collapseId}"
                                aria-expanded="false"
                                aria-controls="${collapseId}">
                                <i class="bi bi-chevron-down fs-4"></i>
                            </button>
                        </div>
                    </div>
                    <div id="${collapseId}" class="collapse section-body px-4 py-3 border-top">
                        <form class="section-form">
                            <div class="mb-2">
                                <label class="form-label">Nama Seksi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control section-nama-input" name="nama_section" placeholder="Nama Seksi" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Instruksi</label>
                                <textarea class="form-control" name="instruksi" placeholder="Instruksi pengerjaan soal"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Formula Penilaian <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span>(</span>
                                    <select class="form-select" name="answer_type" style="width: auto" required>
                                        <option value="correctAnswer">Jawaban Benar</option>
                                        <option value="incorrectAnswer">Jawaban Salah</option>
                                    </select>
                                    <select class="form-select" name="operation" style="width: auto" required>
                                        <option value="*">×</option>
                                        <option value="+">+</option>
                                        <option value="-">-</option>
                                        <option value="/">÷</option>
                                    </select>
                                    <input type="number" class="form-control" name="value" placeholder="n" style="width: 80px" required>
                                    <span>)</span>
                                    <select class="form-select" name="operation2" style="width: auto" required>
                                        <option value="*">×</option>
                                        <option value="+">+</option>
                                        <option value="-">-</option>
                                        <option value="/">÷</option>
                                    </select>
                                    <input type="number" class="form-control" name="value2" placeholder="n" style="width: 80px" required>
                                </div>
                                <small class="text-muted">
                                    Contoh: (Jawaban Benar × n) × n
                                </small>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Kategori Soal <span class="text-danger">*</span></label>
                                <select class="form-select category-dropdown" name="kategori_id" data-section="${self.sectionCount}" required>
                                    <option value="">Pilih Kategori</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Pilih Soal <span class="text-danger">*</span></label>
                                <div class="question-container border rounded p-3" id="question-container-${self.sectionCount}" style="max-height: 300px; overflow-y: auto;">
                                    <div class="text-muted text-center py-3">
                                        <i class="bi bi-list-check fs-3 d-block mb-2"></i>
                                        Pilih kategori terlebih dahulu untuk melihat soal
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <span class="selected-count">0</span> soal dipilih
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            `;

            $container.append(sectionHTML);

            // Load categories for the new section
            self.loadCategories(self.sectionCount);
        });

        // load sections from ujian.ujian_sections count is greater than 0
        if (ujian.ujian_sections && ujian.ujian_sections.length > 0) {
            console.group("🔄 Loading existing sections");
            console.log(
                `Total sections to load: ${ujian.ujian_sections.length}`
            );

            ujian.ujian_sections.forEach((section, index) => {
                self.sectionCount++;
                const currentSectionIndex = self.sectionCount; // Capture immediately for closure

                console.log(
                    `\n--- Processing Section ${index + 1
                    } (UI Section ${currentSectionIndex}) ---`
                );
                console.log("Section data:", section);

                const $container = $("#section-container");
                const collapseId = `collapse-seksi-${currentSectionIndex}`;
                const sectionHTML = `
                <div class="section-item mb-2" data-section-index="${currentSectionIndex}" data-db-section-id="${section.id
                    }">
                <div class="section-content d-flex justify-content-between align-items-center px-4 py-3">
                    <div class="d-flex align-items-center gap-3">
                    <span class="section-drag-handle cursor-grab text-muted">
                        <i class="bi bi-grip-vertical fs-2"></i>
                    </span>
                    <strong class="section-title m-0">${section.nama_section || `Seksi ${currentSectionIndex}`
                    }</strong>
                    </div>
                    <div class="text-muted section-toolbar d-flex align-items-center gap-2">
                    <span>${section.ujian_section_soals
                        ? section.ujian_section_soals.length
                        : 0
                    } soal</span>
                    <button class="chevron-toggle btn btn-sm p-1" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#${collapseId}"
                        aria-expanded="false"
                        aria-controls="${collapseId}">
                        <i class="bi bi-chevron-down fs-4"></i>
                    </button>
                    </div>
                </div>
                <div id="${collapseId}" class="collapse section-body px-4 py-3 border-top">
                    <form class="section-form" data-section-index="${currentSectionIndex}">
                    <div class="mb-2">
                        <label class="form-label">Nama Seksi</label>
                        <input type="text" class="form-control section-nama-input" name="nama_section" placeholder="Nama Seksi" value="${section.nama_section || ""
                    }">
                    </div>
                     <div class="mb-2">
                                <label class="form-label">Instruksi</label>
                                <textarea class="form-control" name="instruksi" placeholder="Instruksi pengerjaan soal">${section.instruksi || ""
                    }</textarea>
                            </div>
                    <div class="mb-2">
                        <label class="form-label">Formula Penilaian</label>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span>(</span>
                            <select class="form-select" name="answer_type" style="width: auto">
                                <option value="correctAnswer" ${section.formula_type === "correctAnswer"
                        ? "selected"
                        : ""
                    }>Jawaban Benar</option>
                                <option value="incorrectAnswer" ${section.formula_type === "incorrectAnswer"
                        ? "selected"
                        : ""
                    }>Jawaban Salah</option>
                            </select>
                            <select class="form-select" name="operation" style="width: auto">
                                <option value="*" ${section.operation_1 === "*"
                        ? "selected"
                        : ""
                    }>×</option>
                                <option value="+" ${section.operation_1 === "+"
                        ? "selected"
                        : ""
                    }>+</option>
                                <option value="-" ${section.operation_1 === "-"
                        ? "selected"
                        : ""
                    }>-</option>
                                <option value="/" ${section.operation_1 === "/"
                        ? "selected"
                        : ""
                    }>÷</option>
                            </select>
                            <input type="number" class="form-control" name="value" placeholder="n" style="width: 80px" value="${section.value_1 || ""
                    }">
                            <span>)</span>
                            <select class="form-select" name="operation2" style="width: auto">
                                <option value="*" ${section.operation_2 === "*"
                        ? "selected"
                        : ""
                    }>×</option>
                                <option value="+" ${section.operation_2 === "+"
                        ? "selected"
                        : ""
                    }>+</option>
                                <option value="-" ${section.operation_2 === "-"
                        ? "selected"
                        : ""
                    }>-</option>
                                <option value="/" ${section.operation_2 === "/"
                        ? "selected"
                        : ""
                    }>÷</option>
                            </select>
                            <input type="number" class="form-control" name="value2" placeholder="n" style="width: 80px" value="${section.value_2 || ""
                    }">
                        </div>
                        <small class="text-muted">
                            Contoh: (Jawaban Benar × n) × n
                        </small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kategori Soal</label>
                        <select class="form-select category-dropdown" name="kategori_id" data-section="${currentSectionIndex}">
                        <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Pilih Soal</label>
                        <div class="question-container border rounded p-3" id="question-container-${currentSectionIndex}" style="max-height: 300px; overflow-y: auto;">
                        <div class="text-muted text-center py-3">
                            <i class="bi bi-list-check fs-3 d-block mb-2"></i>
                            Soal is diambil dari kategori yang dipilih
                        </div>
                        </div>
                        <div class="mt-2">
                        <small class="text-muted">
                            <span class="selected-count">${section.ujian_section_soals
                        ? section.ujian_section_soals.length
                        : 0
                    }</span> soal dipilih
                        </small>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            `;

                $container.append(sectionHTML);
                console.log(
                    `✅ Section ${currentSectionIndex} HTML added to DOM`
                );
                console.log(
                    `Database section.id: ${section.id}, UI section: ${currentSectionIndex}, Category: ${section.kategori_id}`
                );

                // Load categories and set selected category if exists
                self.loadCategories(currentSectionIndex)
                    .then(() => {
                        console.log(
                            `📂 Categories loaded for UI section ${currentSectionIndex}`
                        );
                        if (section.kategori_id) {
                            console.log(
                                `🎯 Setting category ${section.kategori_id} for UI section ${currentSectionIndex} (DB section ${section.id})`
                            );
                            const $categoryDropdown = $(
                                `.category-dropdown[data-section="${currentSectionIndex}"]`
                            );
                            $categoryDropdown.val(section.kategori_id);

                            // Load questions for this category
                            self.loadQuestionsIfExist(
                                section.kategori_id,
                                section.id,
                                section.ujian_section_soals,
                                currentSectionIndex
                            );
                        }
                    })
                    .catch((error) => {
                        console.error(
                            `❌ Error loading categories for section ${currentSectionIndex}:`,
                            error
                        );
                    });
            });
            console.groupEnd();
        }
        // Accordion collapse logic
        $("#section-container").on("click", ".chevron-toggle", function (e) {
            const $btn = $(this);
            const targetId = $btn.attr("data-bs-target");
            const $container = $("#section-container");
            const $openCollapses = $container.find(".collapse.show");

            $openCollapses.each(function () {
                if ("#" + this.id !== targetId) {
                    new bootstrap.Collapse(this).hide();
                }
            });
        });

        // Handle metode penilaian change
        $("#section-container").on(
            "change",
            ".metode-penilaian-dropdown",
            function () {
                const $dropdown = $(this);
                const selectedValue = $dropdown.val();
                const $formulaGroup = $dropdown
                    .closest(".section-form")
                    .find(".formula-input-group");

                if (selectedValue === "manual") {
                    $formulaGroup.show();
                } else {
                    $formulaGroup.hide();
                }
            }
        );

        // Handle category selection change
        $("#section-container").on("change", ".category-dropdown", function () {
            const $dropdown = $(this);
            const categoryId = $dropdown.val();
            const sectionId = $dropdown.data("section");

            // Clear previous timeout
            clearTimeout(self.categoryChangeTimeout);

            // Add debouncing for rapid category changes
            self.categoryChangeTimeout = setTimeout(() => {
                if (categoryId) {
                    self.loadQuestions(categoryId, sectionId);
                } else {
                    // Clear questions
                    const $questionContainer = $dropdown
                        .closest(".section-form")
                        .find(".question-container");
                    $questionContainer.html(`
                        <div class="text-muted text-center py-3">
                            <i class="bi bi-list-check fs-3 d-block mb-2"></i>
                            Pilih kategori terlebih dahulu untuk melihat soal
                        </div>
                    `);
                    self.updateSelectedCount(
                        $dropdown.closest(".section-form")
                    );
                }
            }, 300);
        });

        // Handle question checkbox changes
        $("#section-container").on("change", ".question-checkbox", function () {
            const $checkbox = $(this);
            const $form = $checkbox.closest(".section-form");
            self.updateSelectedCount($form);
            self.updateSectionQuestionCount($form);
        });
    };

    /**
     * Load categories from API with caching support
     * @param {number} sectionId - The section ID for which to load categories
     * @returns {Promise} Promise that resolves when categories are loaded
     */
    DragulaSections.prototype.loadCategories = function (sectionId) {
        const $dropdown = $(`.category-dropdown[data-section="${sectionId}"]`);
        console.log(`📋 Loading categories for UI section ${sectionId}`);

        if ($dropdown.length === 0) {
            console.error(
                `❌ Category dropdown not found for section ${sectionId}`
            );
            return Promise.reject(
                new Error(`Dropdown not found for section ${sectionId}`)
            );
        }

        // Show loading state
        $dropdown.html('<option value="">Loading...</option>');

        // Use cache if available
        if (this.categoriesCache) {
            this.populateCategories($dropdown, this.categoriesCache);
            return Promise.resolve();
        }

        return fetch("/filter/kategori")
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                // Cache the categories
                this.categoriesCache = data;
                this.populateCategories($dropdown, data);
            })
            .catch((error) => {
                console.error(
                    `Error loading categories for section ${sectionId}:`,
                    error
                );
                $dropdown.html(
                    '<option value="">Error loading categories</option>'
                );
                throw error; // Re-throw to allow caller to handle
            });
    };

    // Helper method to populate category dropdown
    DragulaSections.prototype.populateCategories = function ($dropdown, data) {
        console.log(
            `📝 Populating categories for dropdown:`,
            $dropdown.attr("data-section")
        );
        let options = '<option value="">Pilih Kategori</option>';

        if (data && data.length > 0) {
            data.forEach((category) => {
                options += `<option value="${category.id}">${category.nama}</option>`;
            });
            console.log(`✅ Added ${data.length} categories to dropdown`);
        } else {
            options = '<option value="">Tidak ada kategori tersedia</option>';
            console.log(`⚠️ No categories available`);
        }

        $dropdown.html(options);
    };

    /**
     * Load questions if they exist in the section
     * @param {string} categoryId - The category ID
     * @param {string} sectionId - The section ID from database
     * @param {Array} existingQuestions - Array of existing questions
     * @param {number} sectionCount - The section count for UI
     */
    DragulaSections.prototype.loadQuestionsIfExist = function (
        categoryId,
        sectionId,
        existingQuestions,
        sectionCount
    ) {
        console.group(`🔄 Loading questions for section ${sectionCount}`);
        console.log(`Category ID: ${categoryId}, Section DB ID: ${sectionId}`);
        console.log("Existing questions:", existingQuestions);

        const $form = $(
            `.category-dropdown[data-section="${sectionCount}"]`
        ).closest(".section-form");
        // FIX: Use scoped selector instead of global selector
        const $questionContainer = $form.find(".question-container");

        if ($questionContainer.length === 0) {
            console.error(
                `❌ Question container not found for section ${sectionCount}`
            );
            console.groupEnd();
            return;
        }

        console.log(`✅ Found question container for section ${sectionCount}`);
        const self = this; // Store the context

        // Show loading state
        $questionContainer.html(`
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="text-muted mt-2">Memuat soal...</div>
            </div>
        `);
        fetch(
            `/filter/ujian-sections-soals?kategori=${categoryId}&section_id=${sectionId}`,
            {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            }
        )
            .then((response) => response.json())
            .then((response) => {
                // console.log('Loaded questions:', response);
                let questionsHTML = "";
                const data = response.data || response; // Handle DataTables response format
                if (data && data.length > 0) {
                    data.forEach((question, index) => {
                        questionsHTML += self.generateQuestionHTML(
                            question,
                            sectionCount,
                            existingQuestions,
                            index
                        );
                    });
                } else {
                    questionsHTML = `
                        <div class="text-muted text-center py-3">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Tidak ada soal tersedia untuk kategori ini
                        </div>
                    `;
                }
                // Update question container with loaded questions
                $questionContainer.html(questionsHTML);
                self.updateSelectedCount($form);
                console.log(
                    `✅ Successfully loaded ${data.length} questions for section ${sectionCount}`
                );
                console.groupEnd();
            })
            .catch((error) => {
                console.error(
                    `❌ Error loading questions for section ${sectionCount}:`,
                    error
                );
                $questionContainer.html(`
                    <div class="text-danger text-center py-3">
                        <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                        Error memuat soal. Silakan coba lagi.
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="$.DragulaSections.loadQuestionsIfExist('${categoryId}', '${sectionId}', ${JSON.stringify(
                    existingQuestions
                )}, ${sectionCount})">
                            <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                        </button>
                    </div>
                `);
                console.groupEnd();
            });
    };

    /**
     * Load questions based on selected category
     * @param {string} categoryId - The category ID to load questions from
     * @param {number} sectionId - The section ID for the UI
     */
    DragulaSections.prototype.loadQuestions = function (categoryId, sectionId) {
        const $form = $(
            `.category-dropdown[data-section="${sectionId}"]`
        ).closest(".section-form");
        const $questionContainer = $form.find(".question-container");

        // Show loading state
        $questionContainer.html(`
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="text-muted mt-2">Memuat soal...</div>
            </div>
        `);

        fetch(`/bank-soal?kategori=${categoryId}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((response) => {
                let questionsHTML = "";
                const data = response.data || response; // Handle DataTables response format

                if (data && data.length > 0) {
                    data.forEach((question, index) => {
                        questionsHTML += this.generateQuestionHTML(
                            question,
                            sectionId,
                            null,
                            index
                        );
                    });
                } else {
                    questionsHTML = `
                        <div class="text-muted text-center py-3">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Tidak ada soal tersedia untuk kategori ini
                        </div>
                    `;
                }

                $questionContainer.html(questionsHTML);
                this.updateSelectedCount($form);
            })
            .catch((error) => {
                // console.error('Error loading questions:', error);
                $questionContainer.html(`
                    <div class="text-danger text-center py-3">
                        <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                        Error memuat soal. Silakan coba lagi.
                    </div>
                `);
            });
    };

    /**
     * Generate HTML for a question item
     * @param {Object} question - The question data object
     * @param {string} sectionId - The section ID for the UI
     * @param {Array} existingQuestions - Array of existing questions to check for selected state
     * @param {number} index - The index of the question in the list
     * @returns {string} The HTML string for the question
     */
    DragulaSections.prototype.generateQuestionHTML = function (
        question,
        sectionId,
        existingQuestions,
        index
    ) {
        const questionText = question.pertanyaan || `Soal ${(index || 0) + 1}`;
        const questionId = question.id;
        const tingkatKesulitan = question.tingkat_kesulitan
            ? `<span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle fw-medium small px-2 py-1">
                <i class="ri-bar-chart-line me-1"></i>${question.tingkat_kesulitan.nama || question.tingkat_kesulitan
            }</span>`
            : "";
        const kategori = question.kategori
            ? `<span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle fw-medium small px-2 py-1">
                <i class="ri-folder-line me-1"></i>${question.kategori.nama || question.kategori
            }</span>`
            : "";
        const mediaIcon = question.is_audio
            ? `<span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle fw-medium small px-2 py-1">
                <i class="ri-volume-up-line me-1"></i>Audio</span>`
            : `<span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle fw-medium small px-2 py-1">
                <i class="ri-text-wrap me-1"></i>Text</span>`;
        const jenisSoal = question.jenis_isian === 'pilihan_ganda' ? 'Pilihan Ganda' :
            question.jenis_isian === 'true_false' ? 'Benar / Salah' :
                question.jenis_isian;
        const isChecked =
            existingQuestions &&
                existingQuestions.some((q) => q.soal_id === questionId)
                ? "checked"
                : "";

        return `
            <div class="question-box d-flex align-items-center justify-content-between mb-3 p-3 rounded shadow-sm bg-light-subtle">
                <div class="content me-3 w-100">
                    <div class="fw-medium text-dark mb-2 d-flex align-items-center" title="${questionText.replace(
            /"/g,
            "&quot;"
        )}">
                        <span class="text-truncate fs-5">
                            ${questionText.length > 100
                ? questionText.substring(0, 100) + "..."
                : questionText
            }
                        </span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        ${kategori}
                        ${tingkatKesulitan}
                        ${mediaIcon}
                        <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle fw-medium small px-2 py-1">
                            <i class="ri-question-line me-1"></i>${jenisSoal}
                        </span>
                    </div>
                </div>
                <div class="form-check ms-auto">
                    <input class="form-check-input large-checkbox question-checkbox" type="checkbox"
                        value="${questionId}" id="question-${sectionId}-${questionId}" ${isChecked}>
                </div>
            </div>
        `;
    };

    /**
     * Validate section data before allowing save
     * @param {Object} sectionData - The section data to validate
     * @returns {Object} validation result with isValid boolean and errors array
     */
    DragulaSections.prototype.validateSection = function (sectionData) {
        const errors = [];

        if (
            !sectionData.nama_section ||
            sectionData.nama_section.trim() === ""
        ) {
            errors.push("Nama seksi harus diisi");
        }

        if (!sectionData.kategori_id) {
            errors.push("Kategori soal harus dipilih");
        }

        if (
            !sectionData.selected_questions ||
            sectionData.selected_questions.length === 0
        ) {
            errors.push("Minimal satu soal harus dipilih");
        }

        return {
            isValid: errors.length === 0,
            errors: errors,
        };
    };

    // Update selected question count
    DragulaSections.prototype.updateSelectedCount = function ($form) {
        const selectedCount = $form.find(".question-checkbox:checked").length;
        $form.find(".selected-count").text(selectedCount);
    };

    // Update section question count in header
    DragulaSections.prototype.updateSectionQuestionCount = function ($form) {
        const selectedCount = $form.find(".question-checkbox:checked").length;
        const $section = $form.closest(".section-item");
        const $toolbar = $section.find(".section-toolbar span:first");
        $toolbar.text(`${selectedCount} soal`);
    };

    $(document).on("input", ".section-nama-input", function () {
        const $input = $(this);
        const $section = $input.closest(".section-item");
        const $title = $section.find(".section-title");
        const val = $input.val().trim();
        if (val) {
            $title.text(val);
        } else {
            // fallback to default
            const idx = $section.index() + 1;
            $title.text("Seksi " + idx);
        }
    });

    // Inisialisasi
    $.DragulaSections = new DragulaSections();
    $.DragulaSections.Constructor = DragulaSections;
})(window.jQuery);

// Custom functions and scripts section
(function ($) {
    "use strict";

    // Initialize DragulaSections
    $.DragulaSections.init();

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

            $form.find(".question-checkbox:checked").each(function () {
                sectionData.selected_questions.push($(this).val());
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
                    acak_soal: $("#acak_soal").is(":checked"),
                    acak_jawaban: $("#acak_jawaban").is(":checked"),
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
