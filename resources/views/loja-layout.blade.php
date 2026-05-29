<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'GameVault') — A Sua Loja Gamer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gv-dark:    #080a10;
            --gv-panel:   #0e1118;
            --gv-card:    #141820;
            --gv-border:  #1f2535;
            --gv-accent:  #00d4ff;
            --gv-accent2: #7b2fff;
            --gv-green:   #00ff88;
            --gv-red:     #ff4466;
            --gv-yellow:  #ffd700;
            --gv-text:    #e8eaf0;
            --gv-muted:   #6c7a96;
        }
        * { box-sizing: border-box; }
        body { background: var(--gv-dark); color: var(--gv-text); font-family: 'Inter', sans-serif; }
        /* NAVBAR */
        .navbar-gv {
            background: rgba(14,17,24,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--gv-border); padding: 0.75rem 0;
            position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand-gv {
            font-family: 'Rajdhani', sans-serif; font-size: 1.6rem; font-weight: 700;
            color: var(--gv-accent) !important; letter-spacing: 1px; text-decoration: none;
        }
        .navbar-brand-gv span { color: var(--gv-text); }
        .nav-link-gv { color: var(--gv-muted) !important; font-size: 0.9rem; font-weight: 500; padding: 0.4rem 0.8rem !important; transition: color 0.2s; }
        .nav-link-gv:hover { color: var(--gv-text) !important; }
        .search-bar .form-control {
            background: var(--gv-panel); border: 1px solid var(--gv-border); color: var(--gv-text);
            border-radius: 8px 0 0 8px; font-size: 0.88rem;
        }
        .search-bar .form-control:focus { border-color: var(--gv-accent); box-shadow: none; background: var(--gv-panel); color: var(--gv-text); }
        .search-bar .btn { border-radius: 0 8px 8px 0; background: var(--gv-accent); border: none; color: #000; font-weight: 600; }
        .cart-btn {
            background: transparent; border: 1px solid var(--gv-border); color: var(--gv-text);
            border-radius: 8px; padding: 0.45rem 0.9rem; font-size: 0.88rem; position: relative;
            text-decoration: none; transition: border-color 0.2s;
        }
        .cart-btn:hover { border-color: var(--gv-accent); color: var(--gv-accent); }
        .cart-badge {
            position: absolute; top: -6px; right: -6px;
            background: var(--gv-red); color: #fff; border-radius: 50%;
            width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: 700;
        }
        /* PRODUCT CARDS */
        .product-card {
            background: var(--gv-card); border: 1px solid var(--gv-border); border-radius: 12px;
            overflow: hidden; transition: transform 0.2s, border-color 0.2s; height: 100%;
            display: flex; flex-direction: column;
        }
        .product-card:hover { transform: translateY(-4px); border-color: rgba(0,212,255,0.3); }
        .product-card-img {
            width: 100%; aspect-ratio: 4/3; object-fit: cover;
            background: var(--gv-panel);
        }
        .product-card-img-placeholder {
            width: 100%; aspect-ratio: 4/3; background: var(--gv-panel);
            display: flex; align-items: center; justify-content: center; color: var(--gv-muted); font-size: 3rem;
        }
        .product-card-body { padding: 1rem; flex: 1; display: flex; flex-direction: column; }
        .product-card-title { font-size: 0.92rem; font-weight: 600; color: var(--gv-text); margin-bottom: 0.25rem; line-height: 1.3; }
        .product-card-plat { font-size: 0.72rem; color: var(--gv-accent); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
        .product-card-price { margin-top: auto; }
        .price-original { text-decoration: line-through; color: var(--gv-muted); font-size: 0.8rem; }
        .price-final { font-family: 'Rajdhani', sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--gv-green); }
        .price-normal { font-family: 'Rajdhani', sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--gv-text); }
        .badge-promo { background: var(--gv-red); color: #fff; font-size: 0.65rem; padding: 0.2em 0.5em; border-radius: 4px; font-weight: 700; }
        .btn-add-cart { background: var(--gv-accent); color: #000; border: none; font-weight: 600; font-size: 0.82rem; padding: 0.5rem; border-radius: 6px; width: 100%; margin-top: 0.75rem; transition: background 0.2s; }
        .btn-add-cart:hover { background: #00b8d9; color: #000; }
        /* HERO */
        .hero {
            background: linear-gradient(135deg, #080a10 0%, #0d0f1a 50%, #080a10 100%);
            border-bottom: 1px solid var(--gv-border); padding: 4rem 0;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(ellipse at 60% 40%, rgba(0,212,255,0.06) 0%, transparent 60%),
                        radial-gradient(ellipse at 20% 80%, rgba(123,47,255,0.06) 0%, transparent 60%);
        }
        .hero-title { font-family: 'Rajdhani', sans-serif; font-size: 3rem; font-weight: 700; line-height: 1.1; }
        .hero-title span { color: var(--gv-accent); }
        /* FOOTER */
        footer { background: var(--gv-panel); border-top: 1px solid var(--gv-border); padding: 2rem 0; margin-top: 4rem; }
        footer .footer-brand { font-family: 'Rajdhani', sans-serif; font-size: 1.3rem; font-weight: 700; color: var(--gv-accent); }
        footer p { color: var(--gv-muted); font-size: 0.82rem; }
        /* MISC */
        .section-title { font-family: 'Rajdhani', sans-serif; font-size: 1.5rem; font-weight: 700; }
        .section-title span { color: var(--gv-accent); }
        .divider { border-color: var(--gv-border); }
        .form-control, .form-select {
            background: var(--gv-panel); border: 1px solid var(--gv-border); color: var(--gv-text); border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background: var(--gv-panel); border-color: var(--gv-accent); color: var(--gv-text); box-shadow: 0 0 0 3px rgba(0,212,255,0.1);
        }
        .form-label { color: var(--gv-muted); font-size: 0.82rem; font-weight: 500; }
        .btn-gv { background: var(--gv-accent); color: #000; font-weight: 700; border: none; }
        .btn-gv:hover { background: #00b8d9; color: #000; }
        .btn-outline-gv { border: 1px solid var(--gv-accent); color: var(--gv-accent); background: transparent; }
        .btn-outline-gv:hover { background: var(--gv-accent); color: #000; }
        .alert-success { background: rgba(0,255,136,0.08); border-color: rgba(0,255,136,0.3); color: var(--gv-green); }
        .alert-danger  { background: rgba(255,68,102,0.08); border-color: rgba(255,68,102,0.3); color: var(--gv-red); }
        .alert-info    { background: rgba(0,212,255,0.08); border-color: rgba(0,212,255,0.3); color: var(--gv-accent); }
        /* FILTER SIDEBAR */
        .filter-panel { background: var(--gv-card); border: 1px solid var(--gv-border); border-radius: 12px; padding: 1.25rem; }
        .filter-title { font-family: 'Rajdhani', sans-serif; font-size: 1rem; font-weight: 700; color: var(--gv-accent); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem; }
    </style>
    @yield('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-gv">
    <div class="container">
        <div class="d-flex align-items-center gap-4 flex-wrap">
            <a href="{{ route('loja.index') }}" class="navbar-brand-gv">
                <i class="bi bi-controller"></i> Game<span>Vault</span>
            </a>
            <form action="{{ route('loja.catalogo') }}" method="GET" class="search-bar d-flex flex-grow-1" style="max-width:420px">
                <input type="text" class="form-control" name="busca" placeholder="Buscar jogos, consoles..." value="{{ request('busca') }}">
                <button type="submit" class="btn"><i class="bi bi-search"></i></button>
            </form>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <a href="{{ route('loja.catalogo') }}" class="nav-link-gv">Catálogo</a>
                <a href="{{ route('loja.catalogo', ['tipo'=>'console']) }}" class="nav-link-gv">Consoles</a>
                <a href="{{ route('loja.catalogo', ['tipo'=>'acessorio']) }}" class="nav-link-gv">Acessórios</a>
                <a href="{{ route('carrinho.index') }}" class="cart-btn ms-2">
                    <i class="bi bi-bag"></i> Carrinho
                    @php $qtdCarrinho = count(session('carrinho', [])); @endphp
                    @if($qtdCarrinho > 0)
                        <span class="cart-badge">{{ $qtdCarrinho }}</span>
                    @endif
                </a>
                <a href="{{ route('login') }}" class="nav-link-gv"><i class="bi bi-person"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- ALERTS -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

@yield('conteudo')

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="footer-brand mb-2"><i class="bi bi-controller"></i> GameVault</div>
                <p>A sua loja especializada em games. Xbox, PlayStation, consoles clássicos e muito mais.</p>
            </div>
            <div class="col-md-2 mb-3">
                <p class="fw-600 text-white mb-2">Navegação</p>
                <p class="mb-1"><a href="{{ route('loja.index') }}" class="text-decoration-none" style="color:var(--gv-muted)">Início</a></p>
                <p class="mb-1"><a href="{{ route('loja.catalogo') }}" class="text-decoration-none" style="color:var(--gv-muted)">Catálogo</a></p>
            </div>
            <div class="col-md-3 mb-3">
                <p class="fw-600 text-white mb-2">Plataformas</p>
                <p style="color:var(--gv-muted)">Xbox 360 • Xbox One • Xbox Series<br>PS3 • PS4 • PS5</p>
            </div>
            <div class="col-md-3 mb-3">
                <p class="fw-600 text-white mb-2">Contato</p>
                <p style="color:var(--gv-muted)"><i class="bi bi-envelope me-1"></i> contato@gamevault.com.br<br>
                <i class="bi bi-whatsapp me-1"></i> (49) 9 9999-9999</p>
            </div>
        </div>
        <hr class="divider">
        <p class="text-center mb-0" style="color:var(--gv-muted);font-size:0.78rem">
            © {{ date('Y') }} GameVault — Todos os direitos reservados.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
