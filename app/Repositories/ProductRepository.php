<?php namespace App\Repositories;


use App\Category;
use App\Photo;
use App\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
class ProductRepository extends DbRepository{


    /**
     * @param Product $model
     */
    function __construct(Product $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    /**
     * Save a product
     * @param $data
     * @param null $user
     * @return mixed
     */
    public function store($data, $user = null)
    {
        $data = $this->prepareData($data);
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'], 'products', null, null, 640, null) : '';

        $product = ($user) ?  $user->products()->save(new $this->model($data)) : $this->model->create($data);

        $this->sync_categories($product, $data['categories']);
        if (isset($data['tags']))
        {
            $this->sync_tags($product, $data['tags']);
        }
        $this->sync_photos($product, $data);

        return $product;
    }

    /**
     * Update a product
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $product = $this->model->findOrFail($id);
        $data = $this->prepareData($data);

        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'], 'products', null, null, 640, null) : $product->image;

        $product->fill($data);
        $product->save();
        $this->sync_categories($product, $data['categories']);
        if (isset($data['tags']))
        {
            $this->sync_tags($product, $data['tags']);
        }
        return $product;
    }

    /**
     * Sync the tags of the product
     * @param $product
     * @param $tags
     */
    private function sync_tags($product, $tags)
    {
        $product->tags()->sync($tags);
    }
    /**
     * Sync the categories of the product
     * @param $product
     * @param $categories
     */
    public function sync_categories($product, $categories)
    {
        $product->categories()->sync($categories);
    }


    /**
     * Save the photos of the product
     * @param $product
     * @param $data
     */
    public function sync_photos($product, $data)
    {
        if (isset($data['new_photo_file']))
        {
            $cant = count($data['new_photo_file']);
            foreach ($data['new_photo_file'] as $photo)
            {
                $filename = $this->storeImage($photo, 'photo_' . $cant --, 'products/' . $product->id, null, null, 50, null);
                $photos = new Photo;
                $photos->url = $filename;
                $photos->url_thumb = 'thumb_' . $filename;
                $product->photos()->save($photos);
            }
        }

    }

    /**
     * Delete a product by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $product = $this->findById($id);
        $image_delete = $product->image;
        $photos_delete = $product->id;
        $product->delete();

        File::delete(dir_photos_path('products') . $image_delete);
        File::delete(dir_photos_path('products') . 'thumb_' . $image_delete);
        File::deleteDirectory(dir_photos_path('products') . $photos_delete);

        return $product;
    }


    /**
     * Find a product by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->with('categories')->findOrFail($id);
    }

    /**
     * Find a product by Slug
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->model->SearchSlug($slug)->first();
    }

    /**
     * Find a product by Category
     * @param $category
     * @return mixed
     */
    public function findByCategory($category)
    {
        $category = Category::searchSlug($category)->firstOrFail();

        $products = $category->products()->with('categories')->where('published', '=', 1)->paginate($this->limit);

        return $products;
    }

    /**
     * Get all the products for the admin panel
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
        if (isset($search['cat']) && ! empty($search['cat']))
        {
            $category = Category::with('products')->findOrFail($search['cat']);
            $products = $category->products();

        } else
        {
            $products = $this->model;
        }

        if (isset($search['q']) && ! empty($search['q']))
        {
            $products = $products->Search($search['q']);
        }

        if (isset($search['published']) && $search['published'] != "")
        {
            $products = $products->where('published', '=', $search['published']);
        }

        return $products->with('categories')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    /**
     * Get all the featured products for the store
     * @return mixed
     */
    public function getFeatured()
    {

        $products = $this->model->Featured()->orderBy('created_at','DESC')->get();

        return $products;
    }
    /**
     * Get all the products except featured
     * @return mixed
     */
    public function getAllExceptFeatured()
    {

        $products = $this->model->NoFeatured()->orderBy('created_at','DESC')->paginate(10);

        return $products;
    }

    /**
     * get last products for the dashboard page
     * @return mixed
     */
    public function getLasts()
    {
        return $this->model->orderBy('products.created_at', 'desc')
            ->limit(6)->get(['products.id', 'products.name']);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function prepareData($data)
    {
        $data['slug'] = ($data['slug']=="") ? Str::slug($data['name']) : $data['slug'];

        return $data;
    }




}