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
                    <li class="footer__menu__item"><a class="footer__menu__link" href="/blog" target="_blank">Blog</a> </li>

                </ul>
            </nav>
            <a class="footer__logo" href="#"><img src="/img/logo-white.png" alt="Guanacaste Vende"/></a>
        </div>
        <div class="right">
            <div class="footer__social">
                <a class="footer__social__link" href="https://www.facebook.com/guanacastevende" target="_blank"><i class="icon-facebook"></i></a>
                <a class="footer__social__link" href="https://twitter.com/GuanacasteVende" target="_blank"><i class="icon-twitter"></i></a>
                <a class="footer__social__link" href="https://www.youtube.com/channel/UCVDiC3vIclXSKmrKViPIIag" target="_blank"><i class="icon-youtube"></i></a>
                <a class="footer__social__link" href="https://plus.google.com/+GuanacastevendeCR" target="_blank"><i class="icon-google-plus"></i></a>
            </div>
            <div class="footer__copyright">

                <p>Website by <a href="http://avotz.com"><i class="icon-avotz"></i></a></p>
            </div>
        </div>
        <a href="#" class="siteLock" onclick="window.open('https://www.sitelock.com/verify.php?site=www.guanacastevende.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.guanacastevende.com"/></a>
    </div>
</footer>
@yield('scripts')

<div id='cptup-ready'></div>
<script data-cfasync='false' type='text/javascript'>
    window.captain = {up: function(fn) { captain.topics.push(fn) }, topics: []};
    // Add your settings here:
    captain.up({
        api_key: '55d65022ecfbd93dea000025'
    });
</script>
<script data-cfasync='false' type='text/javascript'>
    (function() {
        var cpt = document.createElement('script'); cpt.type = 'text/javascript'; cpt.async = true;
        cpt.src = 'https://captainup.com/assets/embed.es.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(cpt);
    })();
</script>

<script src="{{ elixir('js/bundle.js') }}"></script>
</body>
</html>

