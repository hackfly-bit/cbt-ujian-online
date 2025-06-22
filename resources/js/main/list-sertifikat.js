import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import { Canvas, Textbox, ActiveSelection, FabricImage } from "fabric";



window.$ = $;
window.jQuery = $;


document.addEventListener("DOMContentLoaded", function () {
    // Check if we're on the certificate index page
    if (!document.getElementById('sertifikat-datatable')) {
        console.log('Certificate datatable not found, skipping initialization');
        return;
    }

    // Initialize DataTables for certificate list
    let table = $('#sertifikat-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: window.location.href,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'judul', name: 'judul' },
            { data: 'ujian_nama', name: 'ujian_nama' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        responsive: true,
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
                previous: "Sebelumnya"
            }
        }
    });

    let deleteId = null;

    // Handle preview button click
    $(document).on('click', '.btn-preview', function () {
        const id = $(this).data('id');

        // Make AJAX request to get certificate preview data
        $.ajax({
            url: `/sertifikat/${id}/preview`,
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    const data = response.data;

                    // Create modal content for preview
                    const modalContent = `
                        <div class="modal fade" id="modal-preview" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Preview Sertifikat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <strong>Nama Sertifikat:</strong><br>
                                                    <span class="text-muted">${data.judul}</span>
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Untuk Ujian:</strong><br>
                                                    <span class="text-muted">${data.ujian_nama}</span>
                                                </div>
                                                <div class="mb-3">
                                                    <strong>Status Template:</strong><br>
                                                    <span class="badge ${data.template ? 'bg-success' : 'bg-warning'}">
                                                        ${data.template ? 'Sudah Dikonfigurasi' : 'Belum Dikonfigurasi'}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="border rounded p-3 bg-light">
                                                    <strong>Preview Template:</strong>
                                                    <div class="mt-3 text-center" style="min-height: 400px;" id="template-preview-container">
                                                        <div class="d-flex justify-content-center align-items-center" style="min-height: 400px;">
                                                            <div class="spinner-border text-primary" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="/sertifikat/${id}/edit" class="btn btn-primary">
                                            <i class="ri-edit-line me-1"></i> Edit Template
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    console.log('Preview data:', data);

                    // Remove existing modal if any
                    $('#modal-preview').remove();

                    // Append and show modal
                    $('body').append(modalContent);
                    $('#modal-preview').modal('show');

                    // Render Fabric.js template as image after modal is shown
                    setTimeout(() => {
                        renderFabricTemplate(data.template);
                    }, 500);
                } else {
                    alert('Gagal memuat preview sertifikat');
                }
            },
            error: function () {
                alert('Terjadi kesalahan saat memuat preview');
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function () {
        deleteId = $(this).data('id');
        $('#modal-hapus').modal('show');
    });

    // Handle delete confirmation
    $('#btn-hapus-confirm').on('click', function () {
        if (deleteId) {
            const $button = $(this);
            const $spinner = $button.find('.spinner-border');

            // Show loading state
            $spinner.removeClass('d-none');
            $button.prop('disabled', true);

            // Send delete request
            $.ajax({
                url: `/sertifikat/${deleteId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#modal-hapus').modal('hide');

                    // Show success message
                    $('body').prepend(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i> Sertifikat berhasil dihapus
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);

                    // Refresh table
                    table.ajax.reload();
                },
                error: function (xhr) {
                    $('#modal-hapus').modal('hide');

                    // Show error message
                    $('body').prepend(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> Gagal menghapus sertifikat
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
                complete: function () {
                    // Hide loading state
                    $spinner.addClass('d-none');
                    $button.prop('disabled', false);
                    deleteId = null;
                }
            });
        }
    });

    // Auto-hide alerts after 5 seconds
    $(document).on('click', '.alert .btn-close', function () {
        $(this).closest('.alert').fadeOut();
    });

    // Clean up preview modal when hidden
    $(document).on('hidden.bs.modal', '#modal-preview', function () {
        $(this).remove();
    });

    setTimeout(function () {
        $('.alert').fadeOut();
    }, 5000);

    // Function to render Fabric.js template as image
    async function renderFabricTemplate(templateJson) {
        const container = document.getElementById('template-preview-container');
        const canvas_container = document.getElementsByClassName('canvas-container');

        if (!templateJson) {
            container.innerHTML = `
            <div class="alert alert-warning text-center">
                <i class="ri-exclamation-triangle-line me-2"></i>
                Template belum dikonfigurasi
                <br><small>Silakan edit sertifikat untuk mengatur template.</small>
            </div>
        `;
            return;
        }

        try {
            const fabricData = typeof templateJson === 'string' ? JSON.parse(templateJson) : templateJson;
            const canvasWidth = fabricData.canvasWidth || 680;
            const canvasHeight = fabricData.canvasHeight || 600;

            // Create canvas with responsive styling
            const canvas = document.createElement('canvas');
            canvas.width = canvasWidth;
            canvas.height = canvasHeight;
            canvas.style.border = '1px solid #ddd';
            canvas.style.width = '100%';
            canvas.style.height = 'auto';
            canvas.style.maxWidth = '100%';
            canvas.style.display = 'block';

            // Set container to maintain aspect ratio
            container.style.width = '100%';
            container.style.position = 'relative';

            // canvas_container.style.width = '680px ';
            // canvas_container.style.height = '600px';

            container.innerHTML = '';
            container.appendChild(canvas);

            const fabricCanvas = new Canvas(canvas, {
                isDrawingMode: false,
                selection: false,
                width: canvasWidth,
                height: canvasHeight,
                backgroundColor: fabricData.background || '#fff'
            });

            await fabricCanvas.loadFromJSON(fabricData);

            fabricCanvas.forEachObject(function (obj) {
                obj.selectable = false;
                obj.evented = false;
                obj.hoverCursor = 'default';
                obj.moveCursor = 'default';
            });

            fabricCanvas.renderAll();

            // Auto-resize canvas when container size changes
            const resizeObserver = new ResizeObserver(() => {
                const containerWidth = container.clientWidth;
                const aspectRatio = canvasHeight / canvasWidth;
                const newHeight = containerWidth * aspectRatio;

                canvas.style.width = containerWidth + 'px';
                canvas.style.height = newHeight + 'px';
            });

            resizeObserver.observe(container);

        } catch (error) {
            console.error('Error rendering template:', error);
            container.innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="ri-error-warning-line me-2"></i>
                Error loading template
                <br><small>Template data might be corrupted.</small>
            </div>
        `;
        }
    }
});


