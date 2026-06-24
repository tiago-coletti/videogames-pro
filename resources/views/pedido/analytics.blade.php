@extends('admin')
@section('titulo', 'Relatórios de Vendas')
@section('conteudo')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Relatórios de Vendas</h4>
        <div style="color:var(--gv-muted);font-size:0.82rem">Análise gráfica do desempenho comercial da loja</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('pedido.report') }}" class="btn btn-gv">
            <i class="bi bi-file-earmark-pdf me-2"></i> Geral PDF
        </a>
        <a href="{{ route('pedido.report_jogos') }}" class="btn btn-gv">
            <i class="bi bi-file-earmark-pdf me-2"></i> Jogos PDF
        </a>
        <a href="{{ route('pedido.report_plataformas') }}" class="btn btn-gv">
            <i class="bi bi-file-earmark-pdf me-2"></i> Plataformas PDF
        </a>
        <a href="{{ route('pedido.report_status') }}" class="btn btn-gv">
            <i class="bi bi-file-earmark-pdf me-2"></i> Status PDF
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-gv">
            <div class="card-header">Jogos Mais Vendidos</div>
            <div style="padding:1.25rem">
                {!! $chart1->container() !!}
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-gv">
            <div class="card-header">Plataformas Mais Vendidas</div>
            <div style="padding:1.25rem">
                {!! $chart2->container() !!}
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card-gv">
            <div class="card-header">Status de Pedidos</div>
            <div style="padding:1.25rem">
                {!! $chart3->container() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ $chart1->cdn() }}"></script>
{!! $chart1->script() !!}
{!! $chart2->script() !!}
{!! $chart3->script() !!}
@endsection
