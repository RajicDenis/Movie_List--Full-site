<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Movielist;
use Sentinel;
use DB;

class NewsController extends Controller
{
    public function index() {

    	$newMovies = Movie::where('type', 'movie')->orderBy('created_at', 'desc')->take(3)->get();
    	$newTV = Movie::where('type', 'tvshow')->orderBy('created_at', 'desc')->take(3)->get();
    	$newReviews = DB::table('movie_user')
    		->join('movies', 'movie_id', '=', 'movies.id')
    		->join('users', 'user_id', '=', 'users.id')->orderBy('rev_date', 'desc')->take(3)->get();

    	$popMovie1 = Movie::where('type', 'movie')->orderBy('likes', 'desc')->first();
    	$popMovie2 = Movie::where('type', 'movie')->orderBy('likes', 'desc')->skip(1)->first();
    	$popMovie3 = Movie::where('type', 'movie')->orderBy('likes', 'desc')->skip(2)->first();
    	
    	$popTV1 = Movie::where('type', 'tvshow')->orderBy('likes', 'desc')->first();
    	$popTV2 = Movie::where('type', 'tvshow')->orderBy('likes', 'desc')->skip(1)->first();
    	$popTV3 = Movie::where('type', 'tvshow')->orderBy('likes', 'desc')->skip(2)->first();

        $lists = MovieList::where('public', 1)->orderBy('created_at', 'desc')->take(5)->get();

		return view('news')
    		->with('newMovies', $newMovies)
    		->with('newTV', $newTV)
    		->with('newReviews', $newReviews)
    		->with('popMovie1', $popMovie1)
    		->with('popMovie2', $popMovie2)
    		->with('popMovie3', $popMovie3)
    		->with('popTV1', $popTV1)
    		->with('popTV2', $popTV2)
    		->with('popTV3', $popTV3)
            ->with('lists', $lists);

    }

    public function profileIndex() {

    	$newMovies = Movie::where('type', 'movie')->orderBy('created_at', 'desc')->take(3)->get();
    	$newTV = Movie::where('type', 'tvshow')->orderBy('created_at', 'desc')->take(3)->get();
    	$newReviews = DB::table('movie_user')
    		->join('movies', 'movie_id', '=', 'movies.id')
    		->join('users', 'user_id', '=', 'users.id')->orderBy('rev_date', 'desc')->take(3)->get();

    	return view('profile')
    		->with('newMovies', $newMovies)
    		->with('newTV', $newTV)
    		->with('newReviews', $newReviews);

    }
}
