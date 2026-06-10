@extends('admin')
@section('titulo', isset($dado) ? 'Editar Pedido' : 'Novo Pedido')
@section('conteudo')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pedido.index') }}" class="btn btn-sm btn-outline-gv">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin:0">
        {{ isset($dado) ? 'Editar Pedido #' . $dado->numero : 'Novo Pedido' }}
    </h4>
</div>

@if(isset($dado))
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card-gv mb-3">
            <div class="card-header">Itens do Pedido</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Qtd</th>
                            <th>Preço Un.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dado->itens as $item)
                        <tr>
                            <td style="font-size:0.85rem">{{ $item->produto->nome }}</td>
                            <td>{{ $item->quantidade }}</td>
                            <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                            <td style="font-weight:600">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-gv">
            <div class="card-header">Atualizar Pedido</div>
            <div style="padding:1.25rem">
                <form action="{{ route('pedido.update', $dado->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select" required>
                            @foreach(\App\Models\Pedido::$statusLabels as $val => $label)
                                <option value="{{ $val }}" @selected($dado->status === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Forma de Pagamento *</label>
                        <select name="forma_pagamento" class="form-select" required>
                            <option value="pix" @selected($dado->forma_pagamento==='pix')>Pix</option>
                            <option value="cartao" @selected($dado->forma_pagamento==='cartao')>Cartão</option>
                            <option value="boleto" @selected($dado->forma_pagamento==='boleto')>Boleto</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Frete (R$)</label>
                            <input type="number" name="frete" step="0.01" min="0" class="form-control" value="{{ $dado->frete }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Desconto (R$)</label>
                            <input type="number" name="desconto" step="0.01" min="0" class="form-control" value="{{ $dado->desconto }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Observações</label>
                        <textarea name="observacoes" class="form-control" rows="3">{{ $dado->observacoes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gv w-100">
                        <i class="bi bi-check-circle me-2"></i> Salvar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@else
<form action="{{ route('pedido.store') }}" method="POST" id="pedidoForm">
    @csrf
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card-gv mb-3">
                <div class="card-header">Dados do Pedido</div>
                <div style="padding:1.25rem">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cliente *</label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($clientes as $c)
                                    <option value="{{ $c->id }}">{{ $c->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Forma de Pagamento *</label>
                            <select name="forma_pagamento" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="pix">Pix</option>
                                <option value="cartao">Cartão de Crédito</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Frete (R$)</label>
                            <input type="number" name="frete" step="0.01" min="0" value="0" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Desconto (R$)</label>
                            <input type="number" name="desconto" step="0.01" min="0" value="0" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Observações</label>
                            <input type="text" name="observacoes" class="form-control" placeholder="Opcional">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-gv">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>Produtos</span>
                    <button type="button" onclick="addProduto()" class="btn btn-sm btn-gv">
                        <i class="bi bi-plus"></i> Adicionar Produto
                    </button>
                </div>
                <div style="padding:1.25rem" id="produtosContainer">
                    <div class="produto-row row g-2 mb-2 align-items-end">
                        <div class="col-7">
                            <label class="form-label">Produto</label>
                            <select name="produtos[]" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($produtos as $p)
                                    <option value="{{ $p->id }}" data-preco="{{ $p->preco_final }}">
                                        {{ $p->nome }} — R$ {{ number_format($p->preco_final, 2, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Qtd</label>
                            <input type="number" name="quantidades[]" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-2">
                            <button type="button" onclick="removeRow(this)" class="btn w-100" style="border:1px solid var(--gv-red);color:var(--gv-red);background:none">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-gv">
                <div class="card-header">Ações</div>
                <div style="padding:1.25rem">
                    <button type="submit" class="btn btn-gv w-100 mb-2 py-2">
                        <i class="bi bi-check-circle me-2"></i> Criar Pedido
                    </button>
                    <a href="{{ route('pedido.index') }}" class="btn btn-outline-gv w-100">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<template id="produtoRowTemplate">
    <div class="produto-row row g-2 mb-2 align-items-end">
        <div class="col-7">
            <select name="produtos[]" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach($produtos as $p)
                    <option value="{{ $p->id }}" data-preco="{{ $p->preco_final }}">
                        {{ $p->nome }} — R$ {{ number_format($p->preco_final, 2, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <input type="number" name="quantidades[]" class="form-control" value="1" min="1">
        </div>
        <div class="col-2">
            <button type="button" onclick="removeRow(this)" class="btn w-100" style="border:1px solid var(--gv-red);color:var(--gv-red);background:none">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>
</template>
@endif

@endsection

@section('scripts')
<script>
function addProduto() {
    const tpl = document.getElementById('produtoRowTemplate');
    const clone = tpl.content.cloneNode(true);
    document.getElementById('produtosContainer').appendChild(clone);
}
function removeRow(btn) {
    const rows = document.querySelectorAll('.produto-row');
    if (rows.length <= 1) {
        alert('O pedido precisa ter ao menos 1 produto.');
        return;
    }
    btn.closest('.produto-row').remove();
}
</script>
@endsection
