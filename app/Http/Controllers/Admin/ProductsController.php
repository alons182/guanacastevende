<?php namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProductRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Tag;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ProductsController extends Controller {

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Display a listing of products.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->all();
        $search['q'] = (isset($search['q'])) ? trim($search['q']) : '';
        $search['cat'] = (isset($search['cat'])) ? $search['cat'] : '';
        $search['published'] = (isset($search['published'])) ? [$search['published']] : '';
        $search['published'] = ($search['published'] == '') ? '' : ($search['published'][0] == '') ? '' : $search['published'];
        // dd($search);
        //$this->categoryRepository->getParents();
        $products = $this->productRepository->getAll($search);

        return View('admin.products.index')->with([
            'products'         => $products,
            'search'           => $search['q'],
            'categorySelected' => $search['cat'],
            'selectedStatus'   => ($search['published']) ? $search['published'][0] : ''

        ]);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return Response
     */
    public function create()
    {
        $categories_list = $this->categoryRepository->getParentsAndChildrenList(); //Category::lists('name', 'id');
        $tags_list = Tag::lists('name', 'id');
        return View('admin.products.create')->with(compact('categories_list','tags_list'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductRequest $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();

        $this->productRepository->store($input);

        Flash::message('Product Created');

        return Redirect()->route('products');
    }


    /**
     * Show the form for editing the specified product.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

        $product = $this->productRepository->findById($id);
        $categories_list = $this->categoryRepository->getParentsAndChildrenList();//Category::lists('name', 'id')->all();
        $tags_list = Tag::lists('name', 'id')->all();
        $selected_categories = $product->categories()->select('categories.id AS id')->lists('id')->all();
        $selected_tags = $product->tags()->select('tags.id AS id')->lists('id')->all();

        return View('admin.products.edit')->with(compact('product', 'categories_list','tags_list', 'selected_categories','selected_tags'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  int $id
     * @param ProductRequest $request
     * @return Response
     */
    public function update($id, ProductRequest $request)
    {
        $this->productRepository->update($id, $request->all());

        Flash::message('Updated Product');

        return Redirect()->route('products');
    }

    /**
     * published a Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function pub($id)
    {
        $this->productRepository->update_state($id, 1);

        return Redirect()->route('products');
    }

    /**
     * Unpublished a Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function unpub($id)
    {
        $this->productRepository->update_state($id, 0);

        return Redirect()->route('products');
    }

    /**
     * Featured product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function feat($id)
    {
        $this->productRepository->update_feat($id, 1);

        return Redirect()->route('products');
    }

    /**
     * un-featured product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function unfeat($id)
    {
        $this->productRepository->update_feat($id, 0);

        return Redirect()->route('products');
    }

    /**
     * Remove the specified product from storage.
     * DELETE /products/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->productRepository->destroy($id);

        Flash::message('Product Deleted');

        return Redirect()->route('products');
    }

    /**
     * Remove multiple products from storage.
     * DELETE /products/{id}
     *
     * @internal param int $chk_activity (array of ids)
     * @param Request $request
     * @return Response
     */
    public function option_multiple(Request $request)
    {
        $products_id = $request->input('chk_product');
        $action = $request->input('select_action');
       
        foreach ($products_id as $id)
        {
            if($action == "active")
                $this->productRepository->update_state($id, 1);
            elseif($action == "inactive")
                $this->productRepository->update_state($id, 0);
            elseif($action == "delete")
                $this->productRepository->destroy($id);

        }


        return Redirect()->route('products');

    }

    /**
     * Remove multiple products from storage.
     * DELETE /products/{id}
     *
     * @internal param int $chk_activity (array of ids)
     * @param Request $request
     * @return Response
     */
   /* public function destroy_multiple(Request $request)
    {
        $products_id = $request->input('chk_product');

        foreach ($products_id as $id)
        {
            $this->productRepository->destroy($id);
        }

        Flash::message('Products Deleted');

        return Redirect()->route('products');

    }*/


}
