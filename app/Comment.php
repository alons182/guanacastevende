<?php

namespace App;

use Carbon\Carbon;
use App\Mailers\ContactMailer;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'body','viewed'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function author(){

        return $this->belongsTo('App\User','author_id');
    }
    public function product(){

        return $this->belongsTo('App\Product','product_id');
    }
    public function replies(){

        return $this->hasMany('App\Comment','comment_id');
    }
    public function scopeViewed($query)
    {
        return $query->where('viewed', true);
    }
    public function scopeNotViewed($query)
    {
        return $query->where('viewed', false);
    }

    public function getTimeagoAttribute()
    {
        Carbon::setLocale(config('app.locale'));
        $date = Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
        return $date;
    }
    // this function takes in user ID, comment and the rating and attaches the review to the user by its ID, then the average rating for the user is recalculated
    public function storeCommentForUser($userId, $authorId, $body, $productId)
    {
        //dd($userId. '-'.$authorId.'-'.$body.'-'.$productId);
        $user = User::find($userId);


        // this will be added when we add user's login functionality
        //$this->user_id = Auth::user()->id;
        $this->author_id = $authorId;
        $this->body = $body;
        $this->product_id = $productId;

        return $user->comments()->save($this);

        
      

    }


}
