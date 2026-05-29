@extends('admin')
@section('titulo', isset($dado) ? 'Editar Categoria' : 'Nova Categoria')
@section('conteudo')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('categoria.index') }}" class="btn btn-sm btn-outline-gv"><i class="bi bi-arrow-left"></i></a>
    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">{{ isset($dado) ? 'Editar Categoria' : 'Nova Categoria' }}</h4>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-gv">
            <div class="card-header">Dados da Categoria</div>
            <div style="padding:1.5rem">
                <form action="{{ isset($dado) ? route('categoria.update', $dado->id) : route('categoria.store') }}" method="POST">
                    @csrf
                    @if(isset($dado)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" class="form-control" value="{{ old('nome', $dado->nome ?? '') }}" required placeholder="Ex: RPG, Ação, Aventura...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" placeholder="Descreva a categoria...">{{ old('descricao', $dado->descricao ?? '') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="ativo" id="ativo" {{ old('ativo', $dado->ativo ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo" style="color:var(--gv-text)">Categoria ativa</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gv flex-grow-1">
                            <i class="bi bi-check-circle me-2"></i>{{ isset($dado) ? 'Salvar' : 'Cadastrar' }}
                        </button>
                        <a href="{{ route('categoria.index') }}" class="btn btn-outline-gv">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
