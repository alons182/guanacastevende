<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información desde el sitio Guanacaste Vende - Nuevo Comentario Publicado</title>
</head>
<body>
<p>Nuevo Comentario publicado en  tu producto: {{ $product['name'] }}</p>
<p>Puedes revisarlo y contestarlo en el siguiente enlace: <a href="{{ url('/products/'.$product['id']) }}" target="_blank">aquí</a></p>

</body>
</html>