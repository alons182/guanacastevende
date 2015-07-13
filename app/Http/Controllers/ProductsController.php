<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\ProductFrontRequest;

use App\Option;
use App\Repositories\CategoryRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\ProductRepository;
use App\Tag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;


class ProductsController extends Controller {

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var PhotoRepository
     */
    private $photoRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * @param ProductRepository $productRepository
     * @param PhotoRepository $photoRepository
     * @param CategoryRepository $categoryRepository
     * @param PaymentRepository $paymentRepository
     */
    function __construct(ProductRepository $productRepository, PhotoRepository $photoRepository, CategoryRepository $categoryRepository, PaymentRepository $paymentRepository)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update','Paid','postPaid', 'destroy']]);
        $this->photoRepository = $photoRepository;
        $this->categoryRepository = $categoryRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $category
     * @return Response
     */
    public function index(Request $request)
    {

        $search = array_add($request->all(), 'published', 1);

        $products = $this->productRepository->getall($search);
        $q = (isset($search['q'])) ? $search['q'] : '';

        return view('products.index')->with(compact('products', 'q'));
    }

    public function search(Request $request, $category = null)
    {

        $search = array_add($request->all(), 'published', 1);

        //if ($search['q'] == '') return view('categories.index');
        if (isset($search['q']) || ! $category)
            $products = $this->productRepository->getAll($search);
        else
            $products = $this->productRepository->findByCategory($category);

        $q = (isset($search['q'])) ? $search['q'] : '';

        return view('products.index')->with(compact('products', 'q', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $categories_list = $this->categoryRepository->getParentsAndChildrenList();//Category::lists('name', 'id');
        $tags_list = Tag::select('name', 'price', 'id')->get();
        $options_list = Option::select('name','description', 'price', 'id')->get();
        return View('products.create')->with(compact('categories_list', 'tags_list','options_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductFrontRequest $request
     * @return Response
     */
    public function store(ProductFrontRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->store($input, Auth()->user());

        Flash('Product Created');


        if ($product->option_id == 0 && $product->tags->count() == 0 )
        {
            $this->productRepository->update_state($product->id, 1);

            return Redirect()->route('profile.show', Auth()->user()->username);
        }




        return Redirect()->route('product_payment',$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return Response
     * @internal param int $id
     */
    public function show($slug)
    {
        $product = $this->productRepository->findBySlug($slug);
        $photos = $this->photoRepository->getPhotos($product->id);

        return view('products.show')->with(compact('product', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findById($id);

        if (auth()->user()->id != $product->user_id) return redirect()->home();

        $categories_list = $this->categoryRepository->getParentsAndChildrenList(true);//Category::lists('name', 'id')->all();

        $tags_list = Tag::select('name', 'price', 'id')->get();
        $options_list = Option::select('name','description', 'price', 'id')->get();

        $selected_categories = $product->categories()->select('categories.id AS id')->lists('id')->all();
        $selected_tags = $product->tags()->select('tags.id AS id')->lists('id')->all();

        return view('products.edit')->with(compact('product', 'categories_list', 'tags_list','options_list', 'selected_categories', 'selected_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param ProductFrontRequest $request
     * @return Response
     */
    public function update($id, ProductFrontRequest $request)
    {

        $this->productRepository->update($id, $request->all());

        Flash('Updated Product');

        return Redirect()->route('profile.show', Auth()->user()->username);
    }

    /**
     * Get view for paid options
     * @param $productId
     * @return \Illuminate\View\View
     */
    public function payment($productId)
    {

        $product = $this->productRepository->findById($productId);
        $option = Option::findOrFail($product->option_id);
        return view('products.payment')->with(compact('product','option'));
    }

    /**
     * Post paid options
     * @param PaymentRequest $request
     * @return \Illuminate\View\View
     */
    public function postPayment(PaymentRequest $request)
    {
        $product = $this->productRepository->findById($request->input('product_id'));

        $option = Option::findOrFail($product->option_id);
        $descriptionPayment = $option->name. ' '.$option->price. ' - Etiqueta: '. $product->tags->first()->name. ' ' .$product->tags->first()->price;

        $input = array_add($request->all(), 'user_id',auth()->user()->id);
        $input = array_add($input, 'description',$descriptionPayment);
        $input = array_add($input, 'amount', $option->price + $product->tags->first()->price );

        $payment = $this->paymentRepository->store($input);

        flash('Producto Creado correctamente');

        return Redirect()->route('profile.show', Auth()->user()->username);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
