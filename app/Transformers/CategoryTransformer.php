<?php namespace App\Transformers;


class CategoryTransformer  extends Transformer{


    public function transform($category)
    {
        return [
            'id' => $category['id'],
            'name' => $category['name'],
            'children' => $category->getImmediateDescendants()->count(),
            'active' => (boolean) $category['published']
        ];
    }
}