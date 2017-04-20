<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function genres() {

    	return $this->belongsToMany('App\Genre');

    }

    public function movielists() {

        return $this->belongsToMany('App/Movielist');

    }

    public function users() {

    	return $this->belongsToMany('App\User')
            ->withPivot('id')
    		->withPivot('score')
            ->withPivot('rating')
            ->withPivot('likes')
            ->withPivot('review')
            ->withPivot('rev_recap')
            ->withPivot('rev_rating')
            ->withPivot('rev_total_likes')
            ->withPivot('rev_date')
            ->orderBy('pivot_score', 'desc');

    }

}
