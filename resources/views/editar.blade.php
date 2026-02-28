<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Pessoa</title>
    <style>
        .form-container { max-width: 450px; margin: 30px auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); background: #f9f9f9; font-family: sans-serif; }
        input, select, button { width: 100%; margin-bottom: 15px; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #2d3748; color: white; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #1a202c; }
        .camera-box { text-align: center; margin-bottom: 15px; border: 2px dashed #ccc; padding: 10px; border-radius: 8px; }
        #webcam { width: 100%; border-radius: 5px; transform: scaleX(-1); } /* Mirror effect */
        #photo-preview { width: 100%; display: none; border-radius: 5px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Novo Cadastro</h1>

        <div class="camera-box">
            <video id="webcam" autoplay playsinline></video>
            <img id="photo-preview" src="">
            <canvas id="canvas" style="display:none;"></canvas>
            <button type="button" id="btn-snap" onclick="takeSnap()">📸 Tirar Foto</button>
            <button type="button" id="btn-reset" onclick="resetCamera()" style="display:none; background-color: #718096;">Tirar Outra</button>
        </div>

        <form action="{{ route('pessoa.store') }}" method="POST">
            @csrf 
            <input type="hidden" name="base64_image" id="base64_image">

            <input type="text" name="name" placeholder="Nome Completo" required>
            <input type="date" name="birth" required>
            
            <select name="gender" required>
                <option value="">Selecione o Gênero</option>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
            </select>

            <button type="submit">Finalizar Cadastro</button>
        </form>
        
        <a href="/" style="text-decoration: none; color: #4a5568; font-size: 14px;">← Voltar para a lista</a>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const photoPreview = document.getElementById('photo-preview');
        const inputImage = document.getElementById('base64_image');
        const btnSnap = document.getElementById('btn-snap');
        const btnReset = document.getElementById('btn-reset');

        // Acessa a câmera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => { video.srcObject = stream; })
            .catch(err => { alert("Erro ao acessar câmera: " + err); });

        function takeSnap() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            
            const dataUrl = canvas.toDataURL('image/png');
            inputImage.value = dataUrl; // Salva no input hidden
            
            // Troca o vídeo pela foto estática
            photoPreview.src = dataUrl;
            photoPreview.style.display = 'block';
            video.style.display = 'none';
            btnSnap.style.display = 'none';
            btnReset.style.display = 'block';
        }

        function resetCamera() {
            photoPreview.style.display = 'none';
            video.style.display = 'block';
            btnSnap.style.display = 'block';
            btnReset.style.display = 'none';
            inputImage.value = "";
        }
    </script>
</body>

</html>