<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Admin') — GameVault Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gv-dark:    #0d0f14;
            --gv-panel:   #13161f;
            --gv-card:    #1a1e2a;
            --gv-border:  #252a38;
            --gv-accent:  #00d4ff;
            --gv-green:   #00ff88;
            --gv-red:     #ff4466;
            --gv-yellow:  #ffd700;
            --gv-text:    #e8eaf0;
            --gv-muted:   #6c7a96;
        }
        body { background: var(--gv-dark); color: var(--gv-text); font-family: 'Inter', sans-serif; min-height: 100vh; }
        .sidebar {
            width: 250px; min-height: 100vh; background: var(--gv-panel);
            border-right: 1px solid var(--gv-border); position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem; border-bottom: 1px solid var(--gv-border);
            font-family: 'Rajdhani', sans-serif; font-size: 1.5rem; font-weight: 700;
            color: var(--gv-accent); letter-spacing: 1px; text-decoration: none;
        }
        .sidebar-brand span { color: var(--gv-text); }
        .sidebar-brand small { display: block; font-size: 0.65rem; color: var(--gv-muted); letter-spacing: 3px; text-transform: uppercase; }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-section { padding: 0.5rem 1.25rem 0.25rem; font-size: 0.65rem; color: var(--gv-muted); text-transform: uppercase; letter-spacing: 2px; }
        .nav-link {
            display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 1.25rem;
            color: var(--gv-muted); font-size: 0.88rem; font-weight: 500; text-decoration: none;
            border-left: 3px solid transparent; transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--gv-text); background: rgba(0,212,255,0.06);
            border-left-color: var(--gv-accent);
        }
        .nav-link i { font-size: 1rem; width: 18px; text-align: center; }
        .main-content { margin-left: 250px; min-height: 100vh; }
        .topbar {
            background: var(--gv-panel); border-bottom: 1px solid var(--gv-border);
            padding: 0.85rem 1.5rem; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 99;
        }
        .topbar-title { font-family: 'Rajdhani', sans-serif; font-size: 1.2rem; font-weight: 600; color: var(--gv-text); }
        .page-content { padding: 1.5rem; }
        .card-gv {
            background: var(--gv-card); border: 1px solid var(--gv-border);
            border-radius: 10px; overflow: hidden;
        }
        .card-gv .card-header {
            background: rgba(0,212,255,0.05); border-bottom: 1px solid var(--gv-border);
            padding: 1rem 1.25rem; font-family: 'Rajdhani', sans-serif; font-weight: 600; font-size: 1rem;
        }
        .btn-gv { background: var(--gv-accent); color: #000; font-weight: 600; border: none; }
        .btn-gv:hover { background: #00b8d9; color: #000; }
        .btn-outline-gv { border: 1px solid var(--gv-accent); color: var(--gv-accent); background: transparent; }
        .btn-outline-gv:hover { background: var(--gv-accent); color: #000; }
        .table { color: var(--gv-text); }
        .table thead th { background: rgba(0,212,255,0.05); color: var(--gv-accent); border-color: var(--gv-border); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 1px; }
        .table td, .table th { border-color: var(--gv-border); vertical-align: middle; }
        .table tbody tr:hover { background: rgba(255,255,255,0.02); }
        .form-control, .form-select {
            background: var(--gv-dark); border: 1px solid var(--gv-border); color: var(--gv-text);
            border-radius: 6px;
        }
        .form-control:focus, .form-select:focus {
            background: var(--gv-dark); border-color: var(--gv-accent); color: var(--gv-text);
            box-shadow: 0 0 0 3px rgba(0,212,255,0.1);
        }
        .form-label { color: var(--gv-muted); font-size: 0.82rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-status { font-size: 0.72rem; padding: 0.3em 0.7em; border-radius: 20px; }
        .alert-success { background: rgba(0,255,136,0.1); border-color: var(--gv-green); color: var(--gv-green); }
        .alert-danger  { background: rgba(255,68,102,0.1);  border-color: var(--gv-red);   color: var(--gv-red); }
        .stat-card { background: var(--gv-card); border: 1px solid var(--gv-border); border-radius: 10px; padding: 1.25rem; }
        .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
        .stat-card .stat-value { font-family: 'Rajdhani', sans-serif; font-size: 1.8rem; font-weight: 700; }
        .stat-card .stat-label { color: var(--gv-muted); font-size: 0.8rem; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--gv-dark); }
        ::-webkit-scrollbar-thumb { background: var(--gv-border); border-radius: 3px; }
    </style>
    @yield('styles')
</head>
<body>
<div class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <i class="bi bi-controller"></i> Game<span>Vault</span>
        <small>Admin Panel</small>
    </a>
    <nav class="sidebar-nav">
        <div class="nav-section">Painel</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section mt-2">Catálogo</div>
        <a href="{{ route('produto.index') }}" class="nav-link @if(request()->routeIs('produto.*')) active @endif">
            <i class="bi bi-box-seam"></i> Produtos
        </a>
        <a href="{{ route('categoria.index') }}" class="nav-link @if(request()->routeIs('categoria.*')) active @endif">
            <i class="bi bi-tags"></i> Categorias
        </a>
        <a href="{{ route('plataforma.index') }}" class="nav-link @if(request()->routeIs('plataforma.*')) active @endif">
            <i class="bi bi-device-ssd"></i> Plataformas
        </a>

        <div class="nav-section mt-2">Vendas</div>
        <a href="{{ route('pedido.index') }}" class="nav-link @if(request()->routeIs('pedido.*')) active @endif">
            <i class="bi bi-receipt"></i> Pedidos
        </a>
        <a href="{{ route('cliente.index') }}" class="nav-link @if(request()->routeIs('cliente.*')) active @endif">
            <i class="bi bi-people"></i> Clientes
        </a>

        <div class="nav-section mt-2">Loja</div>
        <a href="{{ route('loja.index') }}" class="nav-link" target="_blank">
            <i class="bi bi-shop"></i> Ver Loja <i class="bi bi-box-arrow-up-right ms-auto" style="font-size:0.7rem"></i>
        </a>
    </nav>
    <div style="padding:1rem 1.25rem; border-top:1px solid var(--gv-border);">
        <div style="font-size:0.75rem; color:var(--gv-muted);">
            <i class="bi bi-shield-check" style="color:var(--gv-green)"></i>
            Sistema Ativo
        </div>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div class="topbar-title">@yield('titulo', 'Dashboard')</div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('loja.index') }}" class="btn btn-sm btn-outline-gv" target="_blank">
                <i class="bi bi-shop"></i> Ver Loja
            </a>
        </div>
    </div>
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <b><i class="bi bi-exclamation-triangle me-2"></i>Verifique os erros abaixo:</b>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('conteudo')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
