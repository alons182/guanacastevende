<aside class="products__categories">
    <h2 class="products__categories__title">Categorias</h2>
    <ul class="products__categories__ul">
        @forelse($categories as $category)
            <li class="products__categories__item">
                <a class="products__categories__link icon-caret-right" href="{!! URL::route('category_products_path', $category->slug) !!}">{!! $category->name !!}</a>
                @if($category->getImmediateDescendants())
                <ul class="products__subcategories__ul">
                    @foreach($category->getImmediateDescendants() as $subcategory)

                    <li class="products__subcategories__item">
                        <a class="products__subcategories__link icon-caret-right" href="{!! URL::route('category_products_path', $subcategory->slug) !!}">{!! $subcategory->name !!}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
        @empty
            <li class="products__categories__item">
                No se encontraron categorias
            </li>

        @endforelse
    </ul>
</aside>