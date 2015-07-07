<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password','active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use ($search)
        {
            $query->where('username', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        });
    }

    /**
     * relationship with the Profile model
     * @return mixed
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    /**
     * Relationship with the Role model
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimesTamps();
    }

    /**
     * Relationship with the Product model
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * create a profile
     * @param null $profile
     * @return mixed
     */
    public function createProfile($profile = null)
    {
        $profile = ($profile) ? $profile : new Profile();

        return $this->profile()->save($profile);
    }

    /**
     * Verify is the user logged is a user profile
     * @return bool
     */
    public function isCurrent()
    {
        if(Auth::guest()) return false;

        return Auth::user()->id == $this->id;
    }

    /**
     * User have a role
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;

    }

    /**
     * Assign a role to user
     * @param $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * Remove a role to user
     * @param $role
     * @return mixed
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }
}
