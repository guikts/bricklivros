<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-shell">

        @include('partials.sidebar')

        <main class="main-content">
            <div class="container">

                <div class="page-header">
                    <div>
                        <span class="page-eyebrow">Acervo</span>
                        <h2>📚 Catálogo de Livros</h2>
                    </div>
                </div>

                @if(session('sucesso'))
                    <div class="alerta alerta-sucesso">✅ {{ session('sucesso') }}</div>
                @endif
                @if(session('erro'))
                    <div class="alerta alerta-erro">❌ {{ session('erro') }}</div>
                @endif

                @if(Auth::user()->role == 'bibliotecario')
                <div class="card">
                    <h4 class="card-title" style="margin-bottom: 20px;">➕ Cadastrar Novo Livro</h4>

                    <form action="/livros" method="POST" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                        @csrf

                        <input type="text" name="titulo" class="form-control" placeholder="Título do Livro" style="flex: 2; min-width: 200px;" required>
                        <input type="text" name="autor" class="form-control" placeholder="Nome do Autor" style="flex: 2; min-width: 200px;" required>
                        <input type="number" name="quantidade" class="form-control" placeholder="Qtd Exemplares" min="1" style="flex: 1; min-width: 130px;" required>

                        <button type="submit" class="btn btn-success" style="padding: 12px 20px;">Salvar Livro</button>
                    </form>
                </div>
                @endif

                <form action="/livros" method="GET" style="display: flex; gap: 10px; margin-bottom: 25px; align-items: center;">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar por título, autor ou ISBN..." value="{{ request('busca') }}" style="flex: 1;">
                    <button type="submit" class="btn btn-primary">🔍 Buscar</button>
                    <a href="/livros" class="btn btn-secondary">Limpar Filtro</a>
                </form>

                @php
                    $leitores_lista = \App\Models\User::where('role', 'cliente')->get();
                @endphp

                <div class="card" style="padding: 0; overflow: hidden;">
                    <div class="table-responsive">
                        <table class="table" style="margin-top: 0;">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>ISBN</th>
                                    <th>Categoria</th>
                                    <th>Estoque</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($livros as $livro)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $livro->titulo }}</td>
                                        <td>{{ $livro->autor }}</td>
                                        <td style="color: var(--text-muted);">{{ $livro->isbn ?? 'N/A' }}</td>
                                        <td>{{ $livro->categoria ?? 'Geral' }}</td>
                                        <td>
                                            @if($livro->exemplares_disponiveis > 0)
                                                <span class="badge badge-success">{{ $livro->exemplares_disponiveis }} de {{ $livro->total_exemplares }}</span>
                                            @else
                                                <span class="badge badge-danger">Sem estoque</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(Auth::user()->role === 'bibliotecario')

                                                <div class="action-buttons" style="justify-content: center;">
                                                    @if($livro->exemplares_disponiveis > 0)
                                                        <form action="/emprestimos" method="POST" style="display: flex; gap: 5px; margin: 0;">
                                                            @csrf
                                                            <input type="hidden" name="livro_id" value="{{ $livro->id }}">

                                                            <select name="leitor_id" required style="padding: 8px; border: 1px solid var(--border-color); border-radius: 8px; background-color: #fff; max-width: 130px;">
                                                                <option value="" disabled selected>Leitor...</option>
                                                                @foreach($leitores_lista as $leitor)
                                                                    <option value="{{ $leitor->id }}">{{ $leitor->name }}</option>
                                                                @endforeach
                                                            </select>

                                                            <input type="hidden" name="dias_emprestimo" value="14">
                                                            <button type="submit" class="btn btn-success" style="padding: 8px 14px; font-size: 0.85em;">Emprestar</button>
                                                        </form>
                                                    @endif

                                                    <a href="/livros/{{ $livro->id }}/editar" class="btn btn-warning" style="padding: 8px 14px; font-size: 0.85em;">Editar</a>

                                                    <form action="/livros/{{ $livro->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" style="padding: 8px 14px; font-size: 0.85em;">Excluir</button>
                                                    </form>
                                                </div>

                                            @else
                                                <span style="color: var(--text-muted); font-style: italic;">Consulte no balcão</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center" style="padding: 30px; color: var(--text-muted);">Nenhum livro encontrado na busca.</td>
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