<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class JogosMaisVendidos
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $vendasPorJogo = DB::table('pedido_itens')
            ->join('produtos', 'produtos.id', '=', 'pedido_itens.produto_id')
            ->where('produtos.tipo', '=', 'jogo')
            ->select('produtos.nome', DB::raw('SUM(pedido_itens.quantidade) as qtd_vendas'))
            ->groupBy('produtos.id', 'produtos.nome')
            ->orderBy('qtd_vendas', 'desc')
            ->take(10)
            ->get();

        $qtdVendas = [];
        $nomeJogos = [];

        foreach ($vendasPorJogo as $item) {
            $qtdVendas[] = (int) $item->qtd_vendas;
            $nomeJogos[] = $item->nome;
        }

        return $this->chart->barChart()
            ->setTitle('Produtos Mais Vendidos (Jogos)')
            ->setSubtitle('Volume total de unidades pedidas')
            ->addData($qtdVendas)
            ->setLabels($nomeJogos);
    }
}
