@extends('admin')
@section('titulo', 'Relatórios de Vendas')
@section('conteudo')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Relatórios de Vendas</h4>
        <div style="color:var(--gv-muted);font-size:0.82rem">Análise gráfica do desempenho comercial da loja</div>
    </div>
    <a href="{{ route('pedido.report') }}" class="btn btn-gv">
        <i class="bi bi-file-earmark-pdf me-2"></i> Exportar PDF
    </a>
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
</div>

@endsection

@section('scripts')
<script src="{{ $chart1->cdn() }}"></script>
{!! $chart1->script() !!}
{!! $chart2->script() !!}
@endsection
