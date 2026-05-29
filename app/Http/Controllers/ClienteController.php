<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    function index()
    {
        $dados = Cliente::all();
        return view('cliente.list', ['dados' => $dados]);
    }

    function create()
    {
        return view('cliente.form');
    }

    function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->all();
        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Cliente::create($data);

        return redirect('cliente')->with('success', 'Registro cadastrado com sucesso!');
    }

    function edit($id)
    {
        $dado = Cliente::find($id);
        return view('cliente.form', compact('dado'));
    }

    function update(Request $request, $id)
    {
        $this->validateRequest($request, $id);
        $data = $request->all();
        $data['ativo'] = $request->has('ativo') ? 1 : 0;

        Cliente::find($id)->update($data);

        return redirect('cliente')->with('success', 'Registro atualizado com sucesso!');
    }

    function destroy($id)
    {
        $dado = Cliente::find($id);

        if ($dado->pedidos()->count() > 0) {
            return redirect('cliente')->with('error', 'Não é possível excluir pois há pedidos vinculados.');
        }

        Cliente::destroy($id);

        return redirect('cliente')->with('success', 'Registro removido com sucesso!');
    }

    function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Cliente::where(
                $request->tipo,
                'like',
                '%' . $request->valor . '%'
            )->get();
        } else {
            $dados = Cliente::all();
        }

        return view('cliente.list', ['dados' => $dados]);
    }

    function validateRequest(Request $request, $id = null)
    {
        $cpfRule   = 'nullable|unique:clientes,cpf' . ($id ? ",$id" : '');
        $emailRule = 'required|email|unique:clientes,email' . ($id ? ",$id" : '');

        $request->validate([
            'nome'            => 'required|max:200',
            'email'           => $emailRule,
            'cpf'             => $cpfRule,
            'telefone'        => 'nullable|max:20',
            'data_nascimento' => 'nullable|date',
            'cep'             => 'nullable|max:9',
            'estado'          => 'nullable|size:2',
        ], [
            'nome.required'    => 'O :attribute é obrigatório.',
            'email.required'   => 'O :attribute é obrigatório.',
            'email.unique'     => 'Este e-mail já está cadastrado.',
            'cpf.unique'       => 'Este CPF já está cadastrado.',
        ]);
    }
}
