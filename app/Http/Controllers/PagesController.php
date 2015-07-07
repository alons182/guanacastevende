<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mailers\ContactMailer;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ContactMailer
     */
    private $mailer;

    /**
     * @param ProductRepository $productRepository
     * @param ContactMailer $mailer
     */
    function __construct(ProductRepository $productRepository, ContactMailer $mailer)
    {
        $this->productRepository = $productRepository;
        $this->mailer = $mailer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function Home()
    {
        $featured = $this->productRepository->getFeatured();
        $products = $this->productRepository->getAllExceptFeatured();

        return view('pages.index')->with(compact('products','featured'));
    }

    /**
     * Show the form for contact.
     *
     * @return Response
     */
    public function Contact()
    {

       return view('pages.contact');

    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postContact(ContactRequest $request)
    {

        $data = $request->all();

        $this->mailer->contact($data);

        Flash('Mensaje enviado correctamente');

        return Redirect()->route('contact_path');

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
        //
    }
}
