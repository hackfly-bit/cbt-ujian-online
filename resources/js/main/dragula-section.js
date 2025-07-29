import dragula from "dragula/dist/dragula.min.js";


var DragulaSections = function () {
    this.$body = $("body");
    this.sectionCount = 0;
    this.categoriesCache = null;
    this.loadingStates = {};
    this.categoryChangeTimeout = null;
    this.questionDragulaInstances = new Map();
};

DragulaSections.prototype.init = function () {
    const self = this;

    // Inisialisasi dragula untuk section reordering
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

    // Inisialisasi dragula untuk question transfer
    self.initQuestionDragula();

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
                                <label class="form-label">Soal Terpilih</label>
                                <div class="selected-questions-container border rounded p-3" data-plugin="dragula" id="selected-questions-${self.sectionCount}">
                                    <div class="text-muted text-center py-3">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Belum ada soal yang dipilih
                                    </div>
                                </div>
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
                        <label class="form-label">Soal Terpilih</label>
                        <div class="selected-questions-container border rounded p-3" data-plugin="dragula" id="selected-questions-${currentSectionIndex}">
                            <div class="text-muted text-center py-3">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada soal yang dipilih
                            </div>
                        </div>
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

    // Handle question click to move to selected
    $("#section-container").on("click", ".question-box", function (e) {
        // Prevent if clicking on checkbox
        if ($(e.target).hasClass('question-checkbox') || $(e.target).closest('.form-check').length) {
            return;
        }

        const $questionBox = $(this);
        const $form = $questionBox.closest(".section-form");
        const $selectedContainer = $form.find(".selected-questions-container");
        const questionId = $questionBox.find('.question-checkbox').val();

        // Check if question is already selected
        if ($selectedContainer.find(`[data-question-id="${questionId}"]`).length > 0) {
            return;
        }

        // Clone question and add to selected container
        const $clonedQuestion = $questionBox.clone();
        $clonedQuestion
            .addClass('border border-warning shadow-sm')
            .css({
                'transition': 'all 0.2s ease-in-out',
                'transform': 'scale(1.02)'
            })
            .animate({ transform: 'scale(1)' }, 200);
        $clonedQuestion.attr('data-question-id', questionId);

        // Remove checkbox and add remove button
        $clonedQuestion.find('.form-check').html(`
            <button type="button" class="btn btn-sm btn-outline-danger remove-question" title="Hapus soal">
                <i class="bi bi-trash"></i>
            </button>
        `);

        // Clear empty state if exists
        if ($selectedContainer.find('.text-muted.text-center').length > 0) {
            $selectedContainer.empty();
        }

        $selectedContainer.append($clonedQuestion);

        // Check the original checkbox
        $questionBox.find('.question-checkbox').prop('checked', true);

        self.updateSelectedCount($form);
        self.updateSectionQuestionCount($form);
    });

    // Handle remove question from selected
    $("#section-container").on("click", ".remove-question", function (e) {
        e.stopPropagation();
        const $removeBtn = $(this);
        const $selectedQuestion = $removeBtn.closest('.question-box');
        const $form = $removeBtn.closest(".section-form");
        const questionId = $selectedQuestion.attr('data-question-id');

        // Uncheck the original checkbox
        $form.find(`.question-checkbox[value="${questionId}"]`).prop('checked', false);

        // Remove from selected container
        $selectedQuestion.remove();

        // Show empty state if no questions left
        const $selectedContainer = $form.find(".selected-questions-container");
        if ($selectedContainer.children().length === 0) {
            $selectedContainer.html(`
                <div class="text-muted text-center py-3">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    Belum ada soal yang dipilih
                </div>
            `);
        }

        self.updateSelectedCount($form);
        self.updateSectionQuestionCount($form);
    });
};

/**
 * Initialize dragula for question transfer between containers
 */
DragulaSections.prototype.initQuestionDragula = function () {
    const self = this;

    // Function to setup dragula for a specific section
    const setupSectionDragula = function (sectionId) {
        const questionContainer = document.getElementById(`question-container-${sectionId}`);
        const selectedContainer = document.getElementById(`selected-questions-${sectionId}`);

        if (!questionContainer || !selectedContainer) {
            return;
        }

        // Destroy existing instance if exists
        if (self.questionDragulaInstances.has(sectionId)) {
            self.questionDragulaInstances.get(sectionId).destroy();
        }

        const dragulaInstance = dragula([questionContainer, selectedContainer], {
            copy: function (el, source) {
                // Copy from question-container to selected-questions
                return source === questionContainer;
            },
            accepts: function (el, target, source, sibling) {
                // Only allow dropping question-box elements
                return el.classList.contains('question-box');
            },
            moves: function (el, source, handle, sibling) {
                // Allow moving question-box elements
                return el.classList.contains('question-box');
            }
        });

        // Handle drop events
        dragulaInstance.on('drop', function (el, target, source, sibling) {
            const $el = $(el);
            const $form = $el.closest('.section-form');
            const questionId = $el.find('.question-checkbox').val() || $el.attr('data-question-id');

            if (target.id.includes('selected-questions')) {
                // Dropped into selected container

                // Check if already exists in selected
                const $selectedContainer = $(target);
                if ($selectedContainer.find(`[data-question-id="${questionId}"]`).length > 1) {
                    // Remove duplicate
                    $el.remove();
                    return;
                }

                // Clear empty state if exists
                if ($selectedContainer.find('.text-muted.text-center').length > 0) {
                    $selectedContainer.find('.text-muted.text-center').parent().remove();
                }

                // Modify the dropped element
                $el.addClass('border-warning');
                $el.attr('data-question-id', questionId);

                // Replace checkbox with remove button
                $el.find('.form-check').html(`
                    <button type="button" class="btn btn-sm btn-outline-danger" title="Remove question">
                        <i class="bi bi-trash"></i>
                    </button>
                `);

                // Check the original checkbox in question container
                $form.find(`.question-container .question-checkbox[value="${questionId}"]`).prop('checked', true);

            } else if (target.id.includes('question-container')) {
                // Dropped back to question container (remove from selected)
                const $selectedContainer = $form.find('.selected-questions-container');

                // Remove from selected container
                $selectedContainer.find(`[data-question-id="${questionId}"]`).remove();

                // Uncheck the checkbox
                $form.find(`.question-checkbox[value="${questionId}"]`).prop('checked', false);

                // Show empty state if no questions left in selected
                if ($selectedContainer.children('.question-box').length === 0) {
                    $selectedContainer.html(`
                        <div class="text-muted text-center py-3">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada soal yang dipilih
                        </div>
                    `);
                }

                // Remove the dropped element (it was copied, not moved)
                $el.remove();
            }

            self.updateSelectedCount($form);
            self.updateSectionQuestionCount($form);
        });

        // Store the instance
        self.questionDragulaInstances.set(sectionId, dragulaInstance);
    };

    // Setup dragula for existing sections
    $('.selected-questions-container').each(function () {
        const containerId = $(this).attr('id');
        if (containerId) {
            const sectionId = containerId.replace('selected-questions-', '');
            setupSectionDragula(sectionId);
        }
    });

    // Observer to setup dragula for new sections
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            mutation.addedNodes.forEach(function (node) {
                if (node.nodeType === 1) { // Element node
                    const $node = $(node);
                    // Check if new section was added
                    if ($node.hasClass('section-item') || $node.find('.section-item').length > 0) {
                        setTimeout(() => {
                            $('.selected-questions-container').each(function () {
                                const containerId = $(this).attr('id');
                                if (containerId) {
                                    const sectionId = containerId.replace('selected-questions-', '');
                                    if (!self.questionDragulaInstances.has(sectionId)) {
                                        setupSectionDragula(sectionId);
                                    }
                                }
                            });
                        }, 100);
                    }
                }
            });
        });
    });

    // Start observing
    const sectionContainer = document.getElementById('section-container');
    if (sectionContainer) {
        observer.observe(sectionContainer, {
            childList: true,
            subtree: true
        });
    }
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

            // Load existing selected questions into selected-questions-container for edit mode
            const $selectedContainer = $form.find('.selected-questions-container');
            console.log('🔍 Existing questions structure:', existingQuestions);

            if ($selectedContainer.length > 0 && existingQuestions && existingQuestions.length > 0) {
                let selectedQuestionsHTML = '';
                existingQuestions.forEach((questionItem, index) => {
                    // Handle different data structures - could be object with soal_id or just ID
                    let questionId = questionItem;
                    if (typeof questionItem === 'object') {
                        if (questionItem.soal_id) {
                            questionId = questionItem.soal_id;
                        } else if (questionItem.id) {
                            questionId = questionItem.id;
                        } else if (questionItem.soal && questionItem.soal.id) {
                            questionId = questionItem.soal.id;
                        }
                    }

                    // Find the question data from the loaded questions
                    const questionData = data.find(q => q.id == questionId);

                    if (questionData) {
                        const questionHTML = self.generateQuestionHTML(questionItem.soal, sectionCount, existingQuestions, index);
                        const $questionElement = $(questionHTML);

                        // Add selected styling
                        $questionElement
                            .addClass('border border-warning shadow-sm')
                            .css({
                                'transition': 'all 0.2s ease-in-out'
                            })
                            .attr('data-question-id', questionItem.soal_id);

                        // Replace checkbox with remove button
                        $questionElement.find('.form-check').html(`
                            <button type="button" class="btn btn-sm btn-outline-danger remove-question" title="Hapus soal">
                                <i class="bi bi-trash"></i>
                            </button>
                        `);

                        selectedQuestionsHTML += $questionElement.prop('outerHTML');
                    }
                });

                if (selectedQuestionsHTML) {
                    $selectedContainer.html(selectedQuestionsHTML);
                } else {
                    $selectedContainer.html(`
                         <div class="text-muted text-center py-3">
                             <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                             Belum ada soal yang dipilih
                         </div>
                     `);
                }
            } else {
                if ($selectedContainer.length > 0) {
                    $selectedContainer.html(`
                         <div class="text-muted text-center py-3">
                             <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                             Belum ada soal yang dipilih
                         </div>
                     `);
                }
            }

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
    // Get question text and strip HTML tags, or fallback to default numbering
    const questionText = question.pertanyaan ?
        question.pertanyaan.replace(/<[^>]*>/g, '') || `Soal ${(index || 0) + 1}` :
        `Soal ${(index || 0) + 1}`;
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
    // Count from both checkbox (create mode) and selected container (edit mode)
    const checkboxCount = $form.find(".question-checkbox:checked").length;
    const selectedContainerCount = $form.find(".selected-questions-container .question-box").length;
    const selectedCount = Math.max(checkboxCount, selectedContainerCount);
    $form.find(".selected-count").text(selectedCount);
};

// Update section question count in header
DragulaSections.prototype.updateSectionQuestionCount = function ($form) {
    // Count from both checkbox (create mode) and selected container (edit mode)
    const checkboxCount = $form.find(".question-checkbox:checked").length;
    const selectedContainerCount = $form.find(".selected-questions-container .question-box").length;
    const selectedCount = Math.max(checkboxCount, selectedContainerCount);
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

// Export untuk ES6 modules
export default DragulaSections;
