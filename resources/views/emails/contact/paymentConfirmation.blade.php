<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información desde el sitio Guanacaste Vende - Confirmacion de pago</title>
    <style>
        table {
            background-color: transparent;
        }
        th {
            text-align: left;
        }
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }
        .table > thead > tr > th {
            vertical-align: bottom;
            border-bottom: 2px solid #dddddd;
        }
        .table > caption + thead > tr:first-child > th,
        .table > colgroup + thead > tr:first-child > th,
        .table > thead:first-child > tr:first-child > th,
        .table > caption + thead > tr:first-child > td,
        .table > colgroup + thead > tr:first-child > td,
        .table > thead:first-child > tr:first-child > td {
            border-top: 0;
        }
        .table > tbody + tbody {
            border-top: 2px solid #dddddd;
        }
        .table .table {
            background-color: #ffffff;
        }
        .table-condensed > thead > tr > th,
        .table-condensed > tbody > tr > th,
        .table-condensed > tfoot > tr > th,
        .table-condensed > thead > tr > td,
        .table-condensed > tbody > tr > td,
        .table-condensed > tfoot > tr > td {
            padding: 5px;
        }
        .table-bordered {
            border: 1px solid #dddddd;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #dddddd;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > thead > tr > td {
            border-bottom-width: 2px;
        }
        .table-striped > tbody > tr:nth-child(odd) > td,
        .table-striped > tbody > tr:nth-child(odd) > th {
            background-color: #f9f9f9;
        }
        .table-hover > tbody > tr:hover > td,
        .table-hover > tbody > tr:hover > th {
            background-color: #f5f5f5;
        }
        table col[class*="col-"] {
            position: static;
            float: none;
            display: table-column;
        }
        table td[class*="col-"],
        table th[class*="col-"] {
            position: static;
            float: none;
            display: table-cell;
        }
        .table > thead > tr > td.active,
        .table > tbody > tr > td.active,
        .table > tfoot > tr > td.active,
        .table > thead > tr > th.active,
        .table > tbody > tr > th.active,
        .table > tfoot > tr > th.active,
        .table > thead > tr.active > td,
        .table > tbody > tr.active > td,
        .table > tfoot > tr.active > td,
        .table > thead > tr.active > th,
        .table > tbody > tr.active > th,
        .table > tfoot > tr.active > th {
            background-color: #f5f5f5;
        }
        .table-hover > tbody > tr > td.active:hover,
        .table-hover > tbody > tr > th.active:hover,
        .table-hover > tbody > tr.active:hover > td,
        .table-hover > tbody > tr:hover > .active,
        .table-hover > tbody > tr.active:hover > th {
            background-color: #e8e8e8;
        }
        .table > thead > tr > td.success,
        .table > tbody > tr > td.success,
        .table > tfoot > tr > td.success,
        .table > thead > tr > th.success,
        .table > tbody > tr > th.success,
        .table > tfoot > tr > th.success,
        .table > thead > tr.success > td,
        .table > tbody > tr.success > td,
        .table > tfoot > tr.success > td,
        .table > thead > tr.success > th,
        .table > tbody > tr.success > th,
        .table > tfoot > tr.success > th {
            background-color: #dff0d8;
        }
        .table-hover > tbody > tr > td.success:hover,
        .table-hover > tbody > tr > th.success:hover,
        .table-hover > tbody > tr.success:hover > td,
        .table-hover > tbody > tr:hover > .success,
        .table-hover > tbody > tr.success:hover > th {
            background-color: #d0e9c6;
        }
        .table > thead > tr > td.info,
        .table > tbody > tr > td.info,
        .table > tfoot > tr > td.info,
        .table > thead > tr > th.info,
        .table > tbody > tr > th.info,
        .table > tfoot > tr > th.info,
        .table > thead > tr.info > td,
        .table > tbody > tr.info > td,
        .table > tfoot > tr.info > td,
        .table > thead > tr.info > th,
        .table > tbody > tr.info > th,
        .table > tfoot > tr.info > th {
            background-color: #d9edf7;
        }
        .table-hover > tbody > tr > td.info:hover,
        .table-hover > tbody > tr > th.info:hover,
        .table-hover > tbody > tr.info:hover > td,
        .table-hover > tbody > tr:hover > .info,
        .table-hover > tbody > tr.info:hover > th {
            background-color: #c4e3f3;
        }
        .table > thead > tr > td.warning,
        .table > tbody > tr > td.warning,
        .table > tfoot > tr > td.warning,
        .table > thead > tr > th.warning,
        .table > tbody > tr > th.warning,
        .table > tfoot > tr > th.warning,
        .table > thead > tr.warning > td,
        .table > tbody > tr.warning > td,
        .table > tfoot > tr.warning > td,
        .table > thead > tr.warning > th,
        .table > tbody > tr.warning > th,
        .table > tfoot > tr.warning > th {
            background-color: #fcf8e3;
        }
        .table-hover > tbody > tr > td.warning:hover,
        .table-hover > tbody > tr > th.warning:hover,
        .table-hover > tbody > tr.warning:hover > td,
        .table-hover > tbody > tr:hover > .warning,
        .table-hover > tbody > tr.warning:hover > th {
            background-color: #faf2cc;
        }
        .table > thead > tr > td.danger,
        .table > tbody > tr > td.danger,
        .table > tfoot > tr > td.danger,
        .table > thead > tr > th.danger,
        .table > tbody > tr > th.danger,
        .table > tfoot > tr > th.danger,
        .table > thead > tr.danger > td,
        .table > tbody > tr.danger > td,
        .table > tfoot > tr.danger > td,
        .table > thead > tr.danger > th,
        .table > tbody > tr.danger > th,
        .table > tfoot > tr.danger > th {
            background-color: #f2dede;
        }
        .table-hover > tbody > tr > td.danger:hover,
        .table-hover > tbody > tr > th.danger:hover,
        .table-hover > tbody > tr.danger:hover > td,
        .table-hover > tbody > tr:hover > .danger,
        .table-hover > tbody > tr.danger:hover > th {
            background-color: #ebcccc;
        }
        @media screen and (max-width: 767px) {
            .table-responsive {
                width: 100%;
                margin-bottom: 15px;
                overflow-y: hidden;
                overflow-x: auto;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border: 1px solid #dddddd;
                -webkit-overflow-scrolling: touch;
            }
            .table-responsive > .table {
                margin-bottom: 0;
            }
            .table-responsive > .table > thead > tr > th,
            .table-responsive > .table > tbody > tr > th,
            .table-responsive > .table > tfoot > tr > th,
            .table-responsive > .table > thead > tr > td,
            .table-responsive > .table > tbody > tr > td,
            .table-responsive > .table > tfoot > tr > td {
                white-space: nowrap;
            }
            .table-responsive > .table-bordered {
                border: 0;
            }
            .table-responsive > .table-bordered > thead > tr > th:first-child,
            .table-responsive > .table-bordered > tbody > tr > th:first-child,
            .table-responsive > .table-bordered > tfoot > tr > th:first-child,
            .table-responsive > .table-bordered > thead > tr > td:first-child,
            .table-responsive > .table-bordered > tbody > tr > td:first-child,
            .table-responsive > .table-bordered > tfoot > tr > td:first-child {
                border-left: 0;
            }
            .table-responsive > .table-bordered > thead > tr > th:last-child,
            .table-responsive > .table-bordered > tbody > tr > th:last-child,
            .table-responsive > .table-bordered > tfoot > tr > th:last-child,
            .table-responsive > .table-bordered > thead > tr > td:last-child,
            .table-responsive > .table-bordered > tbody > tr > td:last-child,
            .table-responsive > .table-bordered > tfoot > tr > td:last-child {
                border-right: 0;
            }
            .table-responsive > .table-bordered > tbody > tr:last-child > th,
            .table-responsive > .table-bordered > tfoot > tr:last-child > th,
            .table-responsive > .table-bordered > tbody > tr:last-child > td,
            .table-responsive > .table-bordered > tfoot > tr:last-child > td {
                border-bottom: 0;
            }
        }
    </style>
</head>
<body>
<h1>Confirmación de pago</h1>
<div class="logo" style="text-align: center;">
    <img src="{{ url('/img/logo-email.png') }}" alt="Guanacaste Vende">
</div>
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
<p> Seguinos en nuestras redes sociales para estar atento a las sorpresas !!</p>
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