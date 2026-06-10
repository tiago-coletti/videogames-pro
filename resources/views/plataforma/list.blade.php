@extends('admin')
@section('titulo', 'Plataformas')
@section('conteudo')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Plataformas</h4>
        <div style="color:var(--gv-muted);font-size:0.82rem">{{ $dados->count() }} plataforma(s)</div>
    </div>
    <a href="{{ route('plataforma.create') }}" class="btn btn-gv">
        <i class="bi bi-plus-circle me-2"></i> Nova Plataforma
    </a>
</div>

<div class="card-gv mb-3">
    <div style="padding:1rem 1.25rem">
        <form action="{{ route('plataforma.search') }}" method="POST" class="d-flex gap-2">
            @csrf
            <select name="tipo" class="form-select" style="max-width:160px">
                <option value="nome">Nome</option>
                <option value="fabricante">Fabricante</option>
            </select>
            <input type="text" name="valor" class="form-control" placeholder="Buscar...">
            <button type="submit" class="btn btn-gv">
                <i class="bi bi-search me-1"></i> Buscar
            </button>
            <a href="{{ route('plataforma.index') }}" class="btn btn-outline-gv">
                <i class="bi bi-x"></i>
            </a>
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
                    <th>Fabricante</th>
                    <th>Lançamento</th>
                    <th>Produtos</th>
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
                            <img src="/storage/{{ $item->imagem }}" width="40" height="40" style="object-fit:cover;border-radius:6px;border:1px solid var(--gv-border)">
                        @else
                            <div style="width:40px;height:40px;background:var(--gv-border);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--gv-muted)">
                                <i class="bi bi-device-ssd"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight:500">{{ $item->nome }}</td>
                    <td style="color:var(--gv-muted);font-size:0.85rem">{{ $item->fabricante ?? '—' }}</td>
                    <td style="color:var(--gv-muted);font-size:0.85rem">{{ $item->ano_lancamento ?? '—' }}</td>
                    <td>
                        <span style="color:var(--gv-accent);font-family:'Rajdhani',sans-serif;font-weight:700">{{ $item->produtos->count() }}</span>
                    </td>
                    <td>
                        @if($item->ativo)
                            <span class="badge bg-success badge-status">Ativo</span>
                        @else
                            <span class="badge bg-secondary badge-status">Inativo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('plataforma.edit', $item->id) }}" class="btn btn-sm btn-outline-gv">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('plataforma.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="border:1px solid var(--gv-red);color:var(--gv-red);background:none" onclick="return confirm('Remover plataforma?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:3rem;color:var(--gv-muted)">
                        Nenhuma plataforma cadastrada.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
