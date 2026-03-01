<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// 1. Rota da página inicial Carrega a sua tela bemvindo.blade.php
Route::get('/', [SiteController::class, 'index'])->name('home');

// 2. Rotas para criar novos projetos/pessoas
Route::get('/cadastro', [SiteController::class, 'create'])->name('pessoa.create');
Route::post('/cadastro', [SiteController::class, 'store'])->name('pessoa.store');

// 3. Rota do Dashboard do Breeze
Route::get('/dashboard', function () {
    $pessoas = \App\Models\Pessoa::all();

    // 1. Cálculos de Estatísticas
    $total = $pessoas->count();
    $mediaIdade = $total > 0 ? round($pessoas->avg('idade'), 1) : 0;
    $membrosRJ = $pessoas->where('uf', 'RJ')->count();

    // 2. Preparar dados para o gráfico (Cidades)
    $cidades = $pessoas->groupBy('cidade')->map->count();
    $labels = $cidades->keys();
    $valores = $cidades->values();

    return view('dashboard', compact('pessoas', 'total', 'mediaIdade', 'membrosRJ', 'labels', 'valores'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 4. Área Protegida por Login Só se você estiver logado poderá acessar
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rota para abrir a tela de edição
    Route::get('/projetos/{pessoa}/editar', [SiteController::class, 'edit'])->name('pessoa.edit');
    
    // Rota para salvar as alterações
    Route::put('/projetos/{pessoa}', [SiteController::class, 'update'])->name('pessoa.update');
    

    Route::delete('/projetos/{pessoa}', [SiteController::class, 'destroy'])->name('pessoa.destroy');
    
    // Rota do Relatório PDF
    Route::get('/relatorio-pdf', [SiteController::class, 'gerarRelatorio'])->name('pessoa.relatorio');
});
require __DIR__.'/auth.php';