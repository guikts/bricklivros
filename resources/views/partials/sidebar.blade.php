<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('img/logo.png') }}" alt="Logo BrickLivros">
        <span class="brand-name">BrickLivros</span>
    </div>

    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span> Painel
        </a>
        <a href="/livros" class="nav-item {{ request()->is('livros*') ? 'active' : '' }}">
            <span class="nav-icon">📚</span> Catálogo
        </a>
        @if(Auth::user()->role === 'bibliotecario')
            <a href="/leitores" class="nav-item {{ request()->is('leitores*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Leitores
            </a>
            <a href="/relatorio/emprestimos" target="_blank" class="nav-item">
                <span class="nav-icon">📄</span> Relatório
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <strong>{{ Auth::user()->name }}</strong>
                <small>{{ Auth::user()->role === 'bibliotecario' ? 'Bibliotecário' : 'Leitor' }}</small>
            </div>
        </div>
        <a href="/sair" class="btn btn-danger btn-block">Sair</a>
    </div>
</aside>