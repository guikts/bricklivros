<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="auth-page">
        <div class="auth-wrapper">

            <div class="auth-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo BrickLivros">
                <h1>Bem-vindo a BrickLivros!</h1>
            </div>

            <div class="auth-card">
                <h2>Acesso ao Sistema</h2>

                @if($errors->any())
                    <div class="auth-error">
                        E-mail ou senha incorretos. Tente novamente.
                    </div>
                @endif

                <form action="/login" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="email" name="email" class="form-control" required placeholder="Digite seu e-mail">
                    </div>

                    <div class="form-group">
                        <label>Senha:</label>
                        <input type="password" name="password" class="form-control" required placeholder="Digite sua senha">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 13px; font-size: 1.05em; margin-top: 8px;">Entrar no Sistema</button>
                </form>

                <div class="auth-footer">
                    <a href="/cadastrar">Não tem conta? Criar nova conta</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>