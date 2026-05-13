<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Leitores - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <a href="/dashboard" style="color: var(--texto); text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px;">← Voltar ao Painel</a>
    
    <h2 style="border: none;">Gerenciamento de Leitores</h2>

    @if(session('sucesso')) <div class="alerta alerta-sucesso">{{ session('sucesso') }}</div> @endif
    @if(session('erro')) <div class="alerta alerta-erro">{{ session('erro') }}</div> @endif
 
    <form action="/leitores" method="GET" style="display: flex; gap: 10px; margin-bottom: 25px;">
        <input type="text" name="busca" placeholder="Buscar por nome, CPF ou E-mail..." value="{{ request('busca') }}" style="flex: 1;">
        <button type="submit" class="btn">Buscar</button>
        <a href="/leitores" class="btn btn-warning">Limpar Filtro</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF/Matrícula</th>
                <th>Contato</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($leitores as $leitor)
                <tr>
                    <td>{{ $leitor->name }}</td>
                    <td>{{ $leitor->cpf_matricula ?? 'Não informado' }}</td>
                    <td>{{ $leitor->email }}<br><small>{{ $leitor->telefone }}</small></td>
                    <td>
                        <!-- Indicador visual de Status -->
                        @if($leitor->status == 'ativo')
                            <span style="color: var(--sucesso); font-weight: bold;">Ativo</span>
                        @elseif($leitor->status == 'em_atraso')
                            <span style="color: #D35400; font-weight: bold;">Em Atraso</span>
                        @else
                            <span style="color: var(--perigo); font-weight: bold;">Bloqueado</span>
                        @endif
                    </td>
                    <td>
                        <a href="/leitores/{{ $leitor->id }}/editar" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9em;">Editar</a>
                        
                        <form action="/leitores/{{ $leitor->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir o leitor {{ $leitor->name }}?');">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9em; margin-left: 5px;">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Nenhum leitor encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>