<?php


namespace App\Repositories;


use App\Tag;

class TagRepository extends DbRepository{


    function __construct(Tag $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    /**
     * Save a category
     * @param $data
     * @return static
     */
    public function store($data)
    {
        return $this->model->create($data);
    }
    /**
     * Update a category
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|static
     */
    public function update($id, $data)
    {
        $tag = $this->model->findOrFail($id);

        $tag->fill($data);
        $tag->save();

        return $tag;
    }

    /**
     * Find a category by ID
     * @param $id
     * @return \Illuminate\Support\Collection|static
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Delete a category by ID
     * @param $id
     * @return \Illuminate\Support\Collection|DbCategoryRepository|static
     */
    public function destroy($id)
    {
        $tag = $this->findById($id);
        $tag->delete();

        return $tag;
    }


    /**
     * get all categories from admin control
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
        if (isset($search['q']) && ! empty($search['q']))
        {
            $tags = $this->model->Search($search['q']);
        } else
        {
            $tags = $this->model;
        }


        return $tags->orderBy('created_at','desc')->paginate($this->limit);
    }


}