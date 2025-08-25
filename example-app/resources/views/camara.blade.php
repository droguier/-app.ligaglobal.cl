<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Cámara</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; text-align: center; }
        video { width: 100%; max-width: 400px; border-radius: 8px; background: #000; }
        .error { color: #dc2626; margin-top: 16px; }
    </style>
    {{-- <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/minified/html5-qrcode.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Ver Cámara</h1>
        <video id="video" autoplay playsinline></video>
        <div id="error" class="errorweb"></div>
    </div>
    <div class="container">
        <h1>Ver QR Info</h1>
        <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
        <button id="capture-btn" style="margin: 20px auto; display: block; padding: 10px 20px; font-size: 1rem; background: #2563eb; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Capturar Foto y Leer QR</button>
        <canvas id="snapshot" style="display:none;"></canvas>
        <img id="captured-img" src="" alt="Foto capturada" style="display:none; margin: 20px auto; max-width: 100%; border-radius: 8px; box-shadow: 0 2px 8px #0001;" />
        <div id="qr-result" style="margin-top:20px; font-weight:bold;"></div>
        <div id="error" class="errorqr"></div>
    </div>

    <div class="container">
        <h1>Leer QR desde Imagen</h1>
        <input type="file" id="file-input" accept="image/*" style="margin: 10px auto; display: block;" />
        <img id="uploaded-img" src="" alt="Imagen cargada" style="display:none; margin: 20px auto; max-width: 100%; border-radius: 8px; box-shadow: 0 2px 8px #0001;" />
        <div id="qr-upload-result" style="margin-top:20px; font-weight:bold;"></div>
        <div id="error-upload" class="errorqr"></div>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Selecciona una imagen:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
    </div>
    <div id="preview" class="mb-3"></div>
<script>
    const video = document.getElementById('video');
    const errorVideoDiv = document.getElementById('errorweb');
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err) {
                errorVideoDiv.textContent = 'No se pudo acceder a la cámara: ' + err.message;
            });
    } else {
        errorVideoDiv.textContent = 'La API de cámara no está soportada en este navegador.';
    }

    // QR desde imagen capturada
    document.getElementById('capture-btn').addEventListener('click', function() {
        const canvas = document.getElementById('snapshot');
        const qrResult = document.getElementById('qr-result');
        const errorDiv = document.querySelector('.errorqr');
        const img = document.getElementById('captured-img');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/png');
        // Mostrar la imagen capturada
        img.src = dataUrl;
        img.style.display = 'block';
        // Usar html5-qrcode para leer QR de la imagen
        if (window.Html5QrcodeScanner && window.Html5QrcodeScanner.prototype._scanFile) {
            window.Html5QrcodeScanner.prototype._scanFile(canvas, true)
                .then(decodedText => {
                    qrResult.textContent = '¡Código QR leído de la foto! Contenido: ' + decodedText;
                    errorDiv.textContent = '';
                })
                .catch(err => {
                    qrResult.textContent = '';
                    errorDiv.textContent = 'No se detectó QR en la foto.';
                });
        } else {
            errorDiv.textContent = 'No se pudo cargar el lector de QR.';
        }
        // Leer QR desde imagen cargada
        document.getElementById('file-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const img = document.getElementById('uploaded-img');
            const qrResult = document.getElementById('qr-upload-result');
            const errorDiv = document.getElementById('error-upload');
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(event) {
                img.src = event.target.result;
                img.style.display = 'block';
                img.onload = function() {
                    // Crear un canvas temporal para escanear la imagen
                    const tempCanvas = document.createElement('canvas');
                    const tempCtx = tempCanvas.getContext('2d');
                    tempCanvas.width = img.naturalWidth;
                    tempCanvas.height = img.naturalHeight;
                    tempCtx.drawImage(img, 0, 0);
                    if (window.Html5QrcodeScanner && window.Html5QrcodeScanner.prototype._scanFile) {
                        window.Html5QrcodeScanner.prototype._scanFile(tempCanvas, true)
                            .then(decodedText => {
                                qrResult.textContent = '¡Código QR leído de la imagen! Contenido: ' + decodedText;
                                errorDiv.textContent = '';
                            })
                            .catch(err => {
                                qrResult.textContent = '';
                                errorDiv.textContent = 'No se detectó QR en la imagen.';
                            });
                    } else {
                        errorDiv.textContent = 'No se pudo cargar el lector de QR.';
                    }
                };
            };
            reader.readAsDataURL(file);
        });
    });

    function previewImage(event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        const file = event.target.files[0];
        if (file) {
            const img = document.createElement('img');
            img.style.maxWidth = '300px';
            img.style.marginTop = '10px';
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);
        }
    }
</script>
</body>
</html>
