<?php

namespace App\Http\Controllers;

use App\Repositories\PhotoRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhotosController extends Controller
{

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
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->photoRepository->destroy($id);;
    }
}
