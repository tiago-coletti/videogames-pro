<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Cliente;
use App\Models\Produto;
use App\Charts\JogosMaisVendidos;
use App\Charts\PlataformasMaisVendidas;
use App\Charts\StatusPedidosChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    function index()
    {
        $dados = Pedido::with('cliente')->orderByDesc('created_at')->get();
        return view('pedido.list', ['dados' => $dados]);
    }

    function create()
    {
        $clientes = Cliente::where('ativo', true)->orderBy('nome')->get();
        $produtos  = Produto::where('ativo', true)->where('estoque', '>', 0)->orderBy('nome')->get();

        return view('pedido.form', compact('clientes', 'produtos'));
    }

    function store(Request $request)
    {
        $this->validateRequest($request);

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
            $produto = Produto::find($produtoId);
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

        return redirect('pedido')->with('success', 'Registro cadastrado com sucesso!');
    }

    function show($id)
    {
        $pedido = Pedido::with(['cliente', 'itens.produto'])->find($id);
        return view('pedido.show', compact('pedido'));
    }

    function edit($id)
    {
        $dado     = Pedido::with('itens.produto')->find($id);
        $clientes = Cliente::where('ativo', true)->orderBy('nome')->get();
        $produtos  = Produto::where('ativo', true)->orderBy('nome')->get();

        return view('pedido.form', compact('dado', 'clientes', 'produtos'));
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request, true);

        $data = $request->only(['status', 'forma_pagamento', 'frete', 'desconto', 'observacoes']);

        $pedido = Pedido::find($id);
        $total  = $pedido->subtotal + ($data['frete'] ?? 0) - ($data['desconto'] ?? 0);
        $data['total'] = $total;

        $pedido->update($data);

        return redirect('pedido')->with('success', 'Registro updated com sucesso!');
    }

    function destroy($id)
    {
        $pedido = Pedido::find($id);
        $pedido->itens()->delete();

        Pedido::destroy($id);

        return redirect('pedido')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
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

    public function chart(JogosMaisVendidos $chart1, PlataformasMaisVendidas $chart2, StatusPedidosChart $chart3)
    {
        return view('pedido.analytics', [
            'chart1' => $chart1->build(),
            'chart2' => $chart2->build(),
            'chart3' => $chart3->build(),
        ]);
    }

    public function report()
    {
        $pedidos = Pedido::with('cliente')->orderByDesc('created_at')->get();
        $data = [
            'titulo' => 'Relatório Geral de Pedidos',
            'pedidos' => $pedidos
        ];
        $pdf = Pdf::loadView('pedido.report', $data);
        return $pdf->download('relatorio_geral_pedidos.pdf');
    }

    public function reportJogos()
    {
        $jogos = PedidoItem::select('produto_id', DB::raw('SUM(quantidade) as total_vendido'), DB::raw('SUM(subtotal) as receita_total'))
            ->with('produto')
            ->groupBy('produto_id')
            ->orderByDesc('total_vendido')
            ->get();

        $data = [
            'titulo' => 'Relatório de Jogos Mais Vendidos',
            'jogos' => $jogos
        ];
        $pdf = Pdf::loadView('pedido.report_jogos', $data);
        return $pdf->download('relatorio_jogos_mais_vendidos.pdf');
    }

    public function reportPlataformas()
    {
        $plataformas = PedidoItem::select('produtos.plataforma_id', DB::raw('SUM(pedido_itens.quantidade) as total_vendido'), DB::raw('SUM(pedido_itens.subtotal) as receita_total'))
            ->join('produtos', 'pedido_itens.produto_id', '=', 'produtos.id')
            ->with('produto.plataforma')
            ->groupBy('produtos.plataforma_id')
            ->orderByDesc('total_vendido')
            ->get();

        $data = [
            'titulo' => 'Relatório de Plataformas Mais Vendidas',
            'plataformas' => $plataformas
        ];
        $pdf = Pdf::loadView('pedido.report_plataformas', $data);
        return $pdf->download('relatorio_plataformas_mais_vendidas.pdf');
    }

    public function reportStatus()
    {
        $statusCounts = DB::table('pedidos')
            ->select('status', DB::raw('COUNT(*) as total_pedidos'), DB::raw('SUM(total) as receita_total'))
            ->groupBy('status')
            ->orderByDesc('total_pedidos')
            ->get();

        $data = [
            'titulo' => 'Relatório de Status de Pedidos',
            'statusCounts' => $statusCounts
        ];
        $pdf = Pdf::loadView('pedido.report_status', $data);
        return $pdf->download('relatorio_status_pedidos.pdf');
    }

    function validateRequest(Request $request, $isUpdate = false)
    {
        if ($isUpdate) {
            $request->validate([
                'status'          => 'required',
                'forma_pagamento' => 'required',
            ]);
        } else {
            $request->validate([
                'cliente_id'      => 'required|exists:clientes,id',
                'forma_pagamento' => 'required',
                'produtos'        => 'required|array|min:1',
                'produtos.*'      => 'exists:produtos,id',
                'quantidades.*'   => 'integer|min:1',
            ], [
                'cliente_id.required' => 'Selecione um cliente.',
                'produtos.required'   => 'Adicione ao menos um produto.',
            ]);
        }
    }
}
