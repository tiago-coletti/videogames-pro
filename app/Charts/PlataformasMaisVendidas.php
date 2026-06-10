<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class PlataformasMaisVendidas
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $vendasPorPlataforma = DB::table('pedido_itens')
            ->join('produtos', 'produtos.id', '=', 'pedido_itens.produto_id')
            ->join('plataformas', 'plataformas.id', '=', 'produtos.plataforma_id')
            ->select('plataformas.nome', DB::raw('SUM(pedido_itens.quantidade) as qtd_vendas'))
            ->groupBy('plataformas.id', 'plataformas.nome')
            ->orderBy('qtd_vendas', 'desc')
            ->get();

        $qtdVendas = [];
        $nomePlataformas = [];

        foreach ($vendasPorPlataforma as $item) {
            $qtdVendas[] = (int) $item->qtd_vendas;
            $nomePlataformas[] = $item->nome;
        }

        return $this->chart->pieChart()
            ->setTitle('Proporção de Vendas por Plataforma')
            ->setSubtitle('Volume total por ecossistema')
            ->addData($qtdVendas)
            ->setLabels($nomePlataformas);
    }
}
