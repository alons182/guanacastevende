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
        //$featured = $this->productRepository->getFeaturedBanner();
        $products = $this->productRepository->getFeatured();

        return view('pages.index')->with(compact('products'));
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
     * Show the About Page.
     *
     * @return Response
     */
    public function About()
    {

        return view('pages.about');

    }

    /**
     * Show the Terms Page.
     *
     * @return Response
     */
    public function Terms()
    {

        return view('pages.terms');

    }


}
