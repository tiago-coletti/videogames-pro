<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;

class AuthController extends Controller
{
    function showLogin()
    {
        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'E-mail ou senha inválidos.')->withInput();
    }

    function registro(Request $request)
    {
        $this->validateRequest($request);

        $user = User::create([
            'name'     => $request->nome,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Cliente::create([
            'nome'    => $request->nome,
            'email'   => $request->email,
            'user_id' => $user->id,
        ]);

        Auth::login($user);

        return redirect()->route('loja.index')->with('success', 'Conta criada com sucesso! Bem-vindo(a), ' . $request->nome . '!');
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    function validateRequest(Request $request)
    {
        $request->validate([
            'nome'     => 'required|max:200',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.unique'      => 'Este e-mail já está cadastrado.',
            'password.min'      => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);
    }
}
