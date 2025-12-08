<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - Elegance Joias</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
</head>
<body>

    <div class="top-bar">
        <span>Faça login e ganhe 20% em sua primeira compra. <a href="{{ route('cadastro') }}">Registre-se</a></span>
        <button class="close-btn" title="Fechar">✕</button>
    </div>
    <header class="container main-header">
        <a href="{{ route('index') }}" class="logo">Elegance Joias</a> 
        <nav>
            <a href="{{ route('index') }}">Página Inicial</a>
            <a href="{{ route('feminino') }}">Feminino</a>
            <a href="{{ route('masculino') }}">Masculino</a>
        </nav>
        <div class="header-icons">
            <div class="search-container">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Pesquisar produtos" class="search-input">
            </div>
            <a href="{{ route('carrinho') }}" class="icon-link cart-icon-link" title="Carrinho">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span class="cart-item-count">0</span>
            </a>
            <a href="{{ route('login') }}" class="icon-link" title="Login">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </a>
        </div>
    </header>

    <main class="container" style="padding: 40px 0;">
        <nav class="breadcrumb">
            <a href="{{ route('index') }}">Página Inicial</a>
            <span>&gt;</span>
            <span class="current">Sobre</span>
        </nav>

        <section style="max-width: 800px; margin: 40px auto;">
            <h1>Sobre a Elegance Joias</h1>
            <p style="font-size: 16px; line-height: 1.8; color: #666; margin: 20px 0;">
                Bem-vindo à Elegance Joias, sua melhor escolha em joaleria de luxo e elegância. Desde nossa fundação, 
                nos comprometemos em oferecer as mais belas peças de joalheria para todos os momentos especiais da sua vida.
            </p>
            <p style="font-size: 16px; line-height: 1.8; color: #666; margin: 20px 0;">
                Com mais de duas décadas de experiência, nossa missão é proporcionar qualidade incomparável, design inovador 
                e atendimento excepcional. Cada joia é cuidadosamente selecionada ou confeccionada para garantir a satisfação 
                e a felicidade de nossos clientes.
            </p>
            <p style="font-size: 16px; line-height: 1.8; color: #666; margin: 20px 0;">
                Acreditamos que toda pessoa merece usar uma joia que reflita sua personalidade, elegância e estilo de vida. 
                Por isso, oferecemos uma ampla variedade de produtos, desde clássicos atemporais até as tendências mais atuais 
                em joaleria.
            </p>
        </section>
    </main>

    <footer class="container main-footer">
        <div class="footer-grid">
            <div class="footer-about">
                <div class="logo">Elegance Joias</div> <p>Joias para todos os momentos.</p>
                <div class="social-icons">
                    <a href="https://twitter.com" target="_blank" rel="noopener" title="Twitter"><svg>...</svg></a>
                    <a href="https://instagram.com" target="_blank" rel="noopener" title="Instagram"><svg>...</svg></a>
                    <a href="https://facebook.com" target="_blank" rel="noopener" title="Facebook"><svg>...</svg></a>
                </div>
            </div>
            <div class="footer-links">
                <h3>SOBRE</h3>
                <ul>
                    <li><a href="{{ route('sobre') }}">Sobre Nós</a></li>
                    <li><a href="{{ route('index') }}">Catálogo</a></li>
                    <li><a href="{{ route('suporte') }}">Contato</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>AJUDA</h3>
                <ul>
                    <li><a href="{{ route('suporte') }}">Suporte</a></li>
                    <li><a href="{{ route('termos') }}">Termos e Condições</a></li>
                    <li><a href="{{ route('privacidade') }}">Políticas e Privacidade</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>NAVEGAÇÃO</h3>
                <ul>
                    <li><a href="{{ route('index') }}">Página Inicial</a></li>
                    <li><a href="{{ route('feminino') }}">Feminino</a></li>
                    <li><a href="{{ route('masculino') }}">Masculino</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Elegance Joias © 2000-2025 - Todos direitos reservados</p> <div class="footer-payment-icons">
                <img src="{{ asset('img/bandeiras.jpg') }}" height="35" width="300" alt="Visa Electron" title="Visa Electron">
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
