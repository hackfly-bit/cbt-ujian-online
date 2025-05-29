import dragula from "dragula/dist/dragula.min.js";
import jQuery from "jquery/dist/jquery.min.js";

(function ($) {
    "use strict";



    var DragulaSections = function () {
        this.$body = $("body");
        this.sectionCount = 0;
    };

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
                                <select class="form-select" name="metode_penilaian">
                                    <option value="">Pilih Metode</option>
                                    <option value="otomatis">Otomatis</option>
                                    <option value="manual">Manual</option>
                                </select>
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

        fetch('/filter/kategori')
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
                console.error('Error loading categories:', error);
                $dropdown.html('<option value="">Error loading categories</option>');
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

        fetch(`/filter/soals?kategori_id=${categoryId}`)
            .then(response => response.json())
            .then(response => {
                let questionsHTML = '';
                const data = response.data || response; // Handle both response formats

                if (data && data.length > 0) {
                    data.forEach((question, index) => {
                        const questionText = question.pertanyaan || question.soal || question.question || `Soal ${index + 1}`;
                        const questionId = question.id;

                        const tingkatKesulitan = question.tingkat_kesulitan?.nama
                            ? `<span class="badge rounded-pill bg-soft-info text-dark me-2 d-flex align-items-center gap-1 px-2 py-1">
                                    <i class="bi bi-bar-chart-line"></i> ${question.tingkat_kesulitan.nama}
                                </span>` : '';

                        const subKategori = question.sub_kategori?.nama
                            ? `<span class="badge rounded-pill bg-soft-secondary text-dark d-flex align-items-center gap-1 px-2 py-1">
                                    <i class="bi bi-tag"></i> ${question.sub_kategori.nama}
                                </span>` : '';

                        questionsHTML += `
                            <div class="question-box d-flex align-items-center justify-content-between mb-3 p-3 rounded shadow-sm bg-light-subtle">
                                <div class="content me-3 w-100">
                                    <div class="fw-medium text-dark text-truncate mb-2" title="${questionText.replace(/"/g, '&quot;')}">
                                        ${questionText.length > 100 ? questionText.substring(0, 100) + '...' : questionText}
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        ${subKategori ? `<span class="badge bg-primary-subtle text-primary small">${subKategori}</span>` : ''}
                                        ${tingkatKesulitan ? `<span class="badge bg-secondary-subtle text-dark small">${tingkatKesulitan}</span>` : ''}
                                    </div>
                                </div>

                                <div class="form-check ms-auto">
                                    <input class="form-check-input large-checkbox" type="checkbox"
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
                console.error('Error loading questions:', error);
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

        // Validate that at least one section exists
        if (sectionData.length === 0) {
            alert('Harap tambahkan minimal satu seksi ujian.');
            goToNextTab('seksi');
            return;
        }

        // Validate each section
        for (let i = 0; i < sectionData.length; i++) {
            const section = sectionData[i];

            if (!section.nama_section) {
                alert(`Harap isi nama seksi untuk Seksi ${i + 1}.`);
                goToNextTab('seksi');
                return;
            }

            if (section.selected_questions.length === 0) {
                alert(`Harap pilih minimal satu soal untuk ${section.nama_section}.`);
                goToNextTab('seksi');
                return;
            }
        }

        // Show confirmation
        const totalQuestions = sectionData.reduce((total, section) => total + section.selected_questions.length, 0);
        const confirmMessage = `Anda akan menyimpan ujian dengan ${sectionData.length} seksi dan total ${totalQuestions} soal. Lanjutkan?`;

        if (confirm(confirmMessage)) {
            // Here you would send the data to your Laravel backend
            console.log('Section data to save:', sectionData);

            // Example: Send to backend
            // fetch('/ujian/store', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({
            //         sections: sectionData
            //         // Add other ujian data here
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         alert('Ujian berhasil disimpan!');
            //         window.location.href = '/ujian';
            //     } else {
            //         alert('Error: ' + data.message);
            //     }
            // })
            // .catch(error => {
            //     console.error('Error:', error);
            //     alert('Terjadi kesalahan saat menyimpan ujian.');
            // });

            alert('Data ujian siap disimpan! (Integrasi dengan backend belum diimplementasikan)');
        }
    };

})(window.jQuery);
