<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Genre;
use App\User;
use App\Utilities;
use Session;
use DB;
use Sentinel;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::where('type', 'movie')->get();
        $tvshows = Movie::where('type', 'tvshow')->get();
        $genres = Genre::all();

        return view('settings')
            ->with('genres', $genres)
            ->with('movies', $movies)
            ->with('tvshows', $tvshows);
        
    }

    public function store(Request $request) {

        $this->validate($request, [
                'title' => 'required|max:200',
                'year' => 'required|integer|min:1800|max:3000',
                'summary' => 'max:2000',
                'language' => 'max:200',
                'country' => 'max:200',
                'imdb' => 'max:300',
                'tmdb' => 'max:300',
            ]);

    	$movies = new Movie;

        if($request->poster != null) {
            $file = $request->poster;
            $destination = public_path().'/images/posters';           
            $fileName = $file->getClientOriginalName();
            $file->move($destination, $fileName);

            $movies->poster = $fileName;
        }

        if($request->banner != null) {
            $file = $request->banner;
            $destination = public_path().'/images/banners';           
            $fileName = $file->getClientOriginalName();
            $file->move($destination, $fileName);

            $movies->banner = $fileName;
        }
    	

    	$movies->title = $request->title;
    	$movies->year = $request->year;

        if($request->summary != null) {
    	   $movies->summary = $request->summary;
        } else {
            $movies->summary = 'No summary available';
        }

        $movies->language = $request->language;
        $movies->country = $request->country;
        $movies->imdb = $request->imdb;
        $movies->tmdb = $request->tmdb;
    	$movies->type = $request->type;
    	

    	if($request->type == 'tvshow') {
    		$movies->status = $request->status;
    	}

    	$movies->save();

    	$movies->genres()->sync($request->genres, false);

    	if($request->type == 'tvshow') { 

    		Session::flash('tv', 'TV show successfuly added!');
            Session::flash('alert_type', 'alert-success');

			return redirect('settings/#2a');

    	} else {

    		Session::flash('movie', 'Movie successfuly added!');
            Session::flash('alert_type', 'alert-success');

    		return redirect('settings/#1a'); 
    	}

    }

    public function edit($id, Request $request) {

        $movie = Movie::find($id);
        $genres = Genre::all();
        $ident = $request->type;

        return view('admin.editMovie')
                ->with('movie', $movie)
                ->with('genres', $genres)
                ->with('ident', $ident);   

    }

    public function update($id, Request $request) {

        $this->validate($request, [
                'title' => 'required|max:200',
                'year' => 'required|integer|min:1800|max:3000',
                'summary' => 'max:2000',
                'language' => 'max:200',
                'country' => 'max:200',
                'imdb' => 'max:300',
                'tmdb' => 'max:300',
            ]);

        $movie = Movie::find($id);

        $movie->title = $request->title;
        $movie->year = $request->year;

        if($request->summary != null) {
           $movies->summary = $request->summary;
        } else {
            $movies->summary = 'No summary available';
        }

        $movies->language = $request->language;
        $movies->country = $request->country;
        $movies->imdb = $request->imdb;
        $movies->tmdb = $request->tmdb;

        if($request->type == 'tvshow') {
            $movie->status = $request->status;
        }

        DB::table('genre_movie')->where('movie_id', $id)->delete();

        $movie->save();

        $movie->genres()->sync($request->genres, false);

        if($request->type == 'tvshow') { 

            Session::flash('tv', 'TV show updated!');
            Session::flash('alert_type', 'alert-warning');

            return redirect('settings/#2a');

        } else {

            Session::flash('movie', 'Movie updated!');
            Session::flash('alert_type', 'alert-warning');

            return redirect('settings/#1a'); 
        }

    }

    public function remove($id, Request $request) {

        Movie::destroy($id);      

        $genres = Genre::all();
        $movies = Movie::where('type', 'movie')->get();
        $tvshows = Movie::where('type', 'tvshow')->get();

        if($request->type == 'movie') {

            Session::flash('movie', 'Movie deleted!');
            Session::flash('alert_type', 'alert-danger');

            return redirect('settings/#1a')
                ->with('genres', $genres)
                ->with('movies', $movies);

        } else {

            Session::flash('tv', 'TV show deleted!');
            Session::flash('alert_type', 'alert-danger');

            return redirect('settings/#2a')
                ->with('genres', $genres)
                ->with('tvshows', $tvshows);

        }

    }

    public function likeMovie(Request $request) {

        $movie = Movie::find($request->mid);

        $movie->likes = $movie->likes + 1;

        $movie->save();

        $user = User::find(Sentinel::getUser()->id);

        if($user->movies()->where('user_id', Sentinel::getUser()->id)->where('movie_id', $request->mid)->first() == null) {

            $user->movies()->attach([$request->mid => ['likes' => 1, 'type' => $movie->type]]);

        } else {

            $user->movies()->updateExistingPivot($request->mid, ['likes' => 1, 'type' => $movie->type]);

        }

        $msg = 'Success';

        return \Response::json($msg);

    }

    public function rateMovie(Request $request) {

        $user = User::find(Sentinel::getUser()->id);
        $mid = $request->mid;

        $score = Utilities::getRating($mid);
        $movie = Movie::find($mid);

        $rating = $request->rating;

        if($user->movies()->where('user_id', Sentinel::getUser()->id)->where('movie_id', $request->mid)->first() == null) {

            $user->movies()->attach([$mid => ['rating' => $rating, 'type' => $movie->type]]);

        } else {

            $user->movies()->updateExistingPivot($mid, ['rating' => $rating, 'type' => $movie->type]);

        }

        $movie->rating = $score;
        $movie->save();

        return \Response::json($rating);

    }

}
