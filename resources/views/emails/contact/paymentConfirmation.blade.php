<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información desde el sitio Guanacaste Vende - Confirmacion de pago</title>
</head>
<body>
<h1>Confirmación de pago</h1>

<p>Gracias por publicar tu artículo en GuanacateVende.com, tu transacción ha sido realizada con éxito y tu artículo está en línea con las siguientes opciones.</p>

<div class="table-responsive payment__options-table">

    <table class="table table-striped  table-bordered table-responsive">
        <thead>
        <tr>
            <th>Item</th>
            <th>Precio</th>
        </tr>
        </thead>
        <tbody>

        @foreach($items as $item)
            <tr>
                <td>{!! $item['name'] !!}</td>
                <td> {!! money($item['price'],'₡') !!}</td>
            </tr>
        @endforeach

        </tbody>

    </table>
    <h1 class="payment__title">Total: {!! money($total, '₡') !!} </h1>
</div>

<p>Podés ver tu artículo en el siguiente enlace: <a href="{{ url('/products/'.$product['id'] ) }}" target="_blank">{{ $product['name'] }}</a></p>
<p>También podés seguir vendiendo haciendo click <a href="{{ url('/products/create') }}" target="_blank">aquí</a></p>
<a style="display: inline-block; padding: 5px;" href="https://www.mastercard.us/en-us/merchants/safety-security/securecode.html" target="_blank"><img
            src="/img/logo-mastercard.png" alt="Mastercard" /></a>
<a style="display: inline-block; padding: 5px;" href="https://usa.visa.com/personal/security/vbv/index.html?it=wb|/|Learn%20More" target="_blank"><img
            src="/img/logo-verified-by-visa.png" alt="Verified by Visa" /></a>
<p> Seguinos en nuestras redes sociales para estar atento a las sorpresas !!</p>
<a style="display: inline-block; padding: 5px;" href="https://www.facebook.com/guanacastevende" target="_blank"><img src="{{ url('/img/facebook.jpg') }}"
                                                                                                                     alt="Facebook"></a>
<a style="display: inline-block; padding: 5px;" href="https://twitter.com/GuanacasteVende" target="_blank"><img src="{{ url('/img/twitter.jpg') }}"
                                                                                                                alt="Twitter"></a>
<a style="display: inline-block; padding: 5px;" href="https://www.youtube.com/channel/UCVDiC3vIclXSKmrKViPIIag" target="_blank"><img src="{{ url('/img/youtube.jpg') }}"
                                                                                                                                     alt="Youtube"></a>
<a style="display: inline-block; padding: 5px;" href="https://plus.google.com/+GuanacastevendeCR" target="_blank"><img src="{{ url('/img/googleplus.jpg') }}"
                                                                                                                       alt="Google Plus"></a>


</body>
</html>