<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';

    protected $fillable = [
        'user_id','name', 'slug', 'description', 'price', 'image', 'published', 'featured'
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
    public function scopeFeatured($query)
    {
        return $query->where(function ($query)
        {
            $query->where('featured', '=', 1)
                ->where('published', '=', 1);
        });
    }
    public function scopeNoFeatured($query)
    {
        return $query->where(function ($query)
        {
            $query->where('featured', '<>', 1)
                ->where('published', '=', 1);
        });
    }
    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = (number($price) == "") ? 0 : number($price);
    }

    /**
     * Relationship with Category model
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
    /**
     * Relationship with Category model
     * @return mixed
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
    /**
     * Relationship with Photos model
     * @return mixed
     */
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
    /**
     * Relationship with Photos model
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
