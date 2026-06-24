<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class StatusPedidosChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $statusCounts = DB::table('pedidos')
            ->select('status', DB::raw('COUNT(*) as total_pedidos'))
            ->groupBy('status')
            ->get();

        $totais = [];
        $labels = [];

        foreach ($statusCounts as $item) {
            $totais[] = (int) $item->total_pedidos;
            $labels[] = ucfirst($item->status);
        }

        return $this->chart->areaChart()
            ->setTitle('Acompanhamento de Status dos Pedidos')
            ->setSubtitle('Volume de pedidos por etapa')
            ->addData($totais)
            ->setXAxis($labels);
    }
}
