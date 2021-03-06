<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id','product_id','amount', 'description','operationNumber'
    ];

    public function scopeSearch($query, $search)
    {

        return $query->whereHas('user', function ($query) use ($search){
            $query->Where('username', 'like', '%' . $search . '%');
        });

    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship with the Product model
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
