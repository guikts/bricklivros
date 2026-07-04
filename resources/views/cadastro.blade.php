<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="auth-page">
        <div class="auth-wrapper wide">

            <div class="auth-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo BrickLivros">
            </div>

            <div class="auth-card">
                <h2>Crie sua Conta</h2>

                <form action="/cadastrar" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Nome Completo:</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ex: João Silva">
                    </div>

                    <div class="form-group">
                        <label>CPF ou Matrícula:</label>
                        <input type="text" name="cpf_matricula" class="form-control" required placeholder="000.000.000-00">
                    </div>

                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="email" class="form-control" required placeholder="seu@email.com">
                    </div>

                    <div class="form-group">
                        <label>Senha:</label>
                        <input type="password" name="password" class="form-control" required placeholder="Mínimo 8 caracteres">
                    </div>

                    <div class="form-group">
                        <label>Tipo de Perfil:</label>
                        <select name="role" class="form-control" required>
                            <option value="cliente">Leitor (Consulta o acervo)</option>
                            <option value="bibliotecario">Bibliotecário (Administrador)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 13px; font-size: 1.05em; margin-top: 8px;">
                        Finalizar Cadastro
                    </button>
                </form>

                <div class="auth-footer">
                    <a href="/login">Já possui uma conta? Fazer Login</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>