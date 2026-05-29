<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Plataforma;

class ProdutoController extends Controller
{
    function index()
    {
        $dados = Produto::with(['categoria', 'plataforma'])->orderBy('nome')->get();
        return view('produto.list', ['dados' => $dados]);
    }

    function create()
    {
        $categorias  = Categoria::where('ativo', true)->orderBy('nome')->get();
        $plataformas = Plataforma::where('ativo', true)->orderBy('nome')->get();

        return view('produto.form', compact('categorias', 'plataformas'));
    }

    function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/produto/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem;
        }

        $data['destaque'] = $request->has('destaque') ? 1 : 0;
        $data['ativo']    = $request->has('ativo') ? 1 : 0;
        $data['preco_promocional'] = $request->preco_promocional ?: null;

        Produto::create($data);

        return redirect('produto')->with('success', 'Registro cadastrado com sucesso!');
    }

    function show($id)
    {
        $produto = Produto::with(['categoria', 'plataforma'])->find($id);
        return view('produto.show', compact('produto'));
    }

    function edit($id)
    {
        $dado        = Produto::find($id);
        $categorias  = Categoria::where('ativo', true)->orderBy('nome')->get();
        $plataformas = Plataforma::where('ativo', true)->orderBy('nome')->get();

        return view('produto.form', compact('dado', 'categorias', 'plataformas'));
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/produto/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem;
        }

        $data['destaque'] = $request->has('destaque') ? 1 : 0;
        $data['ativo']    = $request->has('ativo') ? 1 : 0;
        $data['preco_promocional'] = $request->preco_promocional ?: null;

        Produto::find($id)->update($data);

        return redirect('produto')->with('success', 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        Produto::destroy($id);
        return redirect('produto')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
    {
        $query = Produto::with(['categoria', 'plataforma']);

        if (!empty($request->valor)) {
            $query->where($request->tipo, 'like', '%' . $request->valor . '%');
        }

        $dados = $query->orderBy('nome')->get();

        return view('produto.list', ['dados' => $dados]);
    }

    function validateRequest(Request $request)
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
            'nome.required'    => 'O :attribute é obrigatório.',
            'preco.required'   => 'O :attribute é obrigatório.',
            'estoque.required' => 'O :attribute é obrigatório.',
        ]);
    }
}
