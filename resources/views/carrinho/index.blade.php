@extends('loja-layout')
@section('titulo', 'Carrinho')
@section('conteudo')

<div class="container py-4">
    <h2 class="section-title mb-4"><i class="bi bi-bag me-2" style="color:var(--gv-accent)"></i>Meu <span>Carrinho</span></h2>

    @if(count($itens) > 0)
    <div class="row g-4">

        <!-- ITENS DO CARRINHO -->
        <div class="col-lg-8">
            <div style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:12px;overflow:hidden">
                <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--gv-border);display:flex;justify-content:space-between;align-items:center">
                    <span style="font-family:'Rajdhani',sans-serif;font-weight:600;font-size:1rem">
                        {{ count($itens) }} item(ns) no carrinho
                    </span>
                    <form action="{{ route('carrinho.limpar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm" style="color:var(--gv-red);background:none;border:1px solid var(--gv-red);font-size:0.78rem"
                            onclick="return confirm('Esvaziar o carrinho?')">
                            <i class="bi bi-trash me-1"></i> Esvaziar
                        </button>
                    </form>
                </div>

                @foreach($itens as $item)
                <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--gv-border);display:flex;gap:1rem;align-items:center">
                    <!-- Imagem -->
                    <div style="width:72px;height:72px;flex-shrink:0;border-radius:8px;overflow:hidden;background:var(--gv-panel);display:flex;align-items:center;justify-content:center">
                        @if($item['produto']->imagem)
                            <img src="/storage/{{ $item['produto']->imagem }}" alt="" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <i class="bi bi-controller" style="font-size:1.5rem;color:var(--gv-muted)"></i>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-grow-1">
                        <div style="font-weight:600;font-size:0.92rem;color:var(--gv-text)">{{ $item['produto']->nome }}</div>
                        <div style="font-size:0.75rem;color:var(--gv-muted)">
                            {{ $item['produto']->plataforma->nome ?? '' }}
                            @if($item['produto']->categoria) · {{ $item['produto']->categoria->nome }} @endif
                        </div>
                        <div style="color:var(--gv-green);font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1rem;margin-top:0.2rem">
                            R$ {{ number_format($item['produto']->preco_final, 2, ',', '.') }}
                        </div>
                    </div>

                    <!-- Quantidade -->
                    <form action="{{ route('carrinho.atualizar', $item['produto']->id) }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <div style="display:flex;align-items:center;background:var(--gv-panel);border:1px solid var(--gv-border);border-radius:6px;overflow:hidden">
                            <button type="submit" name="quantidade" value="{{ $item['quantidade'] - 1 }}"
                                style="background:none;border:none;color:var(--gv-text);padding:0.3rem 0.6rem;cursor:pointer">−</button>
                            <span style="padding:0.3rem 0.5rem;min-width:28px;text-align:center;font-weight:600;font-size:0.9rem">{{ $item['quantidade'] }}</span>
                            <button type="submit" name="quantidade" value="{{ $item['quantidade'] + 1 }}"
                                style="background:none;border:none;color:var(--gv-text);padding:0.3rem 0.6rem;cursor:pointer">+</button>
                        </div>
                    </form>

                    <!-- Subtotal -->
                    <div style="min-width:90px;text-align:right">
                        <div style="font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1.1rem;color:var(--gv-text)">
                            R$ {{ number_format($item['subtotal'], 2, ',', '.') }}
                        </div>
                    </div>

                    <!-- Remover -->
                    <form action="{{ route('carrinho.remover', $item['produto']->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:var(--gv-muted);padding:0.3rem;cursor:pointer;transition:color 0.2s"
                            onmouseover="this.style.color='var(--gv-red)'" onmouseout="this.style.color='var(--gv-muted)'"
                            title="Remover">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </div>
                @endforeach

                <div style="padding:1rem 1.25rem">
                    <a href="{{ route('loja.catalogo') }}" style="color:var(--gv-accent);font-size:0.85rem;text-decoration:none">
                        <i class="bi bi-arrow-left me-1"></i> Continuar comprando
                    </a>
                </div>
            </div>
        </div>

        <!-- RESUMO / CHECKOUT -->
        <div class="col-lg-4">
            <div style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:12px;padding:1.5rem;position:sticky;top:80px">
                <h5 style="font-family:'Rajdhani',sans-serif;font-weight:700;margin-bottom:1.25rem;color:var(--gv-accent)">
                    <i class="bi bi-receipt me-2"></i>Resumo do Pedido
                </h5>

                <div class="d-flex justify-content-between mb-2" style="font-size:0.88rem;color:var(--gv-muted)">
                    <span>Subtotal</span>
                    <span style="color:var(--gv-text)">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:0.88rem;color:var(--gv-muted)">
                    <span>Frete</span>
                    <span style="color:var(--gv-green)">Grátis</span>
                </div>
                <hr style="border-color:var(--gv-border)">
                <div class="d-flex justify-content-between mb-4">
                    <span style="font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1.1rem">Total</span>
                    <span style="font-family:'Rajdhani',sans-serif;font-weight:700;font-size:1.3rem;color:var(--gv-green)">
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </span>
                </div>

                <!-- Formulário de finalização -->
                <form action="{{ route('carrinho.finalizar') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="color:var(--gv-muted);font-size:0.78rem">Seu nome</label>
                        <input type="text" name="nome" class="form-control form-control-sm" placeholder="Nome completo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="color:var(--gv-muted);font-size:0.78rem">E-mail</label>
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="seu@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" style="color:var(--gv-muted);font-size:0.78rem">Forma de pagamento</label>
                        <select name="forma_pagamento" class="form-select form-select-sm" required>
                            <option value="">Selecione...</option>
                            <option value="pix">💰 Pix (5% OFF)</option>
                            <option value="cartao">💳 Cartão de Crédito</option>
                            <option value="boleto">📄 Boleto Bancário</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-gv w-100 py-2" style="font-size:1rem;font-weight:700">
                        <i class="bi bi-check-circle me-2"></i> Finalizar Pedido
                    </button>
                </form>

                <div class="mt-3 text-center" style="font-size:0.72rem;color:var(--gv-muted)">
                    <i class="bi bi-shield-lock me-1"></i> Compra 100% segura e criptografada
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- CARRINHO VAZIO -->
    <div style="text-align:center;padding:5rem 1rem">
        <div style="font-size:5rem;color:var(--gv-border);margin-bottom:1.5rem">
            <i class="bi bi-bag-x"></i>
        </div>
        <h4 style="color:var(--gv-muted);margin-bottom:0.5rem">Seu carrinho está vazio</h4>
        <p style="color:var(--gv-muted);font-size:0.88rem;margin-bottom:2rem">Adicione produtos ao carrinho para continuar comprando.</p>
        <a href="{{ route('loja.catalogo') }}" class="btn btn-gv px-4 py-2">
            <i class="bi bi-grid me-2"></i> Ver Catálogo
        </a>
    </div>
    @endif
</div>

@endsection
