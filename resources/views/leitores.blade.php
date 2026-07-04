<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Leitores - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-shell">

        @include('partials.sidebar')

        <main class="main-content">
            <div class="container">

                <div class="page-header">
                    <div>
                        <span class="page-eyebrow">Administração</span>
                        <h2>👥 Gerenciamento de Leitores</h2>
                    </div>
                </div>

                @if(session('sucesso'))
                    <div class="alerta alerta-sucesso">✅ {{ session('sucesso') }}</div>
                @endif
                @if(session('erro'))
                    <div class="alerta alerta-erro">❌ {{ session('erro') }}</div>
                @endif

                <form action="/leitores" method="GET" style="display: flex; gap: 10px; margin-bottom: 25px;">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar por nome, CPF ou E-mail..." value="{{ request('busca') }}" style="flex: 1;">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <a href="/leitores" class="btn btn-secondary">Limpar Filtro</a>
                </form>

                <div class="card" style="padding: 0; overflow: hidden;">
                    <div class="table-responsive">
                        <table class="table" style="margin-top: 0;">
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
                                        <td style="font-weight: 600;">{{ $leitor->name }}</td>
                                        <td>{{ $leitor->cpf_matricula ?? 'Não informado' }}</td>
                                        <td>{{ $leitor->email }}<br><small style="color: var(--text-muted);">{{ $leitor->telefone }}</small></td>
                                        <td>
                                            @if($leitor->status == 'ativo')
                                                <span class="badge badge-success">Ativo</span>
                                            @elseif($leitor->status == 'em_atraso')
                                                <span class="badge badge-warning">Em Atraso</span>
                                            @else
                                                <span class="badge badge-danger">Bloqueado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="/leitores/{{ $leitor->id }}/editar" class="btn btn-warning" style="padding: 7px 14px; font-size: 0.85em;">Editar</a>

                                                <form action="/leitores/{{ $leitor->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir o leitor {{ $leitor->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" style="padding: 7px 14px; font-size: 0.85em;">Excluir</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center" style="padding: 30px; color: var(--text-muted);">Nenhum leitor encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>