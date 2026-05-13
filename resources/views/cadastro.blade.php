<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - BrickLivros</title>
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
        .register-wrapper {
            width: 100%;
            max-width: 500px; 
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="register-wrapper">
        <div class="text-center" style="margin-bottom: 20px;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo BrickLivros" style="height: 130px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15));">
        </div>

        <div class="card">
            <h2 class="text-center" style="color: var(--primary); margin-top: 0; margin-bottom: 20px;">Crie sua Conta</h2>

            <form action="/cadastrar" method="POST">
                @csrf <div class="form-row" style="display: block;"> <div class="form-group" style="margin-bottom: 15px;">
                        <label>Nome Completo:</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ex: João Silva">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>CPF ou Matrícula:</label>
                        <input type="text" name="cpf_matricula" class="form-control" required placeholder="000.000.000-00">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>E-mail:</label>
                        <input type="email" name="email" class="form-control" required placeholder="seu@email.com">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label>Senha:</label>
                        <input type="password" name="password" class="form-control" required placeholder="Mínimo 8 caracteres">
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label>Tipo de Perfil:</label>
                        <select name="role" class="form-control" required>
                            <option value="cliente">Leitor (Consulta o acervo)</option>
                            <option value="bibliotecario">Bibliotecário (Administrador)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 12px; font-size: 1.1em; background-color: var(--primary);">
                        Finalizar Cadastro
                    </button>
                </div>
            </form>

            <div class="text-center" style="margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 15px;">
                <a href="/login" style="color: var(--secondary); text-decoration: none; font-weight: 600; font-size: 0.95em;">
                    Já possui uma conta? Fazer Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>