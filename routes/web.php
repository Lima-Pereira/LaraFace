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

    //Buscar todas as pessoas no Banco de dados
    $pessoas = \App\Models\Pessoa::all();

    // Manda a Variável $pessoas para a tela do dashboard
    return view('dashboard', compact('pessoas'));
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