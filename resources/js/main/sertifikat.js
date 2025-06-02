import { Canvas, FabricText } from 'fabric'
document.addEventListener("DOMContentLoaded", () => {
    const canvasElement = document.getElementById('certificate-canvas');
    const canvas = new Canvas(canvasElement);
    canvas.selection = true;
    
    // Set canvas dimensions to match the element
    canvas.setDimensions({
        width: canvasElement.width,
        height: canvasElement.height
    });

    // Tambahkan background color ke canvas
    canvas.backgroundColor = 'white';
    canvas.renderAll();

    const addText = () => {
        const text = new FabricText("Teks Baru", {
            left: 100,
            top: 100,
            fontSize: 24,
            fill: 'black'
        });
        canvas.add(text);
        canvas.setActiveObject(text);
        canvas.renderAll();
    };

    const button = document.getElementById('btn-add-text');
    if (button) {
        button.addEventListener('click', addText);
    }

    console.log("Canvas initialized:", canvas);
});
