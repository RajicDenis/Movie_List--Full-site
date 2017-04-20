<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function movielists() {

        return $this->hasMany('App/Movielist');

    }

    public function movies() {

        return $this->belongsToMany('App\Movie')
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
