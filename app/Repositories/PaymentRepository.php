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
        $this->limit = 10;
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

    /**
     * get all categories from admin control
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
        if (isset($search['q']) && ! empty($search['q']))
        {
            $payments = $this->model->Search($search['q']);
        } else
        {
            $payments = $this->model;
        }


        return $payments->orderBy('created_at','desc')->paginate($this->limit);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $payment = $this->findById($id);
        $payment->delete();

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
            $product->featured = ($product->option_id != 1 ) ? $product->featured = 1 : 0;
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
        $data = array_add($data, 'description',$descriptionPayment); //.'- authorizationResult: '.$data['authorizationResult'] );
        $data = array_add($data, 'amount', $total);

        return $data;


    }
}