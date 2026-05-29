<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PedidoController extends Controller
{
    public function index()
    {
        $dados = Pedido::with('cliente')->orderByDesc('created_at')->get();
        return view('pedido.list', ['dados' => $dados]);
    }

    public function create()
    {
        $clientes = Cliente::where('ativo', true)->orderBy('nome')->get();
        $produtos  = Produto::where('ativo', true)->where('estoque', '>', 0)->orderBy('nome')->get();
        return view('pedido.form', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'     => 'required|exists:clientes,id',
            'forma_pagamento' => 'required',
            'produtos'       => 'required|array|min:1',
            'produtos.*'     => 'exists:produtos,id',
            'quantidades.*'  => 'integer|min:1',
        ], [
            'cliente_id.required' => 'Selecione um cliente.',
            'produtos.required'   => 'Adicione ao menos um produto.',
        ]);

        $numero = 'PED-' . strtoupper(Str::random(8));

        $pedido = Pedido::create([
            'numero'          => $numero,
            'cliente_id'      => $request->cliente_id,
            'status'          => 'pendente',
            'forma_pagamento' => $request->forma_pagamento,
            'frete'           => $request->frete ?? 0,
            'desconto'        => $request->desconto ?? 0,
            'observacoes'     => $request->observacoes,
            'subtotal'        => 0,
            'total'           => 0,
        ]);

        $subtotal = 0;
        foreach ($request->produtos as $i => $produtoId) {
            $produto = Produto::findOrFail($produtoId);
            $qtd     = $request->quantidades[$i] ?? 1;
            $preco   = $produto->preco_final;
            $sub     = $preco * $qtd;

            PedidoItem::create([
                'pedido_id'      => $pedido->id,
                'produto_id'     => $produtoId,
                'quantidade'     => $qtd,
                'preco_unitario' => $preco,
                'subtotal'       => $sub,
            ]);

            $subtotal += $sub;
        }

        $total = $subtotal + ($pedido->frete ?? 0) - ($pedido->desconto ?? 0);
        $pedido->update(['subtotal' => $subtotal, 'total' => $total]);

        return redirect()->route('pedido.index')->with('success', "Pedido $numero criado com sucesso!");
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'itens.produto'])->findOrFail($id);
        return view('pedido.show', compact('pedido'));
    }

    public function edit($id)
    {
        $dado     = Pedido::with('itens.produto')->findOrFail($id);
        $clientes = Cliente::where('ativo', true)->orderBy('nome')->get();
        $produtos  = Produto::where('ativo', true)->orderBy('nome')->get();
        return view('pedido.form', compact('dado', 'clientes', 'produtos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status'          => 'required',
            'forma_pagamento' => 'required',
        ]);

        $data = $request->only(['status', 'forma_pagamento', 'frete', 'desconto', 'observacoes']);

        $pedido = Pedido::findOrFail($id);
        $total  = $pedido->subtotal + ($data['frete'] ?? 0) - ($data['desconto'] ?? 0);
        $data['total'] = $total;

        $pedido->update($data);
        return redirect()->route('pedido.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->itens()->delete();
        $pedido->delete();
        return redirect()->route('pedido.index')->with('success', 'Pedido removido com sucesso!');
    }

    public function search(Request $request)
    {
        $query = Pedido::with('cliente');
        if (!empty($request->valor)) {
            if ($request->tipo === 'cliente') {
                $query->whereHas('cliente', fn($q) => $q->where('nome', 'like', '%' . $request->valor . '%'));
            } else {
                $query->where($request->tipo, 'like', '%' . $request->valor . '%');
            }
        }
        $dados = $query->orderByDesc('created_at')->get();
        return view('pedido.list', ['dados' => $dados]);
    }
}
