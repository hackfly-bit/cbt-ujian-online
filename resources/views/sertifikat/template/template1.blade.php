<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Penghargaan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Crimson Text', serif;
            background-color: #2a2a2a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .certificate-container {
            width: 1000px;
            height: 707px;
            position: relative;
            background-image: url('{{ asset('images/bg-sertif1.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        
        .certificate-content {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .title-main {
            font-family: 'Playfair Display', serif;
            font-size: 68px;
            font-weight: 900;
            color: #333;
            letter-spacing: 10px;
            text-transform: uppercase;
            position: absolute;
            top: 105px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .subtitle {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #d4af37;
            letter-spacing: 5px;
            text-transform: uppercase;
            position: absolute;
            top: 185px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .award-text {
            font-size: 18px;
            color: #333;
            font-weight: 400;
            position: absolute;
            top: 260px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 700;
            color: #333;
            font-style: italic;
            position: absolute;
            top: 320px;
            left: 50%;
            transform: translateX(-50%);
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
            min-width: 420px;
            text-align: center;
        }
        
        .description {
            font-size: 15px;
            color: #555;
            line-height: 1.4;
            position: absolute;
            top: 400px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 650px;
            text-align: center;
        }
        
        .signature-left {
            position: absolute;
            bottom: 120px;
            left: 160px;
            text-align: center;
        }
        
        .signature-right {
            position: absolute;
            bottom: 120px;
            right: 160px;
            text-align: center;
        }
        
        .signature-line {
            width: 170px;
            height: 2px;
            background-color: #333;
            margin-bottom: 8px;
        }
        
        .signature-title {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        
        .signature-role {
            font-size: 13px;
            color: #333;
            font-weight: 400;
        }
        
        .qr-code {
            position: absolute;
            bottom: 120px;
            left: 50%;
            transform: translateX(-50%);
            width: 75px;
            height: 75px;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            color: #333;
            background-color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-content">
            <h1 class="title-main">SERTIFIKAT</h1>
            <h2 class="subtitle">PENGHARGAAN</h2>
            
            <p class="award-text">Dengan bangga diberikan kepada :</p>
            <h3 class="recipient-name">[Nama Lengkap]</h3>
            <p class="description">
                Lorem Ipsum cupidata non ullamco tempor occaecat magna pariatur 
                occaecat excepteur nostrud elit deserunt irure cillum commodo 
                cillum eu cillum et ipsum
            </p>
            
            <div class="signature-left">
                <div class="signature-line"></div>
                <div class="signature-title">NAMA</div>
                <div class="signature-role">Pimpinan Perusahaan</div>
            </div>
            
            <div class="qr-code">
                QR Code
            </div>
            
            <div class="signature-right">
                <div class="signature-line"></div>
                <div class="signature-title">NAMA</div>
                <div class="signature-role">Ketua Panitia</div>
            </div>
        </div>
    </div>
</body>
</html>