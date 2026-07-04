<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Leitor - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-shell">

        @include('partials.sidebar')

        <main class="main-content">
            <div class="container" style="max-width: 640px;">

                <div class="page-header">
                    <div>
                        <span class="page-eyebrow">Leitores</span>
                        <h2>Editar Leitor</h2>
                    </div>
                </div>

                <div class="card">
                    <p style="margin-top: 0; margin-bottom: 20px; color: var(--text-muted);">Atualizando dados de: <strong style="color: var(--text-main);">{{ $leitor->name }}</strong></p>

                    <form action="/leitores/{{ $leitor->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nome Completo:</label>
                            <input type="text" name="nome" class="form-control" value="{{ $leitor->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>CPF ou Matrícula:</label>
                            <input type="text" name="cpf" class="form-control" value="{{ $leitor->cpf_matricula }}">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>E-mail:</label>
                                <input type="email" name="email" class="form-control" value="{{ $leitor->email }}" required>
                            </div>
                            <div class="form-group">
                                <label>Telefone:</label>
                                <input type="text" name="telefone" class="form-control" value="{{ $leitor->telefone }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status do Leitor:</label>
                            <select name="status" class="form-control">
                                <option value="ativo" {{ $leitor->status == 'ativo' ? 'selected' : '' }}>🟢 Ativo (Pode fazer empréstimos)</option>
                                <option value="em_atraso" {{ $leitor->status == 'em_atraso' ? 'selected' : '' }}>🟠 Em Atraso (Bloqueado p/ novos empréstimos)</option>
                                <option value="bloqueado" {{ $leitor->status == 'bloqueado' ? 'selected' : '' }}>🔴 Bloqueado (Punido/Suspenso)</option>
                            </select>
                        </div>

                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Salvar Alterações</button>
                            <a href="/leitores" class="btn btn-secondary" style="text-align: center;">Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</body>
</html>