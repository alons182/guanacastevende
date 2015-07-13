<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'name','price', 'description'
    ];

    /**
     * Relationship with the Product model
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
