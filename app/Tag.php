<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $table = 'tags';
    protected $fillable = [
        'name'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('name', 'like', '%' . $search . '%');
            //->orWhere('description', 'like', '%' . $search . '%');
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
