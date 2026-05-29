<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $dados = Categoria::orderBy('nome')->get();
        return view('categoria.list', ['dados' => $dados]);
    }

    public function create()
    {
        return view('categoria.form');
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'nome'     => 'required|max:100',
            'descricao' => 'nullable|string',
        ], [
            'nome.required' => 'O nome é obrigatório.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->except('_token');
        $data['ativo'] = $request->has('ativo') ? 1 : 0;
        Categoria::create($data);
        return redirect()->route('categoria.index')->with('success', 'Categoria cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $dado = Categoria::findOrFail($id);
        return view('categoria.form', ['dado' => $dado]);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->except(['_token', '_method']);
        $data['ativo'] = $request->has('ativo') ? 1 : 0;
        Categoria::findOrFail($id)->update($data);
        return redirect()->route('categoria.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $dado = Categoria::findOrFail($id);
        if ($dado->produtos()->count() > 0) {
            return redirect()->route('categoria.index')->with('error', 'Não é possível excluir pois há produtos vinculados.');
        }
        $dado->delete();
        return redirect()->route('categoria.index')->with('success', 'Categoria removida com sucesso!');
    }

    public function search(Request $request)
    {
        $dados = !empty($request->valor)
            ? Categoria::where($request->tipo, 'like', '%' . $request->valor . '%')->get()
            : Categoria::orderBy('nome')->get();
        return view('categoria.list', ['dados' => $dados]);
    }
}
