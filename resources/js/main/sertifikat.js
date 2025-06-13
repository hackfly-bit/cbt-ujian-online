// shortcut-fabric.js
import { Canvas, Textbox, ActiveSelection, FabricImage } from "fabric";

window.addEventListener("DOMContentLoaded", () => {
    const canvasElement = document.getElementById("certificate-canvas");
    const canvasSizes = {
        "a4-portrait": { width: 794, height: 1123 },
        "a4-landscape": { width: 1123, height: 794 },
        "f4-portrait": { width: 827, height: 1307 },
        "f4-landscape": { width: 1307, height: 827 },
    };

    const defaultSizeKey = "a4-landscape";
    const defaultSize = canvasSizes[defaultSizeKey];
    canvasElement.width = defaultSize.width;
    canvasElement.height = defaultSize.height;

    const canvas = new Canvas(canvasElement, { backgroundColor: "#fff" });
    if (data.template) {

        const templateData = JSON.parse(data.template);
        console.log("Template data loaded:", templateData);

        // Restore canvas size if saved in template
        if (templateData.canvasWidth && templateData.canvasHeight) {
            // Update canvas element size
            canvasElement.width = templateData.canvasWidth;
            canvasElement.height = templateData.canvasHeight;

            // Update canvas instance size
            canvas.setDimensions({
                width: templateData.canvasWidth,
                height: templateData.canvasHeight
            });

            // Store size key for reference
            canvas.sizeKey = templateData.sizeKey || defaultSizeKey;
        }
        // Load template using Promise syntax
        canvas.loadFromJSON(data.template)
            .then(() => {
                canvas.getObjects().forEach((obj) => obj.setCoords());
                canvas.renderAll();
                console.log("Template loaded from JSON.");
            })
            .catch(error => {
                console.error("Error loading template:", error);
                // Fallback to white background
                canvas.set('backgroundColor', '#fff');
                canvas.renderAll();
            });
    } else {
        // Set white background if no template
        canvas.set('backgroundColor', '#fff');
        canvas.renderAll();
    }
    window.certificateCanvas = canvas;

    // Elements
    const addTextBtn = document.getElementById("btn-add-text");
    const addImageBtn = document.getElementById("btn-add-image");
    const sizeSelector = document.getElementById("canvas-size-selector");
    const textPropertiesCard = document.getElementById("text-properties");
    const editBackgroundBtn = document.getElementById("edit-background");
    const bgPropertiesPanel = document.getElementById("bg-properties");
    const bgUploadBtn = document.getElementById("bg-upload"); // tombol dalam panel

    const bgAddImageBtn = document.getElementById("bg-add-image");
    const bgRemoveBtn = document.getElementById("bg-remove");
    const bgRemoveWrapper = document.getElementById("bg-remove-wrapper");

    const fontSizeInput = document.getElementById("font-size");
    const fontColorInput = document.getElementById("text-color");
    const fontFamilyInput = document.getElementById("font-family");
    const boldCheckbox = document.getElementById("bold");
    const italicCheckbox = document.getElementById("italic");
    const underlineCheckbox = document.getElementById("underline");
    const resetTextBtn = document.getElementById("reset-text-properties");

    // Ambil elemen input
    const bgOpacity = document.getElementById("bg-opacity");
    const bgScaleContain = document.getElementById("bg-scale-contain");
    const bgScaleCover = document.getElementById("bg-scale-cover");

    // Update Sertifikat Button
    const btnUpdateSertifikat = document.getElementById("updateTemplate");
    const btnPreview = document.getElementById("preview");

    const alignButtons = {
        left: document.getElementById("align-left"),
        center: document.getElementById("align-center"),
        right: document.getElementById("align-right"),
        justify: document.getElementById("align-justify"),
    };

    // Undo/Redo Stack
    let undoStack = [];
    let redoStack = [];
    const maxStackSize = 50;
    let isRestoring = false;
    let lastSavedHash = null;
    let saveTimeout = null;

    const hashCode = (str) => {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = (hash << 5) - hash + str.charCodeAt(i);
            hash |= 0;
        }
        return hash;
    };

    const saveState = (force = false) => {
        if (isRestoring) return;
        if (saveTimeout) clearTimeout(saveTimeout);

        saveTimeout = setTimeout(() => {
            const json = JSON.stringify(canvas.toDatalessJSON());
            const hash = hashCode(json);

            if (force || hash !== lastSavedHash) {
                undoStack.push(json);
                if (undoStack.length > maxStackSize) undoStack.shift();
                redoStack = [];
                lastSavedHash = hash;
                console.log("✔️ State saved.");
            }
        }, 100);
    };

    const restoreState = (json) => {
        if (!json) return;
        isRestoring = true;
        canvas.clear();
        canvas.loadFromJSON(JSON.parse(json), () => {
            canvas.getObjects().forEach((obj) => obj.setCoords());
            canvas.requestRenderAll();
            isRestoring = false;
            lastSavedHash = hashCode(json);
            console.log("🔄 State restored.");
        });
    };

    // Initial save
    saveState(true);
    ["object:added", "object:modified", "object:removed"].forEach((evt) =>
        canvas.on(evt, () => saveState())
    );

    // Add Text
    const addText = () => {
        const textbox = new Textbox("Teks Baru", {
            left: 100,
            top: 100,
            width: 300,
            fontSize: 32,
            fontFamily: "Arial",
            fill: "#000",
        });
        canvas.add(textbox);
        canvas.setActiveObject(textbox);
        canvas.requestRenderAll();
        updateTextProperties(textbox);
        showTextProperties();
    };

    if (addTextBtn) addTextBtn.addEventListener("click", addText);

    // Add Image
    if (addImageBtn) {
        addImageBtn.addEventListener("click", () => {
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.accept = "image/*";

            fileInput.onchange = (e) => {
                const file = e.target.files[0];
                if (!file) {
                    console.log("No file selected");
                    return;
                }

                console.log("File selected:", file.name);
                const reader = new FileReader();

                reader.onload = (event) => {
                    const imgData = event.target.result;
                    console.log(
                        "Image data loaded, creating fabric image:",
                        imgData.substring(0, 50) + "..."
                    );

                    const imgElement = new Image();
                    imgElement.src = imgData;
                    imgElement.onload = () => {
                        const fabricImage = new FabricImage(imgElement);
                        const scale = Math.min(
                            300 / imgElement.width,
                            300 / imgElement.height
                        );
                        fabricImage.scale(scale);

                        fabricImage.set({
                            left: 100,
                            top: 100,
                        });

                        canvas.add(fabricImage);
                        canvas.setActiveObject(fabricImage);
                        canvas.requestRenderAll();
                        saveState();
                        console.log("Image successfully added to canvas");
                    };
                };

                reader.onerror = (error) => {
                    console.error("Error reading file:", error);
                };

                reader.readAsDataURL(file);
            };

            fileInput.click();
        });
    }

    let currentBgImage = null;

    // Tombol Tambah Gambar
    if (bgAddImageBtn) {
        bgAddImageBtn.addEventListener("click", () => {
            console.log("Canvas JSON:", JSON.stringify(canvas.toSVG(), null, 2));
            const input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const fabricImage = new FabricImage(img);
                        const scaleX = canvas.width / img.width;
                        const scaleY = canvas.height / img.height;
                        const scale = Math.max(scaleX, scaleY);

                        fabricImage.set({
                            scaleX: scale,
                            scaleY: scale,
                            left: 0,
                            top: 0,
                            selectable: false,
                            evented: false,
                            opacity: 1,
                        });

                        canvas.backgroundImage = fabricImage;
                        canvas.requestRenderAll();
                        currentBgImage = fabricImage;

                        // Tampilkan tombol remove dan sembunyikan add
                        bgRemoveWrapper.style.display = "block";
                        bgAddImageBtn.style.display = "none";

                        // Reset ke nilai default
                        document.getElementById("bg-opacity").value = 1;

                        saveState(true);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            };
            input.click();
        });
    }

    // Inisialisasi tampilan tombol berdasarkan background
    if (canvas.backgroundImage) {
        bgRemoveWrapper.style.display = "block";
        bgAddImageBtn.style.display = "none";
    } else {
        bgRemoveWrapper.style.display = "none";
        bgAddImageBtn.style.display = "block";
    }

    // Tombol Hapus Gambar
    if (bgRemoveBtn) {
        bgRemoveBtn.addEventListener("click", () => {
            if (canvas.backgroundImage) {
                canvas.backgroundImage = null;
                canvas.requestRenderAll();
                currentBgImage = null;
                bgRemoveWrapper.style.display = "none";
                bgAddImageBtn.style.display = "block"; // Show add button
                saveState(true);
            }
        });
    }

    // Tombol utama: tampil/sembunyi panel background
    if (editBackgroundBtn) {
        editBackgroundBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Mencegah event global listener menutup panel

            document.querySelectorAll(".card.draggable").forEach((panel) => {
                if (panel !== bgPropertiesPanel) panel.style.display = "none";
            });

            bgPropertiesPanel.style.display =
                bgPropertiesPanel.style.display === "none" ? "block" : "none";
        });
    }

    // Upload background image
    if (bgUploadBtn) {
        bgUploadBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Cegah menutup panel

            const input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const fabricImage = new fabric.Image(img);
                        const scaleX = canvas.width / img.width;
                        const scaleY = canvas.height / img.height;
                        const scale = Math.max(scaleX, scaleY);

                        fabricImage.set({
                            scaleX: scale,
                            scaleY: scale,
                            left: 0,
                            top: 0,
                            selectable: false,
                            evented: false,
                        });

                        canvas.setBackgroundImage(
                            fabricImage,
                            canvas.renderAll.bind(canvas)
                        );
                        saveState(true);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            };
            input.click();
        });
    }

    // Fungsi render dan simpan state
    function updateCanvas() {
        canvas.requestRenderAll();
        if (typeof saveState === "function") saveState();
    }

    // Periksa background image
    function getBackgroundImage() {
        return canvas.backgroundImage || null;
    }

    // Opacity
    bgOpacity.addEventListener("input", () => {
        const bg = getBackgroundImage();
        if (!bg) return;
        bg.set("opacity", parseFloat(bgOpacity.value));
        updateCanvas();
    });

    // Helper untuk atur active class
    function setActiveScaleButton(activeButton) {
        document.querySelectorAll(".bg-scale-button").forEach((btn) => {
            btn.classList.remove("active");
        });
        activeButton.classList.add("active");
    }

    // Scale Mode: Contain
    if (bgScaleContain) {
        bgScaleContain.addEventListener("click", () => {
            const bg = getBackgroundImage();
            if (!bg) return;

            const scale = Math.min(
                canvas.width / bg.width,
                canvas.height / bg.height
            );
            bg.set({
                scaleX: scale,
                scaleY: scale,
                left: 0,
                top: 0,
                originX: "left",
                originY: "top",
            });
            updateCanvas();

            setActiveScaleButton(bgScaleContain); // tambahkan ini
        });
    }

    // Scale Mode: Cover
    if (bgScaleCover) {
        bgScaleCover.addEventListener("click", () => {
            const bg = getBackgroundImage();
            if (!bg) return;

            const scale = Math.max(
                canvas.width / bg.width,
                canvas.height / bg.height
            );
            bg.set({
                scaleX: scale,
                scaleY: scale,
                left: 0,
                top: 0,
                originX: "left",
                originY: "top",
            });
            updateCanvas();

            setActiveScaleButton(bgScaleCover); // tambahkan ini
        });
    }

    // Sembunyikan panel properti saat klik di luar
    document.addEventListener("click", function (e) {
        if (!e.target) return;
        const clickedPanel = e.target.closest(".card.draggable");
        const isClickEditBtn = e.target.closest("#edit-background");

        if (!clickedPanel && !isClickEditBtn) {
            // Only hide background properties panel when clicking outside
            if (
                bgPropertiesPanel &&
                bgPropertiesPanel.style.display === "block"
            ) {
                bgPropertiesPanel.style.display = "none";
            }
        }
    });

    // Text Properties Panel
    const showTextProperties = () => {
        if (textPropertiesCard) textPropertiesCard.style.display = "block";
    };

    const hideTextProperties = () => {
        if (textPropertiesCard) textPropertiesCard.style.display = "none";
    };

    const updateTextProperties = (text) => {
        if (!text) return;
        if (fontSizeInput) fontSizeInput.value = text.fontSize || 32;
        if (fontColorInput) fontColorInput.value = text.fill || "black";
        if (fontFamilyInput) fontFamilyInput.value = text.fontFamily || "Arial";
        if (boldCheckbox) boldCheckbox.checked = text.fontWeight === "bold";
        if (italicCheckbox)
            italicCheckbox.checked = text.fontStyle === "italic";
    };

    // Fungsi untuk apply properti text ke objek aktif canvas
    const applyTextProperties = () => {
        const active = canvas.getActiveObject();
        if (!active || active.type !== "textbox") return;

        active.set({
            fontSize: parseInt(fontSizeInput.value, 10) || 32,
            fill: fontColorInput.value || "#000",
            fontFamily: fontFamilyInput.value || "Arial", // pakai nilai dari dropdown
            fontWeight: boldCheckbox.checked ? "bold" : "normal",
            fontStyle: italicCheckbox.checked ? "italic" : "normal",
            underline: underlineCheckbox.checked, // jika ada fitur underline
        });
        canvas.requestRenderAll();
        saveState();
    };

    // Pasang event listener untuk font family dropdown
    if (fontFamilyInput) {
        fontFamilyInput.addEventListener("change", () => {
            // Sebelum apply, cek apakah font sudah ready via FontFaceObserver (optional)
            const fontName = fontFamilyInput.value;

            // Jika mau menggunakan FontFaceObserver (disarankan) :
            if (window.FontFaceObserver) {
                const font = new FontFaceObserver(fontName);
                font.load(null, 5000)
                    .then(() => {
                        applyTextProperties();
                    })
                    .catch(() => {
                        console.warn(
                            `Font "${fontName}" gagal dimuat, pakai fallback.`
                        );
                        applyTextProperties();
                    });
            } else {
                // Tanpa FontFaceObserver, langsung apply (mungkin font belum termuat sempurna)
                applyTextProperties();
            }
        });
    }

    // Jangan lupa tambahkan fontFamilyInput ke daftar yang trigger applyTextProperties:
    [
        fontSizeInput,
        fontColorInput,
        fontFamilyInput,
        boldCheckbox,
        italicCheckbox,
        underlineCheckbox, // jika sudah ada
    ].forEach((el) => {
        if (el) el.addEventListener("input", applyTextProperties);
    });

    Object.entries(alignButtons).forEach(([align, btn]) => {
        if (btn) {
            btn.addEventListener("click", () => {
                const active = canvas.getActiveObject();
                if (!active) return;

                const objects =
                    active.type === "activeSelection"
                        ? active.getObjects()
                        : [active];
                objects.forEach((obj) => {
                    if (obj.type === "textbox" || obj.type === "text") {
                        obj.set({ textAlign: align });
                    }
                });

                canvas.requestRenderAll();
                saveState();

                // Hapus semua active class dari semua tombol
                Object.values(alignButtons).forEach((b) =>
                    b.classList.remove("active")
                );

                // Tambahkan ke tombol yang diklik
                btn.classList.add("active");
            });
        }
    });

    function updateAlignUI() {
        const active = canvas.getActiveObject();
        if (!active) return;

        // Reset all alignment buttons first
        Object.values(alignButtons).forEach((btn) => {
            if (btn) btn.classList.remove("active");
        });

        // Get the text object
        const obj =
            active.type === "activeSelection" ? active.getObjects()[0] : active;

        // If it's a text object, update the UI
        if (obj?.type === "textbox" || obj?.type === "text") {
            const currentAlign = obj.textAlign || "left";
            const button = alignButtons[currentAlign];
            if (button) button.classList.add("active");
        }
    }

    canvas.on("selection:created", updateAlignUI);
    canvas.on("selection:updated", updateAlignUI);

    // Reset Text Properties
    const resetTextProperties = () => {
        const active = canvas.getActiveObject();
        if (!active || active.type !== "textbox") return;

        active.set({
            fontSize: 32,
            fill: "#000",
            fontFamily: "Arial",
            fontWeight: "normal",
            fontStyle: "normal",
            underline: false,
            textAlign: "left",
        });

        canvas.requestRenderAll();
        updateTextProperties(active);
        updateAlignUI();
        saveState();
    };

    if (resetTextBtn)
        resetTextBtn.addEventListener("click", resetTextProperties);

    // Underline Checkbox

    canvas.on("selection:created", ({ selected }) => {
        const obj = selected[0];
        obj?.type === "textbox"
            ? (updateTextProperties(obj), showTextProperties())
            : hideTextProperties();
    });

    canvas.on("selection:updated", ({ selected }) => {
        const obj = selected[0];
        obj?.type === "textbox"
            ? (updateTextProperties(obj), showTextProperties())
            : hideTextProperties();
    });

    canvas.on("selection:cleared", hideTextProperties);

    // Simulasi data dari backend
    const dataFromDb = {
        namaLengkap: "Ahmad Surya",
        ujian: "Matematika",
        tanggalUjian: "4 Juni 2025",
        nilaiUjian: "95",
    };

    // Placeholder Generator
    const addPlaceholder = (text) => {
        const placeholder = new Textbox(text, {
            left: 100,
            top: 100,
            width: 300,
            fontSize: 32,
            fontFamily: "Arial",
            fill: "#555",
            editable: false,
            selectable: true,
            hasControls: true,
            lockScalingX: false,
            lockScalingY: false,
            lockRotation: false,
            hoverCursor: "move",
        });
        canvas.add(placeholder);
        canvas.setActiveObject(placeholder);
        canvas.requestRenderAll();
        updateTextProperties(placeholder);
        showTextProperties();
    };

    // Event listeners
    document.getElementById("nama-peserta").addEventListener("click", () => {
        addPlaceholder("[Nama Lengkap]");
    });
    document.getElementById("ujian").addEventListener("click", () => {
        addPlaceholder("[Ujian]");
    });
    document.getElementById("tanggal-ujian").addEventListener("click", () => {
        addPlaceholder("[Tanggal Ujian]");
    });
    document.getElementById("nilai-ujian").addEventListener("click", () => {
        addPlaceholder("[Nilai Ujian]");
    });

    // Render Placeholder dari Data
    const renderPlaceholdersFromData = () => {
        canvas.getObjects().forEach((obj) => {
            if (
                (obj.type === "textbox" || obj.type === "text") &&
                obj.text.startsWith("[")
            ) {
                switch (obj.text) {
                    case "[Nama Lengkap]":
                        obj.text = dataFromDb.namaLengkap;
                        break;
                    case "[Ujian]":
                        obj.text = dataFromDb.ujian;
                        break;
                    case "[Tanggal Ujian]":
                        obj.text = dataFromDb.tanggalUjian;
                        break;
                    case "[Nilai Ujian]":
                        obj.text = dataFromDb.nilaiUjian;
                        break;
                    case "[QR Code]":
                        // Buat QR code di sini kalau perlu
                        break;
                }
            }
        });
        canvas.requestRenderAll();
    };

    // Misalnya kamu panggil ini saat klik "Generate Sertifikat"
    const generateBtn = document.getElementById("generate");
    if (generateBtn) {
        generateBtn.addEventListener("click", renderPlaceholdersFromData);
    }

    // Resize canvas
    if (sizeSelector) {
        sizeSelector.value = defaultSizeKey;
        sizeSelector.addEventListener("change", (e) => {
            const selectedSize = canvasSizes[e.target.value];
            if (selectedSize) {
                canvasElement.width = selectedSize.width;
                canvasElement.height = selectedSize.height;
                canvas.setDimensions(selectedSize);
                canvas.setBackgroundColor(
                    "#fff",
                    canvas.renderAll.bind(canvas)
                );
                saveState(true);
            }
        });
    }

    // Keyboard Shortcuts
    document.addEventListener("keydown", (e) => {
        if (document.activeElement !== canvas.upperCanvasEl || !canvas) return;

        const active = canvas.getActiveObject();
        let moved = false;

        if (e.ctrlKey || e.metaKey) {
            switch (e.key.toLowerCase()) {
                case "z":
                    if (undoStack.length > 1) {
                        redoStack.push(undoStack.pop());
                        restoreState(undoStack[undoStack.length - 1]);
                    }
                    e.preventDefault();
                    break;
                case "y":
                    if (redoStack.length) {
                        const state = redoStack.pop();
                        undoStack.push(state);
                        restoreState(state);
                    }
                    e.preventDefault();
                    break;
                case "a":
                    const objects = canvas.getObjects();
                    if (objects.length) {
                        canvas.discardActiveObject();
                        const selection = new ActiveSelection(objects, {
                            canvas,
                        });
                        canvas.setActiveObject(selection);
                        canvas.requestRenderAll();
                    }
                    e.preventDefault();
                    break;
            }
        } else if (active) {
            switch (e.key) {
                case "Delete":
                case "Backspace":
                    canvas.remove(active);
                    canvas.discardActiveObject();
                    canvas.requestRenderAll();
                    saveState();
                    e.preventDefault();
                    break;
                case "ArrowUp":
                    active.top -= 5;
                    moved = true;
                    break;
                case "ArrowDown":
                    active.top += 5;
                    moved = true;
                    break;
                case "ArrowLeft":
                    active.left -= 5;
                    moved = true;
                    break;
                case "ArrowRight":
                    active.left += 5;
                    moved = true;
                    break;
            }

            if (moved) {
                active.setCoords();
                canvas.requestRenderAll();
                saveState();
                e.preventDefault();
            }
        }
    });

    canvas.upperCanvasEl.tabIndex = 1000;
    canvas.upperCanvasEl.addEventListener("mousedown", () => {
        canvas.upperCanvasEl.focus();
    });

    // Fungsi universal untuk drag element
    function makeDraggable(dragHandleId, containerId) {
        const handle = document.querySelector(dragHandleId);
        const container = document.querySelector(containerId);
        let isDragging = false;
        let offsetX = 0,
            offsetY = 0;

        if (handle && container) {
            handle.style.cursor = "move";

            handle.addEventListener("mousedown", (e) => {
                isDragging = true;
                const rect = container.getBoundingClientRect();
                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;
                document.body.style.userSelect = "none";
            });

            document.addEventListener("mousemove", (e) => {
                if (!isDragging) return;
                container.style.left = `${e.clientX - offsetX}px`;
                container.style.top = `${e.clientY - offsetY}px`;
            });

            document.addEventListener("mouseup", () => {
                isDragging = false;
                document.body.style.userSelect = "auto";
            });
        }
    }

    // Aktifkan drag untuk kedua panel
    makeDraggable("#drag-handle", "#text-properties");
    makeDraggable("#bg-drag-handle", "#bg-properties");


    // Update Sertifikat Button
    if (btnUpdateSertifikat) {
        btnUpdateSertifikat.addEventListener("click", () => {
            // Get canvas data as JSON for database storage
            const template = JSON.stringify(canvas.toObject());

            // Save to database via AJAX
            saveTemplateToDatabase(template);
        });
    }

    function saveTemplateToDatabase(template) {

        const pathParts = window.location.pathname.split('/');
        const id = pathParts[2]; // ['sertifikat', '1', 'edit'] -> index 2
        console.log(id); // Output: "1"

        const canvasData = JSON.parse(template);

        // Add canvas size information to the JSON
        canvasData.canvasWidth = canvas.width;
        canvasData.canvasHeight = canvas.height;
        canvasData.sizeKey = canvas.sizeKey || defaultSizeKey;

        fetch(`/sertifikat/${id}/template`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // if using Laravel/similar
            },
            body: JSON.stringify({
                template: JSON.stringify(canvasData),
                name: 'Certificate Template',
                // Add other metadata as needed
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Template saved successfully:', data);
                    alert('Template berhasil disimpan!');
                } else {
                    console.error('Error saving template:', data.error);
                    alert('Gagal menyimpan template');
                }
            })
            .catch(error => {
                console.error('Network error:', error);
                alert('Terjadi kesalahan jaringan');
            });
    }

    // Add preview button functionality
    if (btnPreview) {
        btnPreview.addEventListener("click", () => {
            showPreview();
        });
    }

    function showPreview() {
        // Create preview modal/window
        const previewModal = document.createElement('div');
        previewModal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    `;

        // Create preview content
        const previewContent = document.createElement('div');
        previewContent.style.cssText = `
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 90%;
        max-height: 90%;
        overflow: auto;
    `;

        // Export canvas as image for preview
        const dataURL = canvas.toDataURL({
            format: 'png',
            quality: 1,
            multiplier: 2 // Higher resolution for preview
        });

        previewContent.innerHTML = `
        <h3>Preview Sertifikat</h3>
        <img src="${dataURL}" style="max-width: 100%; height: auto; border: 1px solid #ddd;">
        <div style="margin-top: 15px;">
            <button onclick="this.closest('.preview-modal').remove()" style="margin-right: 10px;">Tutup</button>
        </div>
    `;

        previewModal.className = 'preview-modal';
        previewModal.appendChild(previewContent);
        document.body.appendChild(previewModal);

        // Close on background click
        previewModal.addEventListener('click', (e) => {
            if (e.target === previewModal) {
                previewModal.remove();
            }
        });
    }







});
