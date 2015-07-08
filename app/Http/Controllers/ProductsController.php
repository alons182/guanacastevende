<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductFrontRequest;

use App\Repositories\PhotoRepository;
use App\Repositories\ProductRepository;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class ProductsController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var PhotoRepository
     */
    private $photoRepository;

    /**
     * @param ProductRepository $productRepository
     * @param PhotoRepository $photoRepository
     */
    function __construct(ProductRepository $productRepository, PhotoRepository $photoRepository)
    {
        $this->productRepository = $productRepository;
        $this->middleware('auth',['only' =>['create','store','edit','update','destroy']]);
        $this->photoRepository = $photoRepository;
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

        return view('products.index')->with(compact('products','q'));
    }

    public function search(Request $request , $category = null)
    {

        $search = array_add($request->all(), 'published', 1);

        //if ($search['q'] == '') return view('categories.index');
        if(isset($search['q']) || !$category)
            $products = $this->productRepository->getAll($search);
        else
            $products = $this->productRepository->findByCategory($category);

        $q = (isset($search['q'])) ? $search['q'] : '';

        return view('products.index')->with(compact('products','q','category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $categories_list = Category::lists('name', 'id');
        $tags_list = Tag::lists('name', 'id');

        return View('products.create')->with(compact('categories_list','tags_list'));
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

        $this->productRepository->store($input, Auth()->user());

        Flash('Product Created');

        return Redirect()->route('profile.show', Auth()->user()->username);
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
        return view('products.show')->with(compact('product','photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $product = $this->productRepository->findById($id);

        if(auth()->user()->id != $product->user_id) return redirect()->home();

        $categories_list = Category::lists('name', 'id')->all();
        $tags_list = Tag::lists('name', 'id')->all();
        $selected_categories = $product->categories()->select('categories.id AS id')->lists('id')->all();
        $selected_tags = $product->tags()->select('tags.id AS id')->lists('id')->all();

       return view('products.edit')->with(compact('product', 'categories_list','tags_list', 'selected_categories','selected_tags'));
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
