<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class CarrinhoController extends Controller
{
    function index()
    {
        $carrinho = $this->getCarrinho();
        $total    = 0;
        $itens    = [];

        foreach ($carrinho as $produtoId => $item) {
            $produto = Produto::find($produtoId);
            if ($produto) {
                $subtotal = $produto->preco_final * $item['quantidade'];
                $total   += $subtotal;
                $itens[]  = [
                    'produto'   => $produto,
                    'quantidade' => $item['quantidade'],
                    'subtotal'  => $subtotal,
                ];
            }
        }

        return view('carrinho.index', compact('itens', 'total'));
    }

    function adicionar(Request $request, $produtoId)
    {
        $produto = Produto::findOrFail($produtoId);
        $carrinho = $this->getCarrinho();
        $qtd = (int) ($request->quantidade ?? 1);

        if (isset($carrinho[$produtoId])) {
            $carrinho[$produtoId]['quantidade'] += $qtd;
        } else {
            $carrinho[$produtoId] = ['quantidade' => $qtd];
        }

        $this->saveCarrinho($carrinho);

        return redirect()->back()->with('success', '"' . $produto->nome . '" adicionado ao carrinho!');
    }

    function atualizar(Request $request, $produtoId)
    {
        $carrinho = $this->getCarrinho();
        $qtd = (int) $request->quantidade;

        if ($qtd <= 0) {
            unset($carrinho[$produtoId]);
        } else {
            $carrinho[$produtoId]['quantidade'] = $qtd;
        }

        $this->saveCarrinho($carrinho);

        return redirect()->route('carrinho.index')->with('success', 'Carrinho atualizado!');
    }

    function remover($produtoId)
    {
        $carrinho = $this->getCarrinho();
        unset($carrinho[$produtoId]);
        $this->saveCarrinho($carrinho);

        return redirect()->route('carrinho.index')->with('success', 'Item removido do carrinho.');
    }

    function limpar()
    {
        session()->forget('carrinho');

        return redirect()->route('carrinho.index')->with('success', 'Carrinho esvaziado.');
    }

    function finalizar(Request $request)
    {
        $request->validate([
            'nome'            => 'required',
            'email'           => 'required|email',
            'forma_pagamento' => 'required',
        ]);

        $carrinho = $this->getCarrinho();
        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('error', 'Seu carrinho está vazio.');
        }

        session()->forget('carrinho');

        return redirect()->route('loja.index')->with('success', 'Pedido finalizado com sucesso! Em breve você receberá a confirmação.');
    }

    private function getCarrinho()
    {
        return session('carrinho', []);
    }

    private function saveCarrinho(array $carrinho)
    {
        session(['carrinho' => $carrinho]);
    }
}
