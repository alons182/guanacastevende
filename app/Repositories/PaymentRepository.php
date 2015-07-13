<?php


namespace App\Repositories;


use App\Payment;

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
        //$data = $this->prepareData($data);

        $payment = $this->model->create($data);

        return $payment;
    }
}