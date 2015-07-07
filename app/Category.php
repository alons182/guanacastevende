<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'published', 'featured'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('name', 'like', '%' . $search . '%');
                //->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    public function scopeSearchSlug($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('slug', '=', $search)
                ->where('published', '=', 1);
        });
    }

    /*public function scopeSearchParent($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('parent_id', '=', $search);
        });
    }*/

    public function scopeFeatured($query)
    {
        return $query->where(function ($query)
        {
            $query->where('featured', '=', 1)
                ->where('published', '=', 1);
        });
    }


    /**
     * Relationship with Product model
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
