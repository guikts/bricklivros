<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: var(--bg-color);
        }
        .login-wrapper {
            width: 100%;
            max-width: 400px; 
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="text-center" style="margin-bottom: 25px;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo BrickLivros" style="height: 400px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15));">
            <h1>Bem vindo a Brick Livros!</h1>
        </div>

        <div class="card">
            <h2 class="text-center" style="color: var(--primary); margin-top: 0; margin-bottom: 20px;">Acesso ao Sistema</h2>

            @if($errors->any())
                <div style="background-color: #f8d7da; border-left: 5px solid var(--danger); color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px; font-size: 0.9em; font-weight: 500;">
                    E-mail ou senha incorretos. Tente novamente.
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>E-mail:</label>
                    <input type="email" name="email" class="form-control" required placeholder="Digite seu e-mail">
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label>Senha:</label>
                    <input type="password" name="password" class="form-control" required placeholder="Digite sua senha">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1.1em;">Entrar no Sistema</button>
            </form>

            <div class="text-center" style="margin-top: 25px; border-top: 1px solid var(--border-color); padding-top: 15px;">
                <a href="/cadastrar" style="color: var(--secondary); text-decoration: none; font-weight: 600; font-size: 0.95em; transition: color 0.2s;">Não tem conta? Criar nova conta</a>
            </div>
        </div>
    </div>

</body>
</html>