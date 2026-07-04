<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-shell">

        @include('partials.sidebar')

        <main class="main-content">
            <div class="container" style="max-width: 640px;">

                <div class="page-header">
                    <div>
                        <span class="page-eyebrow">Acervo</span>
                        <h2>Editar Livro</h2>
                    </div>
                </div>

                <div class="card">
                    <p style="margin-top: 0; margin-bottom: 20px; color: var(--text-muted);">Modificando o acervo: <strong style="color: var(--text-main);">{{ $livro->titulo }}</strong></p>

                    <form action="/livros/{{ $livro->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Título:</label>
                            <input type="text" name="titulo" class="form-control" value="{{ $livro->titulo }}" required>
                        </div>

                        <div class="form-group">
                            <label>Autor:</label>
                            <input type="text" name="autor" class="form-control" value="{{ $livro->autor }}" required>
                        </div>

                        <div class="form-group">
                            <label>ISBN:</label>
                            <input type="text" name="isbn" class="form-control" value="{{ $livro->isbn }}" required>
                        </div>

                        <div class="form-group">
                            <label>Categoria:</label>
                            <input type="text" name="categoria" class="form-control" value="{{ $livro->categoria }}" required>
                        </div>

                        <div class="form-group">
                            <label>Total de Exemplares:</label>
                            <input type="number" name="quantidade" class="form-control" value="{{ $livro->total_exemplares }}" required>
                        </div>

                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Salvar Alterações</button>
                            <a href="/livros" class="btn btn-secondary" style="text-align: center;">Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</body>
</html>