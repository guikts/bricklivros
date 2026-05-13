<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class LivroController extends Controller
{
    public function cadastrarLivro(Request $request)
    {
        Livro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'isbn' => rand(100, 999), 
            'categoria' => 'Geral',
            'total_exemplares' => $request->quantidade,
            'exemplares_disponiveis' => $request->quantidade,
        ]);
        return back(); 
    }

    public function listarLivros(Request $request)
    {
        if (isset($_GET['busca']) && $_GET['busca'] != '') {
            $livros = Livro::where('titulo', 'like', '%' . $_GET['busca'] . '%')
                           ->orWhere('autor', 'like', '%' . $_GET['busca'] . '%')
                           ->get(); 
        } else {
            $livros = Livro::all(); 
        }
        return view('livros', compact('livros'));
    }

    public function editarLivro($id)
    {
        $livro = Livro::find($id); 
        return view('editar_livro', compact('livro'));
    }

    public function atualizarLivro(Request $request, $id)
    {
        $livro = Livro::find($id);
        $livro->update([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'isbn' => $request->isbn,
            'categoria' => $request->categoria,
            'total_exemplares' => $request->quantidade,
            'exemplares_disponiveis' => $request->quantidade, 
        ]);
        return redirect('/livros'); 
    }

    public function excluirLivro($id)
    {
        $livro = Livro::find($id);
        $livro->delete(); 
        return back();
    }
}