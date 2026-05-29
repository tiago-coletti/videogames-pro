@extends('admin')
@section('titulo', 'Produtos')
@section('conteudo')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Produtos</h4>
        <div style="color:var(--gv-muted);font-size:0.82rem">{{ $dados->count() }} produto(s) encontrado(s)</div>
    </div>
    <a href="{{ route('produto.create') }}" class="btn btn-gv">
        <i class="bi bi-plus-circle me-2"></i> Novo Produto
    </a>
</div>

<!-- BUSCA -->
<div class="card-gv mb-3">
    <div style="padding:1rem 1.25rem">
        <form action="{{ route('produto.search') }}" method="POST" class="d-flex gap-2 flex-wrap">
            @csrf
            <select name="tipo" class="form-select" style="max-width:160px">
                <option value="nome">Nome</option>
                <option value="tipo">Tipo</option>
            </select>
            <input type="text" name="valor" class="form-control flex-grow-1" placeholder="Buscar produto...">
            <button type="submit" class="btn btn-gv"><i class="bi bi-search me-1"></i> Buscar</button>
            <a href="{{ route('produto.index') }}" class="btn btn-outline-gv"><i class="bi bi-x"></i></a>
        </form>
    </div>
</div>

<div class="card-gv">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Plataforma</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $item)
                <tr>
                    <td style="color:var(--gv-muted);font-size:0.8rem">{{ $item->id }}</td>
                    <td>
                        @if($item->imagem)
                            <img src="/storage/{{ $item->imagem }}" width="48" height="48" style="object-fit:cover;border-radius:6px;border:1px solid var(--gv-border)">
                        @else
                            <div style="width:48px;height:48px;background:var(--gv-border);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--gv-muted)">
                                <i class="bi bi-controller"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:500;font-size:0.88rem">{{ $item->nome }}</div>
                        @if($item->tem_promocao)
                            <span style="font-size:0.68rem;color:var(--gv-red);font-weight:600">PROMOÇÃO</span>
                        @endif
                    </td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->plataforma->nome ?? '—' }}</td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->categoria->nome ?? '—' }}</td>
                    <td>
                        <span style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--gv-accent)">{{ $item->tipo }}</span>
                    </td>
                    <td>
                        @if($item->tem_promocao)
                            <div style="font-size:0.75rem;text-decoration:line-through;color:var(--gv-muted)">R$ {{ number_format($item->preco, 2, ',', '.') }}</div>
                            <div style="font-family:'Rajdhani',sans-serif;font-weight:700;color:var(--gv-green)">R$ {{ number_format($item->preco_final, 2, ',', '.') }}</div>
                        @else
                            <div style="font-family:'Rajdhani',sans-serif;font-weight:700">R$ {{ number_format($item->preco, 2, ',', '.') }}</div>
                        @endif
                    </td>
                    <td>
                        @if($item->estoque <= 5)
                            <span style="color:{{ $item->estoque == 0 ? 'var(--gv-red)' : 'var(--gv-yellow)' }};font-weight:700">
                                {{ $item->estoque }}
                            </span>
                        @else
                            {{ $item->estoque }}
                        @endif
                    </td>
                    <td>
                        @if($item->ativo)
                            <span class="badge bg-success badge-status">Ativo</span>
                        @else
                            <span class="badge bg-secondary badge-status">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('produto.edit', $item->id) }}" class="btn btn-sm btn-outline-gv">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('produto.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="border:1px solid var(--gv-red);color:var(--gv-red);background:none"
                                onclick="return confirm('Remover produto?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center" style="padding:3rem;color:var(--gv-muted)">
                        <i class="bi bi-box-seam" style="font-size:2rem;display:block;margin-bottom:0.5rem"></i>
                        Nenhum produto cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
