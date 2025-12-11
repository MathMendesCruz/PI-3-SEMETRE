<header class="container main-header">
    <a href="{{ route('index') }}" class="logo">Elegance Joias</a>
    <nav>
        <a href="{{ route('index') }}">Página Inicial</a>
        <a href="{{ route('feminino') }}">Feminino</a>
        <a href="{{ route('masculino') }}">Masculino</a>
    </nav>
    <div class="header-icons">
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" name="q" placeholder="Pesquisar produtos" class="search-input" value="{{ request('q') }}">
            <button type="submit" style="display: none;"></button>
        </form>
        <a href="{{ route('carrinho') }}" class="icon-link cart-icon-link" title="Carrinho">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <span class="cart-item-count" id="cart-count">0</span>
        </a>
        @auth
            <div class="user-menu">
                <button class="icon-link user-menu-toggle" title="Menu do usuário">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    @if(Auth::user()->is_admin)
                        <span class="admin-badge">ADM</span>
                    @endif
                </button>
                <div class="user-menu-dropdown">
                    <p class="menu-user-name">{{ Auth::user()->name }}</p>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('adm.dashboard') }}" class="menu-link">Painel de Admin</a>
                    @endif
                    <a href="{{ route('profile') }}" class="menu-link">Meu Perfil</a>
                    <a href="{{ route('orders.index') }}" class="menu-link">Meus Pedidos</a>
                    <form action="{{ route('logout') }}" method="POST" class="menu-logout">
                        @csrf
                        <button type="submit" class="menu-logout-btn">Sair</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="icon-link" title="Login">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </a>
        @endauth
    </div>
</header>
