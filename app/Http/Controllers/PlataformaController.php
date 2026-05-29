<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plataforma;

class PlataformaController extends Controller
{
    function index()
    {
        $dados = Plataforma::all();
        return view('plataforma.list', ['dados' => $dados]);
    }

    function create()
    {
        return view('plataforma.form');
    }

    function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/plataforma/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem;
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Plataforma::create($data);

        return redirect('plataforma')->with('success', 'Registro cadastrado com sucesso!');
    }

    function edit($id)
    {
        $dado = Plataforma::find($id);
        return view('plataforma.form', compact('dado'));
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $imagem = $request->file('imagem');

        if ($imagem) {
            $nome_imagem = date('YmdiHs') . "." . $imagem->getClientOriginalExtension();
            $diretorio = "imagem/plataforma/";
            $imagem->storeAs($diretorio, $nome_imagem, 'public');

            $data['imagem'] = $diretorio . $nome_imagem;
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Plataforma::find($id)->update($data);

        return redirect('plataforma')->with('success', 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        $dado = Plataforma::find($id);

        if ($dado->produtos()->count() > 0) {
            return redirect('plataforma')->with('error', 'Não é possível excluir pois há produtos vinculados.');
        }

        Plataforma::destroy($id);

        return redirect('plataforma')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Plataforma::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Plataforma::all();
        }

        return view('plataforma.list', ['dados' => $dados]);
    }

    function validateRequest(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'fabricante' => 'nullable|max:100',
            'ano_lancamento' => 'nullable|integer|min:1970|max:2027',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ], [
            'nome.required' => "O :attribute é obrigatório.",
        ]);
    }
}
