<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;

class SiteController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::all();
        $totalPessoas = $pessoas->count();
        $mediaIdade = $pessoas->avg('idade'); // Usando a coluna do banco

        return view('bemvindo', compact('pessoas', 'totalPessoas', 'mediaIdade'));
    }

    public function create()
    {
        return view('cadastro');
    }

    public function store(Request $request)
    {
        // 1. Validação 
        $data = $request->validate([
            // 'regex' garante que apenas letras e espaços sejam aceitos no nome
            'name'   => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            // 'before:today' impede que alguém nasça no futuro
            // 'after:1900-01-01' evita datas irreais de séculos passados
            'birth'  => 'required|date|before:today|after:1900-01-01',

            'gender' => 'required|in:masculino,feminino' // Garante que não inventem gêneros no código
        ], [
            // Mensagens personalizadas em português para o seu portfólio
            'name.regex' => 'O nome não pode conter números ou caracteres especiais.',
            'birth.before' => 'A data de nascimento não pode ser no futuro.',
        ]);
        // 2. Processamento da Foto da Câmera
        if ($request->base64_image) {
            $img = $request->base64_image;

            // Remove o cabeçalho "data:image/png;base64,"
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);

            // Gera um nome único para o arquivo usando o timestamp
            $fileName = 'perfil_' . time() . '.png';

            // Salva o arquivo decodificado no disco 'public'
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, base64_decode($img));

            // Adiciona o nome do arquivo aos dados que vão para o banco
            $data['image_path'] = $fileName;
        }

        // 3. Cálculo da idade (Carbon)
        $data['idade'] = \Carbon\Carbon::parse($request->birth)->age;

        // 4. Salva tudo no banco de uma vez
        Pessoa::create($data);

        return redirect('/')->with('success', 'Cadastro com foto realizado com sucesso!');
    }

    public function edit(pessoa $pessoa){
        return view('editar', compact('pessoa'));

    }
    public function destroy(Pessoa $pessoa)
    {
        // 1. Se a pessoa tiver uma foto física na pasta storage, o ideal seria deletar o arquivo também
        if ($pessoa->image_path) {
            \Storage::disk('public')->delete($pessoa->image_path);
        }

        // 2. Remove o registro do banco de dados SQLite
        $pessoa->delete();

        // 3. Redireciona com uma mensagem de confirmação
        return redirect('/')->with('success', 'Membro removido com sucesso!');
    }
}
