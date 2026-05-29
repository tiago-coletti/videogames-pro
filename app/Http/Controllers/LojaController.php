<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Plataforma;

class LojaController extends Controller
{
    function index()
    {
        $destaques   = Produto::where('ativo', true)->where('destaque', true)->with(['categoria', 'plataforma'])->take(8)->get();
        $lancamentos = Produto::where('ativo', true)->orderByDesc('data_lancamento')->with(['categoria', 'plataforma'])->take(8)->get();
        $categorias  = Categoria::where('ativo', true)->withCount('produtos')->get();
        $plataformas = Plataforma::where('ativo', true)->withCount('produtos')->get();

        return view('loja.index', compact('destaques', 'lancamentos', 'categorias', 'plataformas'));
    }

    function catalogo(Request $request)
    {
        $query = Produto::where('ativo', true)->with(['categoria', 'plataforma']);

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->filled('plataforma_id')) {
            $query->where('plataforma_id', $request->plataforma_id);
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        $ordenar = $request->get('ordenar', 'nome');
        match($ordenar) {
            'preco_asc'  => $query->orderBy('preco'),
            'preco_desc' => $query->orderByDesc('preco'),
            'lancamento' => $query->orderByDesc('data_lancamento'),
            default      => $query->orderBy('nome'),
        };

        $produtos    = $query->paginate(12)->withQueryString();
        $categorias  = Categoria::where('ativo', true)->get();
        $plataformas = Plataforma::where('ativo', true)->get();

        return view('loja.catalogo', compact('produtos', 'categorias', 'plataformas'));
    }

    function produto($id)
    {
        $produto     = Produto::with(['categoria', 'plataforma'])->where('ativo', true)->findOrFail($id);
        $relacionados = Produto::where('ativo', true)
            ->where('id', '!=', $id)
            ->where('plataforma_id', $produto->plataforma_id)
            ->take(4)->get();

        return view('loja.produto', compact('produto', 'relacionados'));
    }
}
