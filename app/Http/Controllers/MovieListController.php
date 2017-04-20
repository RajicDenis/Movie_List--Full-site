<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movielist;
use App\User;
use App\Movie;
use Sentinel;
use Session;
use DB;

class MovieListController extends Controller
{
    public function index() {

        if($this->userHasList() == true) {

            $movielist = Movielist::where('user_id', Sentinel::getUser()->id)->orderBy('created_at', 'desc')->first();
            $allLists = Movielist::where('user_id', Sentinel::getUser()->id)->where('id', '!=', $movielist->id)->get();
        
        } else {

            $movielist = null;
            $allLists = null;
        }

        $score = User::where('id', Sentinel::getUser()->id)->get();
    	$listdb = Movielist::where('user_id', Sentinel::getUser()->id)->get();	              

    	return view('movielist')
    		->with('movielist', $movielist)
    		->with('allLists', $allLists)
    		->with('listdb', $listdb)
            ->with('score', $score);

    }

    public function showUserlists() {

        $lists = MovieList::where('public', 1)->orderBy('created_at', 'desc')->paginate(5); 
        
        $allLists = Movielist::all();
        $publicLists = Movielist::where('public', 1)->get();

        return view('userLists')
            ->with('allLists', $allLists)
            ->with('publicLists', $publicLists)
            ->with('lists', $lists);

    }

    public function showList($uid, $mid) {

        $movielist = Movielist::where('id', $mid)->first();
        $score = User::where('id', $uid)->get();
        $listdb = 1;

        return view('movielist')
            ->with('movielist', $movielist)
            ->with('score', $score)
            ->with('listdb', $listdb);

    }

    public function createList() {

    	return view('createList');

    }

    public function storeList(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'max:500',
        ]);

    	$list = new Movielist;

    	$list->name = $request->name;
    	$list->description = $request->description;
    	$list->user_id = $request->user_id;
    	$list->save();

    	return $this->index();

    }

    public function switchList($id) {

    	$movielist = Movielist::find($id);
    	$allLists = Movielist::where('user_id', Sentinel::getUser()->id)->where('id', '!=', $id)->get();
    	$listdb = Movielist::all();	
        $score = User::where('id', Sentinel::getUser()->id)->get();

    	return view('movielist')
    		->with('movielist', $movielist)
    		->with('allLists', $allLists)
    		->with('listdb', $listdb)
            ->with('score', $score);

    }

    public function addMovie(Request $request) {

    	$movielist = Movielist::find($request->lid);
        $user = User::find(Sentinel::getUser()->id);
        $movie = Movie::find($request->mid);

    	$movielist->movies()->attach($request->mid);

        if($user->movies()->where('user_id', Sentinel::getUser()->id)->where('movie_id', $request->mid)->first() == null) {

            $user->movies()->attach([$request->mid => ['score' => $request->score, 'type' => $movie->type]]);

        } else {

            $user->movies()->updateExistingPivot($request->mid, ['score' => $request->score, 'type' => $movie->type]);

        }
        
        return redirect()->back();

    }

    public function addScore(Request $request) {

        $user = User::find(Sentinel::getUser()->id);

        $user->movies()->updateExistingPivot($request->mid, ['score' => $request->score]);
 
        return redirect()->back();

    }

    public function remove($lid, $mid) {

        $movielist = Movielist::find($lid);

        $movielist->movies()->detach($mid);

        return $this->switchList($lid);

    }

    public function shareList($id) {

        $movielist = Movielist::find($id);

        $movielist->public = 1;
        $movielist->save();

        return redirect()->back();
    }

    public function deleteList($id) {

        Movielist::destroy($id);

        DB::table('movie_movielist')->where('movielist_id', $id)->delete();

        return $this->index();

    }

    private function userHasList() {

        if(Movielist::where('user_id', Sentinel::getUser()->id)->first() == null) {

            return false;

        } else {

            return true;

        }

    }

}
