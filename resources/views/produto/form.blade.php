@extends('admin')
@section('titulo', isset($dado) ? 'Editar Produto' : 'Novo Produto')
@section('conteudo')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('produto.index') }}" class="btn btn-sm btn-outline-gv"><i class="bi bi-arrow-left"></i></a>
    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">
        {{ isset($dado) ? 'Editar Produto' : 'Novo Produto' }}
    </h4>
</div>

<form action="{{ isset($dado) ? route('produto.update', $dado->id) : route('produto.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($dado)) @method('PUT') @endif

    <div class="row g-3">
        <!-- Coluna esquerda -->
        <div class="col-lg-8">
            <div class="card-gv mb-3">
                <div class="card-header">Informações Básicas</div>
                <div style="padding:1.25rem">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto *</label>
                        <input type="text" name="nome" class="form-control" value="{{ old('nome', $dado->nome ?? '') }}" required placeholder="Ex: God of War Ragnarök">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="5" placeholder="Descreva o produto...">{{ old('descricao', $dado->descricao ?? '') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Desenvolvedora</label>
                            <input type="text" name="desenvolvedora" class="form-control" value="{{ old('desenvolvedora', $dado->desenvolvedora ?? '') }}" placeholder="Ex: Sony Santa Monica">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Distribuidora</label>
                            <input type="text" name="distribuidora" class="form-control" value="{{ old('distribuidora', $dado->distribuidora ?? '') }}" placeholder="Ex: Sony Interactive">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-gv mb-3">
                <div class="card-header">Preço e Estoque</div>
                <div style="padding:1.25rem">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Preço (R$) *</label>
                            <input type="number" name="preco" step="0.01" min="0" class="form-control"
                                value="{{ old('preco', $dado->preco ?? '') }}" required placeholder="0,00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Preço Promocional (R$)</label>
                            <input type="number" name="preco_promocional" step="0.01" min="0" class="form-control"
                                value="{{ old('preco_promocional', $dado->preco_promocional ?? '') }}" placeholder="Deixe vazio se não tiver">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Estoque *</label>
                            <input type="number" name="estoque" min="0" class="form-control"
                                value="{{ old('estoque', $dado->estoque ?? 0) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-gv">
                <div class="card-header">Classificação</div>
                <div style="padding:1.25rem">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tipo *</label>
                            <select name="tipo" class="form-select" required>
                                <option value="jogo" @selected(old('tipo', $dado->tipo ?? 'jogo') === 'jogo')>🎮 Jogo</option>
                                <option value="console" @selected(old('tipo', $dado->tipo ?? '') === 'console')>🖥️ Console</option>
                                <option value="acessorio" @selected(old('tipo', $dado->tipo ?? '') === 'acessorio')>🎧 Acessório</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Classificação Etária</label>
                            <select name="classificacao_etaria" class="form-select">
                                <option value="">Selecione</option>
                                @foreach(['Livre','10','12','14','16','18'] as $c)
                                    <option value="{{ $c }}" @selected(old('classificacao_etaria', $dado->classificacao_etaria ?? '') == $c)>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Data de Lançamento</label>
                            <input type="date" name="data_lancamento" class="form-control"
                                value="{{ old('data_lancamento', isset($dado) && $dado->data_lancamento ? $dado->data_lancamento->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Plataforma</label>
                            <select name="plataforma_id" class="form-select">
                                <option value="">Selecione...</option>
                                @foreach($plataformas as $plat)
                                    <option value="{{ $plat->id }}" @selected(old('plataforma_id', $dado->plataforma_id ?? '') == $plat->id)>{{ $plat->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Categoria</label>
                            <select name="categoria_id" class="form-select">
                                <option value="">Selecione...</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('categoria_id', $dado->categoria_id ?? '') == $cat->id)>{{ $cat->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna direita -->
        <div class="col-lg-4">
            <div class="card-gv mb-3">
                <div class="card-header">Imagem do Produto</div>
                <div style="padding:1.25rem">
                    @if(isset($dado) && $dado->imagem)
                        <div style="margin-bottom:1rem;text-align:center">
                            <img src="/storage/{{ $dado->imagem }}" style="max-width:100%;border-radius:8px;border:1px solid var(--gv-border)" alt="Imagem atual">
                            <div style="font-size:0.72rem;color:var(--gv-muted);margin-top:0.4rem">Imagem atual</div>
                        </div>
                    @endif
                    <input type="file" name="imagem" class="form-control" accept="image/png,image/jpg,image/jpeg,image/webp">
                    <div style="font-size:0.72rem;color:var(--gv-muted);margin-top:0.4rem">PNG, JPG ou WEBP. Max 2MB.</div>
                </div>
            </div>

            <div class="card-gv mb-3">
                <div class="card-header">Opções</div>
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:0.75rem">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="ativo" id="ativo" {{ old('ativo', $dado->ativo ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo" style="color:var(--gv-text);font-size:0.88rem">Produto ativo (visível na loja)</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="destaque" id="destaque" {{ old('destaque', $dado->destaque ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="destaque" style="color:var(--gv-text);font-size:0.88rem">Produto em destaque na home</label>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column gap-2">
                <button type="submit" class="btn btn-gv py-2">
                    <i class="bi bi-check-circle me-2"></i> {{ isset($dado) ? 'Salvar Alterações' : 'Cadastrar Produto' }}
                </button>
                <a href="{{ route('produto.index') }}" class="btn btn-outline-gv">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@endsection
