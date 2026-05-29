<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;

// ─── AUTENTICAÇÃO ────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/registro', [AuthController::class, 'registro'])->name('registro.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── LOJA PÚBLICA ────────────────────────────────────────────────────
Route::get('/', [LojaController::class, 'index'])->name('loja.index');
Route::get('/catalogo', [LojaController::class, 'catalogo'])->name('loja.catalogo');
Route::get('/produto/{id}', [LojaController::class, 'produto'])->name('loja.produto');

// ─── CARRINHO ────────────────────────────────────────────────────────
Route::prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('index');
    Route::post('/adicionar/{produto}', [CarrinhoController::class, 'adicionar'])->name('adicionar');
    Route::post('/atualizar/{produto}', [CarrinhoController::class, 'atualizar'])->name('atualizar');
    Route::post('/remover/{produto}', [CarrinhoController::class, 'remover'])->name('remover');
    Route::post('/limpar', [CarrinhoController::class, 'limpar'])->name('limpar');
    Route::post('/finalizar', [CarrinhoController::class, 'finalizar'])->name('finalizar');
});

// ─── ADMIN DASHBOARD ─────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

// ─── PRODUTOS ────────────────────────────────────────────────────────
Route::prefix('admin/produtos')->name('produto.')->group(function () {
    Route::get('/', [ProdutoController::class, 'index'])->name('index');
    Route::get('/novo', [ProdutoController::class, 'create'])->name('create');
    Route::post('/', [ProdutoController::class, 'store'])->name('store');
    Route::post('/busca', [ProdutoController::class, 'search'])->name('search');
    Route::get('/{id}', [ProdutoController::class, 'show'])->name('show');
    Route::get('/{id}/editar', [ProdutoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProdutoController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProdutoController::class, 'destroy'])->name('destroy');
});

// ─── CATEGORIAS ──────────────────────────────────────────────────────
Route::prefix('admin/categorias')->name('categoria.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/nova', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::post('/busca', [CategoriaController::class, 'search'])->name('search');
    Route::get('/{id}/editar', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy');
});

// ─── PLATAFORMAS ─────────────────────────────────────────────────────
Route::prefix('admin/plataformas')->name('plataforma.')->group(function () {
    Route::get('/', [PlataformaController::class, 'index'])->name('index');
    Route::get('/nova', [PlataformaController::class, 'create'])->name('create');
    Route::post('/', [PlataformaController::class, 'store'])->name('store');
    Route::post('/busca', [PlataformaController::class, 'search'])->name('search');
    Route::get('/{id}/editar', [PlataformaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PlataformaController::class, 'update'])->name('update');
    Route::delete('/{id}', [PlataformaController::class, 'destroy'])->name('destroy');
});

// ─── CLIENTES ────────────────────────────────────────────────────────
Route::prefix('admin/clientes')->name('cliente.')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('index');
    Route::get('/novo', [ClienteController::class, 'create'])->name('create');
    Route::post('/', [ClienteController::class, 'store'])->name('store');
    Route::post('/busca', [ClienteController::class, 'search'])->name('search');
    Route::get('/{id}/editar', [ClienteController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ClienteController::class, 'update'])->name('update');
    Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('destroy');
});

// ─── PEDIDOS ─────────────────────────────────────────────────────────
Route::prefix('admin/pedidos')->name('pedido.')->group(function () {
    Route::get('/', [PedidoController::class, 'index'])->name('index');
    Route::get('/novo', [PedidoController::class, 'create'])->name('create');
    Route::post('/', [PedidoController::class, 'store'])->name('store');
    Route::post('/busca', [PedidoController::class, 'search'])->name('search');
    Route::get('/{id}', [PedidoController::class, 'show'])->name('show');
    Route::get('/{id}/editar', [PedidoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PedidoController::class, 'update'])->name('update');
    Route::delete('/{id}', [PedidoController::class, 'destroy'])->name('destroy');
});
