<div class="clear"></div>
<footer class="footer">
    <div class="inner">
        <div class="footer__terms">
            <a class="footer__terms__link" href="{{ route('terms_path') }}">Términos y Condiciones</a>
        </div>

        <div class="left">
            <nav class="footer__menu">
                <ul class="footer__menu__ul">
                    <li class="footer__menu__item"><a class="footer__menu__link" href="{{ route('about_path') }}">Acerca de</a> </li>
                    <li class="footer__menu__item"><a class="footer__menu__link" href="{{ route('products_path') }}">Productos</a> </li>
                    <li class="footer__menu__item"><a class="footer__menu__link" href="{{ route('contact_path') }}">Contactenos</a> </li>
                    <li class="footer__menu__item"><a class="footer__menu__link" href="#">Blog</a> </li>

                </ul>
            </nav>
            <a class="footer__logo" href="#"><img src="/img/logo.png" alt="Guanacaste Vende"/></a>
        </div>
        <div class="right">
            <div class="footer__social">
                <a class="footer__social__link" href="#"><i class="icon-facebook"></i></a>
                <a class="footer__social__link" href="#"><i class="icon-twitter"></i></a>
                <a class="footer__social__link" href="#"><i class="icon-youtube"></i></a>
                <a class="footer__social__link" href="#"><i class="icon-google-plus"></i></a>
            </div>
            <div class="footer__copyright">
                <p>Website by <a href="http://avotz.com"><i class="icon-avotz"></i></a></p>
            </div>
        </div>

    </div>
</footer>
@yield('scripts')
<script src="{{ elixir('js/bundle.js') }}"></script>
</body>
</html>

