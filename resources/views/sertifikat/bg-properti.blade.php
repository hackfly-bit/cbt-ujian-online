<div id="bg-properties" class="card shadow-lg draggable"
    style="display:none; position: absolute; right: 40px; top: 120px; width: 280px; z-index: 999;">
    <div class="card-body">
        <!-- Drag Handle -->
        <div class="text-center" style="margin-top: -15px; cursor: move;" id="bg-drag-handle">
            <i class="ri-more-fill fs-2 text-muted"></i>
        </div>

        <h4 class="card-title">Background Properties</h4>

        <!-- Tambah Gambar -->
        <div class="mb-3">
            <button id="bg-add-image" class="btn btn-primary w-100">
                <i class="ri-image-add-line me-1"></i> Add Image
            </button>
        </div>

        <!-- Hapus Gambar -->
        <div class="mb-3" id="bg-remove-wrapper" style="display: none;">
            <button id="bg-remove" class="btn btn-outline-danger w-100">
                <i class="ri-delete-bin-line me-1"></i> Remove Background
            </button>
        </div>

        <!-- Opacity -->
        <div class="mb-3">
            <label class="form-label">Opacity</label>
            <input type="range" id="bg-opacity" class="form-range" min="0" max="1" step="0.01" value="1">
        </div>

        <!-- Scale Mode -->
        <div class="mb-3">
            <label class="form-label d-block">Scale Mode</label>
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-outline-secondary bg-scale-button" id="bg-scale-contain">Contain</button>
                <button type="button" class="btn btn-outline-secondary bg-scale-button" id="bg-scale-cover">Cover</button>
            </div>
        </div>
    </div>
</div>
