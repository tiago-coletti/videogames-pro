# 🎮 GameVault — Loja de Videogames

Site de vendas de videogames e consoles desenvolvido em **Laravel 12** com design dark gamer.

## 📋 Funcionalidades

### 🛍️ Loja Pública
- Página inicial com produtos em destaque e lançamentos
- Catálogo com filtros por plataforma, categoria, tipo e preço
- Página de detalhe do produto com descrição e produtos relacionados
- Carrinho de compras com gerenciamento de quantidade e finalização
- Página de Login com abas Login / Criar Conta

### 🖥️ 5 CRUDs no Painel Administrativo
| CRUD | Funcionalidades |
|---|---|
| **Produtos** | Listar, Criar, Editar, Excluir, Detalhe, Busca |
| **Plataformas** | Listar, Criar, Editar, Excluir, Busca |
| **Categorias** | Listar, Criar, Editar, Excluir, Busca |
| **Clientes** | Listar, Criar, Editar, Excluir, Busca |
| **Pedidos** | Listar, Criar, Editar, Excluir, Detalhe, Busca |

## 🚀 Instalação

```bash
# 1. Instalar dependências
composer install

# 2. Copiar e configurar .env
cp .env.example .env
# Edite DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 3. Gerar chave
php artisan key:generate

# 4. Criar banco
mysql -u root -p -e "CREATE DATABASE gamevault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Migrations + Seed
php artisan migrate
php artisan db:seed

# 6. Storage link
php artisan storage:link

# 7. Rodar
php artisan serve
```

## 🔐 Login padrão (após seed)
- **E-mail:** admin@gamevault.com
- **Senha:** password

## 🗺️ Rotas
| URL | Descrição |
|---|---|
| `/` | Loja — Início |
| `/catalogo` | Catálogo com filtros |
| `/carrinho` | Carrinho |
| `/login` | Login/Registro |
| `/admin` | Dashboard |
| `/admin/produtos` | CRUD Produtos |
| `/admin/plataformas` | CRUD Plataformas |
| `/admin/categorias` | CRUD Categorias |
| `/admin/clientes` | CRUD Clientes |
| `/admin/pedidos` | CRUD Pedidos |

## 🎮 Plataformas incluídas
Xbox 360 • Xbox One • Xbox One S • Xbox Series S • Xbox Series X • PS3 • PS4 • PS5

## 🛠️ Stack
Laravel 12 • PHP 8.2 • MySQL • Bootstrap 5.3 • Bootstrap Icons • DomPDF • LarapexCharts
