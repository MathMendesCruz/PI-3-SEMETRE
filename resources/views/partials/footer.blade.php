<footer class="container main-footer">
    <div class="footer-grid">
        <div class="footer-about">
            <div class="logo">Elegance Joias</div> 
            <p>Joias para todos os momentos.</p>
            <div class="social-icons">
                <a href="https://twitter.com" target="_blank" rel="noopener" title="Twitter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.66 10.66 0 01-10 5.5z"></path></svg></a>
                <a href="https://instagram.com" target="_blank" rel="noopener" title="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><circle cx="17.5" cy="6.5" r="1.5"></circle></svg></a>
                <a href="https://facebook.com" target="_blank" rel="noopener" title="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a6 6 0 00-6 6v3H2v4h7v8h4v-8h3l1-4h-4V8a2 2 0 012-2h3z"></path></svg></a>
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
                <li><a href="#">Calcular Frete</a></li>
                <li><a href="{{ route('termos') }}">Termos e Condições</a></li>
                <li><a href="{{ route('privacidade') }}">Políticas e Privacidade</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h3>FAQ</h3>
            <ul>
                <li><a href="#">Conta</a></li>
                <li><a href="#">Reclamações</a></li>
                <li><a href="#">Pagamento</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>Elegance Joias © 2000-2025 - Todos direitos reservados</p> 
        <div class="footer-payment-icons">
            <img src="{{ asset('img/bandeiras.jpg') }}" height="35" width="300" alt="Visa Electron" title="Visa Electron">
        </div>
    </div>
</footer>
