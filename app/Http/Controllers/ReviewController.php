<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Movie;
use Sentinel;
use DB;
use Datetime;
use Carbon\Carbon;

class ReviewController extends Controller
{

    public function index() {

        $movie_rev = DB::table('movie_user')->where('type', 'movie')->where('review', '!=', null)->paginate(5); 
        
        return view('reviews')->with('movie_rev', $movie_rev);


    }

    public function indexTV() {

        $tv_rev = DB::table('movie_user')->where('type', 'tvshow')->where('review', '!=', null)->paginate(5); 
        
        return view('TVreviews')->with('tv_rev', $tv_rev);

    }

    public function addReview(Request $request) {

        $user = User::find(Sentinel::getUser()->id);
        $date = Carbon::now();
        $mid = $request->mid2;
        $movie = Movie::find($mid);

        $rating = $request->rating;
        $review = $request->review;
        $recap = $request->recap;

        if($user->movies()->where('user_id', Sentinel::getUser()->id)->where('movie_id', $mid)->first() == null) {

            $user->movies()->attach([$mid => ['review' => $review, 'rev_rating' => $rating, 'rev_recap' => $recap, 'rev_date' => $date, 'type' => $movie->type]]);

        } else {

            $user->movies()->updateExistingPivot($mid, ['review' => $review, 'rev_rating' => $rating, 'rev_recap' => $recap, 'rev_date' => $date, 'type' => $movie->type]);

        }

    	return redirect()->back();

    }

    public function showReview($mid, $uid) {

        $movie = Movie::find($mid);
        $revLike = DB::table('review_like')->get();

        $review = $movie->users()->where('user_id', $uid)->get();

        return view('showReview')
            ->with('review', $review)
            ->with('movie', $movie)
            ->with('revLike', $revLike);

    }

    public function likeReview(Request $request) {

        $mid = $request->mid;
        $user_id = $request->uid;
        $rid = $request->rid;

        $user = User::find($user_id);

        DB::table('movie_user')->where('user_id', $user_id)->where('movie_id', $mid)->increment('rev_total_likes');

        DB::table('review_like')->insert(['user_id' => Sentinel::getUser()->id, 'review_id' => $rid, 'likes' => 1]);

    }

}
