
@forelse($products as $product)
    <div class="products__item" style="background-image: url({!! photos_path('products') !!}thumb_{!! $product->image !!})">

        <figure class="products__item__img">
            @if($product->image)
                <a href="{!! ($product->published) ? URL::route('product_path', [$product->id]) : '#' !!}"></a>
            @else
                <a href="{!! ($product->published) ? URL::route('product_path', [$product->id]) : '#' !!}">
                    <img src="/js/holder.js/320x350/text:No-image" alt="{!! $product->name !!}" />
                </a>
            @endif

        </figure>
       
    </div>


@empty
    @if(isset($isHome) && $isHome)
        <!--<p>No se encontraron productos destacados</p>-->
    @else
        <p>No se encontraron productos</p>
    @endif
@endforelse
