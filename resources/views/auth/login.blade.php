<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — GameVault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gv-dark:   #080a10;
            --gv-panel:  #0e1118;
            --gv-card:   #141820;
            --gv-border: #1f2535;
            --gv-accent: #00d4ff;
            --gv-green:  #00ff88;
            --gv-red:    #ff4466;
            --gv-text:   #e8eaf0;
            --gv-muted:  #6c7a96;
        }
        body {
            background: var(--gv-dark); color: var(--gv-text); font-family: 'Inter', sans-serif;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(0,212,255,0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(123,47,255,0.06) 0%, transparent 60%);
        }
        .login-card {
            background: var(--gv-card); border: 1px solid var(--gv-border); border-radius: 16px;
            padding: 2.5rem; width: 100%; max-width: 420px; position: relative;
        }
        .brand {
            font-family: 'Rajdhani', sans-serif; font-size: 2rem; font-weight: 700;
            color: var(--gv-accent); text-align: center; margin-bottom: 0.25rem;
        }
        .brand span { color: var(--gv-text); }
        .subtitle { color: var(--gv-muted); text-align: center; font-size: 0.85rem; margin-bottom: 2rem; }
        .form-control {
            background: var(--gv-dark); border: 1px solid var(--gv-border); color: var(--gv-text);
            border-radius: 8px; padding: 0.75rem 1rem;
        }
        .form-control:focus {
            background: var(--gv-dark); border-color: var(--gv-accent); color: var(--gv-text);
            box-shadow: 0 0 0 3px rgba(0,212,255,0.1);
        }
        .form-control::placeholder { color: var(--gv-muted); }
        .form-label { color: var(--gv-muted); font-size: 0.78rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-gv {
            background: var(--gv-accent); color: #000; border: none; font-weight: 700;
            width: 100%; padding: 0.75rem; border-radius: 8px; font-size: 1rem;
            font-family: 'Rajdhani', sans-serif; letter-spacing: 0.5px; transition: background 0.2s;
        }
        .btn-gv:hover { background: #00b8d9; color: #000; }
        .input-group-text {
            background: var(--gv-dark); border: 1px solid var(--gv-border); color: var(--gv-muted);
            border-right: none;
        }
        .input-group .form-control { border-left: none; }
        .divider {
            display: flex; align-items: center; gap: 1rem;
            color: var(--gv-muted); font-size: 0.75rem; margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: var(--gv-border);
        }
        .alert-danger { background: rgba(255,68,102,0.08); border-color: rgba(255,68,102,0.3); color: var(--gv-red); font-size: 0.85rem; border-radius: 8px; }
        .tabs { display: flex; background: var(--gv-dark); border-radius: 8px; padding: 4px; margin-bottom: 1.5rem; border: 1px solid var(--gv-border); }
        .tab { flex: 1; text-align: center; padding: 0.5rem; cursor: pointer; border-radius: 6px; font-size: 0.85rem; font-weight: 500; color: var(--gv-muted); border: none; background: none; transition: all 0.2s; }
        .tab.active { background: var(--gv-accent); color: #000; font-weight: 700; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="brand"><i class="bi bi-controller"></i> Game<span>Vault</span></div>
    <div class="subtitle">Acesse sua conta para continuar comprando</div>

    <div class="tabs mb-4">
        <button class="tab active" id="tab-login" onclick="showTab('login')">Entrar</button>
        <button class="tab" id="tab-registro" onclick="showTab('registro')">Criar conta</button>
    </div>

    @if(session('error'))
        <div class="alert alert-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    <div id="form-login">
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="seu@email.com" value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-gv">
                <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
            </button>
        </form>

        <div class="divider">ou acesse como</div>

        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center justify-content-center gap-2 text-decoration-none py-2 px-4"
           style="border:1px solid var(--gv-border);border-radius:8px;color:var(--gv-muted);font-size:0.85rem;transition:all 0.2s"
           onmouseover="this.style.borderColor='var(--gv-accent)';this.style.color='var(--gv-accent)'"
           onmouseout="this.style.borderColor='var(--gv-border)';this.style.color='var(--gv-muted)'">
            <i class="bi bi-shield-check"></i> Painel Administrativo
        </a>
    </div>

    <div id="form-registro" style="display:none">
        <form action="{{ route('registro.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nome completo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nome" class="form-control" placeholder="Seu nome" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="seu@email.com" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required minlength="8">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirmar senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
                </div>
            </div>
            <button type="submit" class="btn-gv">
                <i class="bi bi-person-plus me-2"></i> Criar Conta
            </button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('loja.index') }}" style="color:var(--gv-muted);font-size:0.8rem;text-decoration:none">
            <i class="bi bi-arrow-left me-1"></i> Voltar à loja
        </a>
    </div>
</div>

<script>
function showTab(tab) {
    document.getElementById('form-login').style.display    = tab === 'login'    ? 'block' : 'none';
    document.getElementById('form-registro').style.display = tab === 'registro' ? 'block' : 'none';
    document.getElementById('tab-login').className    = 'tab' + (tab === 'login'    ? ' active' : '');
    document.getElementById('tab-registro').className = 'tab' + (tab === 'registro' ? ' active' : '');
}

@if($errors->has('nome') || $errors->has('password') || session('error') == false && $errors->any())
    showTab('registro');
@endif
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
