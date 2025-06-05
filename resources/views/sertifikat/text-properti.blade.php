<!-- Drag & Drop Card -->
<div id="text-properties" class="card shadow-lg draggable"
    style="display: none; position: absolute; right: 40px; top: 120px; width: 300px; z-index: 999;">
    <div class="card-body">
        <!-- Drag Handle -->
        <div class="text-center" style="margin-top: -15px; cursor: move;" id="drag-handle">
            <i class="ri-more-fill fs-2 text-muted"></i>
        </div>

        <h4 class="card-title">Text Properties</h4>

        <div class="mb-3">
            <label class="form-label">Font Family</label>
            <select id="font-family" class="form-select">
                <option value="Arial" style="font-family: Arial, sans-serif;">Arial (Default)</option>
                <option value="Roboto" style="font-family: 'Roboto', sans-serif;">Roboto</option>
                <option value="Open Sans" style="font-family: 'Open Sans', sans-serif;">Open Sans</option>
                <option value="Montserrat" style="font-family: 'Montserrat', sans-serif;">Montserrat</option>
                <option value="Raleway" style="font-family: 'Raleway', sans-serif;">Raleway</option>
                <option value="Oswald" style="font-family: 'Oswald', sans-serif;">Oswald</option>
                <option value="Source Sans Pro" style="font-family: 'Source Sans Pro', sans-serif;">Source Sans Pro
                </option>
                <option value="Playfair Display" style="font-family: 'Playfair Display', serif;">Playfair Display
                </option>

                <!-- Curly / Handwritten Fonts -->
                <option value="Pacifico" style="font-family: 'Pacifico', cursive;">Pacifico (Curly)</option>
                <option value="Lobster" style="font-family: 'Lobster', cursive;">Lobster (Curly)</option>
                <option value="Great Vibes" style="font-family: 'Great Vibes', cursive;">Great Vibes (Curly)</option>
                <option value="Indie Flower" style="font-family: 'Indie Flower', cursive;">Indie Flower (Curly)</option>
                <option value="Caveat" style="font-family: 'Caveat', cursive;">Caveat (Curly)</option>
                <option value="Dancing Script" style="font-family: 'Dancing Script', cursive;">Dancing Script (Curly)
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Font Size</label>
            <input type="number" id="font-size" class="form-control" min="5" max="100" />
        </div>

        <div class="mb-3 d-flex flex-wrap gap-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="bold">
                <label class="form-check-label" for="bold">Bold</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="italic">
                <label class="form-check-label" for="italic">Italic</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="underline">
                <label class="form-check-label" for="underline">Underline</label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Text Color</label>
            <input type="color" id="text-color" class="form-control form-control-color" />
        </div>

        <div class="mb-2">
            <label class="form-label d-block">Alignment</label>
            <div class="btn-group w-100" role="group" aria-label="Text alignment">
                <button type="button" class="btn btn-outline-secondary" id="align-left" title="Align Left">
                    <i class="ri-align-left"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="align-center" title="Align Center">
                    <i class="ri-align-center"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="align-right" title="Align Right">
                    <i class="ri-align-right"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="align-justify" title="Justify">
                    <i class="ri-align-justify"></i>
                </button>
            </div>
        </div>

        <div class="mt-3 text-end">
            <button id="reset-text-properties" class="btn btn-sm btn-outline-danger">Reset</button>
        </div>
    </div>
</div>
