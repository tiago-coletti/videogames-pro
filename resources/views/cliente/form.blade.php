@extends('admin')
@section('titulo', isset($dado) ? 'Editar Cliente' : 'Novo Cliente')
@section('conteudo')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('cliente.index') }}" class="btn btn-sm btn-outline-gv"><i class="bi bi-arrow-left"></i></a>
    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">{{ isset($dado) ? 'Editar Cliente' : 'Novo Cliente' }}</h4>
</div>

<form action="{{ isset($dado) ? route('cliente.update', $dado->id) : route('cliente.store') }}" method="POST">
    @csrf
    @if(isset($dado)) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card-gv mb-3">
                <div class="card-header">Dados Pessoais</div>
                <div style="padding:1.25rem">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Nome Completo *</label>
                            <input type="text" name="nome" class="form-control" value="{{ old('nome', $dado->nome ?? '') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control" value="{{ old('cpf', $dado->cpf ?? '') }}" placeholder="000.000.000-00" maxlength="14">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-mail *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $dado->email ?? '') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone', $dado->telefone ?? '') }}" placeholder="(49) 9 9999-9999">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control"
                                value="{{ old('data_nascimento', isset($dado) && $dado->data_nascimento ? $dado->data_nascimento->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-gv">
                <div class="card-header">Endereço</div>
                <div style="padding:1.25rem">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">CEP</label>
                            <input type="text" name="cep" class="form-control" value="{{ old('cep', $dado->cep ?? '') }}" placeholder="00000-000" maxlength="9">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label">Logradouro</label>
                            <input type="text" name="logradouro" class="form-control" value="{{ old('logradouro', $dado->logradouro ?? '') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Número</label>
                            <input type="text" name="numero" class="form-control" value="{{ old('numero', $dado->numero ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Complemento</label>
                            <input type="text" name="complemento" class="form-control" value="{{ old('complemento', $dado->complemento ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bairro</label>
                            <input type="text" name="bairro" class="form-control" value="{{ old('bairro', $dado->bairro ?? '') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cidade</label>
                            <input type="text" name="cidade" class="form-control" value="{{ old('cidade', $dado->cidade ?? '') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">UF</label>
                            <input type="text" name="estado" class="form-control" value="{{ old('estado', $dado->estado ?? '') }}" maxlength="2" placeholder="SC">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-gv mb-3">
                <div class="card-header">Opções</div>
                <div style="padding:1.25rem">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="ativo" id="ativo" {{ old('ativo', $dado->ativo ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ativo" style="color:var(--gv-text)">Cliente ativo</label>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                <button type="submit" class="btn btn-gv py-2">
                    <i class="bi bi-check-circle me-2"></i>{{ isset($dado) ? 'Salvar' : 'Cadastrar' }}
                </button>
                <a href="{{ route('cliente.index') }}" class="btn btn-outline-gv">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@endsection
