<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Leitor - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container" style="max-width: 600px; margin-top: 30px;">
    <h2>Editar Leitor</h2>
    <p style="margin-bottom: 20px; color: var(--texto);">Atualizando dados de: <strong>{{ $leitor->name }}</strong></p>
    
    <form action="/leitores/{{ $leitor->id }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label>Nome Completo:</label>
            <input type="text" name="nome" value="{{ $leitor->name }}" required>
        </div>

        <div class="form-group">
            <label>CPF ou Matrícula:</label>
            <input type="text" name="cpf" value="{{ $leitor->cpf_matricula }}">
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>E-mail:</label>
                <input type="email" name="email" value="{{ $leitor->email }}" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Telefone:</label>
                <input type="text" name="telefone" value="{{ $leitor->telefone }}">
            </div>
        </div>

        <div class="form-group">
            <label>Status do Leitor:</label>
            <select name="status" style="width: 100%; padding: 10px; border: 1px solid var(--borda); border-radius: 4px;">
                <option value="ativo" {{ $leitor->status == 'ativo' ? 'selected' : '' }}>🟢 Ativo (Pode fazer empréstimos)</option>
                <option value="em_atraso" {{ $leitor->status == 'em_atraso' ? 'selected' : '' }}>🟠 Em Atraso (Bloqueado p/ novos empréstimos)</option>
                <option value="bloqueado" {{ $leitor->status == 'bloqueado' ? 'selected' : '' }}>🔴 Bloqueado (Punido/Suspenso)</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn" style="flex: 1;">Salvar Alterações</button>
            <a href="/leitores" class="btn btn-danger" style="text-align: center;">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>