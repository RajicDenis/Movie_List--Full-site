<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movielist extends Model
{
    public function movies() {

    	return $this->belongsToMany('App\Movie');

    }

    public function users() {

    	return $this->belongsTo('App\User');

    }
}
