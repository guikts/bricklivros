<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">

    <a href="/dashboard" style="color: var(--primary, #0056b3); text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px; font-size: 1.1em;">
        ⬅ Voltar ao Painel
    </a>
    
    <h2 style="border: none; color: #333; margin-bottom: 20px;">📚 Catálogo de Livros</h2>

    @if(session('sucesso')) 
        <div class="card" style="background-color: #d4edda; border-left: 5px solid #28a745; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            ✅ {{ session('sucesso') }}
        </div> 
    @endif
    @if(session('erro')) 
        <div class="card" style="background-color: #f8d7da; border-left: 5px solid #dc3545; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
            ❌ {{ session('erro') }}
        </div> 
    @endif

    @if(Auth::user()->role == 'bibliotecario')
    <div style="background-color: #f8f9fa; padding: 25px; margin-bottom: 30px; border-radius: 8px; border: 1px solid #e0e0e0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin-top: 0; color: #333;">➕ Cadastrar Novo Livro</h4>
        
        <form action="/livros" method="POST" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            @csrf 
            
            <input type="text" name="titulo" class="form-control" placeholder="Título do Livro" style="flex: 2; min-width: 200px;" required>
            <input type="text" name="autor" class="form-control" placeholder="Nome do Autor" style="flex: 2; min-width: 200px;" required>
            <input type="number" name="quantidade" class="form-control" placeholder="Qtd Exemplares" min="1" style="flex: 1; min-width: 130px;" required>
            
            <button type="submit" class="btn btn-success" style="padding: 10px 20px;">Salvar Livro</button>
        </form>
    </div>
    @endif

    <form action="/livros" method="GET" style="display: flex; gap: 10px; margin-bottom: 25px; align-items: center;">
        <input type="text" name="busca" class="form-control" placeholder="Buscar por título, autor ou ISBN..." value="{{ request('busca') }}" style="flex: 1; padding: 10px;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">🔍 Buscar</button>
        <a href="/livros" class="btn btn-secondary" style="padding: 10px 20px;">Limpar Filtro</a>
    </form>

    @php
        $leitores_lista = \App\Models\User::where('role', 'cliente')->get();
    @endphp

    <div class="table-responsive" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background-color: #343a40; color: white;">
                <tr>
                    <th style="padding: 12px 15px;">Título</th>
                    <th style="padding: 12px 15px;">Autor</th>
                    <th style="padding: 12px 15px;">ISBN</th>
                    <th style="padding: 12px 15px;">Categoria</th>
                    <th style="padding: 12px 15px;">Estoque</th>
                    <th style="padding: 12px 15px; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($livros as $livro)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px 15px; font-weight: bold;">{{ $livro->titulo }}</td>
                        <td style="padding: 12px 15px;">{{ $livro->autor }}</td>
                        <td style="padding: 12px 15px; color: #666;">{{ $livro->isbn ?? 'N/A' }}</td>
                        <td style="padding: 12px 15px;">{{ $livro->categoria ?? 'Geral' }}</td>
                        <td style="padding: 12px 15px;">
                            @if($livro->exemplares_disponiveis > 0)
                                <span style="color: #28a745; font-weight: bold; background: #e8f5e9; padding: 4px 8px; border-radius: 4px;">{{ $livro->exemplares_disponiveis }} de {{ $livro->total_exemplares }}</span>
                            @else
                                <span style="color: #dc3545; font-weight: bold; background: #fdecee; padding: 4px 8px; border-radius: 4px;">Sem estoque</span>
                            @endif
                        </td>
                        <td style="padding: 12px 15px; text-align: center;">
                            @if(Auth::user()->role === 'bibliotecario')
                                
                                <div style="display: flex; gap: 8px; justify-content: center; align-items: center; flex-wrap: wrap;">
                                    @if($livro->exemplares_disponiveis > 0)
                                        <form action="/emprestimos" method="POST" style="display: flex; gap: 5px; margin: 0;">
                                            @csrf
                                            <input type="hidden" name="livro_id" value="{{ $livro->id }}">
                                            
                                            <select name="leitor_id" required style="padding: 6px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; max-width: 130px;">
                                                <option value="" disabled selected>Leitor...</option>
                                                @foreach($leitores_lista as $leitor)
                                                    <option value="{{ $leitor->id }}">{{ $leitor->name }}</option>
                                                @endforeach
                                            </select>

                                            <input type="hidden" name="dias_emprestimo" value="14">
                                            <button type="submit" class="btn btn-success" style="padding: 6px 12px; font-size: 0.85em;">Emprestar</button>
                                        </form>
                                    @endif
                                    
                                    <a href="/livros/{{ $livro->id }}/editar" class="btn btn-warning" style="padding: 6px 12px; font-size: 0.85em;">Editar</a>
                                    
                                    <form action="/livros/{{ $livro->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85em;">Excluir</button>
                                    </form>
                                </div>

                            @else
                                <span style="color: #888; font-style: italic;">Consulte no balcão</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #666;">Nenhum livro encontrado na busca.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>