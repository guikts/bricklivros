<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\LeitorController;
use App\Http\Controllers\EmprestimoController;

Route::get('/', function () { return redirect('/login'); });

Route::view('/login', 'login')->name('login');
Route::view('/cadastrar', 'cadastro');

Route::post('/login', [AuthController::class, 'logar']);
Route::post('/cadastrar', [AuthController::class, 'registrar']);

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard');
    Route::get('/sair', [AuthController::class, 'sair']);
    
    // Rotas de Livros
    Route::get('/livros', [LivroController::class, 'listarLivros']);
    Route::post('/livros', [LivroController::class, 'cadastrarLivro']);
    Route::get('/livros/{id}/editar', [LivroController::class, 'editarLivro']);
    Route::put('/livros/{id}', [LivroController::class, 'atualizarLivro']);
    Route::delete('/livros/{id}', [LivroController::class, 'excluirLivro']);
    
    // Rotas de Leitores
    Route::get('/leitores', [LeitorController::class, 'listarLeitores']);
    Route::get('/leitores/{id}/editar', [LeitorController::class, 'editarLeitor']);
    Route::put('/leitores/{id}', [LeitorController::class, 'atualizarLeitor']);
    Route::delete('/leitores/{id}', [LeitorController::class, 'excluirLeitor']);
    
    // Rotas de Empréstimos e Relatório
    Route::post('/emprestimos', [EmprestimoController::class, 'emprestar']);
    Route::post('/emprestimos/renovar/{id}', [EmprestimoController::class, 'renovar']);
    Route::get('/relatorio/emprestimos', [EmprestimoController::class, 'gerarRelatorioPdf']);
    
    Route::post('/devolver-form', function(Request $request) {
        return app(EmprestimoController::class)->devolver($request->emprestimo_id);
    });
});