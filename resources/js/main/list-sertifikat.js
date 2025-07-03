import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import { Canvas, Textbox, ActiveSelection, FabricImage } from "fabric";

window.$ = $;
window.jQuery = $;

document.addEventListener("DOMContentLoaded", function () {
    // Check if we're on the certificate index page
    if (!document.getElementById("sertifikat-datatable")) {
        console.log("Certificate datatable not found, skipping initialization");
        return;
    }

    // Initialize DataTables for certificate list
    let table = $("#sertifikat-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: window.location.href,
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
            { data: "judul", name: "judul" },
            { data: "ujian_nama", name: "ujian_nama" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
        ],
        order: [[1, "asc"]],
        pageLength: 10,
        responsive: true,
        scrollX: true,
        language: {
            processing: "Memuat...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            loadingRecords: "Memuat...",
            zeroRecords: "Tidak ada data yang ditemukan",
            emptyTable: "Tidak ada data yang tersedia",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya",
            },
        },
    });

    let deleteId = null;

    // Handle preview button click
    $(document).on("click", ".btn-preview", function () {
        const id = $(this).data("id");

        // Make AJAX request to get certificate preview data
        $.ajax({
            url: `/sertifikat/${id}/preview`,
            type: "GET",
            success: function (response) {
                if (response.success) {
                    const data = response.data;

                    // Create modal content for preview
                    const modalContent = `
                <div class="modal fade" id="modal-preview" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen" style="padding: 30px;">
                        <div class="modal-content shadow-lg rounded-4">
                            <div class="modal-header">
                                <h5 class="modal-title">Preview Sertifikat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-4">
                                    <!-- LEFT PANEL: Detail Sertifikat -->
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <strong>Nama Sertifikat:</strong><br>
                                            <span class="text-muted">${
                                                data.judul
                                            }</span>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Untuk Ujian:</strong><br>
                                            <span class="text-muted">${
                                                data.ujian_nama
                                            }</span>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Status Template:</strong><br>
                                            <span class="badge ${
                                                data.template
                                                    ? "bg-success"
                                                    : "bg-warning"
                                            }">
                                                ${
                                                    data.template
                                                        ? "Sudah Dikonfigurasi"
                                                        : "Belum Dikonfigurasi"
                                                }
                                            </span>
                                        </div>
                                        <div class="mt-4 d-grid gap-2">
                                            <a href="/sertifikat/${id}/edit" class="btn btn-primary">
                                                <i class="ri-edit-line me-1"></i> Edit Template
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>

                                    <!-- RIGHT PANEL: PNG Preview -->
                                    <div class="col-md-10">
                                        <div class="border rounded bg-white p-4 d-flex flex-column align-items-center justify-content-center" 
                                            style="min-height: 600px; overflow: auto;">
                                            <div id="template-preview-container" class="w-100 d-flex justify-content-center align-items-center" style="min-height: 500px;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                    console.log("Preview data:", data);

                    // Remove existing modal if any
                    $("#modal-preview").remove();

                    // Append and show modal
                    $("body").append(modalContent);
                    $("#modal-preview").modal("show");

                    // Render template as PNG after modal shown
                    setTimeout(() => {
                        renderFabricTemplateAsImage(
                            "#template-preview-container",
                            data.template
                        );
                    }, 500);

                    // Clean DOM after hide
                    $("#modal-preview").on("hidden.bs.modal", function () {
                        $(this).remove();
                    });
                } else {
                    alert("Gagal memuat preview sertifikat");
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat memuat preview");
            },
        });
    });

    // Handle delete button click
    $(document).on("click", ".btn-delete", function () {
        deleteId = $(this).data("id");
        $("#modal-hapus").modal("show");
    });

    // Handle delete confirmation
    $("#btn-hapus-confirm").on("click", function () {
        if (deleteId) {
            const $button = $(this);
            const $spinner = $button.find(".spinner-border");

            // Show loading state
            $spinner.removeClass("d-none");
            $button.prop("disabled", true);

            // Send delete request
            $.ajax({
                url: `/sertifikat/${deleteId}`,
                type: "POST",
                data: {
                    _method: "DELETE",
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    $("#modal-hapus").modal("hide");

                    // Show success message
                    $("body").prepend(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> Sertifikat berhasil dihapus
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);

                    // Refresh table
                    table.ajax.reload();
                },
                error: function (xhr) {
                    $("#modal-hapus").modal("hide");

                    // Show error message
                    $("body").prepend(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> Gagal menghapus sertifikat
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
                complete: function () {
                    // Hide loading state
                    $spinner.addClass("d-none");
                    $button.prop("disabled", false);
                    deleteId = null;
                },
            });
        }
    });

    // Auto-hide alerts after 5 seconds
    $(document).on("click", ".alert .btn-close", function () {
        $(this).closest(".alert").fadeOut();
    });

    // Clean up preview modal when hidden
    $(document).on("hidden.bs.modal", "#modal-preview", function () {
        $(this).remove();
    });

    setTimeout(function () {
        $(".alert").fadeOut();
    }, 5000);

    // Function to render Fabric.js template as image
    async function renderFabricTemplateAsImage(wrapperSelector, templateJson) {
        const wrapper = document.querySelector(wrapperSelector);
        if (!wrapper) return;

        // Bersihkan wrapper
        wrapper.innerHTML = "";

        if (!templateJson) {
            wrapper.innerHTML = `
            <div class="alert alert-warning text-center">
                <i class="ri-exclamation-triangle-line me-2"></i>
                Template belum dikonfigurasi
                <br><small>Silakan edit sertifikat untuk mengatur template.</small>
            </div>
        `;
            return;
        }

        try {
            const fabricData =
                typeof templateJson === "string"
                    ? JSON.parse(templateJson)
                    : templateJson;
            const canvasWidth = fabricData.canvasWidth || 680;
            const canvasHeight = fabricData.canvasHeight || 600;

            // Buat canvas elemen (tidak dimasukkan ke DOM)
            const tempCanvasEl = document.createElement("canvas");
            tempCanvasEl.width = canvasWidth;
            tempCanvasEl.height = canvasHeight;

            const fabricCanvas = new Canvas(tempCanvasEl, {
                isDrawingMode: false,
                selection: false,
                width: canvasWidth,
                height: canvasHeight,
                backgroundColor: fabricData.background || "#fff",
            });

            await fabricCanvas.loadFromJSON(fabricData);

            // Disable interaksi
            fabricCanvas.forEachObject((obj) => {
                obj.selectable = false;
                obj.evented = false;
            });

            fabricCanvas.renderAll();

            // Export as PNG
            const dataURL = fabricCanvas.toDataURL({
                format: "png",
                quality: 1,
                multiplier: 2, // Untuk resolusi tinggi
            });

            // Tampilkan sebagai <img>
            const imgElement = document.createElement("img");
            imgElement.src = dataURL;
            imgElement.alt = "Preview Sertifikat";
            imgElement.style.maxWidth = "100%";
            imgElement.style.height = "auto";
            imgElement.style.border = "1px solid #ddd";
            imgElement.style.borderRadius = "8px";

            wrapper.appendChild(imgElement);
        } catch (error) {
            console.error("Error rendering template as PNG:", error);
            wrapper.innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="ri-error-warning-line me-2"></i>
                Error rendering template as Image
                <br><small>Template data might be corrupted.</small>
            </div>
        `;
        }
    }
});
