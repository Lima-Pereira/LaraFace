<!DOCTYPE html>
<html>

<head>
    <title>Editar Pessoa</title>
    <style>
        .form-container {
            max-width: 450px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #f9f9f9;
            font-family: sans-serif;
        }

        input, select, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #2d3748;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover { background-color: #1a202c; }

        .camera-box {
            text-align: center;
            margin-bottom: 15px;
            border: 2px dashed #ccc;
            padding: 10px;
            border-radius: 8px;
        }

        #webcam { width: 100%; border-radius: 5px; transform: scaleX(-1); }
        #photo-preview { width: 100%; display: none; border-radius: 5px; margin-bottom: 10px; }
        
        .flex-container { display: flex; gap: 10px; margin-bottom: 0; }
        .flex-main { width: 75%; }
        .flex-side { width: 25%; }
        .bg-readonly { background-color: #edf2f7; color: #4a5568; cursor: not-allowed; }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Editar Cadastro</h1>

        <div class="camera-box">
            <video id="webcam" autoplay playsinline></video>
            <img id="photo-preview" src="">
            <canvas id="canvas" style="display:none;"></canvas>
            <button type="button" id="btn-snap" onclick="takeSnap()">📸 Tirar Foto</button>
            <button type="button" id="btn-reset" onclick="resetCamera()" style="display:none; background-color: #718096;">Tirar Outra</button>
        </div>

        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <strong>Opa! Tem algo errado:</strong>
                <ul style="margin-top: 5px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pessoa.update', $pessoa->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="base64_image" id="base64_image">

            <input type="text" name="name" placeholder="Nome Completo" value="{{ $pessoa->name }}" required>
            <input type="date" name="birth" value="{{ $pessoa->birth }}" required>

            <select name="gender" required>
                <option value="masculino" {{ $pessoa->gender == 'masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="feminino" {{ $pessoa->gender == 'feminino' ? 'selected' : '' }}>Feminino</option>
            </select>

            <input type="text" name="cpf" id="cpf" placeholder="CPF (000.000.000-00)" value="{{ $pessoa->cpf }}" required>

            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">
            <h3 style="color: #4a5568; margin-bottom: 15px; font-weight: bold;">Endereço</h3>

            <input type="text" name="cep" id="cep" placeholder="CEP (00000-000)" maxlength="9" value="{{ $pessoa->cep }}" required>
            
            <div class="flex-container">
                <input type="text" name="rua" id="rua" readonly placeholder="Rua / Logradouro" 
                    class="flex-main bg-readonly" value="{{ $pessoa->rua }}">
                <input type="text" name="numero" id="numero" placeholder="Nº" 
                    class="flex-side" value="{{ $pessoa->numero }}" required>
            </div>

            <input type="text" name="bairro" id="bairro" readonly placeholder="Bairro" 
                class="bg-readonly" value="{{ $pessoa->bairro }}">
            
            <div class="flex-container">
                <input type="text" name="cidade" id="cidade" readonly placeholder="Cidade" 
                    class="flex-main bg-readonly" value="{{ $pessoa->cidade }}">
                <input type="text" name="uf" id="uf" readonly placeholder="UF" 
                    class="flex-side bg-readonly" value="{{ $pessoa->uf }}">
            </div>

            <button type="submit" style="background-color: #2563eb; margin-top: 10px;">Salvar Alterações</button>
        </form>

        <a href="/" style="text-decoration: none; color: #4a5568; font-size: 14px;">← Voltar para a lista</a>
    </div>

    <script>
        // --- CONFIGURAÇÃO DA CÂMERA ---
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const photoPreview = document.getElementById('photo-preview');
        const inputImage = document.getElementById('base64_image');
        const btnSnap = document.getElementById('btn-snap');
        const btnReset = document.getElementById('btn-reset');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => { video.srcObject = stream; })
            .catch(err => { alert("Erro ao acessar câmera: " + err); });

        function takeSnap() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);
            const dataUrl = canvas.toDataURL('image/png');
            inputImage.value = dataUrl;
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

        // --- MÁSCARAS ---
        document.getElementById('cpf').addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + (x[3] ? '.' + x[3] : '') + (x[4] ? '-' + x[4] : '');
        });

        document.getElementById('cep').addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,5})(\d{0,3})/);
            e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2];
        });

        // --- VIACEP (BUSCA AUTOMÁTICA) ---
        const inputCep = document.getElementById('cep');

        function buscarCep() {
            let cep = inputCep.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(res => res.json())
                    .then(dados => {
                        if (!dados.erro) {
                            document.getElementById('rua').value = dados.logradouro;
                            document.getElementById('bairro').value = dados.bairro;
                            document.getElementById('cidade').value = dados.localidade;
                            document.getElementById('uf').value = dados.uf;
                            
                            // Foca no número se estiver vazio (agiliza a edição)
                            if(!document.getElementById('numero').value) {
                                document.getElementById('numero').focus();
                            }
                        }
                    });
            }
        }

        inputCep.addEventListener('blur', buscarCep);

        // Dispara a busca assim que a página carrega para preencher os campos "readonly"
        window.onload = function() {
            if (inputCep.value) { buscarCep(); }
        };
    </script>
</body>

</html>