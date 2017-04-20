<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Movie;
use Sentinel;
use DB;

class Utilities extends Model
{
    public static function scoreExists($mid) {

    	$user = User::find(Sentinel::getUser()->id);

    	if($user->movies()->where('movie_id', $mid)->exists()) {

    		return true;

    	} else {

    		return false;

    	}
    	
    }

    public static function getRating($mid) {

    	$movie = Movie::find($mid);

    	$r = $movie->users()->get(); 
        
        if(count($r) != null) {
            $ratingSum = '';
            $count = 0;

            foreach($r as $u) {
                if($u->pivot->rating != null) {
                    $ratingSum += $u->pivot->rating;
                    $count += 1;
                } 
            }

            if($count != 0) {
                $avgRating = $ratingSum / $count;
            } else {
                $avgRating = null; 
            }    

        } else {
            $avgRating = null;
        }

        return $avgRating;

    }

    public static function getAvgUserRating($uid, $type) {

        $ratings = DB::table('movie_user')->where('user_id', $uid)->get();
        
        if($type == 'movie') {
            $movies = DB::table('movies')->where('type', 'movie')->get();
        } else {
            $movies = DB::table('movies')->where('type', 'tvshow')->get();
        }

        if(count($ratings) != null) {
            $ratingSum = '';
            $count = 0;

            foreach($ratings as $r) {
                foreach($movies as $m) {
                    if($m->id == $r->movie_id) {
                        if($r->rating != null) {
                            $ratingSum += $r->rating;
                            $count += 1;
                        } 
                    }
                }
            }

            if($count != 0) {
                $avgRating = $ratingSum / $count;
            } else {
                $avgRating = null; 
            }    

        } else {
            $avgRating = null;
        }

        return $avgRating;

    }

    public static function getUser($id) {

        $user = User::find($id);

        return $user;

    }

    public static function getMovie($id) {

        $movie = Movie::find($id);

        return $movie;

    }

    public static function getMoviesInList($id) {

        $list = Movielist::find($id);
        $array = [];

        foreach($list->movies as $m) {
            $array[] = $m->poster;
        }

        return $array;

    }

    public static function hasFourPosters($id) {

        $list = Movielist::find($id);
        $array = [];

        foreach($list->movies as $m) {
            $array[] = $m->poster;
        }

        if(count($array) > 3) {
            return true;
        } else {
            return false;
        }

    }

    public static function listHasMovie($listid, $movieid) {

        $list = DB::table('movie_movielist')->where('movielist_id', $listid)->where('movie_id', $movieid)->first();

        if($list == null) {
            return false;
        } else {
            return true;
        }

    }

    public static function getAdmin() {

        $adminRole = DB::table('roles')->where('slug', 'admin')->first();

        $userID = DB::table('role_users')->where('role_id', $adminRole->id)->first();

        $admin = User::find($userID->user_id);

        return $admin;

    }

    public static function getReviewStat($stat) {

        if($stat == 'total') {
            $table = DB::table('movie_user')->where('review', '!=', null)->get();
            $total = count($table);
            return $total;
        } elseif($stat == 'movies') {
            $table = DB::table('movie_user')->where('review', '!=', null)->where('type', 'movie')->get();
            $total = count($table);
            return $total;
        } elseif($stat == 'tvshows') {
            $table = DB::table('movie_user')->where('review', '!=', null)->where('type', 'tvshow')->get();
            $total = count($table);
            return $total;
        } elseif($stat == 'avg') {
            $table = DB::table('movie_user')->where('review', '!=', null)->where('rev_rating', '!=', null)->get();
            $count = 0;
            $avgRating = '';

            if(count($table) != 0) {
                foreach($table as $t) {
                    $avgRating += $t->rev_rating;
                    $count += 1;
                }
            } else {
                $avgRating = 0;
                $count = 0;
            }

            $score = $avgRating / $count;

            return $score;
        }

    }

}
