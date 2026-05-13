<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LeitorController extends Controller
{
    public function listarLeitores(Request $request)
    {
        if (isset($_GET['busca']) && $_GET['busca'] != '') {
            $leitores = User::where('role', 'cliente') // <-- Filtra para ser só leitor
                            ->where('name', 'like', '%' . $_GET['busca'] . '%')
                            ->get();
        } else {
            $leitores = User::where('role', 'cliente')->get(); // <-- Filtra para ser só leitor
        }
        
        return view('leitores', compact('leitores'));
    }

    public function editarLeitor($id)
    {
        $leitor = User::find($id);
        return view('editar_leitor', compact('leitor'));
    }

    public function atualizarLeitor(Request $request, $id)
    {
        $leitor = User::find($id);
        
        $leitor->update([
            'name' => $request->nome,
            'cpf_matricula' => $request->cpf,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'status' => $request->status, 
        ]);

        return redirect('/leitores');
    }

    public function excluirLeitor($id)
    {
        $leitor = User::find($id);
        $leitor->delete(); 
        return back();
    }
}