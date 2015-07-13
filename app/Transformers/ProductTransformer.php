<?php namespace App\Transformers;


class ProductTransformer  extends Transformer{


    public function transform($product)
    {
        return [
            'name' => $product['name'],
            'description' => $product['description'],
            'active' => (boolean) $product['published']
        ];
    }
}