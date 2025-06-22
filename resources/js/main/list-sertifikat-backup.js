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
    $(document).on('click', '.btn-preview', function() {
        const id = $(this).data('id');
        
        // Make AJAX request to get certificate preview data
        $.ajax({
            url: `/sertifikat/${id}/preview`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    // Create modal content for preview
                    const modalContent = `
                        <div class="modal fade" id="modal-preview" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Preview Sertifikat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Nama Sertifikat:</strong></div>
                                            <div class="col-sm-9">${data.judul}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Untuk Ujian:</strong></div>
                                            <div class="col-sm-9">${data.ujian_nama}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Template:</strong>
                                                <div class="mt-2 p-3 border rounded bg-light">
                                                    ${data.template ? 'Template telah dikonfigurasi' : 'Template belum dikonfigurasi'}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Remove existing modal if any
                    $('#modal-preview').remove();
                    
                    // Append and show modal
                    $('body').append(modalContent);
                    $('#modal-preview').modal('show');
                } else {
                    alert('Gagal memuat preview sertifikat');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat memuat preview');
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function() {
        deleteId = $(this).data('id');
        $('#modal-hapus').modal('show');
    });

    // Handle delete confirmation
    $('#btn-hapus-confirm').on('click', function() {
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
                success: function(response) {
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
                error: function(xhr) {
                    $('#modal-hapus').modal('hide');
                    
                    // Show error message
                    $('body').prepend(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> Gagal menghapus sertifikat
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
                complete: function() {
                    // Hide loading state
                    $spinner.addClass('d-none');
                    $button.prop('disabled', false);
                    deleteId = null;
                }
            });
        }
    });

    // Auto-hide alerts after 5 seconds
    $(document).on('click', '.alert .btn-close', function() {
        $(this).closest('.alert').fadeOut();
    });
    
    // Clean up preview modal when hidden
    $(document).on('hidden.bs.modal', '#modal-preview', function () {
        $(this).remove();
    });
    
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
});

        // Make AJAX request to get certificate preview data
        $.ajax({
            url: `/sertifikat/${id}/preview`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    // Create modal content for preview
                    const modalContent = `
                        <div class="modal fade" id="modal-preview" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Preview Sertifikat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Nama Sertifikat:</strong></div>
                                            <div class="col-sm-9">${data.judul}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Untuk Ujian:</strong></div>
                                            <div class="col-sm-9">${data.ujian_nama}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Template:</strong>
                                                <div class="mt-2 p-3 border rounded bg-light">
                                                    ${data.template ? 'Template telah dikonfigurasi' : 'Template belum dikonfigurasi'}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Remove existing modal if any
                    $('#modal-preview').remove();

                    // Append and show modal
                    $('body').append(modalContent);
                    $('#modal-preview').modal('show');
                } else {
                    alert('Gagal memuat preview sertifikat');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat memuat preview');
            }
        });
    });

    // Handle delete button click
    $(document).on('click', '.btn-delete', function() {
        deleteId = $(this).data('id');
        $('#modal-hapus').modal('show');
    });

    // Handle delete confirmation
    $('#btn-hapus-confirm').on('click', function() {
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
                success: function(response) {
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
                error: function(xhr) {
                    $('#modal-hapus').modal('hide');

                    // Show error message
                    $('body').prepend(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i> Gagal menghapus sertifikat
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
                complete: function() {
                    // Hide loading state
                    $spinner.addClass('d-none');
                    $button.prop('disabled', false);
                    deleteId = null;
                }
            });
        }
    });

    // Auto-hide alerts after 5 seconds
    $(document).on('click', '.alert .btn-close', function() {
        $(this).closest('.alert').fadeOut();
    });

    // Clean up preview modal when hidden
    $(document).on('hidden.bs.modal', '#modal-preview', function () {
        $(this).remove();
    });

    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
});
