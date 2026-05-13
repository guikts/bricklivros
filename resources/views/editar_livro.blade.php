<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container" style="max-width: 600px; margin-top: 30px;">
    <h2>Editar Livro</h2>
    <p style="margin-bottom: 20px; color: var(--texto);">Modificando o acervo: <strong>{{ $livro->titulo }}</strong></p>
    
    <form action="/livros/{{ $livro->id }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="form-group">
            <label>Título:</label>
            <input type="text" name="titulo" value="{{ $livro->titulo }}" required>
        </div>

        <div class="form-group">
            <label>Autor:</label>
            <input type="text" name="autor" value="{{ $livro->autor }}" required>
        </div>

        <div class="form-group">
            <label>ISBN:</label>
            <input type="text" name="isbn" value="{{ $livro->isbn }}" required>
        </div>

        <div class="form-group">
            <label>Categoria:</label>
            <input type="text" name="categoria" value="{{ $livro->categoria }}" required>
        </div>

        <div class="form-group">
            <label>Total de Exemplares:</label>
            <input type="number" name="quantidade" value="{{ $livro->total_exemplares }}" required>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn" style="flex: 1;">Salvar Alterações</button>
            <a href="/livros" class="btn btn-danger" style="text-align: center;">Cancelar</a>
        </div>
    </form>
</div>

</body>
</html>