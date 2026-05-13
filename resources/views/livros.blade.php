<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <a href="/dashboard" style="color: var(--texto); text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px;">← Voltar ao Painel</a>
    
    <h2 style="border: none;">Catálogo de Livros</h2>

    <!-- Alertas -->
    @if(session('sucesso')) <div class="alerta alerta-sucesso">{{ session('sucesso') }}</div> @endif
    @if(session('erro')) <div class="alerta alerta-erro">{{ session('erro') }}</div> @endif

    @if(Auth::user()->role == 'bibliotecario')
    <div style="background-color: #f8f9fa; padding: 20px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ddd;">
        <h4 style="margin-top: 0;">➕ Cadastrar Novo Livro</h4>
        
        <form action="/livros" method="POST" style="display: flex; gap: 10px; align-items: center;">
            @csrf 
            
            <input type="text" name="titulo" class="form-control" placeholder="Título do Livro" required>
            <input type="text" name="autor" class="form-control" placeholder="Nome do Autor" required>
            <input type="number" name="quantidade" class="form-control" placeholder="Qtd Exemplares" min="1" style="width: 150px;" required>
            
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
    @endif
    <hr>

    <form action="/livros" method="GET" style="display: flex; gap: 10px; margin-bottom: 25px;">
        <input type="text" name="busca" placeholder="Buscar por título, autor ou ISBN..." value="{{ request('busca') }}" style="flex: 1;">
        <button type="submit" class="btn">Buscar</button>
        <a href="/livros" class="btn btn-warning">Limpar Filtro</a>
    </form>

    @php
        $leitores_lista = \App\Models\User::where('role', 'cliente')->get();
    @endphp

    
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Categoria</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($livros as $livro)
                <tr>
                    <td>{{ $livro->titulo }}</td>
                    <td>{{ $livro->autor }}</td>
                    <td>{{ $livro->isbn }}</td>
                    <td>{{ $livro->categoria }}</td>
                    <td>
                        @if($livro->exemplares_disponiveis > 0)
                            <span class="status-ok">{{ $livro->exemplares_disponiveis }} de {{ $livro->total_exemplares }}</span>
                        @else
                            <span class="status-bad">Sem estoque</span>
                        @endif
                    </td>
                    <td>
                        @if(Auth::user()->role === 'bibliotecario')
                            
                            @if($livro->exemplares_disponiveis > 0)
                                <form action="/emprestimos" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                                    
                                    <select name="leitor_id" required style="width: 150px; padding: 5px; margin-right: 5px; border: 1px solid var(--borda); border-radius: 4px; background-color: #fff;">
                                        <option value="" disabled selected>Escolha o leitor...</option>
                                        @foreach($leitores_lista as $leitor)
                                            <option value="{{ $leitor->id }}">{{ $leitor->name }}</option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" name="dias_emprestimo" value="14">

                                    <button type="submit" class="btn btn-success" style="padding: 5px 10px; font-size: 0.9em;">Emprestar</button>
                                </form>
                            @endif
                            
                            <a href="/livros/{{ $livro->id }}/editar" class="btn btn-warning" style="padding: 5px 10px; font-size: 0.9em; margin-left: 5px;">Editar</a>
                            
                            <form action="/livros/{{ $livro->id }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.9em; margin-left: 5px;">Excluir</button>
                            </form>

                        @else
                            <span style="color: var(--texto); font-style: italic;">Consulte no balcão</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Nenhum livro encontrado na busca.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>