<?php namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Product;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;


class ProductsController extends ApiController
{

    protected  $productTransformer;

    function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
        $this->middleware('auth.basic',['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     * @internal param
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ?: 3;
        $products = Product::paginate($limit);

        return $this->respondWithPagination($products,[
            'data'   => $this->productTransformer->transformCollection($products->all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     * @internal param
     */
    public function store(Request $request)
    {

       if(! auth()->user()->hasRole('administrator'))
        {
           $this->setStatusCode(422);
           return $this->respondWithError('No have permission');
        }

       if( !$request->input('user_id'))
       {
           $this->setStatusCode(422);
           return $this->respondWithError('Parameters Failed validation for a product');
       }

        Product::create($request->all());

        return $this->respondCreated('Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     * @internal param int $id
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(! $product)
        {
            return $this->respondNotFound('Product does not exist');

        }
        return $this->respond([
           'data' => $this->productTransformer->transform($product)
        ]);
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
