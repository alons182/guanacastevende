<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Tag;
use App\Transformers\TagTransformer;


use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TagsController extends ApiController
{
    protected $tagTransformer;

    function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $productId
     * @return Response
     */
    public function index($productId = null)
    {
        $tags = $this->getTags($productId);

        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tags->all())
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }



    /**
     * @param $productId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTags($productId)
    {
        return $productId ? Product::findOrFail($productId)->tags : Tag::all();

    }
}
