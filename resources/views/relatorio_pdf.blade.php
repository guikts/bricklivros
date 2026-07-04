<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Empréstimos</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1c2530;
            margin: 30px;
        }
        .report-header {
            border-bottom: 3px solid #005B96;
            padding-bottom: 14px;
            margin-bottom: 22px;
        }
        .report-header h1 {
            margin: 0 0 4px;
            color: #06263e;
            font-size: 20px;
        }
        .report-header p {
            margin: 0;
            color: #6b7686;
            font-size: 11px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e7ebf1; padding: 8px 10px; text-align: left; }
        th {
            background-color: #005B96;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        tr:nth-child(even) { background-color: #f3f5f9; }
        .devolvido { color: #1e7e34; font-weight: bold; }
        .pendente { color: #a71d2a; font-weight: bold; }
    </style>
</head>
<body>

    <div class="report-header">
        <h1>Relatório Geral de Empréstimos — BrickLivros</h1>
        <p>Gerado em: {{ date('d/m/Y H:i') }}</p>
    </div>

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