<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Empréstimos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; color: #005B96; border-bottom: 2px solid #005B96; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #BDC3C7; padding: 8px; text-align: left; }
        th { background-color: #005B96; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .devolvido { color: green; font-weight: bold; }
        .pendente { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Relatório Geral de Empréstimos - BrickLivros</h1>
    <p>Gerado em: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Leitor</th>
                <th>Livro</th>
                <th>Data Empréstimo</th>
                <th>Data Limite</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emprestimos as $emp)
                <tr>
                    <td>{{ $emp->id }}</td>
                    <td>{{ \App\Models\User::find($emp->user_id)->name ?? 'Leitor Excluído' }}</td>
                    <td>{{ \App\Models\Livro::find($emp->livro_id)->titulo ?? 'Livro Excluído' }}</td>
                    
                    <td>{{ date('d/m/Y', strtotime($emp->data_emprestimo)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($emp->data_limite_devolucao)) }}</td>
                    
                    <td>
                        @if($emp->data_devolucao)
                            <span class="devolvido">Devolvido em {{ date('d/m/Y', strtotime($emp->data_devolucao)) }}</span>
                        @else
                            <span class="pendente">Pendente</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>