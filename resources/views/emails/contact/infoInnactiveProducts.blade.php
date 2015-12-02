<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información desde el sitio Guanacaste Vende - Productos inactivos (30 dias)</title>
</head>
<body>
<h2>Productos Inactivos</h2>
<p>Se ha puesto inactivo {{ $innactives }} Articulo(s)</p>
<ul>
@foreach($productsIna as $product)
	<li>{{ $product }}</li>
@endforeach
</ul>
<h2>Productos Eliminados</h2>
<p>Se han eliminado {{ $deleted }} Articulo(s)</p>
<ul>
@foreach($productsDel as $product)
	<li>{{ $product }}</li>
@endforeach
</ul>
</body>
</html>