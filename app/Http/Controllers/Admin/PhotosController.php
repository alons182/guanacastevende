<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\PhotoRepository;
use Illuminate\Http\Request;

class PhotosController extends Controller {

    /**
     * @var PhotoRepository
     */
    private $photoRepository;

    /**
     * @param PhotoRepository $photoRepository
     */
    function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;

    }


    /**
     * Store a newly created resource in storage.
     * POST /photos
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data['product_id'] = $request->input('id');
        $data['photo'] = $_FILES['file'];

        return $this->photoRepository->store($data);;
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /photos/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->photoRepository->destroy($id);;
    }

}
