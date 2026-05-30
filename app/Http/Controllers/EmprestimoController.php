<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;
use App\Models\Livro;
use App\Models\User;

class EmprestimoController extends Controller
{
    public function emprestar(Request $request)
    {
        $livro = Livro::find($request->livro_id);
        $leitor = User::find($request->leitor_id);

        if ($livro->exemplares_disponiveis <= 0) { 
            return back()->with('erro', 'Livro sem estoque.');
        }

        if ($leitor->status == 'em_atraso' || $leitor->status == 'bloqueado') { 
            return back()->with('erro', 'Usuário bloqueado ou em atraso.');
        }

        $dias = $request->dias_emprestimo ?? 14; 

        Emprestimo::create([
            'user_id' => $leitor->id,
            'livro_id' => $livro->id,
            'data_emprestimo' => date('Y-m-d'),
            'data_limite_devolucao' => date('Y-m-d', strtotime("+$dias days")), 
        ]);

        $livro->decrement('exemplares_disponiveis'); 
        return back(); 
    }

    public function devolver($id)
    {
        $emprestimo = \App\Models\Emprestimo::findOrFail($id);
        
        $hoje = strtotime(date('Y-m-d'));
        $limite = strtotime($emprestimo->data_limite_devolucao);

        $valor_multa = 0;
        $status = 'sem_multa';

        if ($hoje > $limite) {
            $dias_atraso = ($hoje - $limite) / 86400;

            $valor_multa = $dias_atraso * 2.00;
            $status = 'pendente';
        }

        $emprestimo->update([
        'data_devolucao' => date('Y-m-d'),
        'valor_multa' => $valor_multa,
        'status_multa' => $status
        ]);

        $livro = \App\Models\Livro::find($emprestimo->livro_id);
        if ($livro) {
            $livro->increment('exemplares_disponiveis');
        }

        if ($valor_multa > 0){
            $mensagem = "Livro devolvido! Atenção: Foi gerada uma multa de" . number_format($valor_multa, 2, ',', '.') . " por " . $dias_atraso . "dia(s) de atraso";
            return back() ->with('erro', mensagem);
        }

        return back()->with('sucesso', 'Livro devolvido com sucesso!');
    }

    public function gerarRelatorioPdf()
    {
        $emprestimos = Emprestimo::all(); 
        return view('relatorio_pdf', compact('emprestimos'));
    }

    public function renovar(Request $request, $id)
    {
        $emprestimo = Emprestimo::find($id);

        if ($emprestimo->data_devolucao) {
            return back()->with('erro', 'Este livro já foi devolvido, não pode ser renovado.');
        }

        $dias_extras = $request->dias_adicionais ?? 7;

        $nova_data = date('Y-m-d', strtotime($emprestimo->data_limite_devolucao . " + $dias_extras days"));

        $emprestimo->update([
            'data_limite_devolucao' => $nova_data
        ]);

        return back();
    }
}