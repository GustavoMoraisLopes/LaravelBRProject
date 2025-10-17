<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackofficeController;

Route::get('/', [ProdutoController::class, 'index'])->name('home');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/adicionar/{produto}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');

Route::get('/profile', function () {
    return view('profile.edit');
})->middleware('auth')->name('profile.edit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/backoffice', [BackofficeController::class, 'index'])->name('backoffice');
    Route::get('/backoffice/create', [BackofficeController::class, 'create'])->name('backoffice.create');
    Route::post('/backoffice/store', [BackofficeController::class, 'store'])->name('backoffice.store');
    Route::delete('/produtos/{produto}', [BackofficeController::class, 'destroy'])->name('produtos.destroy');
});
