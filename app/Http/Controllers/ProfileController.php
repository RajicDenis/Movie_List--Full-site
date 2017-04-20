<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Movie;
use Sentinel;
use Session;
use DB;

class ProfileController extends Controller
{
    public function showAccount() {

    	$ident = 'account';

    	return view('profile.profile')->with('ident', $ident);

    }

    public function updateAccount(Request $request) {

    	$this->validate($request, [
            'username' => 'required|max:200',
            'first_name' => 'max:100',
            'last_name' => 'max:100',
            'email' => 'required|email',
        ]);

    	$user = User::find(Sentinel::getUser()->id);

    	$user->username = $request->username;
    	$user->first_name = $request->first_name;
    	$user->last_name = $request->last_name;
    	$user->email = $request->email;
    	$user->save();

    	Session::flash('account', 'Account successfuly updated!');
        Session::flash('alert_type', 'alert-success');

        return $this->showAccount();

    }

    public function uploadAvatar(Request $request) {

    	$user = User::find(Sentinel::getUser()->id);

    	if($request->avatar != null) {
            $file = $request->avatar;
            $destination = public_path().'/images/avatars';           
            $fileName = $file->getClientOriginalName();
            $file->move($destination, $fileName);

            $user->avatar = $fileName;
        }

        $user->save();

        return redirect()->back();

    }

    public function removeAvatar(Request $request) {

    	$user = User::find(Sentinel::getUser()->id);

        $user->avatar = null;
        $user->save();

        return redirect()->back(); 

    }

    public function showReviews() {

        $movie_rev = DB::table('movie_user')->where('type', 'movie')->where('review', '!=', null)->get();
        $tv_rev = DB::table('movie_user')->where('type', 'tvshow')->where('review', '!=', null)->get(); 

        $ident = 'reviews';

        return view('profile.profile')
            ->with('ident', $ident)
            ->with('movie_rev', $movie_rev)
            ->with('tv_rev', $tv_rev);


    }

    public function showLikes() {

    	$movies = Movie::where('type', 'movie')->get();
    	$tvshows = Movie::where('type', 'tvshow')->get();

    	$allMovies = Movie::all();
    	$reviews = DB::table('review_like')->where('user_id', Sentinel::getUser()->id)->get();

    	$ident = 'likes';

    	return view('profile.profile')
    		->with('ident', $ident)
    		->with('movies', $movies)
    		->with('tvshows', $tvshows)
    		->with('allMovies', $allMovies)
    		->with('reviews', $reviews);

    }

    public function showProfile($id) {

        $user = User::find($id);
        $ident = 'likes';

        $movies = Movie::where('type', 'movie')->get();
        $tvshows = Movie::where('type', 'tvshow')->get();

        $allMovies = Movie::all();
        $reviews = DB::table('review_like')->where('user_id', $id)->get();

        return view('profile.userProfile')
            ->with('ident', $ident)
            ->with('movies', $movies)
            ->with('tvshows', $tvshows)
            ->with('allMovies', $allMovies)
            ->with('reviews', $reviews)
            ->with('user', $user);

    }

     public function userReviews($id) {

        $user = User::find($id);
        $movie_rev = DB::table('movie_user')->where('type', 'movie')->where('review', '!=', null)->get();
        $tv_rev = DB::table('movie_user')->where('type', 'tvshow')->where('review', '!=', null)->get(); 

        $ident = 'reviews';

        return view('profile.userProfile')
            ->with('ident', $ident)
            ->with('movie_rev', $movie_rev)
            ->with('tv_rev', $tv_rev)
            ->with('user', $user);

    }
}
