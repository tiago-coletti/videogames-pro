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

Route::get('/', [LojaController::class, 'index'])->name('loja.index');
Route::get('/catalogo', [LojaController::class, 'catalogo'])->name('loja.catalogo');
Route::get('/produto/{id}', [LojaController::class, 'produto'])->name('loja.produto');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/registro', [AuthController::class, 'registro'])->name('registro.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/adicionar/{produto}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::post('/carrinho/atualizar/{produto}', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar');
Route::post('/carrinho/remover/{produto}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::post('/carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');
Route::post('/carrinho/finalizar', [CarrinhoController::class, 'finalizar'])->name('carrinho.finalizar');

Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/produto', [ProdutoController::class, 'index'])->name('produto.index');
Route::get('/produto/create', [ProdutoController::class, 'create'])->name('produto.create');
Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');
Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');
Route::post('/produto/search', [ProdutoController::class, 'search'])->name('produto.search');
Route::get('/produto/{id}', [ProdutoController::class, 'show'])->name('produto.show');
Route::get('produto/edit/{id}', [ProdutoController::class, 'edit'])->name('produto.edit');
Route::put('produto/update/{id}', [ProdutoController::class, 'update'])->name('produto.update');

Route::get('/categoria', [CategoriaController::class, 'index'])->name('categoria.index');
Route::get('/categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
Route::post('/categoria', [CategoriaController::class, 'store'])->name('categoria.store');
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
Route::post('/categoria/search', [CategoriaController::class, 'search'])->name('categoria.search');
Route::get('categoria/edit/{id}', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::put('categoria/update/{id}', [CategoriaController::class, 'update'])->name('categoria.update');

Route::get('/plataforma', [PlataformaController::class, 'index'])->name('plataforma.index');
Route::get('/plataforma/create', [PlataformaController::class, 'create'])->name('plataforma.create');
Route::post('/plataforma', [PlataformaController::class, 'store'])->name('plataforma.store');
Route::delete('/plataforma/{id}', [PlataformaController::class, 'destroy'])->name('plataforma.destroy');
Route::post('/plataforma/search', [PlataformaController::class, 'search'])->name('plataforma.search');
Route::get('plataforma/edit/{id}', [PlataformaController::class, 'edit'])->name('plataforma.edit');
Route::put('plataforma/update/{id}', [PlataformaController::class, 'update'])->name('plataforma.update');

Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente.index');
Route::get('/cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
Route::post('/cliente', [ClienteController::class, 'store'])->name('cliente.store');
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
Route::post('/cliente/search', [ClienteController::class, 'search'])->name('cliente.search');
Route::get('cliente/edit/{id}', [ClienteController::class, 'edit'])->name('cliente.edit');
Route::put('cliente/update/{id}', [ClienteController::class, 'update'])->name('cliente.update');

Route::get('/pedido', [PedidoController::class, 'index'])->name('pedido.index');
Route::get('/pedido/create', [PedidoController::class, 'create'])->name('pedido.create');
Route::post('/pedido', [PedidoController::class, 'store'])->name('pedido.store');
Route::delete('/pedido/{id}', [PedidoController::class, 'destroy'])->name('pedido.destroy');
Route::post('/pedido/search', [PedidoController::class, 'search'])->name('pedido.search');
Route::get('/pedido/{id}', [PedidoController::class, 'show'])->name('pedido.show');
Route::get('pedido/edit/{id}', [PedidoController::class, 'edit'])->name('pedido.edit');
Route::put('pedido/update/{id}', [PedidoController::class, 'update'])->name('pedido.update');
