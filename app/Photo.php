<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

    protected $table = 'photos';

    protected $fillable = [

        'product_id', 'url', 'url_thumb'

    ];


    /**
     * Relationship with Product model
     * @return mixed
     */
    public function products()
    {
        return $this->belongsTo('App\Product');
    }

}
