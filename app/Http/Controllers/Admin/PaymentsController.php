<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{

    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * @param PaymentRepository $paymentRepository
     */
    function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->all();
        $search['q'] = (isset($search['q'])) ? trim($search['q']) : '';

        $payments = $this->paymentRepository->getAll($search);

        return View('admin.payments.index')->with([
            'payments'     => $payments,
            'search'         => $search['q']


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->paymentRepository->destroy($id);

        Flash('Payment Deleted');

        return Redirect()->route('payments');
    }
}
