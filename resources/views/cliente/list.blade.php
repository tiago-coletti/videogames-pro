@extends('admin')
@section('titulo', 'Clientes')
@section('conteudo')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">Clientes</h4>
        <div style="color:var(--gv-muted);font-size:0.82rem">{{ $dados->count() }} cliente(s)</div>
    </div>
    <a href="{{ route('cliente.create') }}" class="btn btn-gv"><i class="bi bi-person-plus me-2"></i> Novo Cliente</a>
</div>

<div class="card-gv mb-3">
    <div style="padding:1rem 1.25rem">
        <form action="{{ route('cliente.search') }}" method="POST" class="d-flex gap-2">
            @csrf
            <select name="tipo" class="form-select" style="max-width:160px">
                <option value="nome">Nome</option>
                <option value="email">E-mail</option>
                <option value="cpf">CPF</option>
                <option value="telefone">Telefone</option>
            </select>
            <input type="text" name="valor" class="form-control" placeholder="Buscar cliente...">
            <button type="submit" class="btn btn-gv"><i class="bi bi-search me-1"></i> Buscar</button>
            <a href="{{ route('cliente.index') }}" class="btn btn-outline-gv"><i class="bi bi-x"></i></a>
        </form>
    </div>
</div>

<div class="card-gv">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Pedidos</th>
                    <th>Status</th>
                    <th colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dados as $item)
                <tr>
                    <td style="color:var(--gv-muted);font-size:0.8rem">{{ $item->id }}</td>
                    <td style="font-weight:500">{{ $item->nome }}</td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->email }}</td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->cpf ?? '—' }}</td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->telefone ?? '—' }}</td>
                    <td style="font-size:0.82rem;color:var(--gv-muted)">{{ $item->cidade ? $item->cidade . '/' . $item->estado : '—' }}</td>
                    <td><span style="color:var(--gv-accent);font-family:'Rajdhani',sans-serif;font-weight:700">{{ $item->pedidos->count() }}</span></td>
                    <td>
                        @if($item->ativo)
                            <span class="badge bg-success badge-status">Ativo</span>
                        @else
                            <span class="badge bg-secondary badge-status">Inativo</span>
                        @endif
                    </td>
                    <td><a href="{{ route('cliente.edit', $item->id) }}" class="btn btn-sm btn-outline-gv"><i class="bi bi-pencil"></i></a></td>
                    <td>
                        <form action="{{ route('cliente.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="border:1px solid var(--gv-red);color:var(--gv-red);background:none"
                                onclick="return confirm('Remover cliente?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center" style="padding:3rem;color:var(--gv-muted)">Nenhum cliente cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
