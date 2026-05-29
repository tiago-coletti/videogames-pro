@extends('loja-layout')
@section('titulo', 'Início')
@section('conteudo')

<!-- HERO -->
<section class="hero">
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-2" style="color:var(--gv-accent);font-size:0.8rem;text-transform:uppercase;letter-spacing:3px;font-weight:600">
                    <i class="bi bi-controller me-1"></i> A Maior Loja Gamer
                </div>
                <h1 class="hero-title mb-3">
                    Seu próximo jogo<br>está <span>aqui</span>.
                </h1>
                <p style="color:var(--gv-muted);font-size:1rem;max-width:420px" class="mb-4">
                    Jogos, consoles e acessórios para Xbox, PlayStation e muito mais.
                    Os melhores títulos com os melhores preços.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('loja.catalogo') }}" class="btn btn-gv px-4 py-2">
                        <i class="bi bi-grid me-1"></i> Ver Catálogo
                    </a>
                    <a href="{{ route('loja.catalogo', ['tipo'=>'console']) }}" class="btn btn-outline-gv px-4 py-2">
                        <i class="bi bi-device-ssd me-1"></i> Consoles
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <div style="font-size:9rem;opacity:0.08;font-weight:900;line-height:1;color:var(--gv-accent)">
                    GAME
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PLATAFORMAS -->
<section class="py-4" style="background:var(--gv-panel);border-bottom:1px solid var(--gv-border)">
    <div class="container">
        <div class="d-flex align-items-center gap-4 flex-wrap justify-content-center">
            @foreach($plataformas as $plat)
            <a href="{{ route('loja.catalogo', ['plataforma_id' => $plat->id]) }}"
               class="text-decoration-none d-flex align-items-center gap-2 px-4 py-2"
               style="color:var(--gv-muted);border:1px solid var(--gv-border);border-radius:30px;transition:all 0.2s;font-size:0.85rem;font-weight:500"
               onmouseover="this.style.borderColor='var(--gv-accent)';this.style.color='var(--gv-accent)'"
               onmouseout="this.style.borderColor='var(--gv-border)';this.style.color='var(--gv-muted)'">
                <i class="bi bi-controller"></i> {{ $plat->nome }}
                <span style="font-size:0.7rem;background:var(--gv-border);border-radius:10px;padding:0.1rem 0.4rem">{{ $plat->produtos_count }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- DESTAQUES -->
@if($destaques->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0"><i class="bi bi-star-fill me-2" style="color:var(--gv-yellow)"></i>Em <span>Destaque</span></h2>
            <a href="{{ route('loja.catalogo') }}" class="btn btn-sm btn-outline-gv">Ver tudo</a>
        </div>
        <div class="row g-3">
            @foreach($destaques as $p)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    @if($p->imagem)
                        <img src="/storage/{{ $p->imagem }}" alt="{{ $p->nome }}" class="product-card-img">
                    @else
                        <div class="product-card-img-placeholder"><i class="bi bi-controller"></i></div>
                    @endif
                    <div class="product-card-body">
                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                            <span class="product-card-plat">{{ $p->plataforma->nome ?? '—' }}</span>
                            @if($p->tem_promocao) <span class="badge-promo">OFERTA</span> @endif
                        </div>
                        <div class="product-card-title">{{ $p->nome }}</div>
                        <div class="product-card-price mt-2">
                            @if($p->tem_promocao)
                                <div class="price-original">R$ {{ number_format($p->preco, 2, ',', '.') }}</div>
                                <div class="price-final">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                            @else
                                <div class="price-normal">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                            @endif
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('loja.produto', $p->id) }}" class="btn btn-sm btn-outline-gv flex-grow-1">Ver</a>
                            <form action="{{ route('carrinho.adicionar', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantidade" value="1">
                                <button type="submit" class="btn btn-sm btn-gv"><i class="bi bi-bag-plus"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CATEGORIAS -->
@if($categorias->count() > 0)
<section class="py-5" style="background:var(--gv-panel);border-top:1px solid var(--gv-border);border-bottom:1px solid var(--gv-border)">
    <div class="container">
        <h2 class="section-title mb-4">Categorias</h2>
        <div class="row g-3">
            @php
            $icons = ['bi-joystick','bi-trophy','bi-people','bi-gun','bi-globe','bi-lightning','bi-puzzle','bi-music-note','bi-car-front','bi-sword'];
            @endphp
            @foreach($categorias as $i => $cat)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('loja.catalogo', ['categoria_id' => $cat->id]) }}" class="text-decoration-none">
                    <div style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:12px;padding:1.25rem;text-align:center;transition:all 0.2s"
                         onmouseover="this.style.borderColor='var(--gv-accent)'"
                         onmouseout="this.style.borderColor='var(--gv-border)'">
                        <div style="font-size:2rem;color:var(--gv-accent);margin-bottom:0.5rem">
                            <i class="bi {{ $icons[$i % count($icons)] }}"></i>
                        </div>
                        <div style="font-weight:600;font-size:0.88rem;color:var(--gv-text)">{{ $cat->nome }}</div>
                        <div style="font-size:0.72rem;color:var(--gv-muted)">{{ $cat->produtos_count }} jogos</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- LANÇAMENTOS -->
@if($lancamentos->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0"><i class="bi bi-lightning-fill me-2" style="color:var(--gv-accent)"></i>Lança<span>mentos</span></h2>
            <a href="{{ route('loja.catalogo', ['ordenar'=>'lancamento']) }}" class="btn btn-sm btn-outline-gv">Ver tudo</a>
        </div>
        <div class="row g-3">
            @foreach($lancamentos as $p)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card">
                    @if($p->imagem)
                        <img src="/storage/{{ $p->imagem }}" alt="{{ $p->nome }}" class="product-card-img">
                    @else
                        <div class="product-card-img-placeholder"><i class="bi bi-controller"></i></div>
                    @endif
                    <div class="product-card-body">
                        <div class="product-card-plat">{{ $p->plataforma->nome ?? '—' }}</div>
                        <div class="product-card-title">{{ $p->nome }}</div>
                        <div class="product-card-price mt-2">
                            @if($p->tem_promocao)
                                <div class="price-original">R$ {{ number_format($p->preco, 2, ',', '.') }}</div>
                                <div class="price-final">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                            @else
                                <div class="price-normal">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                            @endif
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('loja.produto', $p->id) }}" class="btn btn-sm btn-outline-gv flex-grow-1">Ver</a>
                            <form action="{{ route('carrinho.adicionar', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantidade" value="1">
                                <button type="submit" class="btn btn-sm btn-gv"><i class="bi bi-bag-plus"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
