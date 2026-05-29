@extends('admin')
@section('titulo', 'Pedidos')
@section('conteudo')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Pedidos</h4>
        <div style="color:var(--gv-muted);font-size:0.82rem">{{ $dados->count() }} pedido(s)</div>
    </div>
    <a href="{{ route('pedido.create') }}" class="btn btn-gv"><i class="bi bi-plus-circle me-2"></i> Novo Pedido</a>
</div>

<div class="card-gv mb-3">
    <div style="padding:1rem 1.25rem">
        <form action="{{ route('pedido.search') }}" method="POST" class="d-flex gap-2">
            @csrf
            <select name="tipo" class="form-select" style="max-width:160px">
                <option value="numero">Número</option>
                <option value="status">Status</option>
                <option value="cliente">Cliente</option>
            </select>
            <input type="text" name="valor" class="form-control" placeholder="Buscar pedido...">
            <button type="submit" class="btn btn-gv"><i class="bi bi-search me-1"></i> Buscar</button>
            <a href="{{ route('pedido.index') }}" class="btn btn-outline-gv"><i class="bi bi-x"></i></a>
        </form>
    </div>
</div>

<div class="card-gv">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Pagamento</th>
                    <th>Itens</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $item)
                <tr>
                    <td>
                        <a href="{{ route('pedido.show', $item->id) }}" style="color:var(--gv-accent);text-decoration:none;font-weight:600;font-size:0.85rem">
                            {{ $item->numero }}
                        </a>
                    </td>
                    <td style="font-size:0.85rem">{{ $item->cliente->nome }}</td>
                    <td style="font-size:0.8rem;color:var(--gv-muted);text-transform:capitalize">{{ $item->forma_pagamento ?? '—' }}</td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->itens->count() }} item(ns)</td>
                    <td style="font-family:'Rajdhani',sans-serif;font-weight:700;color:var(--gv-green)">
                        R$ {{ number_format($item->total, 2, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge bg-{{ $item->status_color }} badge-status">{{ $item->status_label }}</span>
                    </td>
                    <td style="font-size:0.8rem;color:var(--gv-muted)">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('pedido.edit', $item->id) }}" class="btn btn-sm btn-outline-gv"><i class="bi bi-pencil"></i></a></td>
                    <td>
                        <form action="{{ route('pedido.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="border:1px solid var(--gv-red);color:var(--gv-red);background:none"
                                onclick="return confirm('Remover pedido?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center" style="padding:3rem;color:var(--gv-muted)">Nenhum pedido cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
