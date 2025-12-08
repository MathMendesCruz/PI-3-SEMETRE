<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte - Elegance Joias</title>
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
            <span class="current">Suporte</span>
        </nav>

        <section style="max-width: 800px; margin: 40px auto;">
            <h1>Central de Suporte</h1>
            <p style="font-size: 16px; line-height: 1.8; color: #666; margin: 20px 0;">
                Precisando de ajuda? Estamos aqui para atender suas dúvidas e resolver seus problemas com rapidez e eficiência.
            </p>
            
            <h2 style="margin-top: 40px;">Como Podemos Ajudar?</h2>
            <ul style="font-size: 16px; line-height: 2; color: #666;">
                <li>📧 <strong>Email:</strong> suporte@elegancejoias.com.br</li>
                <li>📞 <strong>Telefone:</strong> (11) 3000-0000</li>
                <li>💬 <strong>Chat:</strong> Disponível de seg. a sex., 9h-18h</li>
            </ul>

            <h2 style="margin-top: 40px;">Perguntas Frequentes</h2>
            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <h3 style="color: #333;">Qual é o prazo de entrega?</h3>
                <p style="color: #666;">Geralmente entregamos em 5 a 7 dias úteis para São Paulo e região.</p>
            </div>

            <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <h3 style="color: #333;">Posso fazer devolução?</h3>
                <p style="color: #666;">Sim! Aceitamos devoluções dentro de 30 dias após a compra.</p>
            </div>
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
