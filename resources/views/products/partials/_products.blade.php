
@forelse($products as $product)
    <div class="products__item">

        <figure class="products__item__img">
            @if($product->image)
                <a href="{!! ($product->published) ? URL::route('product_path', [$product->slug]) : '#' !!}">
                    <img src="{!! photos_path('products') !!}thumb_{!! $product->image !!}" alt="{!! $product->name !!}" />
                 </a>
            @else
                <a href="{!! ($product->published) ? URL::route('product_path', [$product->slug]) : '#' !!}">
                    <img src="/js/holder.js/320x350/text:No-image" alt="{!! $product->name !!}" /></a>
                </a>
            @endif

        </figure>
        <div class="products__item__stick">
           <i class="icon-tag"></i>
            @if($product->option_id == 4 || $product->option_id == 3 )
                <span class="products__item__tag">
                    {!! ($product->option_id == 3) ? 'NUEVO' : $product->message_option !!}
                </span>
            @endif
            @foreach($product->tags as $tag)
                <span class="products__item__tag">{!! $tag->name !!}</span>
            @endforeach
        </div>
        @if(! $product->published)
            <div class="products__item__published">
                No Publicado
            </div>
        @endif
        <div class="products__item__info">
            <h2 class="products__item__intro">
                <a class="products__item__link icon-caret-right" href="{!! ($product->published) ? URL::route('product_path', [$product->slug]) : '#' !!}">{!! $product->name !!}</a>
            </h2>
        </div>
        @if (isset($user) && $user->isCurrent())
            {!! link_to_route('products.edit', 'Editar', $product->id,['class'=>'products__item__edit']) !!}
        @endif

    </div>


@empty
    <p>No se encontraron productos</p>
@endforelse
