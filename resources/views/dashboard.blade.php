<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - BrickLivros</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        
        <header class="topbar">
            <div style="display: flex; align-items: center;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo BrickLivros" style="height: 150px; width: auto; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15));">
            </div>
            <div class="user-info">
                <span>Olá, <strong>{{ Auth::user()->name }}</strong> (ID: {{ Auth::user()->id }})</span>
                <a href="/sair" class="btn btn-danger">Sair</a>
            </div>
        </header>

        <!-- Alertas Inteligentes (Sucesso e Erro da Multa) -->
        @if(session('sucesso')) 
            <div class="card" style="background-color: #d4edda; border-left: 5px solid var(--success); color: #155724; padding: 15px;">
                ✅ {{ session('sucesso') }}
            </div> 
        @endif
        @if(session('erro')) 
            <div class="card" style="background-color: #f8d7da; border-left: 5px solid var(--danger); color: #721c24; padding: 15px;">
                ❌ {{ session('erro') }}
            </div> 
        @endif
        
        <div class="text-center" style="margin-bottom: 40px;">
            <a href="/livros" class="btn btn-primary btn-lg">Acessar Catálogo de Livros ➔</a>
        </div>

        <!-- Visão do Bibliotecario -->
        @if(Auth::user()->role === 'bibliotecario')
            
            <div class="card" style="background-color: var(--primary); color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <h3 style="margin: 0;">🛠️ Painel de Gestão</h3>
                    <div style="display: flex; gap: 15px;">
                        <a href="/leitores" class="btn btn-secondary" style="background-color: rgba(255,255,255,0.2);">👥 Gerenciar Leitores</a>
                        <a href="/relatorio/emprestimos" target="_blank" class="btn" style="background-color: white; color: var(--danger);">📄 Relatório PDF</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title" style="color: var(--success);">📥 Realizar Novo Empréstimo</h3>
                
                <form action="/emprestimos" method="POST">
                    @csrf
                    @php
                        $livros_disponiveis = \App\Models\Livro::where('exemplares_disponiveis', '>', 0)->get();
                        $leitores_cadastrados = \App\Models\User::where('role', 'cliente')->get();
                    @endphp

                    <div class="form-row">
                        <div class="form-group" style="flex: 3;">
                            <label>Livro Disponível:</label>
                            <select name="livro_id" class="form-control" required>
                                <option value="" disabled selected>Selecione um livro da prateleira...</option>
                                @foreach($livros_disponiveis as $livro)
                                    <option value="{{ $livro->id }}">ID: {{ $livro->id }} - {{ $livro->titulo }} ({{ $livro->exemplares_disponiveis }} disp.)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style="flex: 3;">
                            <label>Leitor:</label>
                            <select name="leitor_id" class="form-control" required>
                                <option value="" disabled selected>Selecione o leitor...</option>
                                @foreach($leitores_cadastrados as $leitor)
                                    <option value="{{ $leitor->id }}">ID: {{ $leitor->id }} - {{ $leitor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label>Dias:</label>
                            <input type="number" name="dias_emprestimo" class="form-control" value="14" min="1" required>
                        </div>
                        
                        <div class="form-group" style="flex: 1;">
                            <button type="submit" class="btn btn-success" style="width: 100%; padding: 12px;">Emprestar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <!-- Título atualizado para mostrar que agora é um Histórico também -->
                <h3 class="card-title">📋 Controle de Empréstimos (Histórico e Ativos)</h3>
                @php
                    // Mudamos a query para trazer TODOS, ordenados do mais recente pro mais antigo
                    $emprestimos_gerais = \App\Models\Emprestimo::orderBy('id', 'desc')->get();
                @endphp

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cód</th>
                                <th>Livro</th>
                                <th>Leitor</th>
                                <th>Vencimento</th>
                                <th>Devolução</th>
                                <th>Multa</th>
                                <th>Status</th>
                                <th class="text-center">Ações Rápidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emprestimos_gerais as $emp)
                                <tr>
                                    <td><strong>#{{ $emp->id }}</strong></td>
                                    <td>{{ \App\Models\Livro::find($emp->livro_id)->titulo ?? 'Excluído' }}</td>
                                    <td>{{ \App\Models\User::find($emp->user_id)->name ?? 'Excluído' }}</td>
                                    <td style="color: var(--danger); font-weight: bold;">{{ date('d/m/Y', strtotime($emp->data_limite_devolucao)) }}</td>
                                    
                                    <!-- Nova Coluna: Devolução -->
                                    <td>
                                        @if($emp->data_devolucao)
                                            <span style="color: var(--success); font-weight: bold;">{{ date('d/m/Y', strtotime($emp->data_devolucao)) }}</span>
                                        @else
                                            <span style="color: #f39c12; font-weight: bold;">Pendente</span>
                                        @endif
                                    </td>

                                    <!-- Nova Coluna: Valor da Multa -->
                                    <td>
                                        @if($emp->valor_multa > 0)
                                            <span style="color: var(--danger); font-weight: bold;">R$ {{ number_format($emp->valor_multa, 2, ',', '.') }}</span>
                                        @else
                                            <span style="color: #888;">-</span>
                                        @endif
                                    </td>

                                    <!-- Nova Coluna: Status da Multa -->
                                    <td>
                                        @if($emp->status_multa == 'pendente')
                                            <span style="background-color: var(--danger); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">Multado</span>
                                        @elseif($emp->status_multa == 'sem_multa' && $emp->data_devolucao)
                                            <span style="background-color: var(--success); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">No Prazo</span>
                                        @else
                                            <span style="background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">Em Aberto</span>
                                        @endif
                                    </td>

                                    <!-- Coluna: Ações Rápidas -->
                                    <td>
                                        @if(!$emp->data_devolucao)
                                            <div class="action-buttons" style="justify-content: center;">
                                                <!-- Link atualizado para bater com a rota do Controller -->
                                                <form action="/emprestimos/devolver/{{ $emp->id }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">⬇️ Devolver</button>
                                                </form>

                                                <form action="/emprestimos/renovar/{{ $emp->id }}" method="POST" class="action-buttons">
                                                    @csrf
                                                    <input type="number" name="dias_adicionais" value="7" min="1" class="form-control" style="width: 70px; padding: 8px;">
                                                    <button type="submit" class="btn btn-info">🔄 Renovar</button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-center" style="color: #888; font-size: 0.9em;">Concluído</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if($emprestimos_gerais->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center" style="padding: 30px; color: var(--text-muted);">
                                        Nenhum empréstimo registrado ainda. ✨
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- Visão do Cliente/Leitor (Mantida Exatamente Igual) -->  
        @else
            
            <div class="card text-center" style="padding: 40px;">
                <h2 style="color: var(--primary);">Olá, Leitor! 👋</h2>
                <p style="color: var(--text-muted); font-size: 1.1em;">Acesse nosso catálogo para descobrir novas histórias. Para empréstimos e devoluções, procure o balcão de atendimento.</p>
            </div>

            <div class="card">
                <h3 class="card-title">📚 Meus Livros</h3>
                
                @php
                    $meus_emprestimos = \App\Models\Emprestimo::where('user_id', Auth::id())
                                        ->whereNull('data_devolucao')
                                        ->get();
                @endphp

                @if($meus_emprestimos->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Livro</th>
                                    <th>Data Limite</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meus_emprestimos as $emp)
                                    @php
                                        $livro = \App\Models\Livro::find($emp->livro_id);
                                        $hoje = strtotime(date('Y-m-d'));
                                        $limite = strtotime($emp->data_limite_devolucao);
                                        $dias_restantes = ($limite - $hoje) / 86400;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $livro->titulo ?? 'Livro Removido' }}</strong></td>
                                        <td>{{ date('d/m/Y', strtotime($emp->data_limite_devolucao)) }}</td>
                                        <td>
                                            @if($dias_restantes > 0)
                                                <span class="badge badge-success">No prazo ({{ $dias_restantes }} dias)</span>
                                            @elseif($dias_restantes == 0)
                                                <span class="badge badge-warning">⚠️ Devolver HOJE</span>
                                            @else
                                                <span class="badge badge-danger">🚨 Atrasado ({{ abs($dias_restantes) }} dias)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center" style="padding: 30px; color: var(--text-muted);">
                        Você não tem nenhum livro pendente. Que tal escolher uma nova leitura hoje?
                    </div>
                @endif
            </div>

        @endif

    </div>
</body>
</html>