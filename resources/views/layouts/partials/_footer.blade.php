<div class="clear"></div>
<footer class="footer">
    <div class="inner">

        <div class="left">

            <a class="footer__logo" href="#"><img src="/img/logo-white.png" alt="Guanacaste Vende"/></a>
            <div class="footer__copyright">

                <span>Website by <a href="http://avotz.com"><i class="icon-avotz"></i></a></span>

            </div>
        </div>
        <div class="right">
            <div class="footer__social">
                <a class="footer__social__link" href="https://www.facebook.com/guanacastevende" target="_blank"><i class="icon-facebook"></i></a>
                <a class="footer__social__link" href="https://twitter.com/GuanacasteVende" target="_blank"><i class="icon-twitter"></i></a>
                <a class="footer__social__link" href="https://www.youtube.com/channel/UCVDiC3vIclXSKmrKViPIIag" target="_blank"><i class="icon-youtube"></i></a>
                <a class="footer__social__link" href="https://plus.google.com/+GuanacastevendeCR" target="_blank"><i class="icon-google-plus"></i></a>
            </div>
            <div class="footer__verify">

                <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=JIfaqN6F1wh6amQKHCl57GcczGx0Pmvki0HKcadEpzw1eTHLXaenO41LULWW"></script></span>
                <a href="#" class="siteLock" onclick="window.open('https://www.sitelock.com/verify.php?site=www.guanacastevende.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.guanacastevende.com"/></a>

            </div>

        </div>

        <div class="footer__terms">
           <p>Esta tienda está autorizada por Visa y MasterCard para realizar transacciones Electrónicas. <a class="footer__terms__link" href="{{ route('terms_path') }}">Términos y Condiciones</a></p>
            <a href="https://www.mastercard.us/en-us/merchants/safety-security/securecode.html" target="_blank"><img
                        src="/img/logo-mastercard.png" alt="Mastercard" /></a>
            <a href="https://usa.visa.com/personal/security/vbv/index.html?it=wb|/|Learn%20More" target="_blank"><img
                        src="/img/logo-verified-by-visa.png" alt="Verified by Visa" /></a>
            <a href="https://www.paypal.com/" target="_blank" style="background-color: #FFF;"><img src="https://www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/aceptamos-145x47.png" alt="Paga con PayPal" style="display: block;" /></a>
        </div>



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
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-21485543-16', 'auto');
    ga('send', 'pageview');

</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '679774882149951');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=679774882149951&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<script src="{{ elixir('js/bundle.js') }}"></script>
</body>
</html>

