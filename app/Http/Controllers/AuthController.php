<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        // Cria o usuário e salva no banco
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password), 
        ]);

        return redirect('/login')->with('sucesso', 'Conta criada com sucesso! Faça seu login.');
    }

    public function logar(Request $request)
    {
        $credenciais = $request->only('email', 'password');

        if (Auth::attempt($credenciais)) {
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }


    public function sair()
    {
        Auth::logout();
        return redirect('/login');
    }
}