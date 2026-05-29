<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    function index()
    {
        $dados = Categoria::all();
        return view('categoria.list', ['dados' => $dados]);
    }

    function create()
    {
        return view('categoria.form');
    }

    function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Categoria::create($data);

        return redirect('categoria')->with('success', 'Registro cadastrado com sucesso!');
    }

    function edit($id)
    {
        $dado = Categoria::find($id);
        return view('categoria.form', compact('dado'));
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Categoria::find($id)->update($data);

        return redirect('categoria')->with('success', 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        $dado = Categoria::find($id);

        if ($dado->produtos()->count() > 0) {
            return redirect('categoria')->with('error', 'Não é possível excluir pois há produtos vinculados.');
        }

        Categoria::destroy($id);

        return redirect('categoria')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Categoria::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Categoria::all();
        }

        return view('categoria.list', ['dados' => $dados]);
    }

    function validateRequest(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'descricao' => 'nullable|string',
        ], [
            'nome.required' => "O :attribute é obrigatório.",
        ]);
    }
}
