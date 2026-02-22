<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index']);
Route::get('/cadastro', [SiteController::class,'create'])->name('pessoa.create');
Route::post('/cadastro',[SiteController::class,'store'])->name('pessoa.store');
Route::delete('/pessoa/{pessoa}',[SiteController::class,'destroy'])->name('pessoa.deletar');