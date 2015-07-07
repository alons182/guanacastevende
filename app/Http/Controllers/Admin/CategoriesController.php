<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class CategoriesController extends Controller {

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        $search['published'] = (isset($search['published'])) ? $search['published'] : '';
        $categories = $this->categoryRepository->getAll($search);

        return View('admin.categories.index')->with([
            'categories'     => $categories,
            'search'         => $search['q'],
            'selectedStatus' => $search['published']

        ]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View('admin.categories.create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return Response
     */
	public function store(CategoryRequest $request)
	{
        $input = $request->all();

        $this->categoryRepository->store($input);

        Flash::message('Category created');

        return Redirect()->route('categories');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $category = $this->categoryRepository->findById($id);

        return View('admin.categories.edit')->withCategory($category);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param CategoryRequest $request
     * @return Response
     */
	public function update($id, CategoryRequest $request)
	{
        $input = $request->all();

        $this->categoryRepository->update($id, $input);

        Flash::message('Category updated');

        return Redirect()->route('categories');
	}

    /**
     * Featured.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function feat($id)
    {
        $this->categoryRepository->update_feat($id, 1);

        return Redirect()->route('categories');
    }

    /**
     * un-featured.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function unfeat($id)
    {
        $this->categoryRepository->update_feat($id, 0);

        return Redirect()->route('categories');
    }


    /**
     * published.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function pub($id)
    {
        $this->categoryRepository->update_state($id, 1);

        return Redirect()->route('categories');
    }

    /**
     * Unpublished.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function unpub($id)
    {
        $this->categoryRepository->update_state($id, 0);

        return Redirect()->route('categories');
    }
    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->categoryRepository->destroy($id);

        Flash::message('Category Deleted');

        return Redirect()->route('categories');
	}


}
