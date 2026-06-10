@extends('admin')
@section('titulo', isset($dado) ? 'Editar Plataforma' : 'Nova Plataforma')
@section('conteudo')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('plataforma.index') }}" class="btn btn-sm btn-outline-gv">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">
        {{ isset($dado) ? 'Editar Plataforma' : 'Nova Plataforma' }}
    </h4>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card-gv">
            <div class="card-header">Dados da Plataforma</div>
            <div style="padding:1.5rem">
                <form action="{{ isset($dado) ? route('plataforma.update', $dado->id) : route('plataforma.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($dado))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" name="nome" class="form-control" value="{{ old('nome', $dado->nome ?? '') }}" required placeholder="Ex: PlayStation 5">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Fabricante</label>
                            <input type="text" name="fabricante" class="form-control" value="{{ old('fabricante', $dado->fabricante ?? '') }}" placeholder="Ex: Sony, Microsoft">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ano de Lançamento</label>
                            <input type="number" name="ano_lancamento" class="form-control" min="1970" max="{{ date('Y')+1 }}" value="{{ old('ano_lancamento', $dado->ano_lancamento ?? '') }}" placeholder="{{ date('Y') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagem</label>
                        @if(isset($dado) && $dado->imagem)
                            <div class="mb-2">
                                <img src="/storage/{{ $dado->imagem }}" style="max-height:80px;border-radius:6px;border:1px solid var(--gv-border)" alt="">
                            </div>
                        @endif
                        <input type="file" name="imagem" class="form-control" accept="image/png,image/jpg,image/jpeg,image/webp">
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="ativo" id="ativo" {{ old('ativo', $dado->ativo ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo" style="color:var(--gv-text)">Plataforma ativa</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gv flex-grow-1">
                            <i class="bi bi-check-circle me-2"></i>{{ isset($dado) ? 'Salvar' : 'Cadastrar' }}
                        </button>
                        <a href="{{ route('plataforma.index') }}" class="btn btn-outline-gv">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
