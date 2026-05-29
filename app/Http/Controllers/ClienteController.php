<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $dados = Cliente::orderBy('nome')->get();
        return view('cliente.list', ['dados' => $dados]);
    }

    public function create()
    {
        return view('cliente.form');
    }

    private function validateRequest(Request $request, $id = null)
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
            'nome.required'    => 'O nome é obrigatório.',
            'email.required'   => 'O e-mail é obrigatório.',
            'email.unique'     => 'Este e-mail já está cadastrado.',
            'cpf.unique'       => 'Este CPF já está cadastrado.',
        ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $data = $request->except('_token');
        $data['ativo'] = $request->has('ativo') ? 1 : 0;
        Cliente::create($data);
        return redirect()->route('cliente.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $dado = Cliente::findOrFail($id);
        return view('cliente.form', ['dado' => $dado]);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, $id);
        $data = $request->except(['_token', '_method']);
        $data['ativo'] = $request->has('ativo') ? 1 : 0;
        Cliente::findOrFail($id)->update($data);
        return redirect()->route('cliente.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $dado = Cliente::findOrFail($id);
        if ($dado->pedidos()->count() > 0) {
            return redirect()->route('cliente.index')->with('error', 'Não é possível excluir pois há pedidos vinculados.');
        }
        $dado->delete();
        return redirect()->route('cliente.index')->with('success', 'Cliente removido com sucesso!');
    }

    public function search(Request $request)
    {
        $dados = !empty($request->valor)
            ? Cliente::where($request->tipo, 'like', '%' . $request->valor . '%')->get()
            : Cliente::orderBy('nome')->get();
        return view('cliente.list', ['dados' => $dados]);
    }
}
