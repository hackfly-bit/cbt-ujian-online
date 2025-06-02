import { Canvas, Textbox } from 'fabric';

window.addEventListener('DOMContentLoaded', () => {
  const canvas = new Canvas('certificate-canvas', {
    backgroundColor: '#fff' // pastikan canvas tidak transparan
  });

  window.certificateCanvas = canvas;

  window.addText = () => {
    const text = new Textbox("Teks Baru", {
      left: 100,
      top: 100,
      width: 300,
      fontSize: 32,
      fontFamily: 'Arial',
      fill: '#000000', // pastikan warna hitam
      backgroundColor: 'rgba(255, 255, 0, 0.2)', // untuk memastikan terlihat
      editable: true,
    });

    canvas.add(text);
    canvas.setActiveObject(text);
    canvas.requestRenderAll();
  };

  // Tambahkan langsung 1 teks untuk testing otomatis:
  window.addText();
});
