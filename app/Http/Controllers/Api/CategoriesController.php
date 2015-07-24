<?php namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Requests;

use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;


class CategoriesController extends ApiController {

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var CategoryTransformer
     */
    private $transformer;

    /**
     * @param CategoryTransformer $transformer
     * @internal param CategoryRepository $categoryRepository
     */
    function __construct(CategoryTransformer $transformer)
    {

        $this->categoryTransformer = $transformer;
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
        $categories = Category::paginate($limit);

        return $this->respondWithPagination($categories,[
            'data'   => $this->categoryTransformer->transformCollection($categories->all()),
        ]);
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
        $category = Category::find($id);

        if(! $category)
        {
            return $this->respondNotFound('Category does not exist');

        }
        return $this->respond([
            'data' => $this->categoryTransformer->transform($category)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $categoryId
     * @return Response
     */
    public function children($categoryId = null)
    {
        $categories = $this->getChildren($categoryId);

        return $this->respond([
            'data' => $this->categoryTransformer->transformCollection($categories->all())
        ]);
    }

    private function getChildren($categoryId)
    {
        return $categoryId ? Category::findOrFail($categoryId)->getImmediateDescendants() : Category::all();
    }


}
