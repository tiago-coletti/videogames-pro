@extends('loja-layout')
@section('titulo', 'Catálogo')
@section('conteudo')

<div class="container py-4">
    <div class="row g-4">

        <!-- SIDEBAR FILTROS -->
        <div class="col-lg-3">
            <div class="filter-panel">
                <div class="filter-title"><i class="bi bi-funnel me-1"></i> Filtros</div>

                <form action="{{ route('loja.catalogo') }}" method="GET" id="filterForm">
                    <!-- Busca -->
                    <div class="mb-3">
                        <label class="form-label">Buscar</label>
                        <input type="text" class="form-control form-control-sm" name="busca" value="{{ request('busca') }}" placeholder="Nome do produto...">
                    </div>

                    <!-- Tipo -->
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="jogo" @selected(request('tipo')=='jogo')>🎮 Jogos</option>
                            <option value="console" @selected(request('tipo')=='console')>🖥️ Consoles</option>
                            <option value="acessorio" @selected(request('tipo')=='acessorio')>🎧 Acessórios</option>
                        </select>
                    </div>

                    <!-- Plataforma -->
                    <div class="mb-3">
                        <label class="form-label">Plataforma</label>
                        <select name="plataforma_id" class="form-select form-select-sm">
                            <option value="">Todas</option>
                            @foreach($plataformas as $plat)
                                <option value="{{ $plat->id }}" @selected(request('plataforma_id')==$plat->id)>{{ $plat->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Categoria -->
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select form-select-sm">
                            <option value="">Todas</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" @selected(request('categoria_id')==$cat->id)>{{ $cat->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Preço máximo -->
                    <div class="mb-3">
                        <label class="form-label">Preço máximo (R$)</label>
                        <input type="number" class="form-control form-control-sm" name="preco_max" value="{{ request('preco_max') }}" placeholder="Ex: 299">
                    </div>

                    <!-- Ordenar -->
                    <div class="mb-4">
                        <label class="form-label">Ordenar por</label>
                        <select name="ordenar" class="form-select form-select-sm">
                            <option value="nome" @selected(request('ordenar')=='nome')>A → Z</option>
                            <option value="preco_asc" @selected(request('ordenar')=='preco_asc')>Menor preço</option>
                            <option value="preco_desc" @selected(request('ordenar')=='preco_desc')>Maior preço</option>
                            <option value="lancamento" @selected(request('ordenar')=='lancamento')>Lançamento</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-gv w-100 mb-2">
                        <i class="bi bi-search me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('loja.catalogo') }}" class="btn btn-outline-gv w-100" style="font-size:0.82rem">
                        <i class="bi bi-x me-1"></i> Limpar filtros
                    </a>
                </form>
            </div>
        </div>

        <!-- PRODUTOS -->
        <div class="col-lg-9">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <span style="color:var(--gv-muted);font-size:0.88rem">
                        {{ $produtos->total() }} produto(s) encontrado(s)
                    </span>
                </div>
            </div>

            @if($produtos->count() > 0)
                <div class="row g-3">
                    @foreach($produtos as $p)
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="product-card">
                            @if($p->imagem)
                                <img src="/storage/{{ $p->imagem }}" alt="{{ $p->nome }}" class="product-card-img">
                            @else
                                <div class="product-card-img-placeholder">
                                    <i class="bi bi-{{ $p->tipo === 'console' ? 'device-ssd' : ($p->tipo === 'acessorio' ? 'headphones' : 'controller') }}"></i>
                                </div>
                            @endif
                            <div class="product-card-body">
                                <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                    <span class="product-card-plat">{{ $p->plataforma->nome ?? '—' }}</span>
                                    @if($p->tem_promocao)<span class="badge-promo">OFERTA</span>@endif
                                </div>
                                <div class="product-card-title">{{ $p->nome }}</div>
                                <div style="font-size:0.72rem;color:var(--gv-muted);margin-top:0.2rem">
                                    {{ $p->categoria->nome ?? '' }}
                                </div>
                                <div class="product-card-price mt-2">
                                    @if($p->tem_promocao)
                                        <div class="price-original">R$ {{ number_format($p->preco, 2, ',', '.') }}</div>
                                        <div class="price-final">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                                    @else
                                        <div class="price-normal">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                                    @endif
                                </div>
                                @if($p->estoque > 0)
                                    <div class="d-flex gap-2 mt-2">
                                        <a href="{{ route('loja.produto', $p->id) }}" class="btn btn-sm btn-outline-gv flex-grow-1" style="font-size:0.78rem">Detalhes</a>
                                        <form action="{{ route('carrinho.adicionar', $p->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantidade" value="1">
                                            <button type="submit" class="btn btn-sm btn-gv" title="Adicionar ao carrinho">
                                                <i class="bi bi-bag-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span style="color:var(--gv-red);font-size:0.78rem;font-weight:600">
                                            <i class="bi bi-x-circle me-1"></i> Esgotado
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- PAGINAÇÃO -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $produtos->links() }}
                </div>
            @else
                <div class="text-center py-5" style="color:var(--gv-muted)">
                    <i class="bi bi-search" style="font-size:3rem;display:block;margin-bottom:1rem"></i>
                    <h5>Nenhum produto encontrado.</h5>
                    <a href="{{ route('loja.catalogo') }}" class="btn btn-outline-gv mt-3">Ver todos os produtos</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
