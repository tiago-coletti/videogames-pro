@extends('admin')
@section('titulo', 'Pedido ' . $pedido->numero)
@section('conteudo')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pedido.index') }}" class="btn btn-sm btn-outline-gv"><i class="bi bi-arrow-left"></i></a>
    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Pedido {{ $pedido->numero }}</h4>
    <span class="badge bg-{{ $pedido->status_color }}">{{ $pedido->status_label }}</span>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <!-- Itens -->
        <div class="card-gv mb-3">
            <div class="card-header"><i class="bi bi-box-seam me-2" style="color:var(--gv-accent)"></i>Itens do Pedido</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Produto</th><th>Plataforma</th><th>Qtd</th><th>Preço Un.</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        @foreach($pedido->itens as $item)
                        <tr>
                            <td style="font-weight:500;font-size:0.88rem">{{ $item->produto->nome }}</td>
                            <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->produto->plataforma->nome ?? '—' }}</td>
                            <td>{{ $item->quantidade }}</td>
                            <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                            <td style="font-family:'Rajdhani',sans-serif;font-weight:700">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Cliente -->
        <div class="card-gv mb-3">
            <div class="card-header"><i class="bi bi-person me-2" style="color:var(--gv-accent)"></i>Cliente</div>
            <div style="padding:1rem">
                <div style="font-weight:600;margin-bottom:0.25rem">{{ $pedido->cliente->nome }}</div>
                <div style="font-size:0.82rem;color:var(--gv-muted)">{{ $pedido->cliente->email }}</div>
                @if($pedido->cliente->telefone)
                    <div style="font-size:0.82rem;color:var(--gv-muted)">{{ $pedido->cliente->telefone }}</div>
                @endif
            </div>
        </div>

        <!-- Resumo financeiro -->
        <div class="card-gv mb-3">
            <div class="card-header"><i class="bi bi-receipt me-2" style="color:var(--gv-accent)"></i>Resumo</div>
            <div style="padding:1rem">
                <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem">
                    <span style="color:var(--gv-muted)">Subtotal</span>
                    <span>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem">
                    <span style="color:var(--gv-muted)">Frete</span>
                    <span>R$ {{ number_format($pedido->frete, 2, ',', '.') }}</span>
                </div>
                @if($pedido->desconto > 0)
                <div class="d-flex justify-content-between mb-2" style="font-size:0.85rem">
                    <span style="color:var(--gv-muted)">Desconto</span>
                    <span style="color:var(--gv-red)">- R$ {{ number_format($pedido->desconto, 2, ',', '.') }}</span>
                </div>
                @endif
                <hr style="border-color:var(--gv-border)">
                <div class="d-flex justify-content-between">
                    <span style="font-family:'Rajdhani',sans-serif;font-weight:700">Total</span>
                    <span style="font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1.2rem;color:var(--gv-green)">
                        R$ {{ number_format($pedido->total, 2, ',', '.') }}
                    </span>
                </div>
                <div style="font-size:0.8rem;color:var(--gv-muted);margin-top:0.5rem;text-transform:capitalize">
                    <i class="bi bi-credit-card me-1"></i> {{ $pedido->forma_pagamento ?? '—' }}
                </div>
            </div>
        </div>

        <a href="{{ route('pedido.edit', $pedido->id) }}" class="btn btn-gv w-100">
            <i class="bi bi-pencil me-2"></i> Editar Pedido
        </a>
    </div>
</div>
@endsection
