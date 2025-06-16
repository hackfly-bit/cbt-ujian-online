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
                        <p class="mb-0">Konten soal atau pengaturan lainnya.</p>

                        <form class="section-form">
                            <div class="mb-2">
                                <label class="form-label">Nama Seksi</label>
                                <input type="text" class="form-control section-nama-input" name="nama_section" placeholder="Nama Seksi">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bobot Nilai</label>
                                <input type="text" class="form-control" name="bobot_nilai" placeholder="Bobot Nilai">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Instruksi</label>
                                <textarea class="form-control" name="instruksi" rows="2" placeholder="Instruksi"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Metode Penilaian</label>
                                <select class="form-select metode-penilaian-dropdown" name="metode_penilaian">
                                    <option value="">Pilih Metode</option>
                                    <option value="otomatis">Otomatis</option>
                                    <option value="manual">Manual</option>
                                </select>
                            </div>
                            <div class="mb-2 formula-input-group" style="display: none;">
                                <label class="form-label">Masukan Rumus Custom</label>
                                <small class="form-text text-muted">Contoh: <code>0.4 * A + 0.6 * B</code> (A = nilai soal pilihan ganda, B = nilai soal esai)</small>
                                <input type="text" class="form-control" name="formula" placeholder="Masukkan nama formula">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Kategori Soal</label>
                                <select class="form-select category-dropdown" name="kategori_id" data-section="${self.sectionCount}">
                                    <option value="">Pilih Kategori</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Pilih Soal</label>
                                <div class="question-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
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
            ujian.ujian_sections.forEach((section, index) => {
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
                    <strong class="section-title m-0">${section.nama_section || `Seksi ${self.sectionCount}`}</strong>
                    </div>
                    <div class="text-muted section-toolbar d-flex align-items-center gap-2">
                    <span>${section.ujian_section_soals ? section.ujian_section_soals.length : 0} soal</span>
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
                    <p class="mb-0">Konten soal atau pengaturan lainnya.</p>

                    <form class="section-form">
                    <div class="mb-2">
                        <label class="form-label">Nama Seksi</label>
                        <input type="text" class="form-control section-nama-input" name="nama_section" placeholder="Nama Seksi" value="${section.nama_section || ''}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Bobot Nilai</label>
                        <input type="text" class="form-control" name="bobot_nilai" placeholder="Bobot Nilai" value="${section.bobot_nilai || ''}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Instruksi</label>
                        <textarea class="form-control" name="instruksi" rows="2" placeholder="Instruksi">${section.instruksi || ''}</textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Metode Penilaian</label>
                        <select class="form-select metode-penilaian-dropdown" name="metode_penilaian">
                        <option value="">Pilih Metode</option>
                        <option value="otomatis" ${section.metode_penilaian === 'otomatis' ? 'selected' : ''}>Otomatis</option>
                        <option value="manual" ${section.metode_penilaian === 'manual' ? 'selected' : ''}>Manual</option>
                        </select>
                    </div>
                    <div class="mb-2 formula-input-group" style="display: ${section.metode_penilaian === 'manual' ? 'block' : 'none'};">
                        <label class="form-label">Masukan Rumus Custom</label>
                        <small class="form-text text-muted">Contoh: <code>0.4 * A + 0.6 * B</code> (A = nilai soal pilihan ganda, B = nilai soal esai)</small>
                        <input type="text" class="form-control" name="formula" placeholder="Masukkan rumus" value="${section.formula || ''}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Kategori Soal</label>
                        <select class="form-select category-dropdown" name="kategori_id" data-section="${self.sectionCount}">
                        <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Pilih Soal</label>
                        <div class="question-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        <div class="text-muted text-center py-3">
                            <i class="bi bi-list-check fs-3 d-block mb-2"></i>
                            Soal is diambil dari kategori yang dipilih
                        </div>
                        </div>
                        <div class="mt-2">
                        <small class="text-muted">
                            <span class="selected-count">${section.ujian_section_soals ? section.ujian_section_soals.length : 0}</span> soal dipilih
                        </small>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
            `;

                $container.append(sectionHTML);
                console.log(section);
                console.log(`Loaded category ${section.kategori_id} for section ${self.sectionCount}`);
                // console.log(`Added section ${self.sectionCount}: ${section.kategori_id = 1} || Seksi ${self.sectionCount}`);

                // update sele

                // Load categories and set selected category if exists
                self.loadCategories(self.sectionCount).then(() => {
                    if (section.kategori_id) {
                        const $categoryDropdown = $(`.category-dropdown[data-section="${self.sectionCount}"]`);
                        $categoryDropdown.val(section.kategori_id);

                        // Load questions for this category
                        self.loadQuestionsIfExist(section.kategori_id, section.id, section.ujian_section_soals);
                    }
                });
            });
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
        $("#section-container").on("change", ".metode-penilaian-dropdown", function () {
            const $dropdown = $(this);
            const selectedValue = $dropdown.val();
            const $formulaGroup = $dropdown.closest('.section-form').find('.formula-input-group');

            if (selectedValue === 'manual') {
                $formulaGroup.show();
            } else {
                $formulaGroup.hide();
            }
        });

        // Handle category selection change
        $("#section-container").on("change", ".category-dropdown", function () {
            const $dropdown = $(this);
            const categoryId = $dropdown.val();
            const sectionId = $dropdown.data("section");

            if (categoryId) {
                self.loadQuestions(categoryId, sectionId);
            } else {
                // Clear questions
                const $questionContainer = $dropdown.closest('.section-form').find('.question-container');
                $questionContainer.html(`
                    <div class="text-muted text-center py-3">
                        <i class="bi bi-list-check fs-3 d-block mb-2"></i>
                        Pilih kategori terlebih dahulu untuk melihat soal
                    </div>
                `);
                self.updateSelectedCount($dropdown.closest('.section-form'));
            }
        });

        // Handle question checkbox changes
        $("#section-container").on("change", ".question-checkbox", function () {
            const $checkbox = $(this);
            const $form = $checkbox.closest('.section-form');
            self.updateSelectedCount($form);
            self.updateSectionQuestionCount($form);
        });
    };

    // Load categories from API
    DragulaSections.prototype.loadCategories = function (sectionId) {
        const $dropdown = $(`.category-dropdown[data-section="${sectionId}"]`);

        // Show loading state
        $dropdown.html('<option value="">Loading...</option>');

        return fetch('/filter/kategori')
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Pilih Kategori</option>';

                if (data && data.length > 0) {
                    data.forEach(category => {
                        options += `<option value="${category.id}">${category.nama}</option>`;
                    });
                } else {
                    options = '<option value="">Tidak ada kategori tersedia</option>';
                }

                $dropdown.html(options);
            })
            .catch(error => {
                // console.error('Error loading categories:', error);
                $dropdown.html('<option value="">Error loading categories</option>');
            });
    };

    // Load questions if they exist in the section
    DragulaSections.prototype.loadQuestionsIfExist = function (categoryId, sectionId, existingQuestions) {
        // console.log(`Loading questions for category ${categoryId} in section ${sectionId} with existing questions:`, existingQuestions);
        const $form = $(`.category-dropdown[data-section="${sectionId}"]`).closest('.section-form');
        const $questionContainer = $('.question-container');
        // console.log('Question container class:', $questionContainer.attr('class'));
        // console.log('Question container found:', $questionContainer.length ? 'Yes' : 'No');
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
        fetch(`/filter/ujian-sections-soals?kategori=${categoryId}&section_id=${sectionId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(response => {
                // console.log('Loaded questions:', response);
                let questionsHTML = '';
                const data = response.data || response; // Handle DataTables response format
                if (data && data.length > 0) {
                    data.forEach((question, index) => {
                        const questionText = question.pertanyaan || `Soal ${index + 1}`;
                        const questionId = question.id;
                        const tingkatKesulitan = question.tingkat_kesulitan
                            ? `<span class="badge bg-secondary-subtle text-dark small">${question.tingkat_kesulitan.nama}</span>`
                            : '';
                        const kategori = question.kategori
                            ? `<span class="badge bg-primary-subtle text-primary small">${question.kategori.nama}</span>`
                            : '';
                        const mediaIcon = question.is_audio
                            ? '<i class="ri-audio-line text-primary me-1"></i>'
                            : '<i class="ri-text-wrap text-muted me-1"></i>';
                        const isChecked = existingQuestions && existingQuestions.some(q => q.soal_id === questionId) ? 'checked' : '';
                        questionsHTML += `
                            <div class="question-box d-flex align-items-center justify-content-between mb-3 p-3 rounded shadow-sm bg-light-subtle">
                                <div class="content me-3 w-100">
                                    <div class="fw-medium text-dark mb-2 d-flex align-items-center" title="${questionText.replace(/"/g, '&quot;')}">
                                        ${mediaIcon}
                                        <span class="text-truncate">
                                            ${questionText.length > 100 ? questionText.substring(0, 100) + '...' : questionText}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        ${kategori}
                                        ${tingkatKesulitan}
                                    </div>
                                </div>
                                <div class="form-check ms-auto">
                                    <input class="form-check-input large-checkbox question-checkbox" type="checkbox"
                                        value="${questionId}" id="question-${sectionId}-${questionId}" ${isChecked}>
                                </div>
                            </div>
                        `;
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
                // console.log('Setting questions HTML:', questionsHTML);
                // console.log('Updating selected count for form:', $form);
                $questionContainer.html(questionsHTML);
                self.updateSelectedCount($form); // Use self instead of this
            })
            .catch(error => {
                // console.error('Error loading questions:', error);
                $questionContainer.html(`
                    <div class="text-danger text-center py-3">
                        <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                        Error memuat soal. Silakan coba lagi.
                    </div>
                `);
            });
    };

    // Load questions based on selected category
    DragulaSections.prototype.loadQuestions = function (categoryId, sectionId) {
        const $form = $(`.category-dropdown[data-section="${sectionId}"]`).closest('.section-form');
        const $questionContainer = $form.find('.question-container');

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
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(response => {
                let questionsHTML = '';
                const data = response.data || response; // Handle DataTables response format

                if (data && data.length > 0) {
                    data.forEach((question, index) => {
                        const questionText = question.pertanyaan || `Soal ${index + 1}`;
                        const questionId = question.id;

                        const tingkatKesulitan = question.tingkat_kesulitan
                            ? `<span class="badge bg-secondary-subtle text-dark small">${question.tingkat_kesulitan}</span>`
                            : '';

                        const kategori = question.kategori
                            ? `<span class="badge bg-primary-subtle text-primary small">${question.kategori}</span>`
                            : '';

                        const mediaIcon = question.is_audio
                            ? '<i class="ri-audio-line text-primary me-1"></i>'
                            : '<i class="ri-text-wrap text-muted me-1"></i>';

                        questionsHTML += `
                            <div class="question-box d-flex align-items-center justify-content-between mb-3 p-3 rounded shadow-sm bg-light-subtle">
                                <div class="content me-3 w-100">
                                    <div class="fw-medium text-dark mb-2 d-flex align-items-center" title="${questionText.replace(/"/g, '&quot;')}">
                                        ${mediaIcon}
                                        <span class="text-truncate">
                                            ${questionText.length > 100 ? questionText.substring(0, 100) + '...' : questionText}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        ${kategori}
                                        ${tingkatKesulitan}
                                    </div>
                                </div>

                                <div class="form-check ms-auto">
                                    <input class="form-check-input large-checkbox question-checkbox" type="checkbox"
                                        value="${questionId}" id="question-${sectionId}-${questionId}">
                                </div>
                            </div>
                        `;
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
            .catch(error => {
                // console.error('Error loading questions:', error);
                $questionContainer.html(`
                    <div class="text-danger text-center py-3">
                        <i class="bi bi-exclamation-triangle fs-3 d-block mb-2"></i>
                        Error memuat soal. Silakan coba lagi.
                    </div>
                `);
            });
    };

    // Update selected question count
    DragulaSections.prototype.updateSelectedCount = function ($form) {
        const selectedCount = $form.find('.question-checkbox:checked').length;
        $form.find('.selected-count').text(selectedCount);
    };

    // Update section question count in header
    DragulaSections.prototype.updateSectionQuestionCount = function ($form) {
        const selectedCount = $form.find('.question-checkbox:checked').length;
        const $section = $form.closest('.section-item');
        const $toolbar = $section.find('.section-toolbar span:first');
        $toolbar.text(`${selectedCount} soal`);
    };

    $(document).on('input', '.section-nama-input', function () {
        const $input = $(this);
        const $section = $input.closest('.section-item');
        const $title = $section.find('.section-title');
        const val = $input.val().trim();
        if (val) {
            $title.text(val);
        } else {
            // fallback to default
            const idx = $section.index() + 1;
            $title.text('Seksi ' + idx);
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
        const metode = document.getElementById('metode_penilaian').value;
        const group = document.getElementById('nilai_kelulusan_group');
        group.style.display = metode === 'rumus_custom' ? 'block' : 'none';
    }
    // document.addEventListener('DOMContentLoaded', toggleNilaiKelulusan);

    // Function to navigate to the next tab
    window.goToNextTab = function (targetTabId) {
        // Hide current active tab
        const $currentActiveTab = $('.tab-pane.show.active');
        const $currentActiveNavTab = $('.nav-link.active');

        $currentActiveTab.removeClass('show active');
        $currentActiveNavTab.removeClass('active').attr('aria-selected', 'false');

        // Show target tab
        const $targetTab = $('#' + targetTabId);
        const $targetNavTab = $('#' + targetTabId + '-tab');

        $targetTab.addClass('show active');
        $targetNavTab.addClass('active').attr('aria-selected', 'true');
    };

    // Function to get all section data for form submission
    window.getSectionData = function () {
        const sections = [];

        $('#section-container .section-item').each(function () {
            const $section = $(this);
            const $form = $section.find('.section-form');

            const sectionData = {
                nama_section: $form.find('input[name="nama_section"]').val(),
                bobot_nilai: $form.find('input[name="bobot_nilai"]').val(),
                instruksi: $form.find('textarea[name="instruksi"]').val(),
                metode_penilaian: $form.find('select[name="metode_penilaian"]').val(),
                kategori_id: $form.find('select[name="kategori_id"]').val(),
                selected_questions: []
            };

            $form.find('.question-checkbox:checked').each(function () {
                sectionData.selected_questions.push($(this).val());
            });

            sections.push(sectionData);
        });

        return sections;
    };

    // Function to handle saving ujian
    window.handleSaveUjian = function () {
        const sectionData = getSectionData();

        // Check if Swal is available
        if (typeof Swal === 'undefined') {
            // console.error('SweetAlert2 is not loaded');
            alert('Harap tambahkan minimal satu seksi ujian.'); // Fallback
            return;
        }

        // Validate that at least one section exists
        if (sectionData.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Harap tambahkan minimal satu seksi ujian.',
                confirmButtonText: 'OK'
            }).then(() => {
                goToNextTab('seksi');
            });
            return;
        }

        // Validate each section
        for (let i = 0; i < sectionData.length; i++) {
            const section = sectionData[i];

            if (!section.nama_section) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: `Harap isi nama seksi untuk Seksi ${i + 1}.`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    goToNextTab('seksi');
                });
                return;
            }

            if (section.selected_questions.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: `Harap pilih minimal satu soal untuk ${section.nama_section}.`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    goToNextTab('seksi');
                });
                return;
            }
        }

        // Show confirmation
        const totalQuestions = sectionData.reduce((total, section) => total + section.selected_questions.length, 0);
        const confirmMessage = `Anda akan menyimpan ujian dengan ${sectionData.length} seksi dan total ${totalQuestions} soal. Lanjutkan?`;

        Swal.fire({
            title: 'Konfirmasi',
            text: confirmMessage,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Here you would send the data to your Laravel backend
                // console.log('Section data to save:', sectionData);
                // cek url http://127.0.0.1:8000/ujian/6
                // get id from url

                let ujianId = null;
                const urlParts = window.location.pathname.split('/');
                let url = '/ujian';
                let method = 'POST';
                
                if (urlParts.length > 2 && urlParts[1] === 'ujian') {
                    const potentialId = urlParts[2];
                    if (potentialId && potentialId.match(/^\d+$/)) {
                        url += `/${potentialId}`;
                        method = 'PUT';
                    }
                }

                // Prepare form data with files
                const tampilanData = getTampilanData();
                
                // Add other data to FormData
                tampilanData.append('sections', JSON.stringify(sectionData));
                tampilanData.append('detail', JSON.stringify({
                    nama: $('#nama_ujian').val(),
                    deskripsi: $('#deskripsi').val(),
                    durasi: $('#durasi_ujian').val() || 120,
                    jenis_ujian: $('#jenis_ujian').val(),
                    tanggal_selesai: $('#tanggal_kedaluwarsa').val(),
                }));
                tampilanData.append('peserta', JSON.stringify({
                    nama: $('#nama').is(':checked'),
                    email: $('#email').is(':checked'),
                    phone: $('#telp').is(':checked'),
                    institusi: $('#sekolah').is(':checked'),
                    nomor_induk: $('#no_induk').is(':checked'),
                    tanggal_lahir: $('#tanggal_lahir').is(':checked'),
                    alamat: $('#alamat').is(':checked')
                }));
                tampilanData.append('pengaturan', JSON.stringify({
                    metode_penilaian: $('#metode_penilaian').val(),
                    nilai_kelulusan: $('#nilai_kelulusan').val(),
                    hasil_ujian: $('#hasil_ujian_tersedia').val(),
                }));

                $.ajax({
                    url: url,
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    data: tampilanData,
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Ujian berhasil disimpan!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/ujian';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error: ' + data.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // console.error('AJAX Error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan ujian.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        }).catch((error) => {
            // console.error('SweetAlert2 error:', error);
            // Fallback to regular confirm
            if (confirm(confirmMessage)) {
                // Continue with save logic using regular alerts
                // console.log('Using fallback confirmation');
            }
        });
    };
    // Prevent form submission on Enter key in section for

    // Theme and appearance functionality
    window.initThemePreview = function() {
        // Toggle custom colors visibility
        $('#use_custom_color').on('change', function() {
            if ($(this).is(':checked')) {
                $('#custom-colors').show();
                $('#default-colors').hide();
            } else {
                $('#custom-colors').hide();
                $('#default-colors').show();
            }
            updatePreview();
        });

        // Theme selection
        $('input[name="theme"]').on('change', function() {
            updatePreview();
        });

        // Color changes
        $('input[type="color"]').on('input', function() {
            updatePreview();
        });

        // Text input changes
        $('#institution_name, #welcome_message').on('input', function() {
            updatePreview();
        });

        // File upload preview
        $('#logo').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.preview-logo .logo-placeholder').html(`<img src="${e.target.result}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;">`);
                };
                reader.readAsDataURL(file);
            }
        });

        // Initial preview
        updatePreview();
        toggleCustomColors();
    };

    window.updatePreview = function() {
        const theme = $('input[name="theme"]:checked').val();
        const useCustomColor = $('#use_custom_color').is(':checked');
        const institutionName = $('#institution_name').val() || 'Nama Institusi';
        const welcomeMessage = $('#welcome_message').val() || 'Pesan sambutan akan ditampilkan di sini...';
        
        let colors = {};
        
        if (useCustomColor) {
            colors = {
                primary: $('#custom_color_1').val(),
                secondary: $('#custom_color_2').val(),
                accent: $('#custom_color_3').val()
            };
        } else {
            colors = {
                background: $('#background_color').val(),
                header: $('#header_color').val()
            };
        }

        applyThemeToPreview(theme, colors, institutionName, welcomeMessage, useCustomColor);
    };

    window.applyThemeToPreview = function(theme, colors, institutionName, welcomeMessage, useCustomColor) {
        const $preview = $('#live-preview');
        const $header = $preview.find('.preview-header');
        const $content = $preview.find('.preview-content');
        const $examCard = $preview.find('.exam-card');
        
        // Reset classes
        $preview.removeClass('classic-preview modern-preview glow-preview minimal-preview');
        $preview.addClass(theme + '-preview');
        
        // Update text content
        $('#preview-institution-name').text(institutionName);
        $('#preview-welcome-message').text(welcomeMessage);
        
        // Apply theme-specific styles
        switch(theme) {
            case 'classic':
                if (useCustomColor) {
                    $header.css({
                        'background': `linear-gradient(135deg, ${colors.primary} 0%, ${colors.secondary} 100%)`,
                        'color': '#fff'
                    });
                    $content.css('background', '#fff');
                    $examCard.css({
                        'background': colors.accent + '20',
                        'border-color': colors.accent
                    });
                } else {
                    $header.css({
                        'background': colors.header,
                        'color': '#333'
                    });
                    $content.css('background', colors.background);
                }
                break;
                
            case 'modern':
                if (useCustomColor) {
                    $header.css({
                        'background': `linear-gradient(135deg, ${colors.primary} 0%, ${colors.secondary} 100%)`,
                        'color': '#fff'
                    });
                    $content.css('background', '#f8f9fa');
                    $examCard.css({
                        'background': colors.accent + '20',
                        'border-color': colors.accent
                    });
                } else {
                    $header.css({
                        'background': 'linear-gradient(135deg, #0d6efd 0%, #0056b3 100%)',
                        'color': '#fff'
                    });
                    $content.css('background', colors.background);
                }
                break;
                
            case 'glow':
                if (useCustomColor) {
                    $header.css({
                        'background': `linear-gradient(135deg, ${colors.primary} 0%, ${colors.secondary} 50%, ${colors.accent} 100%)`,
                        'color': '#fff'
                    });
                } else {
                    $header.css({
                        'background': 'linear-gradient(135deg, #6f42c1 0%, #e83e8c 50%, #fd7e14 100%)',
                        'color': '#fff'
                    });
                }
                $content.css('background', 'linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%)');
                break;
                
            case 'minimal':
                if (useCustomColor) {
                    $header.css({
                        'background': colors.primary,
                        'color': '#fff'
                    });
                    $content.css('background', colors.secondary + '10');
                } else {
                    $header.css({
                        'background': colors.header,
                        'color': '#fff'
                    });
                    $content.css('background', colors.background);
                }
                break;
        }
    };

    window.toggleCustomColors = function() {
        const useCustomColor = $('#use_custom_color').is(':checked');
        if (useCustomColor) {
            $('#custom-colors').show();
            $('#default-colors').hide();
        } else {
            $('#custom-colors').hide();
            $('#default-colors').show();
        }
    };

    // Initialize on DOM ready
    $(document).ready(function() {
        if ($('#tampilan-form').length) {
            initThemePreview();
        }
        
        // Trigger initial state for custom colors
        $('#use_custom_color').trigger('change');
    });

    // Function to get tampilan data
    window.getTampilanData = function() {
        const formData = new FormData();
        
        // Theme data
        formData.append('theme', $('input[name="theme"]:checked').val() || 'classic');
        formData.append('institution_name', $('#institution_name').val() || '');
        formData.append('welcome_message', $('#welcome_message').val() || '');
        formData.append('use_custom_color', $('#use_custom_color').is(':checked') ? 1 : 0);
        
        // Colors
        if ($('#use_custom_color').is(':checked')) {
            formData.append('custom_color_1', $('#custom_color_1').val() || '');
            formData.append('custom_color_2', $('#custom_color_2').val() || '');
            formData.append('custom_color_3', $('#custom_color_3').val() || '');
        } else {
            formData.append('background_color', $('#background_color').val() || '#ffffff');
            formData.append('header_color', $('#header_color').val() || '#f8f9fa');
        }
        
        // Files
        const logoFile = $('#logo')[0].files[0];
        if (logoFile) {
            formData.append('logo', logoFile);
        }
        
        const backgroundFile = $('#background_image')[0].files[0];
        if (backgroundFile) {
            formData.append('background_image', backgroundFile);
        }
        
        const headerFile = $('#header_image')[0].files[0];
        if (headerFile) {
            formData.append('header_image', headerFile);
        }
        
        return formData;
    };

    // ...existing code...
})(window.jQuery);
