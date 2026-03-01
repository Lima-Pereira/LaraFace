<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Rules\CpfValido;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SiteController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::all();
        $totalPessoas = $pessoas->count();
        $mediaIdade = $pessoas->avg('idade');

        return view('bemvindo', compact('pessoas', 'totalPessoas', 'mediaIdade'));
    }

    public function create()
    {
        return view('cadastro');
    }

    public function store(Request $request)
    {
        // 1. Validação Completa (Igual ao Update)
        $data = $request->validate([
            'name'   => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            'birth'  => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:masculino,feminino',
            'cpf'    => ['required', 'string', new CpfValido()],
            'cep'    => 'nullable|string|max:9',
            'rua'    => 'nullable|string|max:255',
            'numero' => 'required|string|max:10', // Obrigatório para o endereço ficar completo
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf'     => 'nullable|string|max:2',
        ], [
            'name.regex' => 'O nome não pode conter números ou caracteres especiais.',
            'birth.before' => 'A data de nascimento não pode ser no futuro.',
        ]);

        // 2. Processamento da Foto
        if ($request->base64_image) {
            $img = $request->base64_image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileName = 'perfil_' . time() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($img));
            $data['image_path'] = $fileName;
        }

        // 3. Cálculo da idade
        $data['idade'] = Carbon::parse($request->birth)->age;

        // 4. Salva no banco
        Pessoa::create($data);

        return redirect('/')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function edit(Pessoa $pessoa)
    {
        return view('editar', compact('pessoa'));
    }

    public function destroy(Pessoa $pessoa)
    {
        if ($pessoa->image_path) {
            Storage::disk('public')->delete($pessoa->image_path);
        }
        $pessoa->delete();
        return redirect('/')->with('success', 'Membro removido com sucesso!');
    }

    public function update(Request $request, Pessoa $pessoa)
    {
        // 1. Validação
        $data = $request->validate([
            'name'   => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/u'],
            'birth'  => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:masculino,feminino',
            'cpf'    => ['required', 'string', new CpfValido()],
            'cep'    => 'nullable|string|max:9',
            'rua'    => 'nullable|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf'     => 'nullable|string|max:2',
        ]);

        // 2. Foto
        if ($request->base64_image) {
            $img = $request->base64_image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileName = 'perfil_' . time() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($img));
            
            if ($pessoa->image_path) {
                Storage::disk('public')->delete($pessoa->image_path);
            }
            $data['image_path'] = $fileName;
        }

        // 3. Idade
        $data['idade'] = Carbon::parse($request->birth)->age;
        
        // 4. Update
        $pessoa->update($data);

        return redirect('/')->with('success', 'Cadastro atualizado com sucesso!');
    }
    public function gerarRelatorio()
    {
        $pessoas = Pessoa::all(); //

        // Carrega a view que criaremos abaixo e passa os dados
        $pdf = Pdf::loadView('relatorio_pdf', compact('pessoas'));

        // Faz o download automático com o nome do arquivo datado
        return $pdf->download('relatorio_clientes_' . now()->format('d_m_Y') . '.pdf');
    }
}