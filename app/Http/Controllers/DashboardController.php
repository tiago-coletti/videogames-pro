<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Pedido;
use App\Models\Cliente;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProdutos'  => Produto::where('ativo', true)->count(),
            'totalPedidos'   => Pedido::count(),
            'totalClientes'  => Cliente::count(),
            'totalVendas'    => Pedido::whereNotIn('status', ['cancelado'])->sum('total'),
            'ultimosPedidos' => Pedido::with('cliente')->orderByDesc('created_at')->take(6)->get(),
            'estoqueBaixo'   => Produto::with('plataforma')->where('estoque', '<=', 5)->where('estoque', '>=', 0)->orderBy('estoque')->take(8)->get(),
        ]);
    }
}
