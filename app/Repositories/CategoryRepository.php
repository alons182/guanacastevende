<?php


namespace App\Repositories;


use App\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryRepository extends DbRepository{


    /**
     * @param Category $model
     */
    function __construct(Category $model)
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
        $data = $this->prepareData($data);
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'], 'categories',null, null, 640, null) : '';

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
        $category = $this->model->findOrFail($id);
        $data = $this->prepareData($data);
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'], 'categories',null, null, 640, null) : $category->image;

        $category->fill($data);
        $category->save();

        return $category;
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
        $category = $this->findById($id);
        $image_delete = $category->image;
        $category->delete();

        File::delete(dir_photos_path('categories') . $image_delete);
        File::delete(dir_photos_path('categories') . 'thumb_' . $image_delete);

        return $category;
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
            $categories = $this->model->Search($search['q']);
        } else
        {
            $categories = $this->model;
        }

        if (isset($search['published']) && $search['published'] != "")
        {
            $categories = $categories->where('published', '=', $search['published']);
        }

        return $categories->orderBy('created_at','desc')->orderBy('lft')->paginate($this->limit);
    }

    /**
     * get all categories for the font-end list search
     * @return mixed
     *
     */
    public function listCategories()
    {

        $categories = $this->model->where('published', '=', 1);

        return $categories->orderBy('created_at','desc')->get();
    }



    /**
     * get categories parents for the format to view the category select
     * @return array
     */
    public function getParentsAndChildrenList()
    {
        $all = $this->model->select('id', 'name', 'depth')->orderBy('lft')->get();

        $result = array();

        foreach ($all as $item)
        {
            $name = $item->name;
            if ($item->depth > 0) $name = str_repeat('—', $item->depth) . ' ' . $name;
            $result[ $item->id ] = $name;
        }

        return $result;
    }

    /**
     * Get parents categories
     * @param $category
     * @return mixed
     */
    public function getParents()
    {
        $categories = $this->model->roots()->get();

        return $categories;
    }
    /**
     * Get children categories from one category
     * @param $category
     * @return mixed
     */
    public function getChildren($category)
    {

        $category = $this->model->whereSlug($category)->first();
        $subcategories = $category->descendants()->lists('name', 'slug')->all();

        return $subcategories;
    }

    private function prepareData($data)
    {
        $data['slug'] = ($data['slug']=="") ? Str::slug($data['name']) : $data['slug'];

        if (! $data['parent_id'])
        {
            $data = array_except($data, array('parent_id'));
        }

        if($data['parent_id'] == 'root')
            $data['parent_id'] = NULL;

        return $data;
    }


}