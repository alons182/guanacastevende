@forelse($products as $product)
    <div class="products__item">

        <figure class="products__item__img">
            @if($product->image)
                <img src="{!! photos_path('products') !!}/thumb_{!! $product->image !!}" alt="{!! $product->name !!}" />
            @else
                <img src="/js/holder.js/320x350/text:No-image" alt="{!! $product->name !!}" /></a>
            @endif

        </figure>
        <div class="products__item__stick">
           <i class="icon-caret-right"></i> Stick
        </div>
        <div class="products__item__info">
            <h2 class="products__item__intro">
                <a class="products__item__link icon-caret-right" href="{!! URL::route('product_path', [$product->slug]) !!}">{!! $product->name !!}</a>
            </h2>
        </div>
        @if (isset($user) && $user->isCurrent())
            {!! link_to_route('products.edit', 'Editar', $product->id,['class'=>'products__item__edit']) !!}
        @endif

    </div>


@empty
    <p>No se encontraron productos</p>
@endforelse
