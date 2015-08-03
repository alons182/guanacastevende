<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model {

    protected $table = 'profiles';

    protected $fillable = [
        'first_name','last_name','ide','address','telephone','telephone2', 'city'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Verify is the profile complete
     * @return bool
     */
    public function isComplete()
    {


        if(Auth::guest()) return false;

        foreach($this->attributes as $attribute)
        {
            if(!$attribute || $attribute == '')
            {
                return false;
            }

        }

        return true;
    }
}
