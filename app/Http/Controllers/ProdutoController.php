<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Plataforma;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $dados = Produto::with(['categoria', 'plataforma'])->orderBy('nome')->get();
        return view('produto.list', ['dados' => $dados]);
    }

    public function create()
    {
        $categorias  = Categoria::where('ativo', true)->orderBy('nome')->get();
        $plataformas = Plataforma::where('ativo', true)->orderBy('nome')->get();
        return view('produto.form', compact('categorias', 'plataformas'));
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'nome'                => 'required|max:200',
            'preco'               => 'required|numeric|min:0',
            'preco_promocional'   => 'nullable|numeric|min:0',
            'estoque'             => 'required|integer|min:0',
            'tipo'                => 'required|in:jogo,console,acessorio',
            'categoria_id'        => 'nullable|exists:categorias,id',
            'plataforma_id'       => 'nullable|exists:plataformas,id',
            'imagem'              => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'classificacao_etaria' => 'nullable|in:Livre,10,12,14,16,18',
        ], [
            'nome.required'   => 'O nome é obrigatório.',
            'preco.required'  => 'O preço é obrigatório.',
            'estoque.required' => 'O estoque é obrigatório.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->except('_token');

        if ($request->hasFile('imagem')) {
            $img = $request->file('imagem');
            $nome = date('YmdHis') . '.' . $img->getClientOriginalExtension();
            $img->storeAs('imagem/produto', $nome, 'public');
            $data['imagem'] = 'imagem/produto/' . $nome;
        }

        $data['destaque'] = $request->has('destaque') ? 1 : 0;
        $data['ativo']    = $request->has('ativo') ? 1 : 0;
        $data['preco_promocional'] = $request->preco_promocional ?: null;

        Produto::create($data);
        return redirect()->route('produto.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show($id)
    {
        $produto = Produto::with(['categoria', 'plataforma'])->findOrFail($id);
        return view('produto.show', compact('produto'));
    }

    public function edit($id)
    {
        $dado        = Produto::findOrFail($id);
        $categorias  = Categoria::where('ativo', true)->orderBy('nome')->get();
        $plataformas = Plataforma::where('ativo', true)->orderBy('nome')->get();
        return view('produto.form', compact('dado', 'categorias', 'plataformas'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('imagem')) {
            $img = $request->file('imagem');
            $nome = date('YmdHis') . '.' . $img->getClientOriginalExtension();
            $img->storeAs('imagem/produto', $nome, 'public');
            $data['imagem'] = 'imagem/produto/' . $nome;
        } else {
            unset($data['imagem']);
        }

        $data['destaque'] = $request->has('destaque') ? 1 : 0;
        $data['ativo']    = $request->has('ativo') ? 1 : 0;
        $data['preco_promocional'] = $request->preco_promocional ?: null;

        Produto::findOrFail($id)->update($data);
        return redirect()->route('produto.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        Produto::findOrFail($id)->delete();
        return redirect()->route('produto.index')->with('success', 'Produto removido com sucesso!');
    }

    public function search(Request $request)
    {
        $query = Produto::with(['categoria', 'plataforma']);
        if (!empty($request->valor)) {
            $query->where($request->tipo, 'like', '%' . $request->valor . '%');
        }
        $dados = $query->orderBy('nome')->get();
        return view('produto.list', ['dados' => $dados]);
    }
}
