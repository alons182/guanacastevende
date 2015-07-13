@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | {!! (isset($category)) ? $category. '-' : '' !!}  Productos @stop
@section('meta-description'){!! (isset($category)) ? 'Lista de productos de la categoria '. $category : 'Todos los Productos' !!}@stop

@section('content')
    <div class="products">
        @include('categories.partials._list')
        <article class="products__items">
            @if(isset($q) && $q!='')
                <h1>Busqueda: {!! $q !!}</h1>
            @else
                <h1>{!! (isset($category)) ? 'Categoria: '. $category : 'Todos los Productos' !!}</h1>
            @endif
            @include('products.partials._products')

        </article>
        @if ($products)
            <div class="pagination-container">{!! $products->appends(['q'=>$q])->render() !!}</div>
        @endif
    </div>



@stop