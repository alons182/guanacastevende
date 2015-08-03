
@forelse($products as $product)
    <div class="products__item">

        <figure class="products__item__img">
            @if($product->image)
                <a href="{!! ($product->published) ? URL::route('product_path', [$product->id]) : '#' !!}">
                    <img src="{!! photos_path('products') !!}thumb_{!! $product->image !!}" alt="{!! $product->name !!}" />
                 </a>
            @else
                <a href="{!! ($product->published) ? URL::route('product_path', [$product->id]) : '#' !!}">
                    <img src="/js/holder.js/320x350/text:No-image" alt="{!! $product->name !!}" /></a>
                </a>
            @endif

        </figure>
        <div class="products__item__stick">
           <i class="{!! ($product->option_id == 4) ? ($product->tags->first()->icon) ? $product->tags->first()->icon : 'icon-tag' : 'icon-tag' !!} animated "></i>
            @if($product->option_id == 2 )
                <span class="products__item__tag">
                     NUEVO
                </span>
            @endif
            @if($product->option_id == 4)
                @foreach($product->tags as $tag)
                    <span class="products__item__tag">{!! $tag->name !!}</span>
                @endforeach
            @endif
        </div>
        @if(! $product->published)
            <div class="products__item__published">
                En espera de confirmación
            </div>
        @endif
        <div class="products__item__price">
            {!! money($product->price,'₡') !!}
        </div>
        <div class="products__item__info">
            <h2 class="products__item__intro">
                <a class="products__item__link icon-caret-right" href="{!! ($product->published) ? URL::route('product_path', [$product->id]) : '#' !!}">{!! $product->name !!}</a>
            </h2>
        </div>
       @if (isset($user) && $user->isCurrent())

            {{--  link_to_route('products.edit', 'Editar', $product->id,['class'=>'products__item__edit']) --}}
            <button type="submit" class="products__item__delete " form="form-delete" formaction="{!! URL::route('products.destroy', [$product->id]) !!}">Eliminar</button>
            {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!}{!! Form::close() !!}
        @endif

    </div>


@empty
    <p>No se encontraron productos</p>
@endforelse
