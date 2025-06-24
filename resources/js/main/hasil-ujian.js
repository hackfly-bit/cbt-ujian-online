import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import { Canvas, Textbox, ActiveSelection, FabricImage, util } from "fabric";
// import { validateCertificateTemplate, generatePreviewData } from '../utils/certificate-template.js';

window.$ = $;
window.jQuery = $;

(function () {
    let table;

    // Initialize DataTables
    initDataTable();

    // Event handlers
    handleDetailClick();
    handleCertificateClick();
    handleDownloadResults();

    function initDataTable() {
        table = $("#hasil-ujian-datatable").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "/hasil-ujian",
                type: "GET",
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
                    data: "peserta_nama",
                    name: "peserta.nama",
                    render: function (data, type, row) {
                        return data || "-";
                    },
                },
                {
                    data: "ujian_nama",
                    name: "ujian.nama_ujian",
                    render: function (data, type, row) {
                        return data || "-";
                    },
                },
                {
                    data: "waktu_selesai_formatted",
                    name: "waktu_selesai",
                    className: "text-center",
                    render: function (data, type, row) {
                        return data || "-";
                    },
                },
                {
                    data: "skor_formatted",
                    name: "hasil_nilai",
                    className: "text-center",
                    render: function (data, type, row) {
                        const skor = parseFloat(data);
                        let badgeClass = "bg-secondary";

                        if (skor >= 600) {
                            badgeClass = "bg-primary"; // tingkat lanjutan/akademik
                        } else if (skor >= 500) {
                            badgeClass = "bg-success"; // mahir
                        } else if (skor >= 400) {
                            badgeClass = "bg-warning"; // menengah
                        } else if (skor >= 310) {
                            badgeClass = "bg-danger"; // dasar
                        }

                        return `<span class="badge ${badgeClass} badge-status">${data}</span>`;
                    },
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    className: "action-icons text-center",
                },
            ],
            language: {
                paginate: {
                    previous: "<i class='ri-arrow-left-s-line'></i>",
                    next: "<i class='ri-arrow-right-s-line'></i>",
                },
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ hasil",
                infoEmpty: "Menampilkan 0 hingga 0 dari 0 hasil",
                infoFiltered: "(disaring dari _MAX_ total hasil)",
                lengthMenu: "Tampilkan _MENU_ hasil",
                search: "Cari:",
                zeroRecords: "Tidak ada data yang sesuai ditemukan.",
                processing: "Memproses...",
                loadingRecords: "Memuat...",
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
    }

    function handleDetailClick() {
        $(document).on("click", ".btn-detail", function () {
            const id = $(this).data("id");
            showDetailModal(id);
        });
    }

    function handleCertificateClick() {
        $(document).on("click", ".btn-certificate", function () {
            const id = $(this).data("id");
            showCertificateModal(id);
        });
    }

    function handleDownloadResults() {
        $("#btn-download-results").on("click", function () {
            downloadResults();
        });

        $("#btn-download-certificate").on("click", function () {
            downloadCertificate();
        });
    }

    function showDetailModal(id) {
        $.ajax({
            url: `/hasil-ujian/${id}`,
            type: "GET",
            beforeSend: function () {
                $("#detail-content").html(`
                    <div class="text-center py-3">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat detail hasil ujian...</p>
                    </div>
                `);
                $("#modal-detail").modal("show");
            },
            success: function (response) {
                if (response.success) {
                    const data = response.data;
                    const detailHtml = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Informasi Peserta</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%">Nama</td>
                                        <td>: ${data.peserta.nama}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: ${data.peserta.email}</td>
                                    </tr>
                                </table>

                                <h6 class="fw-bold mb-3 mt-4">Informasi Ujian</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%">Nama Ujian</td>
                                        <td>: ${data.ujian.nama_ujian}</td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>: ${data.ujian.deskripsi}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Hasil Ujian</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%">Total Soal</td>
                                        <td>: ${data.hasil.total_soal}</td>
                                    </tr>
                                    <tr>
                                        <td>Soal Dijawab</td>
                                        <td>: ${data.hasil.soal_dijawab}</td>
                                    </tr>
                                    <tr>
                                        <td>Jawaban Benar</td>
                                        <td>: ${data.hasil.jawaban_benar}</td>
                                    </tr>
                                    <tr>
                                        <td>Nilai Akhir</td>
                                        <td>: <span class="fw-bold text-primary">${
                                            data.hasil.hasil_nilai
                                        }</span></td>
                                    </tr>
                                    <tr>
                                        <td>Durasi</td>
                                        <td>: ${
                                            data.hasil.durasi_pengerjaan
                                        }</td>
                                    </tr>
                                </table>

                                <h6 class="fw-bold mb-3 mt-4">Waktu Pengerjaan</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%">Mulai</td>
                                        <td>: ${data.waktu.waktu_mulai}</td>
                                    </tr>
                                    <tr>
                                        <td>Selesai</td>
                                        <td>: ${data.waktu.waktu_selesai}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: <span class="badge bg-success">${
                                            data.status
                                        }</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        ${
                            data.detail_section
                                ? `
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">Detail Per Seksi</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Seksi</th>
                                                    <th class="text-center">Total Soal</th>
                                                    <th class="text-center">Dijawab</th>
                                                    <th class="text-center">Benar</th>
                                                    <th class="text-center">Skor (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${data.detail_section
                                                    .map(
                                                        (section) => `
                                                    <tr>
                                                        <td>${section.section_name}</td>
                                                        <td class="text-center">${section.total_questions}</td>
                                                        <td class="text-center">${section.answered_questions}</td>
                                                        <td class="text-center">${section.correct_answers}</td>
                                                        <td class="text-center">${section.score_percentage}%</td>
                                                    </tr>
                                                `
                                                    )
                                                    .join("")}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        `
                                : ""
                        }
                    `;

                    $("#detail-content").html(detailHtml);
                } else {
                    $("#detail-content").html(`
                        <div class="alert alert-danger">
                            <i class="ri-error-warning-line me-2"></i>
                            ${
                                response.message ||
                                "Gagal memuat detail hasil ujian"
                            }
                        </div>
                    `);
                }
            },
            error: function (xhr, status, error) {
                $("#detail-content").html(`
                    <div class="alert alert-danger">
                        <i class="ri-error-warning-line me-2"></i>
                        Terjadi kesalahan saat memuat data. Silakan coba lagi.
                    </div>
                `);
            },
        });
    }

    function showCertificateModal(id) {
        $.ajax({
            url: `/hasil-ujian/${id}/sertifikat`,
            type: "GET",
            beforeSend: function () {
                $("#modal-certificate #certificate-content").html(`
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `);
                $("#modal-certificate").modal("show");
            },
            success: function (response) {
                if (response.success && response.data.sertifikat) {
                    const templateData = response.data.sertifikat;
                    const templateVars = response.data.template_data;

                    // Update Left Panel
                    $("#certificate-title").text(response.data.judul || "-");
                    $("#certificate-ujian").text(
                        response.data.ujian_nama || "-"
                    );
                    $("#certificate-status")
                        .removeClass("bg-success bg-warning")
                        .addClass(
                            response.data.template ? "bg-success" : "bg-warning"
                        )
                        .text(
                            response.data.template
                                ? "Sudah Dikonfigurasi"
                                : "Belum Dikonfigurasi"
                        );

                    // Replace placeholders in template
                    templateData.objects = templateData.objects.map((obj) => {
                        if (obj.type === "Textbox" && obj.text) {
                            obj.text = obj.text
                                .replace(
                                    "[Nama Lengkap]",
                                    templateVars.peserta_nama
                                )
                                .replace("[Nilai]", templateVars.nilai)
                                .replace(
                                    "[Tanggal Ujian]",
                                    templateVars.tanggal_selesai
                                );
                        }
                        return obj;
                    });

                    // Render
                    renderFabricTemplateAsImage(
                        "#certificate-content",
                        templateData
                    )
                        .then((dataURL) => {
                            // Download button
                            $("#btn-download-certificate")
                                .off("click")
                                .on("click", function () {
                                    const link = document.createElement("a");
                                    link.href = dataURL;
                                    link.download = "sertifikat.png";
                                    link.click();
                                });

                            // Print button
                            $("#btn-print-certificate")
                                .off("click")
                                .on("click", function () {
                                    const printWindow = window.open(
                                        "",
                                        "_blank"
                                    );
                                    printWindow.document.write(`
                                <html>
                                    <head>
                                        <title>Print Sertifikat</title>
                                    </head>
                                    <body style="text-align: center; padding: 30px;">
                                        <img src="${dataURL}" style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                                        <script>
                                            window.onload = function() { window.print(); window.onafterprint = window.close; };
                                        </script>
                                    </body>
                                </html>
                            `);
                                    printWindow.document.close();
                                });
                        })
                        .catch((error) => {
                            console.error("Error rendering template:", error);
                            $("#certificate-content").html(`
                            <div class="alert alert-danger text-dark w-100 text-center py-5">
                                <i class="ri-error-warning-line me-2"></i>
                                Gagal memuat template sertifikat: ${error.message}
                            </div>
                        `);
                        });
                } else {
                    $("#certificate-content").html(`
                    <div class="alert alert-warning text-dark text-center py-5">
                        <i class="ri-information-line me-2"></i>
                        ${response.message || "Sertifikat tidak tersedia"}
                    </div>
                `);
                }
            },
            error: function () {
                $("#certificate-content").html(`
                <div class="alert alert-danger text-dark text-center py-5">
                    <i class="ri-error-warning-line me-2"></i>
                    Terjadi kesalahan saat memuat sertifikat. Silakan coba lagi.
                </div>
            `);
            },
        });
    }

    async function renderFabricTemplateAsImage(wrapperSelector, templateJson) {
        const wrapper = document.querySelector(wrapperSelector);
        if (!wrapper) return;

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

            fabricCanvas.forEachObject((obj) => {
                obj.selectable = false;
                obj.evented = false;
            });

            fabricCanvas.renderAll();

            const dataURL = fabricCanvas.toDataURL({
                format: "png",
                quality: 1,
                multiplier: 2,
            });

            const imgElement = document.createElement("img");
            imgElement.src = dataURL;
            imgElement.alt = "Preview Sertifikat";
            imgElement.style.maxWidth = "100%";
            imgElement.style.height = "auto";
            imgElement.style.border = "1px solid #ddd";
            imgElement.style.borderRadius = "8px";

            wrapper.appendChild(imgElement);

            return dataURL;
        } catch (error) {
            console.error("Error rendering template as PNG:", error);
            wrapper.innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="ri-error-warning-line me-2"></i>
                Error rendering template as Image
                <br><small>Template data might be corrupted.</small>
            </div>
        `;
            throw error;
        }
    }

    function downloadResults() {
        $.ajax({
            url: "/hasil-ujian/download/results",
            type: "GET",
            beforeSend: function () {
                $("#btn-download-results")
                    .prop("disabled", true)
                    .html(
                        '<i class="ri-loader-2-line me-1 spinner-border spinner-border-sm"></i> Memproses...'
                    );
            },
            success: function (response) {
                if (response.success) {
                    // Show success message
                    showAlert("success", "Download berhasil", response.message);

                    // Here you would normally trigger actual file download
                    // For now, just show the data count
                    console.log("Download data:", response.data);
                } else {
                    showAlert(
                        "error",
                        "Download gagal",
                        response.message || "Terjadi kesalahan saat mendownload"
                    );
                }
            },
            error: function (xhr, status, error) {
                showAlert(
                    "error",
                    "Download gagal",
                    "Terjadi kesalahan saat mendownload. Silakan coba lagi."
                );
            },
            complete: function () {
                $("#btn-download-results")
                    .prop("disabled", false)
                    .html(
                        '<i class="ri-download-line me-1"></i> Download Hasil Ujian'
                    );
            },
        });
    }

    function downloadCertificate() {
        // Check if there's an active certificate canvas
        const modal = $("#modal-certificate");
        if (modal.hasClass("show")) {
            const canvas = window.certificateCanvas; // We'll store this globally
            if (canvas) {
                downloadCertificateImage(
                    canvas,
                    window.certificateTemplateData
                );
                return;
            }
        }

        // Fallback to browser print
        window.print();
    }

    function downloadCertificateImage(canvas, templateData) {
        try {
            // Create high-quality image
            const originalZoom = canvas.getZoom();
            const originalWidth = canvas.width;
            const originalHeight = canvas.height;

            // Temporarily increase resolution for better quality
            const scale = 2; // 2x resolution
            canvas.setZoom(originalZoom * scale);
            canvas.setDimensions({
                width: originalWidth * scale,
                height: originalHeight * scale,
            });

            // Generate image
            const dataURL = canvas.toDataURL({
                format: "png",
                quality: 1.0,
                multiplier: 1,
            });

            // Restore original dimensions
            canvas.setZoom(originalZoom);
            canvas.setDimensions({
                width: originalWidth,
                height: originalHeight,
            });

            // Create download link
            const link = document.createElement("a");
            link.download = `Sertifikat_${
                templateData.peserta_nama || "Peserta"
            }_${templateData.ujian_nama || "Ujian"}.png`;
            link.href = dataURL;

            // Trigger download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            showAlert(
                "success",
                "Download Berhasil",
                "Sertifikat berhasil didownload"
            );
        } catch (error) {
            console.error("Error downloading certificate:", error);
            showAlert(
                "error",
                "Download Gagal",
                "Terjadi kesalahan saat mendownload sertifikat"
            );
        }
    }

    function printCertificate(canvas) {
        try {
            // Create a new window for printing
            const printWindow = window.open(
                "",
                "_blank",
                "width=800,height=600"
            );

            if (!printWindow) {
                showAlert(
                    "error",
                    "Print Gagal",
                    "Popup diblokir. Mohon izinkan popup untuk print"
                );
                return;
            }

            // Generate high-quality image for printing
            const dataURL = canvas.toDataURL({
                format: "png",
                quality: 1.0,
                multiplier: 2,
            });

            // Create print document
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Sertifikat</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 20px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            min-height: 100vh;
                            background: white;
                        }
                        .certificate-print {
                            max-width: 100%;
                            max-height: 100%;
                            box-shadow: none;
                        }
                        @media print {
                            body {
                                padding: 0;
                            }
                            .certificate-print {
                                width: 100%;
                                height: auto;
                            }
                        }
                    </style>
                </head>
                <body>
                    <img src="${dataURL}" class="certificate-print" alt="Sertifikat" />
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 100);
                        };
                    </script>
                </body>
                </html>
            `;

            printWindow.document.write(printContent);
            printWindow.document.close();
        } catch (error) {
            console.error("Error printing certificate:", error);
            showAlert(
                "error",
                "Print Gagal",
                "Terjadi kesalahan saat mencetak sertifikat"
            );
        }
    }

    function showAlert(type, title, message) {
        const alertClass =
            type === "success" ? "alert-success" : "alert-danger";
        const icon =
            type === "success" ? "ri-check-line" : "ri-error-warning-line";

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${icon} me-2"></i>
                <strong>${title}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Insert alert at the top of the card body
        $(".card-body").prepend(alertHtml);

        // Auto remove after 5 seconds
        setTimeout(() => {
            $(".alert").fadeOut(() => {
                $(".alert").remove();
            });
        }, 5000);
    }

    // Utility functions for Fabric.js
    function resizeCanvasToContainer(canvas, container) {
        const containerWidth = $(container).width() - 40; // 40px for padding
        const canvasWidth = canvas.width;
        const canvasHeight = canvas.height;

        if (containerWidth < canvasWidth) {
            const scale = containerWidth / canvasWidth;
            canvas.setDimensions({
                width: containerWidth,
                height: canvasHeight * scale,
            });
            canvas.setZoom(scale);
        }

        canvas.renderAll();
    }

    function replacePlaceholders(canvas, templateData) {
        const placeholders = {
            "{{peserta_nama}}": templateData.peserta_nama || "",
            "{{ujian_nama}}": templateData.ujian_nama || "",
            "{{nilai}}": templateData.nilai || "",
            "{{tanggal_selesai}}": templateData.tanggal_selesai || "",
            "{{nomor_sertifikat}}": templateData.nomor_sertifikat || "",
            "{{level}}": templateData.level || "",
            "{{institusi}}":
                templateData.institusi || "Institusi Penyelenggara",
            "{{tanggal_terbit}}": new Date().toLocaleDateString("id-ID", {
                year: "numeric",
                month: "long",
                day: "numeric",
            }),
            "{{tahun}}": new Date().getFullYear().toString(),
        };

        canvas.getObjects().forEach(function (obj) {
            if (obj.type === "text" || obj.type === "textbox") {
                let text = obj.text || "";

                Object.keys(placeholders).forEach((placeholder) => {
                    text = text.replace(
                        new RegExp(placeholder, "g"),
                        placeholders[placeholder]
                    );
                });

                obj.set("text", text);
            }
        });
    }

    function setupViewOnlyCanvas(canvas) {
        canvas.selection = false;
        canvas.hoverCursor = "default";
        canvas.moveCursor = "default";
        canvas.defaultCursor = "default";

        canvas.getObjects().forEach(function (obj) {
            obj.selectable = false;
            obj.evented = false;
            obj.hoverCursor = "default";
            obj.moveCursor = "default";
        });
    }

    // Window resize handler for responsive canvas
    $(window).on("resize", function () {
        if (window.certificateCanvas) {
            setTimeout(() => {
                resizeCanvasToContainer(
                    window.certificateCanvas,
                    "#certificate-content"
                );
            }, 100);
        }
    });
})();
