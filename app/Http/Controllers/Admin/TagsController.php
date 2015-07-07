<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TagsController extends Controller {


    /**
     * @var TagRepository
     */
    private $tagRepository;


    /**
     * @param TagRepository $tagRepository
     */
    function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
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

        $tags = $this->tagRepository->getAll($search);

        return View('admin.tags.index')->with([
            'tags'     => $tags,
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
        return View('admin.tags.create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return Response
     */
	public function store(TagRequest $request)
	{
        $input = $request->all();

        $this->tagRepository->store($input);

        Flash::message('Tag created');

        return Redirect()->route('tags');
	}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
	public function edit($id)
	{
        $tag = $this->tagRepository->findById($id);

        return View('admin.tags.edit')->with(compact('tag'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param TagRequest $request
     * @return Response
     */
	public function update($id, TagRequest $request)
	{
        $input = $request->all();

        $this->tagRepository->update($id, $input);

        Flash::message('Tag updated');

        return Redirect()->route('tags');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->tagRepository->destroy($id);

        Flash::message('Tag Deleted');

        return Redirect()->route('tags');
	}

}
