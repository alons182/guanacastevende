<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información desde el sitio Guanacaste Vende - Nueva Pregunta Publicado</title>
</head>
<body>

<h1>Nueva Pregunta publicada en el producto: {{ $product['name'] }}</h1>
<p>Puedes revisarlo y contestarlo en el siguiente enlace: <a href="{{ url('/products/'.$product['id']) }}" target="_blank">aquí</a></p>
<p> Seguinos en nuestras redes sociales para estar atento a las sorpresas !!</p>
<div class="logo" style="text-align: center;">
    <img src="{{ url('/img/logo-email.png') }}" alt="Guanacaste Vende">
</div>
<a style="display: inline-block; padding: 5px;" href="https://www.facebook.com/guanacastevende" target="_blank"><img src="{{ url('/img/facebook.jpg') }}"
                                                                                                                     alt="Facebook"></a>
<a style="display: inline-block; padding: 5px;" href="https://twitter.com/GuanacasteVende" target="_blank"><img src="{{ url('/img/twitter.jpg') }}"
                                                                                                                alt="Twitter"></a>
<a style="display: inline-block; padding: 5px;" href="https://www.youtube.com/channel/UCVDiC3vIclXSKmrKViPIIag" target="_blank"><img src="{{ url('/img/youtube.jpg') }}"
                                                                                                                                     alt="Youtube"></a>
<a style="display: inline-block; padding: 5px;" href="https://plus.google.com/+GuanacastevendeCR" target="_blank"><img src="{{ url('/img/googleplus.jpg') }}"
                                                                                                                       alt="Google Plus"></a>
<p>
<a style="display: inline-block; padding: 5px; vertical-align: middle;" href="https://www.mastercard.us/en-us/merchants/safety-security/securecode.html" target="_blank"><img
            src="{{ url('/img/logo-mastercard.png') }}" alt="Mastercard" /></a>
<a style="display: inline-block; padding: 5px; vertical-align: middle;" href="https://usa.visa.com/personal/security/vbv/index.html?it=wb|/|Learn%20More" target="_blank"><img
            src="{{ url('/img/logo-verified-by-visa.png') }}" alt="Verified by Visa" /></a>
</p>

</body>
</html>