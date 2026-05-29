<?php

namespace App\Http\Controllers;

use App\Models\Plataforma;
use Illuminate\Http\Request;

class PlataformaController extends Controller
{
    public function index()
    {
        $dados = Plataforma::orderBy('nome')->get();
        return view('plataforma.list', ['dados' => $dados]);
    }

    public function create()
    {
        return view('plataforma.form');
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'nome'           => 'required|max:100',
            'fabricante'     => 'nullable|max:100',
            'ano_lancamento' => 'nullable|integer|min:1970|max:' . (date('Y') + 1),
            'imagem'         => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ], [
            'nome.required' => 'O nome é obrigatório.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->except('_token');

        if ($request->hasFile('imagem')) {
            $img = $request->file('imagem');
            $nome = date('YmdHis') . '.' . $img->getClientOriginalExtension();
            $img->storeAs('imagem/plataforma', $nome, 'public');
            $data['imagem'] = 'imagem/plataforma/' . $nome;
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Plataforma::create($data);
        return redirect()->route('plataforma.index')->with('success', 'Plataforma cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $dado = Plataforma::findOrFail($id);
        return view('plataforma.form', ['dado' => $dado]);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('imagem')) {
            $img = $request->file('imagem');
            $nome = date('YmdHis') . '.' . $img->getClientOriginalExtension();
            $img->storeAs('imagem/plataforma', $nome, 'public');
            $data['imagem'] = 'imagem/plataforma/' . $nome;
        } else {
            unset($data['imagem']);
        }

        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Plataforma::findOrFail($id)->update($data);
        return redirect()->route('plataforma.index')->with('success', 'Plataforma atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $dado = Plataforma::findOrFail($id);
        if ($dado->produtos()->count() > 0) {
            return redirect()->route('plataforma.index')->with('error', 'Não é possível excluir pois há produtos vinculados.');
        }
        $dado->delete();
        return redirect()->route('plataforma.index')->with('success', 'Plataforma removida com sucesso!');
    }

    public function search(Request $request)
    {
        $dados = !empty($request->valor)
            ? Plataforma::where($request->tipo, 'like', '%' . $request->valor . '%')->get()
            : Plataforma::orderBy('nome')->get();
        return view('plataforma.list', ['dados' => $dados]);
    }
}
