<?php


namespace App\Repositories;


use App\Option;
use App\Payment;
use App\Product;

class PaymentRepository extends DbRepository {


    /**
     * @param Payment $model
     */
    function __construct(Payment $model)
    {
        $this->model = $model;
    }

    /**
     * Save a product
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $data = $this->prepareData($data);

        $payment = $this->model->create($data);

        return $payment;
    }

    private function prepareData($data)
    {
        $descriptionPayment = "";
        $total = 0;
        $product = Product::findOrFail($data['product_id']);

        if($product->option_id)
        {
            $product->published = 1;
            $product->featured = ($product->option_id == 2) ? $product->featured = 1 : 0;
            $product->save();

            $option = Option::findOrFail($product->option_id);

            $descriptionPayment .= $option->name. ' '.$option->price;
            $total += $option->price;
        }
        if($product->tags->count())
        {
            $descriptionPayment .= ' - Etiqueta: '. $product->tags->first()->name. ' ' .$product->tags->first()->price;
            $total += $product->tags->first()->price;
        }

        $data = array_add($data, 'user_id', auth()->user()->id);
        $data = array_add($data, 'description',$descriptionPayment);
        $data = array_add($data, 'amount', $total);

        return $data;


    }
}