<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Movielist;
use App\Review;
use App\User;
use App\Genre;
use Sentinel;

class BrowseController extends Controller
{
    public function index(Request $request, $year, $order = null) {

        if(Sentinel::check()) {
            $allLists = Movielist::where('user_id', Sentinel::getUser()->id)->get();
        } else {
             $allLists = null;
        }
        
        $allgenres = Genre::all();
    	$moviePath = public_path().'/images/thumbnails/movies/';

        $keyword = $request->get('srch_term');
        
        if($order != null) {
            if($year != 'all') {
                if($order == 'popdesc') {
                    $movies = Movie::where('year', $year)->where('type', 'movie')->orderBy('likes', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'popasc') {
                    $movies = Movie::where('year', $year)->where('type', 'movie')->orderBy('likes', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoredesc') {
                    $movies = Movie::where('year', $year)->where('type', 'movie')->orderBy('rating', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoreasc') {
                    $movies = Movie::where('year', $year)->where('type', 'movie')->orderBy('rating', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                }
            } else {
                if($order == 'popdesc') {
                    $movies = Movie::where('type', 'movie')->orderBy('likes', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'popasc') {
                    $movies = Movie::where('type', 'movie')->orderBy('likes', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoredesc') {
                    $movies = Movie::where('type', 'movie')->orderBy('rating', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoreasc') {
                    $movies = Movie::where('type', 'movie')->orderBy('rating', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                }
            }
        } else {
            if($year != 'all') {
                $movies = Movie::where('year', $year)->where('type', 'movie')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
            } else {
                $movies = Movie::where('type', 'movie')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
            }
        }

        
    	return view('browse')
    		->with('movies', $movies)
            ->with('allLists', $allLists)
            ->with('allgenres', $allgenres)
    		->with('moviePath', $moviePath)
            ->with('year', $year)
            ->with('order', $order);
    }

    public function indexTV(Request $request, $year, $order = null) {

        if(Sentinel::check()) {
            $allLists = Movielist::where('user_id', Sentinel::getUser()->id)->get();
        } else {
             $allLists = null;
        }
        
        $allgenres = Genre::all();
        $tvPath = public_path().'/images/thumbnails/tv/';

        $keyword = $request->get('srch_term');

        if($order != null) {
            if($year != 'all') {
                if($order == 'popdesc') {
                    $tvshows = Movie::where('year', $year)->where('type', 'tvshow')->orderBy('likes', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'popasc') {
                    $tvshows = Movie::where('year', $year)->where('type', 'tvshow')->orderBy('likes', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoredesc') {
                    $tvshows = Movie::where('year', $year)->where('type', 'tvshow')->orderBy('rating', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoreasc') {
                    $tvshows = Movie::where('year', $year)->where('type', 'tvshow')->orderBy('rating', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                }
            } else {
                if($order == 'popdesc') {
                    $tvshows = Movie::where('type', 'tvshow')->orderBy('likes', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'popasc') {
                    $tvshows = Movie::where('type', 'tvshow')->orderBy('likes', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoredesc') {
                    $tvshows = Movie::where('type', 'tvshow')->orderBy('rating', 'desc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                } elseif($order == 'scoreasc') {
                    $tvshows = Movie::where('type', 'tvshow')->orderBy('rating', 'asc')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
                }
            }
        } else {
            if($year != 'all') {
                $tvshows = Movie::where('year', $year)->where('type', 'tvshow')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
            } else {
                $tvshows = Movie::where('type', 'tvshow')->where(function($query) use ($keyword) {
                        return $this->searchTerm($keyword, $query);
                    })->paginate(6);
            }
        }

        return view('browseTV')
            ->with('tvshows', $tvshows)
            ->with('allLists', $allLists)
            ->with('allgenres', $allgenres)
            ->with('tvPath', $tvPath)
            ->with('year', $year)
            ->with('order', $order);
    }

    public function showMovie($id) {

    	$movie = Movie::find($id);
        $allLists = Movielist::where('user_id', Sentinel::getUser()->id)->get();

    	return view('showMovie')
            ->with('movie', $movie)
            ->with('allLists', $allLists);

    }

    public static function searchTerm($keyword, $query) {
            
        $query->where('title','LIKE', '%'.$keyword.'%');  
        
    }

}
