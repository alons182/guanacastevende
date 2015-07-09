<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'rating','comment'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function author(){

        return $this->belongsTo('App\User','author_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeSpam($query)
    {
        return $query->where('spam', true);
    }

    public function scopeNotSpam($query)
    {
        return $query->where('spam', false);
    }
    public function getTimeagoAttribute()
    {
        $date = Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
        return $date;
    }
    // this function takes in user ID, comment and the rating and attaches the review to the user by its ID, then the average rating for the user is recalculated
    public function storeReviewForUser($userId, $authorId, $comment, $rating)
    {
        $user = User::find($userId);

        // this will be added when we add user's login functionality
        //$this->user_id = Auth::user()->id;
        $this->author_id = $authorId;
        $this->comment = $comment;
        $this->rating = $rating;
        $user->reviews()->save($this);

        // recalculate ratings for the specified product
        $user->recalculateRating();
    }


}
