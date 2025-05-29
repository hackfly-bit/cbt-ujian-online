import dragula from "dragula/dist/dragula.min.js";

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

            const container = $("#section-container");
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
                    </div>
                </div>
            `;

            container.append(sectionHTML);
        });

        // Accordion collapse logic
        document.addEventListener("click", function (e) {
            if (e.target.closest(".chevron-toggle")) {
                const btn = e.target.closest(".chevron-toggle");
                const targetId = btn.getAttribute("data-bs-target");
                const container = document.getElementById("section-container");
                const openCollapses =
                    container.querySelectorAll(".collapse.show");

                openCollapses.forEach(function (collapse) {
                    if ("#" + collapse.id !== targetId) {
                        new bootstrap.Collapse(collapse).hide();
                    }
                });
            }
        });
    };

    // Inisialisasi
    $.DragulaSections = new DragulaSections();
    $.DragulaSections.Constructor = DragulaSections;
})(window.jQuery);

(function ($) {
    "use strict";
    $.DragulaSections.init();
})(window.jQuery);
