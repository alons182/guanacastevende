@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | @if(isset($category)) @foreach($category->getAncestors() as $parent) {!! $parent->name !!} - @endforeach {!! $category->name !!} @endif | Productos @stop
@section('meta-description') @if(isset($category)) Lista de productos de la categoria: @foreach($category->getAncestors() as $parent) {!! $parent->name !!} - @endforeach {!! $category->name !!}@else Todos los Productos @endif @stop

@section('content')
    <div class="products">
        @include('categories.partials._list')
        <article class="products__items">
            @if(isset($q) && $q!='')
                <h1>Busqueda: {!! $q !!}</h1>
            @else
                <h1>
                    @if(isset($category))
                        Categoria : 
                        
                        {!! $category->name !!}
                    @else
                        Todos los Productos
                    @endif
                </h1>
            @endif
            @include('products.partials._products')

        </article>
        @if ($products->total())
            <div class="pagination-container">{!! $products->appends(['q'=> $q ])->render() !!}</div>
        @endif
    </div>



@stop