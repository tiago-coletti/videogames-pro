@extends('admin')
@section('titulo', 'Dashboard')
@section('conteudo')

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(0,212,255,0.1);color:var(--gv-accent)">
                    <i class="bi bi-box-seam"></i>
                </div>
                <span style="font-size:0.72rem;color:var(--gv-green);background:rgba(0,255,136,0.1);padding:0.2rem 0.5rem;border-radius:4px">
                    Ativos
                </span>
            </div>
            <div class="stat-value">{{ $totalProdutos }}</div>
            <div class="stat-label">Produtos cadastrados</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(0,255,136,0.1);color:var(--gv-green)">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalPedidos }}</div>
            <div class="stat-label">Pedidos realizados</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(123,47,255,0.1);color:#b084ff">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stat-value">{{ $totalClientes }}</div>
            <div class="stat-label">Clientes cadastrados</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:rgba(255,215,0,0.1);color:var(--gv-yellow)">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <div class="stat-value" style="font-size:1.4rem">R$ {{ number_format($totalVendas, 2, ',', '.') }}</div>
            <div class="stat-label">Total em vendas</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-gv">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-receipt me-2" style="color:var(--gv-accent)"></i>Últimos Pedidos</span>
                <a href="{{ route('pedido.index') }}" class="btn btn-sm btn-outline-gv" style="font-size:0.75rem">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosPedidos as $pedido)
                        <tr>
                            <td><a href="{{ route('pedido.show', $pedido->id) }}" style="color:var(--gv-accent);text-decoration:none">{{ $pedido->numero }}</a></td>
                            <td style="font-size:0.85rem">{{ $pedido->cliente->nome }}</td>
                            <td style="font-family:'Rajdhani',sans-serif;font-weight:700;color:var(--gv-green)">
                                R$ {{ number_format($pedido->total, 2, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $pedido->status_color }} badge-status">
                                    {{ $pedido->status_label }}
                                </span>
                            </td>
                            <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $pedido->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center" style="color:var(--gv-muted);padding:2rem">Nenhum pedido ainda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-gv mb-3">
            <div class="card-header"><i class="bi bi-lightning me-2" style="color:var(--gv-accent)"></i>Ações Rápidas</div>
            <div style="padding:1rem;display:flex;flex-direction:column;gap:0.5rem">
                <a href="{{ route('produto.create') }}" class="btn btn-gv btn-sm">
                    <i class="bi bi-plus-circle me-2"></i> Novo Produto
                </a>
                <a href="{{ route('pedido.create') }}" class="btn btn-outline-gv btn-sm">
                    <i class="bi bi-receipt me-2"></i> Novo Pedido
                </a>
                <a href="{{ route('cliente.create') }}" class="btn btn-outline-gv btn-sm">
                    <i class="bi bi-person-plus me-2"></i> Novo Cliente
                </a>
                <a href="{{ route('plataforma.create') }}" class="btn btn-outline-gv btn-sm">
                    <i class="bi bi-device-ssd me-2"></i> Nova Plataforma
                </a>
            </div>
        </div>

        <div class="card-gv">
            <div class="card-header"><i class="bi bi-exclamation-triangle me-2" style="color:var(--gv-yellow)"></i>Estoque Baixo</div>
            <div style="padding:0.75rem">
                @forelse($estoqueBaixo as $p)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0.5rem;border-bottom:1px solid var(--gv-border)">
                    <div>
                        <div style="font-size:0.82rem;font-weight:500">{{ Str::limit($p->nome, 25) }}</div>
                        <div style="font-size:0.72rem;color:var(--gv-muted)">{{ $p->plataforma->nome ?? '—' }}</div>
                    </div>
                    <span style="background:rgba(255,68,102,0.1);color:var(--gv-red);border:1px solid rgba(255,68,102,0.3);border-radius:4px;padding:0.15rem 0.5rem;font-size:0.75rem;font-weight:700">
                        {{ $p->estoque }} un.
                    </span>
                </div>
                @empty
                <div style="text-align:center;padding:1.5rem;color:var(--gv-muted);font-size:0.82rem">
                    <i class="bi bi-check-circle" style="color:var(--gv-green)"></i> Todos os produtos OK
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
