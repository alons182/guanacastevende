<aside class="products__categories">
    <h2 class="products__categories__title">Categorias</h2>
    <button class="btn-categories">Categorias</button>
    <?php
    $roots = $categories;

    echo "<ul class='products__categories__ul'>";
    foreach ($roots as $root) renderNode($root);
    echo "</ul>";

    // *Very simple* recursive rendering function
    function renderNode($node)
    {
        echo "<li class='products__categories__item parent'>";
        if ($node->children()->count() <= 0)
        {
            echo '<a class="products__categories__link " href="' . URL::route('category_products_path', $node->id) . '">' . $node->name . '</a>';

        } else
        {
            echo '<span class="products__categories__link">' . $node->name . ' <i class="icon-caret-right"></i></span>';
        }

        if ($node->children()->count() > 0)
        {
            echo "<ul class='products__categories__submenu'>";
            foreach ($node->children as $child) renderNode($child);
            echo "</ul>";
        }

        echo "</li>";

    }
    ?>



    </ul>
</aside>