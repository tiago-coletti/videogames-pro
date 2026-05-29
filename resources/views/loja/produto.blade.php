@extends('loja-layout')
@section('titulo', $produto->nome)
@section('conteudo')

<div class="container py-4">
    <!-- BREADCRUMB -->
    <nav style="font-size:0.82rem;color:var(--gv-muted)" class="mb-4">
        <a href="{{ route('loja.index') }}" style="color:var(--gv-muted);text-decoration:none">Início</a>
        <span class="mx-2">/</span>
        <a href="{{ route('loja.catalogo') }}" style="color:var(--gv-muted);text-decoration:none">Catálogo</a>
        <span class="mx-2">/</span>
        <span style="color:var(--gv-text)">{{ $produto->nome }}</span>
    </nav>

    <div class="row g-4">
        <!-- IMAGEM -->
        <div class="col-md-5">
            <div style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:12px;overflow:hidden;aspect-ratio:1;display:flex;align-items:center;justify-content:center">
                @if($produto->imagem)
                    <img src="/storage/{{ $produto->imagem }}" alt="{{ $produto->nome }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <div style="text-align:center;color:var(--gv-muted)">
                        <i class="bi bi-controller" style="font-size:5rem"></i>
                        <div style="font-size:0.8rem;margin-top:0.5rem">Sem imagem</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- DETALHES -->
        <div class="col-md-7">
            <!-- Badges -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                @if($produto->plataforma)
                    <span style="background:rgba(0,212,255,0.1);color:var(--gv-accent);border:1px solid rgba(0,212,255,0.3);border-radius:20px;padding:0.2rem 0.75rem;font-size:0.78rem;font-weight:600">
                        <i class="bi bi-controller me-1"></i>{{ $produto->plataforma->nome }}
                    </span>
                @endif
                @if($produto->categoria)
                    <span style="background:rgba(123,47,255,0.1);color:#b084ff;border:1px solid rgba(123,47,255,0.3);border-radius:20px;padding:0.2rem 0.75rem;font-size:0.78rem">
                        {{ $produto->categoria->nome }}
                    </span>
                @endif
                @if($produto->classificacao_etaria)
                    <span style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:4px;padding:0.15rem 0.5rem;font-size:0.8rem;font-weight:700">
                        {{ $produto->classificacao_etaria }}+
                    </span>
                @endif
            </div>

            <h1 style="font-family:'Rajdhani',sans-serif;font-size:2rem;font-weight:700;color:var(--gv-text);margin-bottom:0.5rem">
                {{ $produto->nome }}
            </h1>

            @if($produto->desenvolvedora)
                <div style="color:var(--gv-muted);font-size:0.85rem;margin-bottom:1.5rem">
                    por <span style="color:var(--gv-text);font-weight:500">{{ $produto->desenvolvedora }}</span>
                    @if($produto->data_lancamento)
                        · {{ $produto->data_lancamento->format('d/m/Y') }}
                    @endif
                </div>
            @endif

            <!-- Preço -->
            <div style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:10px;padding:1.25rem;margin-bottom:1.5rem">
                @if($produto->tem_promocao)
                    <div style="color:var(--gv-muted);font-size:0.85rem;text-decoration:line-through">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </div>
                    <div style="font-family:'Rajdhani',sans-serif;font-size:2.5rem;font-weight:700;color:var(--gv-green);line-height:1">
                        R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                    </div>
                    @php $pct = round((1 - $produto->preco_final / $produto->preco) * 100); @endphp
                    <div style="margin-top:0.3rem">
                        <span class="badge-promo">{{ $pct }}% OFF</span>
                    </div>
                @else
                    <div style="font-family:'Rajdhani',sans-serif;font-size:2.5rem;font-weight:700;color:var(--gv-text);line-height:1">
                        R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                    </div>
                @endif

                <div style="margin-top:0.75rem;font-size:0.8rem;color:var(--gv-muted)">
                    @if($produto->estoque > 0)
                        <i class="bi bi-check-circle-fill" style="color:var(--gv-green)"></i>
                        Em estoque ({{ $produto->estoque }} unidades)
                    @else
                        <i class="bi bi-x-circle-fill" style="color:var(--gv-red)"></i>
                        Fora de estoque
                    @endif
                </div>
            </div>

            <!-- Adicionar ao carrinho -->
            @if($produto->estoque > 0)
            <form action="{{ route('carrinho.adicionar', $produto->id) }}" method="POST" class="d-flex gap-3 mb-3">
                @csrf
                <div style="display:flex;align-items:center;background:var(--gv-card);border:1px solid var(--gv-border);border-radius:8px;overflow:hidden">
                    <button type="button" onclick="changeQty(-1)" style="background:none;border:none;color:var(--gv-text);padding:0.5rem 0.9rem;cursor:pointer;font-size:1rem">−</button>
                    <input type="number" name="quantidade" id="qty" value="1" min="1" max="{{ $produto->estoque }}"
                        style="width:50px;background:none;border:none;color:var(--gv-text);text-align:center;font-weight:600;font-size:1rem">
                    <button type="button" onclick="changeQty(1)" style="background:none;border:none;color:var(--gv-text);padding:0.5rem 0.9rem;cursor:pointer;font-size:1rem">+</button>
                </div>
                <button type="submit" class="btn btn-gv flex-grow-1 py-2">
                    <i class="bi bi-bag-plus me-2"></i> Adicionar ao Carrinho
                </button>
            </form>
            @else
                <div class="alert alert-danger" style="font-size:0.88rem">
                    <i class="bi bi-exclamation-triangle me-2"></i>Produto esgotado. Verifique outros títulos.
                </div>
            @endif

            <!-- Fichas técnicas -->
            <div style="font-size:0.82rem;color:var(--gv-muted);display:grid;grid-template-columns:1fr 1fr;gap:0.4rem 1rem;margin-top:1rem">
                @if($produto->desenvolvedora)
                    <div><span style="color:var(--gv-muted)">Desenvolvedora:</span> <span style="color:var(--gv-text)">{{ $produto->desenvolvedora }}</span></div>
                @endif
                @if($produto->distribuidora)
                    <div><span style="color:var(--gv-muted)">Distribuidora:</span> <span style="color:var(--gv-text)">{{ $produto->distribuidora }}</span></div>
                @endif
                @if($produto->tipo)
                    <div><span style="color:var(--gv-muted)">Tipo:</span> <span style="color:var(--gv-text)">{{ ucfirst($produto->tipo) }}</span></div>
                @endif
                @if($produto->data_lancamento)
                    <div><span style="color:var(--gv-muted)">Lançamento:</span> <span style="color:var(--gv-text)">{{ $produto->data_lancamento->format('d/m/Y') }}</span></div>
                @endif
            </div>
        </div>
    </div>

    <!-- DESCRIÇÃO -->
    @if($produto->descricao)
    <div class="mt-5" style="background:var(--gv-card);border:1px solid var(--gv-border);border-radius:12px;padding:1.5rem">
        <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.2rem;font-weight:700;color:var(--gv-accent);margin-bottom:1rem">
            <i class="bi bi-file-text me-2"></i>Descrição
        </h3>
        <p style="color:var(--gv-muted);line-height:1.8;white-space:pre-line">{{ $produto->descricao }}</p>
    </div>
    @endif

    <!-- RELACIONADOS -->
    @if($relacionados->count() > 0)
    <div class="mt-5">
        <h3 class="section-title mb-4">Você também pode gostar</h3>
        <div class="row g-3">
            @foreach($relacionados as $p)
            <div class="col-6 col-md-3">
                <div class="product-card">
                    @if($p->imagem)
                        <img src="/storage/{{ $p->imagem }}" alt="{{ $p->nome }}" class="product-card-img">
                    @else
                        <div class="product-card-img-placeholder"><i class="bi bi-controller"></i></div>
                    @endif
                    <div class="product-card-body">
                        <div class="product-card-plat">{{ $p->plataforma->nome ?? '—' }}</div>
                        <div class="product-card-title">{{ $p->nome }}</div>
                        <div class="price-normal mt-2">R$ {{ number_format($p->preco_final, 2, ',', '.') }}</div>
                        <a href="{{ route('loja.produto', $p->id) }}" class="btn btn-sm btn-outline-gv w-100 mt-2">Ver</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
@section('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const val = parseInt(input.value) + delta;
    const max = parseInt(input.max);
    if (val >= 1 && val <= max) input.value = val;
}
</script>
@endsection
